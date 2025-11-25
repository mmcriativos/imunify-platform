<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SipniExport extends Model
{
    protected $table = 'sipni_exports';

    protected $fillable = [
        'atendimento_id',
        'atendimento_vacina_id',
        'paciente_id',
        'vacina_id',
        'usuario_id',
        'status',
        'data_tentativa',
        'data_envio',
        'tentativas',
        'protocolo_sipni',
        'resposta_sipni',
        'erro_mensagem',
        'payload',
    ];

    protected $casts = [
        'data_tentativa' => 'datetime',
        'data_envio' => 'datetime',
        'payload' => 'array',
    ];

    // Relacionamentos
    public function atendimento(): BelongsTo
    {
        return $this->belongsTo(Atendimento::class);
    }

    public function atendimentoVacina(): BelongsTo
    {
        return $this->belongsTo(AtendimentoVacina::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function vacina(): BelongsTo
    {
        return $this->belongsTo(Vacina::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeComErro($query)
    {
        return $query->whereIn('status', ['erro', 'rejeitado']);
    }

    public function scopeEnviados($query)
    {
        return $query->where('status', 'enviado');
    }

    // Métodos auxiliares
    public function podeRetentar(): bool
    {
        return $this->tentativas < 3 && in_array($this->status, ['pendente', 'erro']);
    }

    public function marcarComoEnviado(string $protocolo, array $resposta): void
    {
        $this->update([
            'status' => 'enviado',
            'data_envio' => now(),
            'protocolo_sipni' => $protocolo,
            'resposta_sipni' => json_encode($resposta),
        ]);
    }

    public function marcarComoErro(string $mensagem): void
    {
        $this->update([
            'status' => 'erro',
            'tentativas' => $this->tentativas + 1,
            'data_tentativa' => now(),
            'erro_mensagem' => $mensagem,
        ]);
    }
}
