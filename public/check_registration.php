<?php
/**
 * Verifica resultado do registro
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain; charset=utf-8');

echo "=== RESULTADO DO REGISTRO ===\n\n";

try {
    // 1. Verificar se tenant foi criado
    echo "1. Verificando tenant 'multiimune':\n";
    $tenant = DB::table('tenants')->where('id', 'multiimune')->first();
    
    if ($tenant) {
        echo "   ✓ TENANT ENCONTRADO!\n";
        echo "   - ID: {$tenant->id}\n";
        echo "   - Data: {$tenant->data}\n";
        echo "   - Criado em: {$tenant->created_at}\n";
    } else {
        echo "   ✗ Tenant NÃO encontrado no banco central\n";
    }

    // 2. Verificar domínio
    echo "\n2. Verificando domínio:\n";
    $domain = DB::table('domains')->where('domain', 'multiimune.imunify.com.br')->first();
    
    if ($domain) {
        echo "   ✓ DOMÍNIO ENCONTRADO!\n";
        echo "   - Domain: {$domain->domain}\n";
        echo "   - Tenant ID: {$domain->tenant_id}\n";
    } else {
        echo "   ✗ Domínio NÃO encontrado\n";
    }

    // 3. Verificar database pool
    echo "\n3. Pool status:\n";
    $poolUsed = DB::table('database_pool')->where('tenant_id', 'multiimune')->first();
    
    if ($poolUsed) {
        echo "   ✓ Database alocada!\n";
        echo "   - Database: {$poolUsed->database_name}\n";
        echo "   - Alocada em: {$poolUsed->allocated_at}\n";
    } else {
        echo "   ✗ Nenhuma database alocada para este tenant\n";
    }

    // 4. Últimas 30 linhas do log
    echo "\n4. Últimas linhas do log:\n";
    echo "   " . str_repeat("-", 70) . "\n";
    
    $logPath = __DIR__ . '/../storage/logs/laravel.log';
    if (file_exists($logPath)) {
        $lines = file($logPath);
        $lastLines = array_slice($lines, -30);
        foreach ($lastLines as $line) {
            echo "   " . rtrim($line) . "\n";
        }
    } else {
        echo "   ✗ Arquivo de log não encontrado\n";
    }

} catch (Exception $e) {
    echo "\n✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n=== FIM ===\n";
