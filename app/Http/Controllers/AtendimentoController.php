<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\Vacina;
use App\Models\Cidade;
use App\Models\Lancamento;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AtendimentoController extends Controller
{
    public function index()
    {
        $atendimentos = Atendimento::with(['paciente', 'cidade', 'vacinas'])
            ->orderBy('data', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('atendimentos.index', compact('atendimentos'));
    }

    public function create()
    {
        $pacientes = Paciente::where('ativo', true)->orderBy('nome')->get();
        $vacinas = Vacina::where('ativo', true)->orderBy('nome')->get();
        $cidades = Cidade::where('ativo', true)->orderBy('nome')->get();
        
        return view('atendimentos.create', compact('pacientes', 'vacinas', 'cidades'));
    }

    public function store(Request $request)
    {
        \Log::info('=== INÍCIO STORE ATENDIMENTO ===');
        \Log::info('Método HTTP: ' . $request->method());
        \Log::info('URL: ' . $request->fullUrl());
        \Log::info('IP: ' . $request->ip());
        \Log::info('User Agent: ' . $request->userAgent());
        \Log::info('Dados recebidos:', $request->all());
        
        try {
            \Log::info('Iniciando validação...');
            
            $validated = $request->validate([
                'data' => 'required|date',
                'paciente_id' => 'required|exists:pacientes,id',
                'tipo' => 'required|in:clinica,domiciliar',
                'cidade_id' => 'required_if:tipo,domiciliar|nullable|exists:cidades,id',
                'cep' => 'nullable|string|max:9',
                'logradouro' => 'nullable|string|max:255',
                'numero' => 'nullable|string|max:20',
                'bairro' => 'nullable|string|max:100',
                'complemento' => 'nullable|string|max:100',
                'endereco_atendimento' => 'nullable|string|max:255',
                'observacoes' => 'nullable|string',
                'vacinas' => 'required|array|min:1',
                'vacinas.*.vacina_id' => 'required|exists:vacinas,id',
                'vacinas.*.quantidade' => 'required|integer|min:1',
                'vacinas.*.valor_unitario' => 'required|numeric|min:0',
                'vacinas.*.lote' => 'nullable|string|max:100',
                'vacinas.*.validade' => 'nullable|date',
            ]);
            
            \Log::info('✅ Validação passou!');
            \Log::info('Dados validados:', $validated);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ ERRO DE VALIDAÇÃO:');
            \Log::error($e->errors());
            throw $e;
        }

        DB::beginTransaction();
        try {
            \Log::info('Transaction iniciada');
            
            // Calcular valor total
            $valorTotal = 0;
            foreach ($validated['vacinas'] as $vacina) {
                $valorTotal += $vacina['quantidade'] * $vacina['valor_unitario'];
            }
            \Log::info('Valor total calculado: ' . $valorTotal);

            // Construir endereço completo a partir dos campos separados (se fornecidos)
            $enderecoAtendimento = $validated['endereco_atendimento'] ?? null;
            if (!$enderecoAtendimento && $validated['tipo'] === 'domiciliar') {
                $partes = array_filter([
                    $validated['logradouro'] ?? null,
                    $validated['numero'] ?? null,
                    $validated['bairro'] ?? null,
                    $validated['complemento'] ?? null,
                ]);
                
                if (!empty($partes)) {
                    $enderecoAtendimento = implode(', ', $partes);
                    if (!empty($validated['cep'])) {
                        $enderecoAtendimento .= ' - CEP: ' . $validated['cep'];
                    }
                }
            }

            \Log::info('Criando atendimento...');
            
            // Criar atendimento
            $atendimento = Atendimento::create([
                'data' => $validated['data'],
                'paciente_id' => $validated['paciente_id'],
                'tipo' => $validated['tipo'],
                'cidade_id' => $validated['cidade_id'] ?? null,
                'endereco_atendimento' => $enderecoAtendimento,
                'valor_total' => $valorTotal,
                'observacoes' => $validated['observacoes'] ?? null,
                'usuario_id' => Auth::id() ?? 1,
            ]);
            
            \Log::info('✅ Atendimento criado: ID ' . $atendimento->id);

            // Adicionar vacinas
            \Log::info('Adicionando vacinas...');
            foreach ($validated['vacinas'] as $vacinaData) {
                $valorTotalItem = $vacinaData['quantidade'] * $vacinaData['valor_unitario'];
                
                $atendimento->vacinas()->attach($vacinaData['vacina_id'], [
                    'quantidade' => $vacinaData['quantidade'],
                    'valor_unitario' => $vacinaData['valor_unitario'],
                    'valor_total' => $valorTotalItem,
                    'lote' => $vacinaData['lote'] ?? null,
                    'validade' => $vacinaData['validade'] ?? null,
                ]);
            }
            \Log::info('✅ Vacinas vinculadas');

            // Criar lançamento financeiro automático
            if ($valorTotal > 0) {
                \Log::info('Criando lançamento financeiro...');
                
                // Buscar categoria de "Atendimentos" ou criar se não existir
                $categoria = CategoriaFinanceira::firstOrCreate(
                    ['nome' => 'Atendimentos', 'tipo' => 'receita'],
                    ['cor' => '#10B981', 'icone' => '💉', 'ativo' => true]
                );

                // Buscar forma de pagamento padrão (Dinheiro)
                $formaPagamento = FormaPagamento::where('tipo', 'dinheiro')->first();
                if (!$formaPagamento) {
                    $formaPagamento = FormaPagamento::first();
                }

                Lancamento::create([
                    'tipo' => 'receita',
                    'descricao' => 'Atendimento #' . $atendimento->id . ' - ' . $atendimento->paciente->nome,
                    'valor' => $valorTotal,
                    'data' => $validated['data'],
                    'categoria_id' => $categoria->id,
                    'forma_pagamento_id' => $formaPagamento?->id,
                    'atendimento_id' => $atendimento->id,
                    'paciente_id' => $validated['paciente_id'],
                    'usuario_id' => Auth::id() ?? 1,
                    'status' => 'confirmado',
                ]);
                
                \Log::info('✅ Lançamento financeiro criado');
            }

            DB::commit();
            \Log::info('✅ Transaction comitada');
            \Log::info('Redirecionando para: atendimentos.show, ID: ' . $atendimento->id);

            return redirect()->route('atendimentos.show', $atendimento)
                ->with('success', 'Atendimento registrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('❌ ERRO ao criar atendimento:');
            \Log::error('Mensagem: ' . $e->getMessage());
            \Log::error('Arquivo: ' . $e->getFile() . ':' . $e->getLine());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Se for requisição AJAX, retornar JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao registrar atendimento: ' . $e->getMessage(),
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Erro ao registrar atendimento: ' . $e->getMessage())
                ->withErrors(['exception' => $e->getMessage()]);
        }
    }

    public function show(Atendimento $atendimento)
    {
        $atendimento->load(['paciente', 'cidade', 'vacinas', 'usuario']);
        return view('atendimentos.show', compact('atendimento'));
    }

    public function edit(Atendimento $atendimento)
    {
        $atendimento->load('vacinas');
        $pacientes = Paciente::where('ativo', true)->orderBy('nome')->get();
        $vacinas = Vacina::where('ativo', true)->orderBy('nome')->get();
        $cidades = Cidade::where('ativo', true)->orderBy('nome')->get();
        
        return view('atendimentos.edit', compact('atendimento', 'pacientes', 'vacinas', 'cidades'));
    }

    public function update(Request $request, Atendimento $atendimento)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo' => 'required|in:clinica,domiciliar',
            'cidade_id' => 'required_if:tipo,domiciliar|nullable|exists:cidades,id',
            'cep' => 'nullable|string|max:9',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:100',
            'complemento' => 'nullable|string|max:100',
            'endereco_atendimento' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'vacinas' => 'required|array|min:1',
            'vacinas.*.vacina_id' => 'required|exists:vacinas,id',
            'vacinas.*.quantidade' => 'required|integer|min:1',
            'vacinas.*.valor_unitario' => 'required|numeric|min:0',
            'vacinas.*.lote' => 'nullable|string|max:100',
            'vacinas.*.validade' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            // Calcular valor total
            $valorTotal = 0;
            foreach ($validated['vacinas'] as $vacina) {
                $valorTotal += $vacina['quantidade'] * $vacina['valor_unitario'];
            }

            // Construir endereço completo a partir dos campos separados (se fornecidos)
            $enderecoAtendimento = $validated['endereco_atendimento'] ?? null;
            if (!$enderecoAtendimento && $validated['tipo'] === 'domiciliar') {
                $partes = array_filter([
                    $validated['logradouro'] ?? null,
                    $validated['numero'] ?? null,
                    $validated['bairro'] ?? null,
                    $validated['complemento'] ?? null,
                ]);
                
                if (!empty($partes)) {
                    $enderecoAtendimento = implode(', ', $partes);
                    if (!empty($validated['cep'])) {
                        $enderecoAtendimento .= ' - CEP: ' . $validated['cep'];
                    }
                }
            }

            // Atualizar atendimento
            $atendimento->update([
                'data' => $validated['data'],
                'paciente_id' => $validated['paciente_id'],
                'tipo' => $validated['tipo'],
                'cidade_id' => $validated['cidade_id'] ?? null,
                'endereco_atendimento' => $enderecoAtendimento,
                'valor_total' => $valorTotal,
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            // Remover vacinas antigas
            $atendimento->vacinas()->detach();

            // Adicionar vacinas atualizadas
            foreach ($validated['vacinas'] as $vacinaData) {
                $valorTotalItem = $vacinaData['quantidade'] * $vacinaData['valor_unitario'];
                
                $atendimento->vacinas()->attach($vacinaData['vacina_id'], [
                    'quantidade' => $vacinaData['quantidade'],
                    'valor_unitario' => $vacinaData['valor_unitario'],
                    'valor_total' => $valorTotalItem,
                    'lote' => $vacinaData['lote'] ?? null,
                    'validade' => $vacinaData['validade'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('atendimentos.show', $atendimento)
                ->with('success', 'Atendimento atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erro ao atualizar atendimento: ' . $e->getMessage());
        }
    }

    public function destroy(Atendimento $atendimento)
    {
        DB::beginTransaction();
        try {
            \Log::info('🗑️ Iniciando exclusão do atendimento ID: ' . $atendimento->id);
            
            // 1. Excluir lançamentos financeiros relacionados
            $lancamentosExcluidos = Lancamento::where('atendimento_id', $atendimento->id)->delete();
            \Log::info("   ✅ Excluídos {$lancamentosExcluidos} lançamento(s) financeiro(s)");
            
            // 2. Desvincular vacinas (pivot table)
            $vacinasDesvinculadas = $atendimento->vacinas()->detach();
            \Log::info("   ✅ Desvinculadas {$vacinasDesvinculadas} vacina(s)");
            
            // 3. Excluir o atendimento
            $atendimento->delete();
            \Log::info('   ✅ Atendimento excluído com sucesso');
            
            DB::commit();
            
            return redirect()->route('atendimentos.index')
                ->with('success', 'Atendimento removido com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('❌ Erro ao excluir atendimento: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Erro ao excluir atendimento: ' . $e->getMessage());
        }
    }
}
