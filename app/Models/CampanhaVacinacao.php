<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CampanhaVacinacao extends Model
{
    protected $table = 'campanhas_vacinacao';
    
    protected $fillable = [
        'nome',
        'vacina',
        'descricao',
        'data_inicio',
        'data_fim',
        'publico_alvo',
        'idade_minima',
        'idade_maxima',
        'ativa',
        'prioridade'
    ];
    
    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativa' => 'boolean'
    ];
    
    /**
     * Verifica se a campanha está ativa no momento
     */
    public function estaAtiva()
    {
        return $this->ativa && 
               now()->between($this->data_inicio, $this->data_fim);
    }
    
    /**
     * Verifica se o paciente está no público-alvo da campanha
     */
    public function pacienteEstaNoPublico($idadeEmMeses)
    {
        if ($this->idade_minima && $idadeEmMeses < $this->idade_minima) {
            return false;
        }
        
        if ($this->idade_maxima && $idadeEmMeses > $this->idade_maxima) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Scope para campanhas ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('ativa', true)
                    ->where('data_inicio', '<=', now())
                    ->where('data_fim', '>=', now());
    }
}
