<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🧹 Limpando banco tenant: imunifycom_tenant_multiimune\n";
echo "================================================\n\n";

try {
    // Conecta ao banco tenant específico
    $tenantConnection = 'tenant';
    
    // Configura a conexão para este banco específico
    config(['database.connections.tenant.database' => 'imunifycom_tenant_multiimune']);
    
    // Reconecta
    DB::purge($tenantConnection);
    DB::reconnect($tenantConnection);
    
    echo "✓ Conectado ao banco: imunifycom_tenant_multiimune\n\n";
    
    // Lista as tabelas antes
    $tables = DB::connection($tenantConnection)->select('SHOW TABLES');
    echo "📋 Tabelas encontradas: " . count($tables) . "\n\n";
    
    // Desabilita foreign key checks
    DB::connection($tenantConnection)->statement('SET FOREIGN_KEY_CHECKS=0');
    
    $tableCount = 0;
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        
        // Pula a tabela migrations
        if ($tableName === 'migrations') {
            echo "⏭️  Pulando tabela: $tableName\n";
            continue;
        }
        
        // Conta registros antes
        $countBefore = DB::connection($tenantConnection)->table($tableName)->count();
        
        if ($countBefore > 0) {
            // Limpa a tabela
            DB::connection($tenantConnection)->table($tableName)->truncate();
            echo "🗑️  Truncate: $tableName ($countBefore registros removidos)\n";
            $tableCount++;
        }
    }
    
    // Reabilita foreign key checks
    DB::connection($tenantConnection)->statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "\n✅ Limpeza concluída!\n";
    echo "📊 Total de tabelas limpas: $tableCount\n";
    echo "\n🎯 Agora você pode fazer um novo registro com o email: matheus@worldborderless.com.br\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERRO: " . $e->getMessage() . "\n";
    echo "\n📍 Arquivo: " . $e->getFile() . "\n";
    echo "📍 Linha: " . $e->getLine() . "\n";
}
