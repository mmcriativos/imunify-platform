<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanceira;
use Illuminate\Http\Request;

class CategoriaFinanceiraController extends Controller
{
    public function index()
    {
        $receitas = CategoriaFinanceira::where('tipo', 'receita')
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();
            
        $despesas = CategoriaFinanceira::where('tipo', 'despesa')
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view('financeiro.categorias.index', compact('receitas', 'despesas'));
    }

    public function create()
    {
        return view('financeiro.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:receita,despesa',
            'cor' => 'nullable|string|max:7',
            'icone' => 'nullable|string|max:255',
        ]);

        $validated['ativo'] = true;

        CategoriaFinanceira::create($validated);

        return redirect()->route('financeiro.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(CategoriaFinanceira $categoria)
    {
        return view('financeiro.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, CategoriaFinanceira $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:receita,despesa',
            'cor' => 'nullable|string|max:7',
            'icone' => 'nullable|string|max:255',
            'ativo' => 'boolean',
        ]);

        $categoria->update($validated);

        return redirect()->route('financeiro.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(CategoriaFinanceira $categoria)
    {
        $categoria->delete();

        return redirect()->route('financeiro.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
