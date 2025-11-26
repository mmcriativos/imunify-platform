<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICAÇÃO COMPLETA DO SISTEMA\n";
echo "==================================\n\n";

try {
    // 1. Verifica banco CENTRAL
    echo "1️⃣ BANCO CENTRAL (imunifycom_central):\n";
    echo "----------------------------------------\n";
    
    $tenants = DB::connection('central')->table('tenants')->get();
    echo "📊 Tenants cadastrados: " . $tenants->count() . "\n";
    
    if ($tenants->count() > 0) {
        foreach ($tenants as $tenant) {
            echo "   • ID: {$tenant->id}\n";
            echo "     Nome: {$tenant->data}\n";
            echo "     Criado: {$tenant->created_at}\n";
            
            // Verifica domínios deste tenant
            $domains = DB::connection('central')->table('domains')
                ->where('tenant_id', $tenant->id)
                ->get();
            
            echo "     Domínios (" . $domains->count() . "):\n";
            foreach ($domains as $domain) {
                echo "       - {$domain->domain}\n";
            }
            
            // Verifica database pool
            $pool = DB::connection('central')->table('database_pool')
                ->where('tenant_id', $tenant->id)
                ->first();
            
            if ($pool) {
                echo "     Database: {$pool->database_name} (em uso: " . ($pool->in_use ? 'SIM' : 'NÃO') . ")\n";
            }
            echo "\n";
        }
    } else {
        echo "   ❌ Nenhum tenant encontrado!\n\n";
    }
    
    // 2. Verifica POOL
    echo "2️⃣ DATABASE POOL:\n";
    echo "----------------------------------------\n";
    
    $poolTotal = DB::connection('central')->table('database_pool')->count();
    $poolUsed = DB::connection('central')->table('database_pool')->where('in_use', true)->count();
    $poolAvailable = DB::connection('central')->table('database_pool')->where('in_use', false)->count();
    
    echo "📊 Total: $poolTotal\n";
    echo "✅ Disponíveis: $poolAvailable\n";
    echo "🔒 Em uso: $poolUsed\n\n";
    
    if ($poolUsed > 0) {
        $used = DB::connection('central')->table('database_pool')
            ->where('in_use', true)
            ->get();
        
        echo "Databases em uso:\n";
        foreach ($used as $db) {
            echo "   • {$db->database_name} (Tenant ID: {$db->tenant_id})\n";
        }
        echo "\n";
    }
    
    // 3. Verifica banco TENANT multiimune
    echo "3️⃣ BANCO TENANT (imunifycom_tenant_multiimune):\n";
    echo "----------------------------------------\n";
    
    config(['database.connections.tenant.database' => 'imunifycom_tenant_multiimune']);
    DB::purge('tenant');
    DB::reconnect('tenant');
    
    $users = DB::connection('tenant')->table('users')->get();
    echo "👥 Usuários: " . $users->count() . "\n";
    
    if ($users->count() > 0) {
        foreach ($users as $user) {
            echo "   • {$user->name} ({$user->email})\n";
        }
    } else {
        echo "   ℹ️ Nenhum usuário encontrado\n";
    }
    
    echo "\n";
    
    // 4. Últimos logs
    echo "4️⃣ ÚLTIMOS LOGS (últimas 5 linhas):\n";
    echo "----------------------------------------\n";
    
    $logFile = __DIR__ . '/../storage/logs/laravel.log';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lastLines = array_slice($lines, -5);
        foreach ($lastLines as $line) {
            echo $line;
        }
    } else {
        echo "   ℹ️ Arquivo de log não encontrado\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERRO: " . $e->getMessage() . "\n";
    echo "📍 Arquivo: " . $e->getFile() . "\n";
    echo "📍 Linha: " . $e->getLine() . "\n";
}
