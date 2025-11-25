<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConciliacaoCartao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conciliacoes_cartao';

    protected $fillable = [
        'lancamento_id',
        'forma_pagamento_id',
        'nsu',
        'codigo_autorizacao',
        'bandeira',
        'numero_parcelas',
        'valor_bruto',
        'valor_taxa',
        'valor_liquido',
        'data_venda',
        'data_recebimento_prevista',
        'data_recebimento_real',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'numero_parcelas' => 'integer',
        'valor_bruto' => 'decimal:2',
        'valor_taxa' => 'decimal:2',
        'valor_liquido' => 'decimal:2',
        'data_venda' => 'date',
        'data_recebimento_prevista' => 'date',
        'data_recebimento_real' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function lancamento()
    {
        return $this->belongsTo(Lancamento::class);
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    // Scopes
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeRecebido($query)
    {
        return $query->where('status', 'recebido');
    }

    public function scopeCancelado($query)
    {
        return $query->where('status', 'cancelado');
    }

    public function scopeContestado($query)
    {
        return $query->where('status', 'contestado');
    }

    public function scopeVencidas($query)
    {
        return $query->where('status', 'pendente')
            ->where('data_recebimento_prevista', '<', today());
    }

    public function scopePeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('data_venda', [$inicio, $fim]);
    }

    public function scopeBandeira($query, $bandeira)
    {
        return $query->where('bandeira', $bandeira);
    }

    // Helpers
    public function isPendente()
    {
        return $this->status === 'pendente';
    }

    public function isRecebido()
    {
        return $this->status === 'recebido';
    }

    public function isCancelado()
    {
        return $this->status === 'cancelado';
    }

    public function isContestado()
    {
        return $this->status === 'contestado';
    }

    public function isVencido()
    {
        return $this->isPendente() && $this->data_recebimento_prevista < today();
    }

    public function marcarComoRecebido($dataRecebimento = null)
    {
        $this->status = 'recebido';
        $this->data_recebimento_real = $dataRecebimento ?? today();
        return $this->save();
    }

    public function contestar($observacoes = null)
    {
        $this->status = 'contestado';
        if ($observacoes) {
            $this->observacoes = $observacoes;
        }
        return $this->save();
    }

    public function cancelar()
    {
        $this->status = 'cancelado';
        return $this->save();
    }

    public function calcularDiasAtraso()
    {
        if (!$this->isPendente() || !$this->isVencido()) {
            return 0;
        }
        
        return today()->diffInDays($this->data_recebimento_prevista);
    }

    public function getDescricaoCompletaAttribute()
    {
        $desc = "{$this->bandeira} - NSU: {$this->nsu}";
        
        if ($this->numero_parcelas > 1) {
            $desc .= " ({$this->numero_parcelas}x)";
        }
        
        return $desc;
    }
}
