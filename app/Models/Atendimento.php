<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atendimento extends Model
{
    protected $table = 'atendimentos';

    protected $fillable = [
        'data',
        'paciente_id',
        'tipo',
        'cidade_id',
        'endereco_atendimento',
        'valor_total',
        'observacoes',
        'usuario_id',
    ];

    protected $casts = [
        'data' => 'date',
        'valor_total' => 'decimal:2',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vacinas(): BelongsToMany
    {
        return $this->belongsToMany(Vacina::class, 'atendimento_vacina')
            ->withPivot(['id','quantidade','valor_unitario','valor_total','lote','validade'])
            ->withTimestamps();
    }
}
