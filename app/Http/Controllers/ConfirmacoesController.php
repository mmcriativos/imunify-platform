<?php

namespace App\Http\Controllers;

use App\Models\ConfirmacaoPresenca;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConfirmacoesController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->get('periodo', '30dias');
        
        // Calcular data inicial baseado no período
        $dataInicio = match($periodo) {
            'hoje' => Carbon::today(),
            '7dias' => Carbon::now()->subDays(7),
            '15dias' => Carbon::now()->subDays(15),
            '30dias' => Carbon::now()->subDays(30),
            '90dias' => Carbon::now()->subDays(90),
            default => Carbon::now()->subDays(30)
        };

        // KPIs
        $kpis = $this->getKPIs($dataInicio);

        // Últimas confirmações
        $ultimasConfirmacoes = ConfirmacaoPresenca::with(['paciente', 'agendamento'])
            ->where('enviado_em', '>=', $dataInicio)
            ->orderBy('enviado_em', 'desc')
            ->take(50)
            ->get();

        // Agendamentos de hoje/amanhã para monitoramento
        $agendamentosProximos = Agendamento::with(['paciente', 'confirmacaoPresenca'])
            ->whereBetween('data_inicio', [Carbon::today(), Carbon::tomorrow()->endOfDay()])
            ->whereIn('status', ['agendado', 'confirmado'])
            ->orderBy('data_inicio')
            ->get();

        return view('confirmacoes.index', compact(
            'kpis',
            'ultimasConfirmacoes',
            'agendamentosProximos',
            'periodo'
        ));
    }

    private function getKPIs($dataInicio)
    {
        $total = ConfirmacaoPresenca::where('enviado_em', '>=', $dataInicio)->count();
        $confirmados = ConfirmacaoPresenca::where('enviado_em', '>=', $dataInicio)
            ->where('status', 'confirmado')->count();
        $cancelados = ConfirmacaoPresenca::where('enviado_em', '>=', $dataInicio)
            ->where('status', 'cancelado')->count();
        $pendentes = ConfirmacaoPresenca::where('enviado_em', '>=', $dataInicio)
            ->where('status', 'pendente')->count();

        $taxaResposta = $total > 0 ? round((($confirmados + $cancelados) / $total) * 100, 1) : 0;
        $taxaConfirmacao = $total > 0 ? round(($confirmados / $total) * 100, 1) : 0;

        // Hoje
        $hoje = ConfirmacaoPresenca::whereDate('enviado_em', Carbon::today())->count();

        // Esta semana
        $semana = ConfirmacaoPresenca::whereBetween('enviado_em', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        return [
            'total' => $total,
            'confirmados' => $confirmados,
            'cancelados' => $cancelados,
            'pendentes' => $pendentes,
            'taxa_resposta' => $taxaResposta,
            'taxa_confirmacao' => $taxaConfirmacao,
            'hoje' => $hoje,
            'semana' => $semana,
        ];
    }

    public function cancelar(Request $request, $id)
    {
        $confirmacao = ConfirmacaoPresenca::findOrFail($id);
        
        $confirmacao->update([
            'status' => 'cancelado',
            'respondido_em' => now(),
            'resposta_botao' => 'cancelado_manual'
        ]);

        // Atualizar agendamento
        $confirmacao->agendamento->update(['status' => 'cancelado']);

        return redirect()->back()->with('success', 'Agendamento cancelado com sucesso!');
    }

    public function confirmar(Request $request, $id)
    {
        $confirmacao = ConfirmacaoPresenca::findOrFail($id);
        
        $confirmacao->update([
            'status' => 'confirmado',
            'respondido_em' => now(),
            'resposta_botao' => 'confirmado_manual'
        ]);

        // Atualizar agendamento
        $confirmacao->agendamento->update(['status' => 'confirmado']);

        return redirect()->back()->with('success', 'Presença confirmada com sucesso!');
    }
}

