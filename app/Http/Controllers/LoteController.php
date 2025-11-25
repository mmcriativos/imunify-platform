<?php

namespace App\Http\Controllers;

use App\Models\Vacina;
use App\Models\VacinaLote;
use App\Models\EstoqueMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = VacinaLote::with('vacina')
            ->orderBy('data_validade')
            ->paginate(20);
            
        $vacinas = Vacina::where('ativo', true)
            ->orderBy('nome')
            ->get();
            
        return view('lotes.index', compact('lotes', 'vacinas'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vacina_id' => 'required|exists:vacinas,id',
            'numero_lote' => 'required|string|max:100',
            'data_fabricacao' => 'nullable|date',
            'data_validade' => 'required|date|after:today',
            'data_recebimento' => 'nullable|date',
            'quantidade_recebida' => 'required|integer|min:1',
            'preco_unitario_compra' => 'required|numeric|min:0',
            'numero_nota_fiscal' => 'nullable|string|max:100',
            'fornecedor_lote' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Criar o lote
            $lote = VacinaLote::create([
                'vacina_id' => $validated['vacina_id'],
                'numero_lote' => $validated['numero_lote'],
                'data_fabricacao' => $validated['data_fabricacao'] ?? null,
                'data_validade' => $validated['data_validade'],
                'data_recebimento' => $validated['data_recebimento'] ?? now(),
                'data_compra' => $validated['data_recebimento'] ?? now(),
                'quantidade_recebida' => $validated['quantidade_recebida'],
                'quantidade_atual' => $validated['quantidade_recebida'],
                'quantidade_utilizada' => 0,
                'preco_unitario_compra' => $validated['preco_unitario_compra'],
                'valor_total_compra' => $validated['quantidade_recebida'] * $validated['preco_unitario_compra'],
                'numero_nota_fiscal' => $validated['numero_nota_fiscal'] ?? null,
                'fornecedor_lote' => $validated['fornecedor_lote'] ?? null,
                'observacoes' => $validated['observacoes'] ?? null,
                'status' => 'Disponivel',
            ]);
            
            // Atualizar estoque da vacina
            $vacina = Vacina::findOrFail($validated['vacina_id']);
            $estoqueAnterior = $vacina->estoque_atual ?? 0;
            $novoEstoque = $estoqueAnterior + $validated['quantidade_recebida'];
            
            // Calcular custo médio ponderado
            $custoTotal = ($estoqueAnterior * ($vacina->custo_medio ?? $vacina->preco_custo ?? 0)) + 
                          ($validated['quantidade_recebida'] * $validated['preco_unitario_compra']);
            $custoMedio = $novoEstoque > 0 ? $custoTotal / $novoEstoque : $validated['preco_unitario_compra'];
            
            // Atualizar apenas campos que existem
            $updateData = [
                'estoque_atual' => $novoEstoque,
                'custo_medio' => $custoMedio,
            ];
            
            // Adicionar campos opcionais apenas se existirem na tabela
            if (Schema::hasColumn('vacinas', 'lote_atual')) {
                $updateData['lote_atual'] = $validated['numero_lote'];
            }
            
            if (Schema::hasColumn('vacinas', 'validade_lote')) {
                $updateData['validade_lote'] = $validated['data_validade'];
            }
            
            $vacina->update($updateData);
            
            // Registrar movimentação
            EstoqueMovimentacao::create([
                'vacina_id' => $validated['vacina_id'],
                'lote_id' => $lote->id,
                'tipo' => 'Entrada',
                'quantidade' => $validated['quantidade_recebida'],
                'estoque_anterior' => $estoqueAnterior,
                'estoque_atual' => $novoEstoque,
                'motivo' => 'Entrada de Lote',
                'observacoes' => "Lote: {$validated['numero_lote']} - NF: " . ($validated['numero_nota_fiscal'] ?? 'N/A'),
                'user_id' => auth()->id(),
                'data_movimentacao' => now(),
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Lote cadastrado com sucesso!',
                'lote' => $lote->load('vacina'),
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar lote: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function show(VacinaLote $lote)
    {
        $lote->load(['vacina', 'movimentacoes.user']);
        return response()->json($lote);
    }
    
    public function update(Request $request, VacinaLote $lote)
    {
        $validated = $request->validate([
            'numero_lote' => 'required|string|max:100',
            'data_fabricacao' => 'nullable|date',
            'data_validade' => 'required|date',
            'fornecedor_lote' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:Disponivel,Em Uso,Esgotado,Vencido,Bloqueado',
        ]);
        
        $lote->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Lote atualizado com sucesso!',
            'lote' => $lote->load('vacina'),
        ]);
    }
    
    public function destroy(VacinaLote $lote)
    {
        if ($lote->quantidade_utilizada > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir um lote que já foi utilizado.',
            ], 400);
        }
        
        DB::beginTransaction();
        try {
            // Reverter estoque
            $vacina = $lote->vacina;
            $vacina->decrement('estoque_atual', $lote->quantidade_atual);
            
            // Registrar movimentação
            EstoqueMovimentacao::create([
                'vacina_id' => $lote->vacina_id,
                'lote_id' => $lote->id,
                'tipo' => 'Ajuste',
                'quantidade' => -$lote->quantidade_atual,
                'estoque_anterior' => $vacina->estoque_atual + $lote->quantidade_atual,
                'estoque_atual' => $vacina->estoque_atual,
                'motivo' => 'Exclusão de Lote',
                'observacoes' => "Lote excluído: {$lote->numero_lote}",
                'user_id' => auth()->id(),
                'data_movimentacao' => now(),
            ]);
            
            $lote->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Lote excluído com sucesso!',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir lote: ' . $e->getMessage(),
            ], 500);
        }
    }
}
