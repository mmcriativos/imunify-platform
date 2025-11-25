<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cidade;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::where('ativo', true);

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filtro por cidade (busca por texto livre)
        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', "%{$request->cidade}%");
        }

        // Filtro por menor de idade
        if ($request->filled('tipo')) {
            if ($request->tipo === 'menor') {
                $query->where('e_menor', true);
            } elseif ($request->tipo === 'adulto') {
                $query->where('e_menor', false);
            }
        }

        // Ordenação
        $sortField = $request->get('sort', 'nome');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validar campos permitidos para ordenação
        $allowedSorts = ['id', 'nome', 'cpf', 'telefone', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'nome';
        }

        $query->orderBy($sortField, $sortDirection);

        $pacientes = $query->paginate(15)->appends($request->all());
        $cidades = Cidade::where('ativo', true)->orderBy('nome')->get();

        return view('pacientes.index', compact('pacientes', 'cidades'));
    }

    public function create()
    {
        $cidades = Cidade::where('ativo', true)->orderBy('nome')->get();
        return view('pacientes.create', compact('cidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:pacientes,cpf',
            'rg' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:10',
            'cidade' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'e_menor' => 'nullable|boolean',
            'responsavel_nome' => 'nullable|string|max:255',
            'responsavel_cpf' => 'nullable|string|max:14',
            'responsavel_telefone' => 'nullable|string|max:20',
            'responsavel_parentesco' => 'nullable|string|max:50',
        ]);

        // Converte checkbox para boolean
        $validated['e_menor'] = $request->has('e_menor');
        
        // Se não for menor, limpa os campos de responsável
        if (!$validated['e_menor']) {
            $validated['responsavel_nome'] = null;
            $validated['responsavel_cpf'] = null;
            $validated['responsavel_telefone'] = null;
            $validated['responsavel_parentesco'] = null;
        }

        Paciente::create($validated);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente cadastrado com sucesso!');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load(['atendimentos.vacinas']);
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:pacientes,cpf,' . $paciente->id,
            'rg' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:10',
            'cidade' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
            'e_menor' => 'nullable|boolean',
            'responsavel_nome' => 'nullable|string|max:255',
            'responsavel_cpf' => 'nullable|string|max:14',
            'responsavel_telefone' => 'nullable|string|max:20',
            'responsavel_parentesco' => 'nullable|string|max:50',
        ]);

        // Converte checkboxes para boolean
        $validated['e_menor'] = $request->has('e_menor');
        $validated['ativo'] = $request->has('ativo');
        
        // Se não for menor, limpa os campos de responsável
        if (!$validated['e_menor']) {
            $validated['responsavel_nome'] = null;
            $validated['responsavel_cpf'] = null;
            $validated['responsavel_telefone'] = null;
            $validated['responsavel_parentesco'] = null;
        }

        $paciente->update($validated);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->update(['ativo' => false]);
        
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente desativado com sucesso!');
    }
}
