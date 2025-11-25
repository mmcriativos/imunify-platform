<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Vacina extends Model
{
    protected $table = 'vacinas';

    /**
     * Relacionamento com esquema de doses
     */
    public function esquemaDoses()
    {
        return $this->hasMany(VacinaEsquemaDose::class)->ordenadas();
    }

    protected $fillable = [
        'nome',
        'fabricante',
        'modo_agir',
        'indicacoes',
        'descricao',
        'preco_custo',
        'preco_venda_cartao',
        'preco_venda_pix',
        'preco_promocional',
        'validade_dias',
        'numero_doses',
        'intervalo_doses_dias',
        'ativo',
        // Controle de Estoque
        'estoque_atual',
        'estoque_minimo',
        'estoque_ideal',
        'lote_atual',
        'validade_lote',
        // Fornecedor
        'fornecedor_nome',
        'fornecedor_cnpj',
        'fornecedor_contato',
        // Qualidade
        'registro_anvisa',
        'codigo_barras',
        'categoria',
        // Rastreabilidade
        'origem_compra',
        'temperatura_armazenamento_min',
        'temperatura_armazenamento_max',
        // Financeiro
        'custo_medio',
        'margem_lucro',
        // Status
        'status',
        'observacoes_estoque',
        // Alertas
        'alerta_validade',
        'dias_alerta_validade',
        'alerta_estoque_baixo',
    ];

    protected $casts = [
        'temperatura_armazenamento_min' => 'decimal:1',
        'temperatura_armazenamento_max' => 'decimal:1',
        'custo_medio' => 'decimal:2',
        'margem_lucro' => 'decimal:2',
        'preco_custo' => 'decimal:2',
        'preco_venda_cartao' => 'decimal:2',
        'preco_venda_pix' => 'decimal:2',
        'preco_promocional' => 'decimal:2',
        'validade_lote' => 'date',
        'alerta_validade' => 'boolean',
        'alerta_estoque_baixo' => 'boolean',
        'ativo' => 'boolean',
    ];

    public function atendimentos(): BelongsToMany
    {
        return $this->belongsToMany(Atendimento::class, 'atendimento_vacina')
            ->withPivot(['id','quantidade','valor_unitario','valor_total','lote','validade'])
            ->withTimestamps();
    }

    public function lotes(): HasMany
    {
        return $this->hasMany(VacinaLote::class);
    }

    public function lotesDisponiveis(): HasMany
    {
        return $this->hasMany(VacinaLote::class)
            ->where('status', 'Disponivel')
            ->where('quantidade_atual', '>', 0);
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(EstoqueMovimentacao::class);
    }

    // Scopes
    public function scopeComEstoqueBaixo($query)
    {
        return $query->whereColumn('estoque_atual', '<', 'estoque_minimo');
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'Ativo');
    }

    // Acessors
    public function getEstoqueBaixoAttribute(): bool
    {
        return $this->estoque_atual < $this->estoque_minimo;
    }

    public function getTemLotesVencendoAttribute(): bool
    {
        return $this->lotes()
            ->where('status', 'Disponivel')
            ->where('data_validade', '<=', Carbon::now()->addDays($this->dias_alerta_validade ?? 30))
            ->exists();
    }

    public function getValorEstoqueAttribute(): float
    {
        return $this->estoque_atual * ($this->custo_medio ?? $this->preco_custo ?? 0);
    }

    public function getMargemLucroCalculadaAttribute(): ?float
    {
        if (!$this->preco_venda_pix || !$this->custo_medio) {
            return null;
        }
        
        return (($this->preco_venda_pix - $this->custo_medio) / $this->custo_medio) * 100;
    }
}
