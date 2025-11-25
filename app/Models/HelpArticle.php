<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    protected $fillable = [
        'categoria_slug',
        'titulo',
        'slug',
        'conteudo_html',
        'resumo',
        'tags',
        'visualizacoes',
        'ordem',
        'destaque',
        'ativo',
    ];

    protected $casts = [
        'tags' => 'array',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorCategoria($query, $slug)
    {
        return $query->where('categoria_slug', $slug);
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where(function($q) use ($termo) {
            $q->where('titulo', 'like', "%{$termo}%")
              ->orWhere('resumo', 'like', "%{$termo}%")
              ->orWhere('conteudo_html', 'like', "%{$termo}%");
        });
    }

    /**
     * Incrementa visualizações
     */
    public function incrementViews()
    {
        $this->increment('visualizacoes');
    }

    /**
     * Artigos relacionados (mesma categoria, excluindo o atual)
     */
    public function getRelatedArticles($limit = 4)
    {
        return self::ativo()
            ->porCategoria($this->categoria_slug)
            ->where('id', '!=', $this->id)
            ->orderBy('visualizacoes', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Nome formatado da categoria
     */
    public function getCategoriaNomeAttribute()
    {
        return match($this->categoria_slug) {
            'whatsapp' => 'WhatsApp',
            'agendamentos' => 'Agendamentos',
            'vacinas' => 'Vacinas',
            'pacientes' => 'Pacientes',
            'financeiro' => 'Financeiro',
            'relatorios' => 'Relatórios',
            'configuracoes' => 'Configurações',
            default => ucfirst($this->categoria_slug),
        };
    }

    /**
     * Ícone da categoria
     */
    public function getCategoriaIconeAttribute()
    {
        return match($this->categoria_slug) {
            'whatsapp' => '📱',
            'agendamentos' => '📅',
            'vacinas' => '💉',
            'pacientes' => '👥',
            'financeiro' => '💰',
            'relatorios' => '📊',
            'configuracoes' => '⚙️',
            default => '📄',
        };
    }
}
