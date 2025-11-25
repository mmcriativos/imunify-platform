<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\Vacina;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $mesAtual = $request->input('mes', Carbon::now()->month);
        $anoAtual = $request->input('ano', Carbon::now()->year);

        // Estatísticas do mês selecionado
        $atendimentosMes = Atendimento::whereYear('data', $anoAtual)
            ->whereMonth('data', $mesAtual)
            ->count();

        $pacientesAtendidos = Atendimento::whereYear('data', $anoAtual)
            ->whereMonth('data', $mesAtual)
            ->distinct('paciente_id')
            ->count('paciente_id');

        $faturamentoMes = Atendimento::whereYear('data', $anoAtual)
            ->whereMonth('data', $mesAtual)
            ->sum('valor_total');

        // Atendimentos por tipo
        $atendimentosPorTipo = Atendimento::whereYear('data', $anoAtual)
            ->whereMonth('data', $mesAtual)
            ->select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Últimos atendimentos do mês selecionado
        $ultimosAtendimentos = Atendimento::with(['paciente', 'cidade'])
            ->whereYear('data', $anoAtual)
            ->whereMonth('data', $mesAtual)
            ->orderBy('data', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'atendimentosMes',
            'pacientesAtendidos',
            'faturamentoMes',
            'atendimentosPorTipo',
            'ultimosAtendimentos',
            'mesAtual',
            'anoAtual'
        ));
    }

    public function mensal(Request $request)
    {
        return $this->relatorioMensal($request);
    }

    public function relatorioMensal(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month);
        $ano = $request->input('ano', Carbon::now()->year);

        $atendimentos = Atendimento::with(['paciente', 'cidade', 'vacinas'])
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->orderBy('data', 'desc')
            ->get();

        $totalFaturamento = $atendimentos->sum('valor_total');
        $totalAtendimentos = $atendimentos->count();

        return view('relatorios.mensal', compact(
            'atendimentos',
            'totalFaturamento',
            'totalAtendimentos',
            'mes',
            'ano'
        ));
    }

    public function relatorioPorCidade(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month);
        $ano = $request->input('ano', Carbon::now()->year);

        $atendimentosPorCidade = Atendimento::with('cidade')
            ->where('tipo', 'domiciliar')
            ->whereYear('data', $ano)
            ->whereMonth('data', $mes)
            ->select('cidade_id', DB::raw('count(*) as total'), DB::raw('sum(valor_total) as faturamento'))
            ->groupBy('cidade_id')
            ->get();

        return view('relatorios.cidade', compact('atendimentosPorCidade', 'mes', 'ano'));
    }
}
