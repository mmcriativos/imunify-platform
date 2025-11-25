<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Buscar plano ANTES de inicializar tenancy (planos estão no banco central)
$plan = \App\Models\Plan::where('slug', 'starter')->first();

if (!$plan) {
    echo "❌ Plano 'starter' não encontrado no banco central!\n";
    exit;
}

// Agora inicializar tenancy
tenancy()->initialize('multiimune');
$tenant = tenant();

$tenant->plan_id = $plan->id;
$tenant->save();

echo "\n✅ Tenant '{$tenant->id}' associado ao plano '{$plan->name}'\n";
echo "   - Modo WhatsApp: {$plan->whatsapp_mode}\n";
echo "   - Quota mensal: {$plan->whatsapp_quota} mensagens\n";
