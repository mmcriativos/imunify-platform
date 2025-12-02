<?php

/**
 * Script para executar migration de whatsapp_connections em todos os tenants existentes
 * Útil quando uma migration de tenant é adicionada depois que tenants já foram criados
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  Executar Migration whatsapp_connections em Todos Tenants ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$tenants = Tenant::all();

if ($tenants->isEmpty()) {
    echo "⚠️  Nenhum tenant encontrado.\n";
    exit(0);
}

echo "📋 Total de tenants: " . $tenants->count() . "\n\n";

$success = 0;
$errors = 0;

foreach ($tenants as $tenant) {
    echo "Processing: {$tenant->id}... ";
    
    try {
        // Inicializar contexto do tenant
        tenancy()->initialize($tenant);
        
        // Executar a migration específica
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant/2025_11_16_000002_create_whatsapp_connections_table.php',
            '--force' => true,
        ]);
        
        // Finalizar contexto do tenant
        tenancy()->end();
        
        echo "✓ Sucesso\n";
        $success++;
        
    } catch (\Exception $e) {
        tenancy()->end();
        echo "✗ Erro: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "\n" . str_repeat("─", 60) . "\n";
echo "📊 Resumo:\n";
echo "   ✓ Sucesso: $success\n";
echo "   ✗ Erros: $errors\n";
echo "   📋 Total: " . $tenants->count() . "\n";
echo str_repeat("─", 60) . "\n\n";

if ($errors === 0) {
    echo "✅ Todas as migrations foram executadas com sucesso!\n";
} else {
    echo "⚠️  Algumas migrations falharam. Verifique os erros acima.\n";
}
