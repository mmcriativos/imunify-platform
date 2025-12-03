<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "=== Executando Migration de Password Reset Tokens ===\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    try {
        // Verificar se tabela já existe
        $exists = DB::select("SHOW TABLES LIKE 'password_reset_tokens'");
        
        if (empty($exists)) {
            // Criar tabela
            DB::statement("
                CREATE TABLE `password_reset_tokens` (
                    `email` varchar(255) NOT NULL,
                    `token` varchar(255) NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`email`),
                    KEY `password_reset_tokens_email_index` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            echo "  ✅ Tabela criada com sucesso\n";
        } else {
            echo "  ⏭️  Tabela já existe\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Erro: " . $e->getMessage() . "\n";
    }
    
    tenancy()->end();
    echo "\n";
}

echo "=== Concluído ===\n";
