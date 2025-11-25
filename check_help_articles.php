<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🔍 Verificando artigos no Help Center...\n\n";

$tenant = Tenant::find('clinica-demo');

if (!$tenant) {
    echo "❌ Tenant não encontrado!\n";
    exit(1);
}

$tenant->run(function () {
    echo "📊 Total de artigos: " . HelpArticle::count() . "\n\n";
    
    echo "📋 Lista de artigos:\n";
    $artigos = HelpArticle::orderBy('categoria_slug')->orderBy('titulo')->get();
    
    foreach ($artigos as $artigo) {
        echo "  [{$artigo->categoria_slug}] {$artigo->titulo}\n";
        echo "      Slug: {$artigo->slug}\n";
        echo "      Destaque: " . ($artigo->destaque ? 'SIM' : 'NÃO') . "\n";
        echo "\n";
    }
    
    echo "\n🔍 Buscando artigo de campanhas especificamente:\n";
    $campanha = HelpArticle::where('slug', 'como-criar-campanhas-vacinacao')->first();
    
    if ($campanha) {
        echo "  ✅ ENCONTRADO!\n";
        echo "  Título: {$campanha->titulo}\n";
        echo "  Categoria: {$campanha->categoria_slug}\n";
    } else {
        echo "  ❌ NÃO ENCONTRADO!\n";
    }
});
