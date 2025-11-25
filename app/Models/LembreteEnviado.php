<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LembreteEnviado extends Model
{
    protected $table = 'lembretes_enviados';

    protected $fillable = [
        'paciente_id',
        'agendamento_id',
        'tipo',
        'telefone',
        'mensagem',
        'sucesso',
        'erro',
        'message_id',
        'enviado_em',
    ];

    protected $casts = [
        'sucesso' => 'boolean',
        'enviado_em' => 'datetime',
    ];

    // Relacionamentos
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    // Scopes
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeSucesso($query)
    {
        return $query->where('sucesso', true);
    }

    public function scopeFalha($query)
    {
        return $query->where('sucesso', false);
    }

    public function scopeRecentes($query, int $dias = 7)
    {
        return $query->where('enviado_em', '>=', now()->subDays($dias));
    }

    // Métodos auxiliares
    public function getTipoFormatadoAttribute(): string
    {
        $tipos = [
            '7dias' => '7 dias antes',
            '1dia' => '1 dia antes',
            'hoje' => 'No dia',
            'atrasado' => 'Atrasado',
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }
}
