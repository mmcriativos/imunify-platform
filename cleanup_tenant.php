<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\DatabasePool;

$tenantId = $argv[1] ?? null;

if (!$tenantId) {
    echo "Uso: php cleanup_tenant.php <tenant_id>\n";
    echo "Exemplo: php cleanup_tenant.php saudetotal\n";
    exit(1);
}

try {
    DB::connection('central')->beginTransaction();
    
    echo "🗑️  Limpando tenant: {$tenantId}\n";
    
    // 1. Buscar o tenant
    $tenant = DB::connection('central')->table('tenants')->where('id', $tenantId)->first();
    
    if (!$tenant) {
        echo "❌ Tenant '{$tenantId}' não encontrado.\n";
        DB::connection('central')->rollBack();
        exit(1);
    }
    
    echo "✓ Tenant encontrado\n";
    
    // 2. Liberar database de volta para o pool
    $released = DatabasePool::releaseDatabase($tenantId);
    if ($released) {
        echo "✓ Database liberado de volta para o pool\n";
    } else {
        echo "⚠️  Nenhum database estava alocado para este tenant\n";
    }
    
    // 3. Deletar domínios
    $domains = DB::connection('central')->table('domains')->where('tenant_id', $tenantId)->get();
    foreach ($domains as $domain) {
        echo "🌐 Deletando domínio: {$domain->domain}\n";
        DB::connection('central')->table('domains')->where('id', $domain->id)->delete();
    }
    
    // 4. Deletar tenant
    DB::connection('central')->table('tenants')->where('id', $tenantId)->delete();
    echo "✓ Tenant deletado\n";
    
    DB::connection('central')->commit();
    
    echo "\n✅ Tenant '{$tenantId}' limpo com sucesso!\n";
    echo "\n📊 Status do pool:\n";
    
    $pool = DB::connection('central')->table('database_pool')->get();
    foreach ($pool as $db) {
        $status = $db->in_use ? "🔴 EM USO ({$db->tenant_id})" : "🟢 DISPONÍVEL";
        echo "  {$db->database_name}: {$status}\n";
    }
    
} catch (\Exception $e) {
    DB::connection('central')->rollBack();
    echo "\n❌ Erro: " . $e->getMessage() . "\n";
    exit(1);
}
