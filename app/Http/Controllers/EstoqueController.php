<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacina;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class EstoqueController extends Controller
{
    /**
     * Exibe a página de gerenciamento de estoque
     */
    public function index(Request $request)
    {
        $query = Vacina::query();
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('fabricante', 'like', "%{$search}%")
                  ->orWhere('lote_atual', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $status = $request->get('status');
            switch ($status) {
                case 'zerado':
                    $query->where('estoque_atual', 0);
                    break;
                case 'baixo':
                    $query->whereColumn('estoque_atual', '<=', 'estoque_minimo')
                          ->where('estoque_atual', '>', 0);
                    break;
                case 'normal':
                    $query->whereColumn('estoque_atual', '>', 'estoque_minimo');
                    break;
            }
        }
        
        if ($request->filled('vacina')) {
            $query->where('id', $request->get('vacina'));
        }
        
        $vacinas = $query->orderBy('nome')->get();
        
        // Estatísticas do estoque
        $estatisticas = [
            'total_vacinas' => $vacinas->count(),
            'estoque_zerado' => $vacinas->where('estoque_atual', 0)->count(),
            'estoque_baixo' => $vacinas->filter(function ($v) {
                return $v->estoque_atual > 0 && $v->estoque_atual <= $v->estoque_minimo;
            })->count(),
            'estoque_normal' => $vacinas->filter(function ($v) {
                return $v->estoque_atual > $v->estoque_minimo;
            })->count(),
            'valor_total_estoque' => $vacinas->sum(function ($v) {
                return $v->estoque_atual * ($v->preco_custo ?? 0);
            })
        ];
        
        return view('vacinas.estoque-manager', compact('vacinas', 'estatisticas'));
    }
    
    /**
     * Ajusta o estoque para uma quantidade específica
     */
    public function ajustar(Request $request, Vacina $vacina)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:0',
            'motivo' => 'nullable|string|max:255',
            'lote' => 'nullable|string|max:100',
            'validade' => 'nullable|date'
        ]);
        
        $quantidadeAnterior = $vacina->estoque_atual ?? 0;
        $novaQuantidade = $request->input('quantidade');
        
        DB::beginTransaction();
        
        try {
            // Prepara dados para atualização
            $updateData = [
                'estoque_atual' => $novaQuantidade,
                'updated_at' => now()
            ];
            
            // Só adiciona os campos de lote se existirem na tabela
            if (Schema::hasColumn('vacinas', 'lote_atual') && $request->filled('lote')) {
                $updateData['lote_atual'] = $request->input('lote');
            }
            
            if (Schema::hasColumn('vacinas', 'validade_lote') && $request->filled('validade')) {
                $updateData['validade_lote'] = Carbon::parse($request->input('validade'));
            }
            
            // Atualiza o estoque
            $vacina->update($updateData);
            
            // Registra a movimentação no histórico (se existir tabela)
            $this->registrarMovimentacao($vacina, [
                'tipo' => 'ajuste',
                'quantidade_anterior' => $quantidadeAnterior,
                'quantidade_nova' => $novaQuantidade,
                'diferenca' => $novaQuantidade - $quantidadeAnterior,
                'motivo' => $request->input('motivo') ?? 'Ajuste manual',
                'lote' => $request->input('lote'),
                'validade' => $request->input('validade'),
                'usuario_id' => Auth::id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estoque ajustado com sucesso!',
                'estoque_atual' => $novaQuantidade,
                'status' => $this->getStatusEstoque($vacina->fresh())
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao ajustar estoque: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Adiciona quantidade ao estoque
     */
    public function adicionar(Request $request, Vacina $vacina)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
            'lote' => 'nullable|string|max:100',
            'validade' => 'nullable|date'
        ]);
        
        $quantidadeAnterior = $vacina->estoque_atual ?? 0;
        $quantidadeAdicionar = $request->input('quantidade');
        $novaQuantidade = $quantidadeAnterior + $quantidadeAdicionar;
        
        DB::beginTransaction();
        
        try {
            // Prepara dados para atualização
            $updateData = [
                'estoque_atual' => $novaQuantidade,
                'updated_at' => now()
            ];
            
            // Só adiciona os campos de lote se existirem na tabela
            if (Schema::hasColumn('vacinas', 'lote_atual') && $request->filled('lote')) {
                $updateData['lote_atual'] = $request->input('lote');
            }
            
            if (Schema::hasColumn('vacinas', 'validade_lote') && $request->filled('validade')) {
                $updateData['validade_lote'] = Carbon::parse($request->input('validade'));
            }
            
            $vacina->update($updateData);
            
            $this->registrarMovimentacao($vacina, [
                'tipo' => 'entrada',
                'quantidade_anterior' => $quantidadeAnterior,
                'quantidade_nova' => $novaQuantidade,
                'diferenca' => $quantidadeAdicionar,
                'motivo' => $request->input('motivo') ?? 'Entrada de estoque',
                'lote' => $request->input('lote'),
                'validade' => $request->input('validade'),
                'usuario_id' => Auth::id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$quantidadeAdicionar} unidades adicionadas!",
                'estoque_atual' => $novaQuantidade,
                'status' => $this->getStatusEstoque($vacina->fresh())
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao adicionar estoque: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove quantidade do estoque
     */
    public function remover(Request $request, Vacina $vacina)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255'
        ]);
        
        $quantidadeAnterior = $vacina->estoque_atual ?? 0;
        $quantidadeRemover = $request->input('quantidade');
        
        if ($quantidadeRemover > $quantidadeAnterior) {
            return response()->json([
                'success' => false,
                'message' => 'Quantidade a remover é maior que o estoque atual!'
            ], 400);
        }
        
        $novaQuantidade = $quantidadeAnterior - $quantidadeRemover;
        
        DB::beginTransaction();
        
        try {
            $vacina->update([
                'estoque_atual' => $novaQuantidade,
                'updated_at' => now()
            ]);
            
            $this->registrarMovimentacao($vacina, [
                'tipo' => 'saida',
                'quantidade_anterior' => $quantidadeAnterior,
                'quantidade_nova' => $novaQuantidade,
                'diferenca' => -$quantidadeRemover,
                'motivo' => $request->input('motivo') ?? 'Saída de estoque',
                'usuario_id' => Auth::id()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$quantidadeRemover} unidades removidas!",
                'estoque_atual' => $novaQuantidade,
                'status' => $this->getStatusEstoque($vacina->fresh())
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover estoque: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exibe histórico de movimentações
     */
    public function historico(Vacina $vacina)
    {
        // Implementar quando houver tabela de movimentações
        return response()->json([
            'success' => true,
            'historico' => []
        ]);
    }
    
    /**
     * Registra movimentação no histórico (se tabela existir)
     */
    private function registrarMovimentacao($vacina, $dados)
    {
        // Por enquanto apenas log - implementar tabela de movimentações se necessário
        Log::info('Movimentação de Estoque', array_merge([
            'vacina_id' => $vacina->id,
            'vacina_nome' => $vacina->nome,
            'tenant_id' => tenant('id')
        ], $dados));
    }
    
    /**
     * Retorna o status do estoque
     */
    private function getStatusEstoque($vacina)
    {
        $atual = $vacina->estoque_atual ?? 0;
        $minimo = $vacina->estoque_minimo ?? 10;
        
        if ($atual == 0) {
            return ['status' => 'danger', 'text' => 'Zerado', 'color' => 'red'];
        } elseif ($atual <= $minimo) {
            return ['status' => 'warning', 'text' => 'Baixo', 'color' => 'yellow'];
        } else {
            return ['status' => 'success', 'text' => 'Normal', 'color' => 'green'];
        }
    }
}
