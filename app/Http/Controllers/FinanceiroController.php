<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Caixa;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use App\Models\ConciliacaoCartao;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function dashboard(Request $request)
    {
        // Período padrão: mês atual
        $inicio = $request->filled('data_inicio') 
            ? Carbon::parse($request->data_inicio) 
            : now()->startOfMonth();
            
        $fim = $request->filled('data_fim') 
            ? Carbon::parse($request->data_fim) 
            : now()->endOfMonth();

        // Resumo geral
        $totalReceitas = Lancamento::receitas()
            ->whereBetween('data', [$inicio, $fim])
            ->where('status', 'confirmado')
            ->sum('valor');

        $totalDespesas = Lancamento::despesas()
            ->whereBetween('data', [$inicio, $fim])
            ->where('status', 'confirmado')
            ->sum('valor');

        $saldo = $totalReceitas - $totalDespesas;

        // Pendências
        $receitasPendentes = Lancamento::receitas()
            ->where('status', 'pendente')
            ->sum('valor');

        $despesasPendentes = Lancamento::despesas()
            ->where('status', 'pendente')
            ->sum('valor');

        // Contas vencidas (pendentes com vencimento passado)
        $contasVencidas = Lancamento::vencidas()->count();
        $valorVencido = Lancamento::vencidas()->sum('valor');

        // Receitas por categoria
        $receitasPorCategoria = Lancamento::receitas()
            ->whereBetween('data', [$inicio, $fim])
            ->where('status', 'confirmado')
            ->select('categoria_id', DB::raw('SUM(valor) as total'))
            ->groupBy('categoria_id')
            ->with('categoria')
            ->get()
            ->map(function ($item) {
                return [
                    'categoria' => $item->categoria->nome,
                    'cor' => $item->categoria->cor,
                    'total' => $item->total
                ];
            });

        // Despesas por categoria
        $despesasPorCategoria = Lancamento::despesas()
            ->whereBetween('data', [$inicio, $fim])
            ->where('status', 'confirmado')
            ->select('categoria_id', DB::raw('SUM(valor) as total'))
            ->groupBy('categoria_id')
            ->with('categoria')
            ->get()
            ->map(function ($item) {
                return [
                    'categoria' => $item->categoria->nome,
                    'cor' => $item->categoria->cor,
                    'total' => $item->total
                ];
            });

        // Receitas por forma de pagamento
        $receitasPorFormaPagamento = Lancamento::receitas()
            ->whereBetween('data', [$inicio, $fim])
            ->where('status', 'confirmado')
            ->select('forma_pagamento_id', DB::raw('SUM(valor) as total'))
            ->groupBy('forma_pagamento_id')
            ->with('formaPagamento')
            ->get()
            ->map(function ($item) {
                return [
                    'forma' => $item->formaPagamento->nome,
                    'total' => $item->total
                ];
            });

        // Evolução mensal (últimos 6 meses)
        $evolucaoMensal = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mesInicio = now()->subMonths($i)->startOfMonth();
            $mesFim = now()->subMonths($i)->endOfMonth();

            $receitas = Lancamento::receitas()
                ->whereBetween('data', [$mesInicio, $mesFim])
                ->where('status', 'confirmado')
                ->sum('valor');

            $despesas = Lancamento::despesas()
                ->whereBetween('data', [$mesInicio, $mesFim])
                ->where('status', 'confirmado')
                ->sum('valor');

            $evolucaoMensal->push([
                'mes' => $mesInicio->format('M/Y'),
                'receitas' => $receitas,
                'despesas' => $despesas,
                'saldo' => $receitas - $despesas
            ]);
        }

        // Caixa atual
        $caixaAberto = Caixa::aberto()->first();

        // Últimos lançamentos
        $ultimosLancamentos = Lancamento::with(['categoria', 'formaPagamento', 'paciente'])
            ->orderBy('data', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('financeiro.dashboard', compact(
            'inicio',
            'fim',
            'totalReceitas',
            'totalDespesas',
            'saldo',
            'receitasPendentes',
            'despesasPendentes',
            'contasVencidas',
            'valorVencido',
            'receitasPorCategoria',
            'despesasPorCategoria',
            'receitasPorFormaPagamento',
            'evolucaoMensal',
            'caixaAberto',
            'ultimosLancamentos'
        ));
    }

    public function relatorios()
    {
        return view('financeiro.relatorios');
    }

    public function conciliacoes(Request $request)
    {
        $query = ConciliacaoCartao::with(['lancamento', 'formaPagamento']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bandeira')) {
            $query->where('bandeira', $request->bandeira);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_venda', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_venda', '<=', $request->data_fim);
        }

        $conciliacoes = $query->orderBy('data_recebimento_prevista', 'asc')
            ->paginate(30);

        // Totais
        $totalPendente = ConciliacaoCartao::pendente()->sum('valor_liquido');
        $totalRecebido = ConciliacaoCartao::recebido()
            ->whereMonth('data_recebimento_real', now()->month)
            ->sum('valor_liquido');
        $totalVencido = ConciliacaoCartao::vencidas()->sum('valor_liquido');

        return view('financeiro.conciliacoes', compact('conciliacoes', 'totalPendente', 'totalRecebido', 'totalVencido'));
    }

    public function configuracoes()
    {
        $categorias = CategoriaFinanceira::withTrashed()->orderBy('tipo')->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::withTrashed()->orderBy('nome')->get();

        return view('financeiro.configuracoes', compact('categorias', 'formasPagamento'));
    }
}
