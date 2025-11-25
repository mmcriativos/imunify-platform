<?php

namespace App\Http\Controllers;

use App\Models\HelpArticle;
use Illuminate\Http\Request;

class AjudaController extends Controller
{
    /**
     * Página inicial do centro de ajuda
     */
    public function index()
    {
        $categorias = [
            ['slug' => 'whatsapp', 'nome' => 'WhatsApp', 'icone' => '📱', 'descricao' => 'Configurações, envios e relatórios'],
            ['slug' => 'agendamentos', 'nome' => 'Agendamentos', 'icone' => '📅', 'descricao' => 'Calendário, horários e confirmações'],
            ['slug' => 'vacinas', 'nome' => 'Vacinas', 'icone' => '💉', 'descricao' => 'Cadastro, doses e lembretes'],
            ['slug' => 'pacientes', 'nome' => 'Pacientes', 'icone' => '👥', 'descricao' => 'Cadastros, prontuários e histórico'],
            ['slug' => 'financeiro', 'nome' => 'Financeiro', 'icone' => '💰', 'descricao' => 'Caixa, lançamentos e relatórios financeiros'],
            ['slug' => 'relatorios', 'nome' => 'Relatórios', 'icone' => '📊', 'descricao' => 'Dashboards, exportações e métricas'],
            ['slug' => 'configuracoes', 'nome' => 'Configurações', 'icone' => '⚙️', 'descricao' => 'Personalização e ajustes gerais'],
        ];

        // Contar artigos por categoria
        foreach ($categorias as &$cat) {
            $cat['total_artigos'] = HelpArticle::ativo()
                ->porCategoria($cat['slug'])
                ->count();
        }

        // Artigos em destaque
        $destaques = HelpArticle::ativo()
            ->destaque()
            ->orderBy('ordem')
            ->limit(6)
            ->get();

        // Artigos mais vistos
        $populares = HelpArticle::ativo()
            ->orderBy('visualizacoes', 'desc')
            ->limit(5)
            ->get();

        return view('ajuda.index', compact('categorias', 'destaques', 'populares'));
    }

    /**
     * Busca de artigos
     */
    public function buscar(Request $request)
    {
        $termo = $request->input('q');
        
        $resultados = HelpArticle::ativo()
            ->buscar($termo)
            ->orderBy('visualizacoes', 'desc')
            ->paginate(15);

        return view('ajuda.buscar', compact('resultados', 'termo'));
    }

    /**
     * Lista artigos de uma categoria
     */
    public function categoria($slug)
    {
        $categorias = [
            'whatsapp' => ['nome' => 'WhatsApp', 'icone' => '📱', 'descricao' => 'Tudo sobre configuração e uso do WhatsApp Business'],
            'agendamentos' => ['nome' => 'Agendamentos', 'icone' => '📅', 'descricao' => 'Guias completos sobre gerenciamento de agendas'],
            'vacinas' => ['nome' => 'Vacinas', 'icone' => '💉', 'descricao' => 'Cadastro, controle de doses e lembretes automáticos'],
            'pacientes' => ['nome' => 'Pacientes', 'icone' => '👥', 'descricao' => 'Gestão completa de cadastros e histórico'],
            'financeiro' => ['nome' => 'Financeiro', 'icone' => '💰', 'descricao' => 'Controle de caixa, lançamentos e gestão financeira'],
            'relatorios' => ['nome' => 'Relatórios', 'icone' => '📊', 'descricao' => 'Análises, dashboards e exportações'],
            'configuracoes' => ['nome' => 'Configurações', 'icone' => '⚙️', 'descricao' => 'Personalização do sistema para sua clínica'],
        ];

        if (!isset($categorias[$slug])) {
            abort(404);
        }

        $categoria = $categorias[$slug];
        $categoria['slug'] = $slug;

        $artigos = HelpArticle::ativo()
            ->porCategoria($slug)
            ->orderBy('ordem')
            ->orderBy('visualizacoes', 'desc')
            ->get();

        return view('ajuda.categoria', compact('categoria', 'artigos'));
    }

    /**
     * Exibe artigo específico
     */
    public function artigo($slug)
    {
        $artigo = HelpArticle::ativo()
            ->where('slug', $slug)
            ->firstOrFail();

        // Incrementa visualizações
        $artigo->incrementViews();

        // Artigos relacionados
        $relacionados = $artigo->getRelatedArticles(4);

        return view('ajuda.artigo', compact('artigo', 'relacionados'));
    }
}
