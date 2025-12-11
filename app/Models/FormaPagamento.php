<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $table = 'formas_pagamento';

    protected $fillable = [
        'nome',
        'tipo',
        'taxa_percentual',
        'taxa_fixa',
        'prazo_recebimento_dias',
        'requer_conciliacao',
        'cor',
        'icone',
        'ativo'
    ];

    protected $casts = [
        'taxa_percentual' => 'decimal:4',
        'taxa_fixa' => 'decimal:2',
        'prazo_recebimento_dias' => 'integer',
        'requer_conciliacao' => 'boolean',
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function lancamentos()
    {
        return $this->hasMany(Lancamento::class, 'forma_pagamento_id');
    }

    public function conciliacoes()
    {
        return $this->hasMany(ConciliacaoCartao::class, 'forma_pagamento_id');
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeRequerConciliacao($query)
    {
        return $query->where('requer_conciliacao', true);
    }

    public function scopeDinheiro($query)
    {
        return $query->where('tipo', 'dinheiro');
    }

    public function scopePix($query)
    {
        return $query->where('tipo', 'pix');
    }

    public function scopeCartao($query)
    {
        return $query->whereIn('tipo', ['cartao_debito', 'cartao_credito']);
    }

    // Helpers
    public function calcularValorLiquido($valorBruto)
    {
        $desconto = 0;
        
        if ($this->taxa_percentual > 0) {
            $desconto += ($valorBruto * $this->taxa_percentual / 100);
        }
        
        if ($this->taxa_fixa > 0) {
            $desconto += $this->taxa_fixa;
        }
        
        return $valorBruto - $desconto;
    }

    public function calcularDataRecebimento($dataBase = null)
    {
        $data = $dataBase ? \Carbon\Carbon::parse($dataBase) : now();
        return $data->addDays($this->prazo_recebimento_dias ?? 0);
    }

    public function isCartao()
    {
        return in_array($this->tipo, ['cartao_debito', 'cartao_credito']);
    }

    public function isDinheiro()
    {
        return $this->tipo === 'dinheiro';
    }

    public function isPix()
    {
        return $this->tipo === 'pix';
    }
}
