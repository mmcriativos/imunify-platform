<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'paciente_id',
        'atendimento_id',
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'tipo',
        'status',
        'local',
        'cor',
        'observacoes',
        'dia_inteiro',
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'dia_inteiro' => 'boolean',
    ];

    protected $appends = [
        'data_inicio_formatada',
        'data_fim_formatada',
    ];

    // Relacionamentos
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function atendimento(): BelongsTo
    {
        return $this->belongsTo(Atendimento::class);
    }

    public function confirmacaoPresenca(): HasOne
    {
        return $this->hasOne(ConfirmacaoPresenca::class)->latestOfMany();
    }

    // Accessors
    public function getDataInicioFormatadaAttribute(): string
    {
        return $this->data_inicio?->format('d/m/Y H:i') ?? '';
    }

    public function getDataFimFormatadaAttribute(): string
    {
        return $this->data_fim?->format('d/m/Y H:i') ?? '';
    }

    // Scopes
    public function scopeFuturo($query)
    {
        return $query->where('data_inicio', '>=', now());
    }

    public function scopePorPeriodo($query, $inicio, $fim)
    {
        return $query->whereBetween('data_inicio', [$inicio, $fim]);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos auxiliares
    public function toFullCalendarEvent(): array
    {
        $statusLabels = [
            'agendado' => 'Agendado',
            'confirmado' => 'Confirmado',
            'realizado' => 'Realizado',
            'cancelado' => 'Cancelado',
        ];

        $tipoLabels = [
            'atendimento' => 'Atendimento',
            'consulta' => 'Consulta',
            'lembrete' => 'Lembrete',
            'outros' => 'Outros',
        ];

        return [
            'id' => $this->id,
            'title' => $this->titulo,
            'start' => $this->data_inicio->toIso8601String(),
            'end' => $this->data_fim->toIso8601String(),
            'backgroundColor' => $this->cor,
            'borderColor' => $this->cor,
            'allDay' => $this->dia_inteiro,
            'extendedProps' => [
                'descricao' => $this->descricao,
                'tipo' => $this->tipo,
                'status' => $this->status,
                'status_label' => $statusLabels[$this->status] ?? ($this->status ? ucfirst($this->status) : ''),
                'local' => $this->local,
                'paciente' => $this->paciente?->nome,
                'paciente_id' => $this->paciente_id,
                'atendimento_id' => $this->atendimento_id,
                'observacoes' => $this->observacoes,
                'tipo_label' => $tipoLabels[$this->tipo] ?? ($this->tipo ? ucfirst($this->tipo) : ''),
                'data_inicio_input' => $this->data_inicio?->format('Y-m-d\TH:i'),
                'data_fim_input' => $this->data_fim?->format('Y-m-d\TH:i'),
            ],
        ];
    }

    public static function getCoresDisponiveis(): array
    {
        return [
            'atendimento' => '#3B82F6',  // Blue
            'consulta' => '#10B981',      // Green
            'lembrete' => '#F59E0B',      // Amber
            'outros' => '#8B5CF6',        // Purple
        ];
    }
}
