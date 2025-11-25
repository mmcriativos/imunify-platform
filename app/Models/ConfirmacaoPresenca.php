<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmacaoPresenca extends Model
{
    protected $table = 'confirmacoes_presenca';

    protected $fillable = [
        'agendamento_id',
        'paciente_id',
        'lembrete_enviado_id',
        'telefone',
        'status',
        'mensagem_botao',
        'resposta_botao',
        'message_id',
        'enviado_em',
        'respondido_em'
    ];

    protected $casts = [
        'enviado_em' => 'datetime',
        'respondido_em' => 'datetime',
    ];

    // Relacionamentos
    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function lembreteEnviado(): BelongsTo
    {
        return $this->belongsTo(LembreteEnviado::class);
    }

    // Scopes
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeConfirmado($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopeCancelado($query)
    {
        return $query->where('status', 'cancelado');
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('enviado_em', '>=', now()->subDays($dias));
    }
}

