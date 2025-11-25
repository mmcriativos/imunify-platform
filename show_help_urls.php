<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;

echo "🌐 URLs do Help Center\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    $domain = $tenant->domains->first()->domain ?? 'N/A';
    
    echo "📋 Tenant: {$tenant->id}\n";
    echo "   🌐 Domínio: http://{$domain}\n";
    echo "   📚 Help Center: http://{$domain}/ajuda\n";
    echo "   🎯 Categoria Vacinas: http://{$domain}/ajuda/vacinas\n";
    echo "   📄 Artigo Campanhas: http://{$domain}/ajuda/artigo/como-criar-campanhas-vacinacao\n";
    echo "\n";
}
