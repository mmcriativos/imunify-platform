<?php

/**
 * Verifica tabelas em um database específico
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$databaseName = $argv[1] ?? 'imunifycom_tenant_multiimune';

echo "========================================\n";
echo "VERIFICANDO TABELAS DO DATABASE\n";
echo "========================================\n\n";

echo "Database: {$databaseName}\n\n";

try {
    // Conectar ao database
    $defaultConnection = config('database.default');
    $dbConfig = config("database.connections.{$defaultConnection}");
    
    config(['database.connections.check_db' => [
        'driver' => 'mysql',
        'host' => $dbConfig['host'],
        'port' => $dbConfig['port'],
        'database' => $databaseName,
        'username' => $dbConfig['username'],
        'password' => $dbConfig['password'],
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]]);

    DB::purge('check_db');
    
    // Listar tabelas
    $tables = DB::connection('check_db')->select('SHOW TABLES');
    
    if (empty($tables)) {
        echo "✓ Database está VAZIO (nenhuma tabela)\n";
    } else {
        echo "❌ Database contém " . count($tables) . " tabelas:\n\n";
        
        $tableKey = 'Tables_in_' . $databaseName;
        foreach ($tables as $table) {
            echo "   - {$table->$tableKey}\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
