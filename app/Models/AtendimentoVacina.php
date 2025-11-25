<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtendimentoVacina extends Model
{
    protected $table = 'atendimento_vacina';

    protected $fillable = [
        'atendimento_id',
        'vacina_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'lote',
        'validade',
    ];

    public $timestamps = true;

    public function vacina(): BelongsTo
    {
        return $this->belongsTo(Vacina::class);
    }

    public function atendimento(): BelongsTo
    {
        return $this->belongsTo(Atendimento::class);
    }
}
