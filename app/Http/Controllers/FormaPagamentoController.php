<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    public function index()
    {
        $formas = FormaPagamento::orderBy('tipo')->orderBy('nome')->get();
        
        // Agrupar por tipo
        $formasPorTipo = $formas->groupBy('tipo');
        
        return view('financeiro.formas-pagamento.index', compact('formasPorTipo'));
    }

    public function create()
    {
        return view('financeiro.formas-pagamento.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'tipo' => 'required|in:dinheiro,pix,debito,credito,boleto,transferencia,outro',
            'taxa_percentual' => 'nullable|numeric|min:0|max:100',
            'prazo_recebimento' => 'nullable|integer|min:0',
            'requer_conciliacao' => 'boolean',
            'adquirente' => 'nullable|max:255',
        ]);

        $validated['ativo'] = true;

        FormaPagamento::create($validated);

        return redirect()->route('financeiro.formas-pagamento.index')
            ->with('success', 'Forma de pagamento criada com sucesso!');
    }

    public function edit(FormaPagamento $formaPagamento)
    {
        return view('financeiro.formas-pagamento.edit', compact('formaPagamento'));
    }

    public function update(Request $request, FormaPagamento $formaPagamento)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'tipo' => 'required|in:dinheiro,pix,debito,credito,boleto,transferencia,outro',
            'taxa_percentual' => 'nullable|numeric|min:0|max:100',
            'prazo_recebimento' => 'nullable|integer|min:0',
            'requer_conciliacao' => 'boolean',
            'adquirente' => 'nullable|max:255',
            'ativo' => 'boolean',
        ]);

        $formaPagamento->update($validated);

        return redirect()->route('financeiro.formas-pagamento.index')
            ->with('success', 'Forma de pagamento atualizada com sucesso!');
    }

    public function destroy(FormaPagamento $formaPagamento)
    {
        $formaPagamento->delete();

        return redirect()->route('financeiro.formas-pagamento.index')
            ->with('success', 'Forma de pagamento excluída com sucesso!');
    }
}
