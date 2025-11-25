<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'data_nascimento',
        'telefone',
        'email',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'observacoes',
        'ativo',
        'e_menor',
        'responsavel_nome',
        'responsavel_cpf',
        'responsavel_telefone',
        'responsavel_parentesco',
        'token_carteira',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        // Gerar token único ao criar paciente
        static::creating(function ($paciente) {
            if (empty($paciente->token_carteira)) {
                $paciente->token_carteira = Str::random(32);
            }
        });
    }
    
    /**
     * Gera novo token para a carteira (caso precise regenerar)
     */
    public function regenerarToken()
    {
        $this->token_carteira = Str::random(32);
        $this->save();
        return $this->token_carteira;
    }

    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class);
    }
}
