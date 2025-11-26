<?php
/**
 * Limpa COMPLETAMENTE: central + todos os tenants do pool
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain; charset=utf-8');

echo "=== LIMPEZA COMPLETA (CENTRAL + TENANTS) ===\n\n";

try {
    // 1. Limpar banco central
    echo "1. Limpando banco CENTRAL...\n";
    
    DB::table('domains')->delete();
    echo "   ✓ Domains deletados\n";
    
    DB::table('tenants')->delete();
    echo "   ✓ Tenants deletados\n";
    
    // 2. Limpar TODOS os bancos tenant do pool
    echo "\n2. Limpando bancos TENANT...\n";
    
    $databases = DB::table('database_pool')->get();
    
    foreach ($databases as $db) {
        echo "   Limpando {$db->database_name}... ";
        
        try {
            // Criar conexão temporária para este banco
            config(['database.connections.tenant_clean' => [
                'driver' => 'mysql',
                'host' => config('database.connections.mysql.host'),
                'port' => config('database.connections.mysql.port'),
                'database' => $db->database_name,
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'strict' => true,
            ]]);
            
            // Desabilitar foreign key checks
            DB::connection('tenant_clean')->statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Pegar todas as tabelas
            $tables = DB::connection('tenant_clean')
                ->select('SHOW TABLES');
            
            $tableCount = 0;
            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                DB::connection('tenant_clean')->statement("DROP TABLE IF EXISTS `{$tableName}`");
                $tableCount++;
            }
            
            // Re-habilitar foreign key checks
            DB::connection('tenant_clean')->statement('SET FOREIGN_KEY_CHECKS=1');
            
            echo "✓ ({$tableCount} tabelas)\n";
            
        } catch (\Exception $e) {
            echo "✗ ERRO: " . $e->getMessage() . "\n";
        }
    }
    
    // 3. Resetar pool
    echo "\n3. Resetando pool...\n";
    DB::table('database_pool')->update([
        'in_use' => false,
        'tenant_id' => null,
        'allocated_at' => null,
    ]);
    echo "   ✓ Pool resetado\n";
    
    // 4. Status final
    echo "\n4. Status final:\n";
    $tenantsCount = DB::table('tenants')->count();
    $domainsCount = DB::table('domains')->count();
    $poolAvailable = DB::table('database_pool')->where('in_use', false)->count();
    
    echo "   - Tenants (central): {$tenantsCount}\n";
    echo "   - Domains (central): {$domainsCount}\n";
    echo "   - Pool disponível: {$poolAvailable}\n";
    
    echo "\n✅ LIMPEZA COMPLETA! Sistema pronto para novo registro.\n";

} catch (\Exception $e) {
    echo "\n✗ ERRO: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== FIM ===\n";
