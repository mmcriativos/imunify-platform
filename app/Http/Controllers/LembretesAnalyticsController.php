<?php

namespace App\Http\Controllers;

use App\Models\LembreteEnviado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LembretesAnalyticsController extends Controller
{
    /**
     * Exibe o dashboard de análise de lembretes
     */
    public function index(Request $request)
    {
        $periodo = $request->get('periodo', '7dias');
        $dataInicio = $this->getDataInicio($periodo);
        
        return view('lembretes.analytics', [
            'kpis' => $this->getKPIs($dataInicio),
            'graficoTemporal' => $this->getGraficoTemporal($dataInicio),
            'graficoPorTipo' => $this->getGraficoPorTipo($dataInicio),
            'graficoTaxaSucesso' => $this->getGraficoTaxaSucesso($dataInicio),
            'ultimosEnvios' => $this->getUltimosEnvios(),
            'periodo' => $periodo,
        ]);
    }

    /**
     * Retorna KPIs principais
     */
    private function getKPIs($dataInicio)
    {
        $query = LembreteEnviado::where('enviado_em', '>=', $dataInicio);
        
        $total = $query->count();
        $sucessos = $query->where('sucesso', true)->count();
        $falhas = $query->where('sucesso', false)->count();
        $taxaSucesso = $total > 0 ? round(($sucessos / $total) * 100, 1) : 0;
        
        $hoje = LembreteEnviado::whereDate('enviado_em', today())->count();
        $semana = LembreteEnviado::where('enviado_em', '>=', now()->startOfWeek())->count();
        $mes = LembreteEnviado::where('enviado_em', '>=', now()->startOfMonth())->count();
        
        return [
            'total' => $total,
            'sucessos' => $sucessos,
            'falhas' => $falhas,
            'taxa_sucesso' => $taxaSucesso,
            'hoje' => $hoje,
            'semana' => $semana,
            'mes' => $mes,
        ];
    }

    /**
     * Dados para gráfico temporal (linha do tempo)
     */
    private function getGraficoTemporal($dataInicio)
    {
        $dados = LembreteEnviado::select(
                DB::raw('DATE(enviado_em) as data'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN sucesso = 1 THEN 1 ELSE 0 END) as sucessos'),
                DB::raw('SUM(CASE WHEN sucesso = 0 THEN 1 ELSE 0 END) as falhas')
            )
            ->where('enviado_em', '>=', $dataInicio)
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return [
            'labels' => $dados->map(fn($d) => Carbon::parse($d->data)->format('d/m')),
            'total' => $dados->pluck('total'),
            'sucessos' => $dados->pluck('sucessos'),
            'falhas' => $dados->pluck('falhas'),
        ];
    }

    /**
     * Dados para gráfico por tipo de lembrete
     */
    private function getGraficoPorTipo($dataInicio)
    {
        $dados = LembreteEnviado::select('tipo', DB::raw('COUNT(*) as total'))
            ->where('enviado_em', '>=', $dataInicio)
            ->groupBy('tipo')
            ->get();

        $tiposLabels = [
            '7dias' => '7 dias antes',
            '1dia' => '1 dia antes',
            'hoje' => 'No dia',
            'atrasado' => 'Atrasados',
        ];

        return [
            'labels' => $dados->map(fn($d) => $tiposLabels[$d->tipo] ?? $d->tipo),
            'valores' => $dados->pluck('total'),
        ];
    }

    /**
     * Dados para gráfico de taxa de sucesso (pizza)
     */
    private function getGraficoTaxaSucesso($dataInicio)
    {
        $sucessos = LembreteEnviado::where('enviado_em', '>=', $dataInicio)
            ->where('sucesso', true)
            ->count();
        
        $falhas = LembreteEnviado::where('enviado_em', '>=', $dataInicio)
            ->where('sucesso', false)
            ->count();

        return [
            'labels' => ['Sucesso', 'Falha'],
            'valores' => [$sucessos, $falhas],
        ];
    }

    /**
     * Últimos envios
     */
    private function getUltimosEnvios()
    {
        return LembreteEnviado::with(['paciente', 'agendamento'])
            ->latest('enviado_em')
            ->take(20)
            ->get();
    }

    /**
     * Determina data de início baseado no período
     */
    private function getDataInicio($periodo)
    {
        return match($periodo) {
            'hoje' => now()->startOfDay(),
            '7dias' => now()->subDays(7),
            '15dias' => now()->subDays(15),
            '30dias' => now()->subDays(30),
            '90dias' => now()->subDays(90),
            default => now()->subDays(7),
        };
    }

    /**
     * API endpoint para atualizar dados via AJAX
     */
    public function apiDados(Request $request)
    {
        $periodo = $request->get('periodo', '7dias');
        $dataInicio = $this->getDataInicio($periodo);
        
        return response()->json([
            'kpis' => $this->getKPIs($dataInicio),
            'graficoTemporal' => $this->getGraficoTemporal($dataInicio),
            'graficoPorTipo' => $this->getGraficoPorTipo($dataInicio),
            'graficoTaxaSucesso' => $this->getGraficoTaxaSucesso($dataInicio),
        ]);
    }
}
