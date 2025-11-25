<?php

namespace App\Services;

use App\Models\Vacina;
use App\Models\VacinaLote;
use App\Models\EstoqueMovimentacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstoqueService
{
    /**
     * Registra uma movimentação de estoque
     */
    public function registrarMovimentacao(
        int $vacinaId,
        string $tipo,
        int $quantidade,
        array $dados = []
    ): EstoqueMovimentacao {
        return DB::transaction(function () use ($vacinaId, $tipo, $quantidade, $dados) {
            $vacina = Vacina::findOrFail($vacinaId);
            $estoqueAnterior = $vacina->estoque_atual;

            // Calcula novo estoque baseado no tipo de movimentação
            $novoEstoque = $this->calcularNovoEstoque($estoqueAnterior, $tipo, $quantidade);

            // Atualiza estoque da vacina
            $vacina->update(['estoque_atual' => $novoEstoque]);

            // Se for entrada, pode precisar atualizar custo médio
            if (in_array($tipo, ['entrada', 'ajuste']) && isset($dados['custo_unitario'])) {
                $this->atualizarCustoMedio($vacina, $quantidade, $dados['custo_unitario']);
            }

            // Registra a movimentação
            $movimentacao = EstoqueMovimentacao::create([
                'vacina_id' => $vacinaId,
                'lote_id' => $dados['lote_id'] ?? null,
                'user_id' => Auth::id(),
                'tipo' => $tipo,
                'quantidade' => $quantidade,
                'estoque_anterior' => $estoqueAnterior,
                'estoque_atual' => $novoEstoque,
                'motivo' => $dados['motivo'] ?? null,
                'observacoes' => $dados['observacoes'] ?? null,
                'documento_referencia' => $dados['documento_referencia'] ?? null,
                'atendimento_id' => $dados['atendimento_id'] ?? null,
                'paciente_id' => $dados['paciente_id'] ?? null,
                'custo_unitario' => $dados['custo_unitario'] ?? null,
                'custo_total' => isset($dados['custo_unitario']) ? $quantidade * $dados['custo_unitario'] : null,
            ]);

            return $movimentacao;
        });
    }

    /**
     * Entrada de lote
     */
    public function entradaLote(array $dadosLote): VacinaLote
    {
        return DB::transaction(function () use ($dadosLote) {
            // Cria o lote
            $lote = VacinaLote::create($dadosLote);

            // Registra movimentação de entrada
            $this->registrarMovimentacao(
                $lote->vacina_id,
                'entrada',
                $lote->quantidade_recebida,
                [
                    'lote_id' => $lote->id,
                    'motivo' => 'Entrada de lote: ' . $lote->numero_lote,
                    'custo_unitario' => $lote->preco_unitario_compra,
                    'documento_referencia' => $lote->numero_nota_fiscal,
                ]
            );

            return $lote;
        });
    }

    /**
     * Verifica alertas de estoque e validade
     */
    public function verificarAlertas(): array
    {
        $alertas = [];

        // Estoque baixo
        $vacinasEstoqueBaixo = Vacina::comEstoqueBaixo()
            ->where('alerta_estoque_baixo', true)
            ->get();

        foreach ($vacinasEstoqueBaixo as $vacina) {
            $alertas[] = [
                'tipo' => 'estoque_baixo',
                'vacina_id' => $vacina->id,
                'vacina_nome' => $vacina->nome,
                'estoque_atual' => $vacina->estoque_atual,
                'estoque_minimo' => $vacina->estoque_minimo,
                'prioridade' => $vacina->estoque_atual == 0 ? 'alta' : 'media'
            ];
        }

        // Lotes vencendo
        $lotesVencendo = VacinaLote::with('vacina')
            ->vencendo()
            ->get();

        foreach ($lotesVencendo as $lote) {
            $alertas[] = [
                'tipo' => 'validade',
                'vacina_id' => $lote->vacina_id,
                'lote_id' => $lote->id,
                'vacina_nome' => $lote->vacina->nome,
                'numero_lote' => $lote->numero_lote,
                'data_validade' => $lote->data_validade,
                'dias_para_vencer' => $lote->dias_para_vencer,
                'quantidade' => $lote->quantidade_atual,
                'prioridade' => $lote->vencido ? 'alta' : ($lote->dias_para_vencer <= 7 ? 'alta' : 'media')
            ];
        }

        return $alertas;
    }

    /**
     * Calcula novo estoque baseado no tipo de movimentação
     */
    private function calcularNovoEstoque(int $estoqueAtual, string $tipo, int $quantidade): int
    {
        $tiposEntrada = ['entrada', 'devolucao'];
        $tiposSaida = ['saida', 'aplicacao', 'perda', 'vencimento'];

        if (in_array($tipo, $tiposEntrada)) {
            return $estoqueAtual + $quantidade;
        } elseif (in_array($tipo, $tiposSaida)) {
            return max(0, $estoqueAtual - $quantidade);
        } elseif ($tipo === 'ajuste') {
            return $quantidade; // Ajuste define o valor absoluto
        }

        return $estoqueAtual;
    }

    /**
     * Atualiza custo médio ponderado
     */
    private function atualizarCustoMedio(Vacina $vacina, int $quantidade, float $custoUnitario): void
    {
        $estoqueTotalAntes = $vacina->estoque_atual - $quantidade;
        $custoMedioAtual = $vacina->custo_medio ?? 0;

        if ($estoqueTotalAntes > 0) {
            $valorTotalAntes = $estoqueTotalAntes * $custoMedioAtual;
            $valorNovaEntrada = $quantidade * $custoUnitario;
            $novoValorTotal = $valorTotalAntes + $valorNovaEntrada;
            $novoCustoMedio = $novoValorTotal / $vacina->estoque_atual;
        } else {
            $novoCustoMedio = $custoUnitario;
        }

        $vacina->update(['custo_medio' => $novoCustoMedio]);
    }
}
