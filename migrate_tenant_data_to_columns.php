<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

echo "🔧 MIGRANDO DADOS DO JSON PARA COLUNAS DA TABELA\n";
echo str_repeat('=', 60) . "\n\n";

$tenant = Tenant::find('multiimune');

if (!$tenant) {
    echo "❌ Tenant 'multiimune' não encontrado!\n";
    exit(1);
}

echo "📋 Tenant encontrado: {$tenant->id}\n\n";

// Pegar dados do JSON 'data'
$data = json_decode($tenant->getRawOriginal('data'), true) ?? [];

echo "📦 Dados no campo JSON 'data':\n";
echo str_repeat('-', 60) . "\n";
foreach ($data as $key => $value) {
    if (!is_array($value)) {
        echo "   {$key}: " . ($value ?? 'null') . "\n";
    }
}
echo "\n";

// Campos que devem estar nas colunas
$columnsToMigrate = [
    'plan_id',
    'clinic_name',
    'status',
    'trial_ends_at',
    'grace_period_ends_at',
    'subscription_ends_at',
    'suspended_at',
    'archived_at',
    'email',
    'phone',
    'cnpj',
    'address',
    'city',
    'state',
    'zip_code',
    'primary_color',
    'timezone',
    'whatsapp_enabled',
    'cnes',
    'crm',
];

echo "🔄 Migrando dados para colunas da tabela...\n";
echo str_repeat('-', 60) . "\n";

$updates = [];
foreach ($columnsToMigrate as $column) {
    if (isset($data[$column])) {
        $value = $data[$column];
        
        // Tratar datas
        if (in_array($column, ['trial_ends_at', 'grace_period_ends_at', 'subscription_ends_at', 'suspended_at', 'archived_at'])) {
            $value = $value ? \Carbon\Carbon::parse($value) : null;
        }
        
        $updates[$column] = $value;
        echo "   ✓ {$column}: " . ($value ?? 'null') . "\n";
    }
}

if (empty($updates)) {
    echo "\n⚠️ Nenhum dado para migrar!\n";
} else {
    echo "\n💾 Salvando na tabela...\n";
    
    // Atualizar diretamente no banco para evitar o behavior do Stancl
    DB::table('tenants')
        ->where('id', 'multiimune')
        ->update($updates);
    
    echo "✅ Dados migrados com sucesso!\n\n";
    
    // Recarregar tenant
    $tenant = Tenant::find('multiimune');
    
    echo "📊 Verificando colunas da tabela:\n";
    echo str_repeat('-', 60) . "\n";
    $rawData = DB::table('tenants')->where('id', 'multiimune')->first();
    
    echo "   plan_id: " . ($rawData->plan_id ?? 'null') . "\n";
    echo "   clinic_name: " . ($rawData->clinic_name ?? 'null') . "\n";
    echo "   status: " . ($rawData->status ?? 'null') . "\n";
    echo "   subscription_ends_at: " . ($rawData->subscription_ends_at ?? 'null') . "\n";
    echo "   trial_ends_at: " . ($rawData->trial_ends_at ?? 'null') . "\n";
    echo "   grace_period_ends_at: " . ($rawData->grace_period_ends_at ?? 'null') . "\n";
    echo "\n";
    
    if ($rawData->subscription_ends_at && $rawData->subscription_ends_at !== 'null') {
        echo "🎉 SUCESSO! Os dados agora estão nas colunas da tabela!\n";
    } else {
        echo "⚠️ ATENÇÃO! Ainda há dados faltando nas colunas.\n";
    }
}

echo "\n" . str_repeat('=', 60) . "\n";
echo "✨ Processo concluído!\n";
