<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "🔍 ESTRUTURA DA TABELA TENANTS\n";
echo "================================\n\n";

try {
    // 1. Verificar colunas da tabela
    echo "1️⃣ Colunas da tabela 'tenants':\n";
    echo str_repeat("-", 50) . "\n";
    
    $columns = DB::connection('central')
        ->select("SHOW COLUMNS FROM tenants");
    
    foreach ($columns as $column) {
        echo "  • {$column->Field} ({$column->Type})\n";
    }
    
    echo "\n";
    
    // 2. Buscar tenant completo
    echo "2️⃣ Dados do tenant 'multiimune':\n";
    echo str_repeat("-", 50) . "\n";
    
    $tenant = DB::connection('central')
        ->table('tenants')
        ->where('id', 'multiimune')
        ->first();
    
    if ($tenant) {
        echo "✅ Tenant encontrado!\n\n";
        
        foreach ((array)$tenant as $key => $value) {
            if (is_string($value) && strlen($value) > 100) {
                $value = substr($value, 0, 100) . '...';
            }
            echo "  • {$key}: {$value}\n";
        }
        
        echo "\n";
        
        // Verificar se tem a coluna tenancy_db_name
        if (property_exists($tenant, 'tenancy_db_name')) {
            echo "✅ Coluna 'tenancy_db_name' existe!\n";
            echo "   Valor: {$tenant->tenancy_db_name}\n";
        } else {
            echo "❌ Coluna 'tenancy_db_name' NÃO existe no resultado!\n";
            echo "\nPropriedades do objeto:\n";
            echo implode(', ', array_keys((array)$tenant)) . "\n";
        }
    } else {
        echo "❌ Tenant não encontrado!\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERRO: " . $e->getMessage() . "\n";
    echo "📍 Arquivo: " . $e->getFile() . "\n";
    echo "📍 Linha: " . $e->getLine() . "\n";
}
