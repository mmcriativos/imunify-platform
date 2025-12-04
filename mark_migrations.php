<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

echo "=== Marcando migrations já executadas ===\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    try {
        // Migrations que já existem mas não estão marcadas
        $migrations = [
            '2025_11_13_082912_add_branding_fields_to_tenants_table',
            '2025_11_13_095840_create_sessions_table',
            '2025_12_03_105310_create_password_reset_tokens_table',
        ];
        
        foreach ($migrations as $migration) {
            // Verificar se já está marcada
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
        }
    } catch (\Exception $e) {
        echo "  ❌ Erro: " . $e->getMessage() . "\n";
    }
    
    tenancy()->end();
    echo "\n";
}

echo "=== Concluído ===\n";
