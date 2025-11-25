<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

$tenant = Tenant::where('id', 'multiimune')->first();

$tenant->run(function() {
    echo "Procurando artigos com 'agend' no slug:\n\n";
    
    $artigos = HelpArticle::where('slug', 'like', '%agend%')->get();
    
    if ($artigos->isEmpty()) {
        echo "Nenhum artigo encontrado.\n";
    } else {
        foreach ($artigos as $artigo) {
            echo "- {$artigo->slug} → {$artigo->titulo}\n";
        }
    }
});
