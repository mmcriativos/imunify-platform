<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstoqueMovimentacao extends Model
{
    protected $table = 'estoque_movimentacoes';

    protected $fillable = [
        'vacina_id',
        'lote_id',
        'user_id',
        'tipo',
        'quantidade',
        'estoque_anterior',
        'estoque_atual',
        'motivo',
        'observacoes',
        'documento_referencia',
        'atendimento_id',
        'paciente_id',
        'custo_unitario',
        'custo_total',
    ];

    protected $casts = [
        'custo_unitario' => 'decimal:2',
        'custo_total' => 'decimal:2',
    ];

    public function vacina(): BelongsTo
    {
        return $this->belongsTo(Vacina::class);
    }

    public function lote(): BelongsTo
    {
        return $this->belongsTo(VacinaLote::class, 'lote_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function atendimento(): BelongsTo
    {
        return $this->belongsTo(Atendimento::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->whereIn('tipo', ['entrada', 'ajuste', 'devolucao']);
    }

    public function scopeSaidas($query)
    {
        return $query->whereIn('tipo', ['saida', 'aplicacao', 'perda', 'vencimento']);
    }

    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('created_at', [$dataInicio, $dataFim]);
    }

    // Accessors
    public function getTipoDescricaoAttribute(): string
    {
        $tipos = [
            'entrada' => 'Entrada',
            'saida' => 'Saída',
            'ajuste' => 'Ajuste',
            'perda' => 'Perda',
            'vencimento' => 'Vencimento',
            'transferencia' => 'Transferência',
            'devolucao' => 'Devolução',
            'aplicacao' => 'Aplicação'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    public function getCorTipoAttribute(): string
    {
        $cores = [
            'entrada' => 'green',
            'saida' => 'red',
            'ajuste' => 'blue',
            'perda' => 'red',
            'vencimento' => 'orange',
            'transferencia' => 'purple',
            'devolucao' => 'green',
            'aplicacao' => 'blue'
        ];

        return $cores[$this->tipo] ?? 'gray';
    }
}
