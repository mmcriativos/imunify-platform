<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

$tenant = Tenant::where('id', 'multiimune')->first();

$tenant->run(function() {
    $artigo = HelpArticle::where('slug', 'lembrete-automatico-vacinacao')->first();
    
    if ($artigo) {
        echo "Título: " . $artigo->titulo . "\n";
        echo "Categoria: " . $artigo->categoria_slug . "\n";
        echo "Destaque: " . ($artigo->destaque ? 'Sim' : 'Não') . "\n\n";
        echo "Conteúdo (primeiros 800 chars):\n";
        echo substr($artigo->conteudo_html, 0, 800) . "\n";
    } else {
        echo "Artigo não encontrado!\n";
    }
});
