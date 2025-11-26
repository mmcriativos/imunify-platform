<?php
/**
 * Limpa TODOS os tenants para teste limpo
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain; charset=utf-8');

echo "=== LIMPEZA TOTAL PARA TESTE ===\n\n";

try {
    echo "1. Limpando todos os tenants...\n";
    
    // Deletar domains
    $domainsDeleted = DB::table('domains')->delete();
    echo "   - Domains deletados: {$domainsDeleted}\n";
    
    // Resetar pool
    DB::table('database_pool')->update([
        'in_use' => false,
        'tenant_id' => null,
        'allocated_at' => null,
    ]);
    echo "   - Pool resetado\n";
    
    // Deletar tenants
    $tenantsDeleted = DB::table('tenants')->delete();
    echo "   - Tenants deletados: {$tenantsDeleted}\n";
    
    echo "\n2. Status final:\n";
    $tenantsCount = DB::table('tenants')->count();
    $domainsCount = DB::table('domains')->count();
    $poolAvailable = DB::table('database_pool')->where('in_use', false)->count();
    
    echo "   - Tenants: {$tenantsCount}\n";
    echo "   - Domains: {$domainsCount}\n";
    echo "   - Pool disponível: {$poolAvailable}\n";
    
    echo "\n✓ Sistema limpo! Pronto para novo registro via formulário.\n";

} catch (\Exception $e) {
    echo "\n✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n=== FIM ===\n";
