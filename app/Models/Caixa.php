<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caixa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'caixas';

    protected $fillable = [
        'data',
        'hora_abertura',
        'hora_fechamento',
        'saldo_inicial',
        'saldo_final',
        'total_entradas',
        'total_saidas',
        'saldo_esperado',
        'diferenca',
        'status',
        'usuario_abertura_id',
        'usuario_fechamento_id',
        'observacoes_abertura',
        'observacoes_fechamento'
    ];

    protected $casts = [
        'data' => 'date',
        'saldo_inicial' => 'decimal:2',
        'saldo_final' => 'decimal:2',
        'total_entradas' => 'decimal:2',
        'total_saidas' => 'decimal:2',
        'saldo_esperado' => 'decimal:2',
        'diferenca' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function usuarioAbertura()
    {
        return $this->belongsTo(User::class, 'usuario_abertura_id');
    }

    public function usuarioFechamento()
    {
        return $this->belongsTo(User::class, 'usuario_fechamento_id');
    }

    public function lancamentos()
    {
        return $this->hasMany(Lancamento::class, 'caixa_id');
    }

    // Scopes
    public function scopeAberto($query)
    {
        return $query->where('status', 'aberto');
    }

    public function scopeFechado($query)
    {
        return $query->where('status', 'fechado');
    }

    public function scopeHoje($query)
    {
        return $query->whereDate('data', today());
    }

    public function scopePeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('data', [$inicio, $fim]);
    }

    // Helpers
    public function isAberto()
    {
        return $this->status === 'aberto';
    }

    public function isFechado()
    {
        return $this->status === 'fechado';
    }

    public function atualizarTotais()
    {
        $this->total_entradas = $this->lancamentos()
            ->where('tipo', 'receita')
            ->where('status', 'confirmado')
            ->sum('valor');

        $this->total_saidas = $this->lancamentos()
            ->where('tipo', 'despesa')
            ->where('status', 'confirmado')
            ->sum('valor');

        $this->saldo_esperado = $this->saldo_inicial + $this->total_entradas - $this->total_saidas;

        return $this;
    }

    public function fechar($saldoFinal, $observacoes = null)
    {
        $this->hora_fechamento = now()->format('H:i:s');
        $this->usuario_fechamento_id = auth()->id();
        $this->saldo_final = $saldoFinal;
        $this->diferenca = $saldoFinal - $this->saldo_esperado;
        $this->observacoes_fechamento = $observacoes;
        $this->status = 'fechado';
        
        return $this->save();
    }

    public function calcularSaldoEsperado()
    {
        $entradas = $this->lancamentos()
            ->where('tipo', 'receita')
            ->where('status', 'confirmado')
            ->sum('valor');
        
        $saidas = $this->lancamentos()
            ->where('tipo', 'despesa')
            ->where('status', 'confirmado')
            ->sum('valor');
        
        return $this->saldo_inicial + $entradas - $saidas;
    }

    public function temDiferenca()
    {
        return abs($this->diferenca ?? 0) > 0.01; // Tolera 1 centavo de diferença
    }
}
