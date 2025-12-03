<?php

/**
 * Script para corrigir migrations problemáticas em produção
 * Execute: php fix_migrations_production.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

echo "🔧 Corrigindo migrations problemáticas em produção\n\n";

// 1. Verificar se arquivo existe e remover
$problematicFile = __DIR__ . '/database/migrations/2025_11_13_082912_add_branding_fields_to_tenants_table.php';
if (file_exists($problematicFile)) {
    unlink($problematicFile);
    echo "✅ Removido: 2025_11_13_082912_add_branding_fields_to_tenants_table.php\n\n";
} else {
    echo "⏭️  Arquivo já foi removido anteriormente\n\n";
}

// 2. Marcar migrations já aplicadas em cada tenant
echo "📝 Marcando migrations já aplicadas nos tenants...\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    try {
        tenancy()->initialize($tenant);
        
        $migrationsToMark = [
            '2025_11_13_082912_add_branding_fields_to_tenants_table',
            '2025_11_13_095840_create_sessions_table',
            '2025_12_03_105310_create_password_reset_tokens_table',
        ];
        
        foreach ($migrationsToMark as $migration) {
            // Verificar se tabela existe primeiro
            $tableExists = false;
            
            if ($migration === '2025_11_13_095840_create_sessions_table') {
                $tableExists = DB::select("SHOW TABLES LIKE 'sessions'");
            } elseif ($migration === '2025_12_03_105310_create_password_reset_tokens_table') {
                $tableExists = DB::select("SHOW TABLES LIKE 'password_reset_tokens'");
            } elseif ($migration === '2025_11_13_082912_add_branding_fields_to_tenants_table') {
                // Verificar se coluna clinic_name existe na tabela tenants
                $columns = DB::select("SHOW COLUMNS FROM tenants LIKE 'clinic_name'");
                $tableExists = !empty($columns);
            }
            
            if ($tableExists) {
                // Marcar migration como executada
                $exists = DB::table('migrations')->where('migration', $migration)->exists();
                
                if (!$exists) {
                    DB::table('migrations')->insert([
                        'migration' => $migration,
                        'batch' => 1
                    ]);
                    echo "  ✅ Marcada: $migration\n";
                } else {
                    echo "  ⏭️  Já marcada: $migration\n";
                }
            } else {
                echo "  ⚠️  Tabela não existe, migration será executada: $migration\n";
            }
        }
        
        tenancy()->end();
        echo "\n";
        
    } catch (\Exception $e) {
        echo "  ❌ Erro: " . $e->getMessage() . "\n\n";
        tenancy()->end();
    }
}

echo "✅ Correção completa!\n\n";
echo "Próximos passos:\n";
echo "1. Execute: php artisan tenants:run migrate\n";
echo "2. Verifique se tudo funcionou corretamente\n";
