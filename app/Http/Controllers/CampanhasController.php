<?php

namespace App\Http\Controllers;

use App\Models\CampanhaVacinacao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampanhasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campanhas = CampanhaVacinacao::orderBy('data_inicio', 'desc')->get();
        
        // Separar por status
        $ativas = $campanhas->filter(fn($c) => $c->estaAtiva());
        $futuras = $campanhas->filter(fn($c) => Carbon::parse($c->data_inicio)->isFuture());
        $encerradas = $campanhas->filter(fn($c) => Carbon::parse($c->data_fim)->isPast() && !$c->estaAtiva());
        
        return view('campanhas.index', compact('campanhas', 'ativas', 'futuras', 'encerradas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campanhas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'vacina' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'publico_alvo' => 'nullable|string|max:255',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0|gte:idade_minima',
            'prioridade' => 'required|in:baixa,média,alta',
            'ativa' => 'boolean',
        ]);

        $campanha = CampanhaVacinacao::create($validated);

        return redirect()
            ->route('campanhas.index')
            ->with('success', '✅ Campanha criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CampanhaVacinacao $campanha)
    {
        return view('campanhas.show', compact('campanha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampanhaVacinacao $campanha)
    {
        return view('campanhas.edit', compact('campanha'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampanhaVacinacao $campanha)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'vacina' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'publico_alvo' => 'nullable|string|max:255',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0|gte:idade_minima',
            'prioridade' => 'required|in:baixa,média,alta',
            'ativa' => 'boolean',
        ]);

        $campanha->update($validated);

        return redirect()
            ->route('campanhas.index')
            ->with('success', '✅ Campanha atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampanhaVacinacao $campanha)
    {
        $campanha->delete();

        return redirect()
            ->route('campanhas.index')
            ->with('success', '✅ Campanha excluída com sucesso!');
    }

    /**
     * Toggle campaign active status
     */
    public function toggleStatus(CampanhaVacinacao $campanha)
    {
        $campanha->update(['ativa' => !$campanha->ativa]);

        $status = $campanha->ativa ? 'ativada' : 'desativada';
        
        return back()->with('success', "✅ Campanha {$status} com sucesso!");
    }
}
