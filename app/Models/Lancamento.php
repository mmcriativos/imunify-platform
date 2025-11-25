<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lancamentos';

    protected $fillable = [
        'caixa_id',
        'categoria_id',
        'forma_pagamento_id',
        'atendimento_id',
        'paciente_id',
        'usuario_id',
        'tipo',
        'descricao',
        'numero_documento',
        'valor',
        'valor_juros',
        'valor_multa',
        'valor_desconto',
        'data',
        'data_vencimento',
        'data_pagamento',
        'hora',
        'parcela_numero',
        'parcela_total',
        'status',
        'conciliado',
        'data_conciliacao',
        'observacoes',
        'metadata'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'valor_juros' => 'decimal:2',
        'valor_multa' => 'decimal:2',
        'valor_desconto' => 'decimal:2',
        'data' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'data_conciliacao' => 'date',
        'conciliado' => 'boolean',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function caixa()
    {
        return $this->belongsTo(Caixa::class);
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaFinanceira::class, 'categoria_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimento::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function conciliacaoCartao()
    {
        return $this->hasOne(ConciliacaoCartao::class, 'lancamento_id');
    }

    // Scopes
    public function scopeReceitas($query)
    {
        return $query->where('tipo', 'receita');
    }

    public function scopeDespesas($query)
    {
        return $query->where('tipo', 'despesa');
    }

    public function scopeConfirmado($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeCancelado($query)
    {
        return $query->where('status', 'cancelado');
    }

    public function scopeHoje($query)
    {
        return $query->whereDate('data', today());
    }

    public function scopePeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('data', [$inicio, $fim]);
    }

    public function scopeCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function scopeFormaPagamento($query, $formaPagamentoId)
    {
        return $query->where('forma_pagamento_id', $formaPagamentoId);
    }

    public function scopePaciente($query, $pacienteId)
    {
        return $query->where('paciente_id', $pacienteId);
    }

    public function scopeVencidas($query)
    {
        return $query->where('status', 'pendente')
            ->whereNotNull('data_vencimento')
            ->whereDate('data_vencimento', '<', now());
    }

    public function scopeAVencer($query, $dias = 7)
    {
        return $query->where('status', 'pendente')
            ->whereNotNull('data_vencimento')
            ->whereDate('data_vencimento', '>=', now())
            ->whereDate('data_vencimento', '<=', now()->addDays($dias));
    }

    public function scopeVencimentoHoje($query)
    {
        return $query->where('status', 'pendente')
            ->whereNotNull('data_vencimento')
            ->whereDate('data_vencimento', now());
    }

    // Helpers
    public function isReceita()
    {
        return $this->tipo === 'receita';
    }

    public function isDespesa()
    {
        return $this->tipo === 'despesa';
    }

    public function isConfirmado()
    {
        return $this->status === 'confirmado';
    }

    public function isPendente()
    {
        return $this->status === 'pendente';
    }

    public function isCancelado()
    {
        return $this->status === 'cancelado';
    }

    public function marcarComoConfirmado()
    {
        $this->status = 'confirmado';
        return $this->save();
    }

    public function cancelar()
    {
        $this->status = 'cancelado';
        return $this->save();
    }

    public function marcarComoPago($dataPagamento = null)
    {
        $this->status = 'confirmado';
        $this->data_pagamento = $dataPagamento ?? now();
        return $this->save();
    }

    public function isVencida()
    {
        return $this->status === 'pendente' 
            && $this->data_vencimento 
            && $this->data_vencimento->isPast();
    }

    public function diasAtraso()
    {
        if (!$this->isVencida()) {
            return 0;
        }
        return now()->diffInDays($this->data_vencimento);
    }

    public function getValorTotalAttribute()
    {
        return $this->valor + $this->valor_juros + $this->valor_multa - $this->valor_desconto;
    }

    public function getValorLiquidoAttribute()
    {
        if ($this->formaPagamento) {
            return $this->formaPagamento->calcularValorLiquido($this->valor);
        }
        return $this->valor;
    }

    public function getDescricaoCompletaAttribute()
    {
        $desc = $this->descricao;
        
        if ($this->paciente) {
            $desc .= " - {$this->paciente->nome}";
        }
        
        return $desc;
    }
}
