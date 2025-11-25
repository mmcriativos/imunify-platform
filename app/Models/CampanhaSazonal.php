<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampanhaSazonal extends Model
{
    protected $table = 'campanhas_sazonais';
    
    protected $fillable = [
        'nome',
        'descricao',
        'vacina',
        'data_inicio',
        'data_fim',
        'ativa',
        'publico_alvo',
        'preco_promocional'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativa' => 'boolean',
        'preco_promocional' => 'decimal:2'
    ];

    public function scopeAtivas($query)
    {
        return $query->where('ativa', true)
                     ->where('data_fim', '>=', now());
    }

    public function scopeTerminandoEm($query, $dias = 3)
    {
        return $query->where('ativa', true)
                     ->where('data_fim', '>=', now())
                     ->where('data_fim', '<=', now()->addDays($dias));
    }
}
