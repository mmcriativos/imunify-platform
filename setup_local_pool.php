<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\DatabasePool;

echo "=== Configurando Pool de Databases Local ===\n\n";

// 1. Criar databases físicos
echo "1. Criando databases físicos...\n";
for ($i = 1; $i <= 5; $i++) {
    $dbName = 'tenant_' . str_pad($i, 3, '0', STR_PAD_LEFT);
    
    try {
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "   ✓ Database criado: {$dbName}\n";
    } catch (\Exception $e) {
        echo "   ⚠ Erro ao criar {$dbName}: " . $e->getMessage() . "\n";
    }
}

echo "\n2. Adicionando databases ao pool...\n";
// 2. Adicionar ao pool
for ($i = 1; $i <= 5; $i++) {
    $dbName = 'tenant_' . str_pad($i, 3, '0', STR_PAD_LEFT);
    
    if (DatabasePool::where('database_name', $dbName)->exists()) {
        echo "   - {$dbName} já existe no pool\n";
        continue;
    }
    
    DatabasePool::create([
        'database_name' => $dbName,
        'in_use' => false,
    ]);
    
    echo "   ✓ Adicionado ao pool: {$dbName}\n";
}

echo "\n3. Status do pool:\n";
$total = DatabasePool::count();
$available = DatabasePool::getAvailableCount();
$inUse = DatabasePool::where('in_use', true)->count();

echo "   Total: {$total}\n";
echo "   Disponíveis: {$available}\n";
echo "   Em uso: {$inUse}\n";

echo "\n✅ Pool configurado com sucesso!\n";
