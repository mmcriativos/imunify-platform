<?php
/**
 * Prepara ambiente para novo teste de registro
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain; charset=utf-8');

echo "=== PREPARANDO AMBIENTE PARA TESTE ===\n\n";

try {
    // 1. Deletar tenant e domínio existentes
    echo "1. Limpando tenant/domain 'multiimune'...\n";
    DB::table('domains')->where('domain', 'multiimune.imunify.com.br')->delete();
    $deleted = DB::table('tenants')->where('id', 'multiimune')->delete();
    echo "   ✓ Deletados: {$deleted} registros\n";

    // 2. Verificar status atual
    echo "\n2. Status atual:\n";
    $tenantsCount = DB::table('tenants')->count();
    $domainsCount = DB::table('domains')->count();
    $poolAvailable = DB::table('database_pool')->where('is_available', true)->count();
    
    echo "   - Tenants: {$tenantsCount}\n";
    echo "   - Domains: {$domainsCount}\n";
    echo "   - Pool disponível: {$poolAvailable}\n";

    // 3. Limpar cache
    echo "\n3. Limpando cache...\n";
    app('cache')->store()->flush();
    echo "   ✓ Cache limpo\n";

    echo "\n✓ Ambiente pronto para novo teste de registro!\n";
    echo "\nPróximo passo: Acesse https://imunify.com.br/registrar\n";

} catch (Exception $e) {
    echo "\n✗ ERRO: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== FIM ===\n";
