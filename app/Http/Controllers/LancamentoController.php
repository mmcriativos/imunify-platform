<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Caixa;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use App\Models\Paciente;
use App\Models\ConciliacaoCartao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LancamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Lancamento::with(['categoria', 'formaPagamento', 'paciente', 'usuario']);

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('forma_pagamento_id')) {
            $query->where('forma_pagamento_id', $request->forma_pagamento_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data', '<=', $request->data_fim);
        }

        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        $lancamentos = $query->orderBy('data', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // Dados para filtros
        $categorias = CategoriaFinanceira::ativas()->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::ativas()->orderBy('nome')->get();

        return view('financeiro.lancamentos.index', compact('lancamentos', 'categorias', 'formasPagamento'));
    }

    public function create()
    {
        $categorias = CategoriaFinanceira::ativas()->orderBy('tipo')->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::ativas()->orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();
        $caixaAberto = Caixa::aberto()->first();

        return view('financeiro.lancamentos.create', compact('categorias', 'formasPagamento', 'pacientes', 'caixaAberto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:receita,despesa',
            'categoria_id' => 'required|exists:categorias_financeiras,id',
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'observacoes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $caixaAberto = Caixa::aberto()->first();

            $lancamento = Lancamento::create([
                'caixa_id' => $caixaAberto ? $caixaAberto->id : null,
                'categoria_id' => $request->categoria_id,
                'forma_pagamento_id' => $request->forma_pagamento_id,
                'paciente_id' => $request->paciente_id,
                'usuario_id' => auth()->id(),
                'tipo' => $request->tipo,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data' => $request->data,
                'hora' => now()->format('H:i:s'),
                'status' => 'confirmado',
                'observacoes' => $request->observacoes
            ]);

            // Se for cartão e precisar de conciliação
            $formaPagamento = FormaPagamento::find($request->forma_pagamento_id);
            if ($formaPagamento && $formaPagamento->requer_conciliacao && $request->filled('nsu')) {
                ConciliacaoCartao::create([
                    'lancamento_id' => $lancamento->id,
                    'adquirente' => $formaPagamento->adquirente ?? 'Não especificado',
                    'bandeira' => $request->bandeira,
                    'nsu' => $request->nsu,
                    'autorizacao' => $request->codigo_autorizacao,
                    'data_venda' => $request->data,
                    'data_prevista_recebimento' => $formaPagamento->calcularDataRecebimento($request->data),
                    'valor_bruto' => $request->valor,
                    'valor_liquido' => $formaPagamento->calcularValorLiquido($request->valor),
                    'numero_parcelas' => $request->numero_parcelas ?? 1,
                    'status' => 'pendente'
                ]);
            }

            DB::commit();

            return redirect()->route('financeiro.lancamentos.index')
                ->with('success', 'Lançamento criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro ao criar lançamento: ' . $e->getMessage());
        }
    }

    public function show(Lancamento $lancamento)
    {
        $lancamento->load(['categoria', 'formaPagamento', 'paciente', 'usuario', 'caixa', 'conciliacaoCartao']);
        
        return view('financeiro.lancamentos.show', compact('lancamento'));
    }

    public function edit(Lancamento $lancamento)
    {
        $categorias = CategoriaFinanceira::ativas()->orderBy('tipo')->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::ativas()->orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();

        return view('financeiro.lancamentos.edit', compact('lancamento', 'categorias', 'formasPagamento', 'pacientes'));
    }

    public function update(Request $request, Lancamento $lancamento)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias_financeiras,id',
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'observacoes' => 'nullable|string'
        ]);

        $lancamento->update([
            'categoria_id' => $request->categoria_id,
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'observacoes' => $request->observacoes
        ]);

        return redirect()->route('financeiro.lancamentos.show', $lancamento)
            ->with('success', 'Lançamento atualizado com sucesso!');
    }

    public function destroy(Lancamento $lancamento)
    {
        try {
            $lancamento->delete();
            
            return redirect()->route('financeiro.lancamentos.index')
                ->with('success', 'Lançamento excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir lançamento: ' . $e->getMessage());
        }
    }

    public function marcarComoConfirmado(Lancamento $lancamento)
    {
        if ($lancamento->isConfirmado()) {
            return back()->with('error', 'Este lançamento já está confirmado.');
        }

        $lancamento->marcarComoConfirmado();

        return back()->with('success', 'Lançamento confirmado!');
    }

    public function cancelar(Lancamento $lancamento)
    {
        if ($lancamento->isCancelado()) {
            return back()->with('error', 'Este lançamento já está cancelado.');
        }

        $lancamento->cancelar();

        return back()->with('success', 'Lançamento cancelado!');
    }
}
