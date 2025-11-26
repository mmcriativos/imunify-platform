<?php

/**
 * Verifica status dos tenants e pool
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "STATUS DO SISTEMA MULTI-TENANT\n";
echo "========================================\n\n";

// Tenants
echo "TENANTS:\n";
$tenants = \Illuminate\Support\Facades\DB::table('tenants')->get();
if ($tenants->isEmpty()) {
    echo "   ❌ Nenhum tenant cadastrado\n\n";
} else {
    foreach ($tenants as $tenant) {
        $data = $tenant->data ? json_decode($tenant->data, true) : [];
        $dbName = $data['tenancy_db_name'] ?? '[indefinido]';
        $clinicName = $data['clinic_name'] ?? '[sem nome]';
        $status = $data['status'] ?? ($tenant->status ?? '[sem status]');

        echo "   - ID: {$tenant->id}\n";
        echo "     Database: {$dbName}\n";
        echo "     Nome: {$clinicName}\n";
        echo "     Status: {$status}\n\n";
    }
}

// Domínios
echo "DOMÍNIOS:\n";
$domains = \Illuminate\Support\Facades\DB::table('domains')->get();
if ($domains->isEmpty()) {
    echo "   ❌ Nenhum domínio cadastrado\n\n";
} else {
    foreach ($domains as $domain) {
        echo "   - {$domain->domain} -> Tenant: {$domain->tenant_id}\n";
    }
    echo "\n";
}

// Pool
echo "DATABASE POOL:\n";
$pools = \App\Models\DatabasePool::all();
$inUse = 0;
$available = 0;

foreach ($pools as $pool) {
    if ($pool->in_use) {
        $inUse++;
        echo "   🔒 {$pool->database_name} -> Tenant: {$pool->tenant_id}\n";
    } else {
        $available++;
    }
}

echo "\n   ✓ Disponíveis: {$available}\n";
echo "   🔒 Em uso: {$inUse}\n";

echo "\n========================================\n";
