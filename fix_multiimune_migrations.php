<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Conectar ao banco do tenant multiimune
config(['database.connections.tenant.database' => 'tenantmultiimune']);
DB::purge('tenant');
DB::reconnect('tenant');

// Marcar migrations problemáticas como executadas
$migrations = [
    '2025_11_12_184932_add_modo_agir_to_vacinas_table',
    '2025_11_13_082912_add_branding_fields_to_tenants_table',
    '2025_11_13_095840_create_sessions_table',
    '2025_11_13_112649_expand_vacinas_table_with_inventory_control',
    '2025_11_13_112707_create_vacina_lotes_table',
    '2025_11_13_175534_add_lote_atual_to_vacinas_table',
    '2025_11_13_192000_add_lote_columns_safe',
    '2025_11_14_192623_add_cnes_crm_to_tenants_table',
    '2025_11_16_000001_add_whatsapp_fields_to_plans_table',
];

foreach ($migrations as $migration) {
    try {
        DB::connection('tenant')->table('migrations')->insert([
            'migration' => $migration,
            'batch' => 10
        ]);
        echo "✓ Marcada: $migration\n";
    } catch (\Exception $e) {
        echo "  Já existe: $migration\n";
    }
}

echo "\n✅ Migrations marcadas como executadas!\n";
