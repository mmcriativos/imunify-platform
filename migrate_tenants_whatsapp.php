<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenants = \App\Models\Tenant::all();

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    // Marcar migrations problemáticas
    DB::table('migrations')->insertOrIgnore([
        ['migration' => '2025_11_14_163704_add_cidade_field_to_pacientes_table', 'batch' => DB::table('migrations')->max('batch') + 1],
    ]);
    
    // Rodar migration do WhatsApp
    try {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/2025_11_16_000002_create_whatsapp_connections_table.php',
            '--force' => true,
        ]);
        echo "  ✅ WhatsApp connections criada\n";
    } catch (\Exception $e) {
        echo "  ❌ Erro: " . $e->getMessage() . "\n";
    }
    
    tenancy()->end();
}

echo "\n✅ Processo concluído!\n";
