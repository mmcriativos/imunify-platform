<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class VacinaLote extends Model
{
    protected $table = 'vacina_lotes';

    protected $fillable = [
        'vacina_id',
        'numero_lote',
        'lote_interno',
        'data_fabricacao',
        'data_validade',
        'data_recebimento',
        'quantidade_recebida',
        'quantidade_atual',
        'quantidade_utilizada',
        'preco_unitario_compra',
        'valor_total_compra',
        'numero_nota_fiscal',
        'data_compra',
        'fornecedor_lote',
        'observacoes',
        'status',
        'origem_distribuicao',
        'historico_temperatura',
    ];

    protected $casts = [
        'data_fabricacao' => 'date',
        'data_validade' => 'date',
        'data_recebimento' => 'date',
        'data_compra' => 'date',
        'preco_unitario_compra' => 'decimal:2',
        'valor_total_compra' => 'decimal:2',
        'historico_temperatura' => 'array',
    ];

    public function vacina(): BelongsTo
    {
        return $this->belongsTo(Vacina::class);
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(EstoqueMovimentacao::class, 'lote_id');
    }

    // Scopes
    public function scopeDisponiveis($query)
    {
        return $query->where('status', 'Disponivel')
                    ->where('quantidade_atual', '>', 0);
    }

    public function scopeVencendo($query, $dias = 30)
    {
        return $query->where('data_validade', '<=', Carbon::now()->addDays($dias))
                    ->where('status', 'Disponivel');
    }

    public function scopeVencidos($query)
    {
        return $query->where('data_validade', '<', Carbon::now())
                    ->where('status', '!=', 'Vencido');
    }

    // Accessors
    public function getVencidoAttribute(): bool
    {
        return $this->data_validade < Carbon::now();
    }

    public function getVencendoAttribute(): bool
    {
        $diasAlerta = $this->vacina->dias_alerta_validade ?? 30;
        return $this->data_validade <= Carbon::now()->addDays($diasAlerta);
    }

    public function getDiasParaVencerAttribute(): int
    {
        return Carbon::now()->diffInDays($this->data_validade, false);
    }

    public function getValorTotalAtualAttribute(): float
    {
        return $this->quantidade_atual * ($this->preco_unitario_compra ?? 0);
    }
}
