<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

// Selecionar o tenant
$tenant = Tenant::where('id', 'multiimune')->firstOrFail();

// Executar no contexto do tenant
tenancy()->initialize($tenant);

echo "🔧 Adicionando coluna deleted_at à tabela formas_pagamento...\n\n";

try {
    DB::statement('ALTER TABLE formas_pagamento ADD COLUMN deleted_at TIMESTAMP NULL AFTER updated_at');
    echo "✅ Coluna deleted_at adicionada com sucesso!\n";
} catch (\Exception $e) {
    if (str_contains($e->getMessage(), 'Duplicate column name')) {
        echo "⚠️  Coluna deleted_at já existe!\n";
    } else {
        echo "❌ Erro: " . $e->getMessage() . "\n";
    }
}

echo "\n📋 Verificando estrutura da tabela...\n";
$columns = DB::select('SHOW COLUMNS FROM formas_pagamento');
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}
