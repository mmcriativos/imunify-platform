<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembrete extends Model
{
    protected $fillable = [
        'paciente_id',
        'tipo',
        'canal',
        'destinatario',
        'mensagem',
        'status',
        'erro_mensagem',
        'data_agendamento',
        'data_envio',
        'metadata'
    ];

    protected $casts = [
        'data_agendamento' => 'datetime',
        'data_envio' => 'datetime',
        'metadata' => 'array'
    ];

    // Relacionamentos
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeParaEnviar($query)
    {
        return $query->where('status', 'pendente')
                     ->where('data_agendamento', '<=', now());
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos auxiliares
    public function marcarComoEnviado()
    {
        $this->update([
            'status' => 'enviado',
            'data_envio' => now()
        ]);
    }

    public function marcarComoErro($mensagemErro)
    {
        $this->update([
            'status' => 'erro',
            'erro_mensagem' => $mensagemErro
        ]);
    }
}
