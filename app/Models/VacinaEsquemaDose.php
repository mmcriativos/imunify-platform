<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacinaEsquemaDose extends Model
{
    use HasFactory;

    protected $table = 'vacina_esquema_doses';

    protected $fillable = [
        'vacina_id',
        'dose_numero',
        'nome_dose',
        'idade_minima_meses',
        'idade_maxima_meses',
        'intervalo_minimo_dias',
        'intervalo_maximo_dias',
        'obrigatoria',
        'rede',
        'observacoes',
        'ordem'
    ];

    protected $casts = [
        'obrigatoria' => 'boolean',
        'dose_numero' => 'integer',
        'idade_minima_meses' => 'integer',
        'idade_maxima_meses' => 'integer',
        'intervalo_minimo_dias' => 'integer',
        'intervalo_maximo_dias' => 'integer',
        'ordem' => 'integer'
    ];

    /**
     * Relacionamento com Vacina
     */
    public function vacina()
    {
        return $this->belongsTo(Vacina::class);
    }

    /**
     * Verifica se dose está no período ideal baseado na idade do paciente
     */
    public function estaNoPeriodoIdeal($idadeMeses)
    {
        if ($this->idade_minima_meses && $idadeMeses < $this->idade_minima_meses) {
            return false;
        }
        
        if ($this->idade_maxima_meses && $idadeMeses > $this->idade_maxima_meses) {
            return false;
        }
        
        return true;
    }

    /**
     * Verifica se dose está atrasada
     */
    public function estaAtrasada($idadeMeses)
    {
        return $this->idade_maxima_meses && $idadeMeses > $this->idade_maxima_meses;
    }

    /**
     * Calcula data prevista baseado na última dose
     */
    public function calcularDataPrevista($dataUltimaDose, $dataNascimento)
    {
        if ($this->dose_numero == 1) {
            // Primeira dose: baseada na idade mínima
            if ($this->idade_minima_meses) {
                return \Carbon\Carbon::parse($dataNascimento)->addMonths($this->idade_minima_meses);
            }
            return \Carbon\Carbon::parse($dataNascimento);
        }
        
        // Doses subsequentes: baseadas no intervalo mínimo
        if ($this->intervalo_minimo_dias && $dataUltimaDose) {
            return \Carbon\Carbon::parse($dataUltimaDose)->addDays($this->intervalo_minimo_dias);
        }
        
        return null;
    }

    /**
     * Scope para doses obrigatórias
     */
    public function scopeObrigatorias($query)
    {
        return $query->where('obrigatoria', true);
    }

    /**
     * Scope para doses do SUS
     */
    public function scopeSus($query)
    {
        return $query->whereIn('rede', ['sus', 'ambas']);
    }

    /**
     * Scope ordenadas
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('dose_numero');
    }
}
