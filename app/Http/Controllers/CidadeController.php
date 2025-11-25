<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = Cidade::where('ativo', true)
            ->orderBy('nome')
            ->paginate(20);

        return view('cidades.index', compact('cidades'));
    }

    public function create()
    {
        return view('cidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
        ]);

        // Verificar se a cidade já existe
        $cidadeExistente = Cidade::where('nome', $validated['nome'])
            ->where('uf', $validated['uf'])
            ->first();

        if ($cidadeExistente) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "A cidade {$validated['nome']} - {$validated['uf']} já existe no sistema."
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['nome' => "A cidade {$validated['nome']} - {$validated['uf']} já existe no sistema."])
                ->withInput();
        }

        try {
            $cidade = Cidade::create($validated);

            // Se for requisição AJAX, retornar JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cidade cadastrada com sucesso!',
                    'cidade' => [
                        'id' => $cidade->id,
                        'nome' => $cidade->nome,
                        'uf' => $cidade->uf,
                    ]
                ]);
            }

            return redirect()->route('cidades.index')
                ->with('success', 'Cidade cadastrada com sucesso!');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao cadastrar cidade. Tente novamente.'
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['erro' => 'Erro ao cadastrar cidade. Tente novamente.'])
                ->withInput();
        }
    }

    public function show(Cidade $cidade)
    {
        return view('cidades.show', compact('cidade'));
    }

    public function edit(Cidade $cidade)
    {
        return view('cidades.edit', compact('cidade'));
    }

    public function update(Request $request, Cidade $cidade)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
        ]);

        // Checkbox: se não está marcado, não vem no request
        $validated['ativo'] = $request->has('ativo') ? true : false;

        $cidade->update($validated);

        return redirect()->route('cidades.index')
            ->with('success', 'Cidade atualizada com sucesso!');
    }

    public function destroy(Cidade $cidade)
    {
        $cidade->update(['ativo' => false]);
        
        return redirect()->route('cidades.index')
            ->with('success', 'Cidade desativada com sucesso!');
    }
}
