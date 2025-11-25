<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaFinanceira extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_financeiras';

    protected $fillable = [
        'nome',
        'tipo',
        'cor',
        'icone',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function lancamentos()
    {
        return $this->hasMany(Lancamento::class, 'categoria_id');
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeReceitas($query)
    {
        return $query->where('tipo', 'receita');
    }

    public function scopeDespesas($query)
    {
        return $query->where('tipo', 'despesa');
    }

    // Helpers
    public function isReceita()
    {
        return $this->tipo === 'receita';
    }

    public function isDespesa()
    {
        return $this->tipo === 'despesa';
    }

    public function getTotalLancamentos()
    {
        return $this->lancamentos()->sum('valor');
    }
}
