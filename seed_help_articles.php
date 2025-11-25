<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenants = \App\Models\Tenant::all();

echo "🔄 Populando artigos de ajuda em todos os tenants...\n\n";

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    try {
        $seeder = new \Database\Seeders\HelpArticlesSeeder();
        $seeder->run();
        echo "  ✅ Artigos de ajuda criados com sucesso\n\n";
    } catch (\Exception $e) {
        echo "  ❌ Erro: {$e->getMessage()}\n\n";
    }
    
    tenancy()->end();
}

echo "✅ Processo concluído!\n";
