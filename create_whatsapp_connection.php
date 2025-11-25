<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔧 Criando conexão WhatsApp para tenant multiimune\n";
echo str_repeat('=', 50) . "\n\n";

// Inicializar tenant
tenancy()->initialize('multiimune');

// Buscar plano do tenant
$tenant = tenant();
$plan = $tenant->plan;

echo "📋 Plano do tenant: {$plan->name}\n";
echo "   - Modo: {$plan->whatsapp_mode}\n";
echo "   - Quota: " . ($plan->whatsapp_unlimited ? 'Ilimitado' : $plan->whatsapp_quota) . "\n\n";

// Criar ou atualizar conexão WhatsApp
$connection = App\Models\WhatsAppConnection::updateOrCreate(
    ['id' => 1], // Usar ID fixo para ter apenas uma conexão por tenant
    [
        'mode' => $plan->whatsapp_mode,
        'status' => 'connected',
        'messages_sent_month' => 0,
        'messages_quota' => $plan->whatsapp_quota,
        'quota_unlimited' => $plan->whatsapp_unlimited,
        'quota_reset_date' => now()->addMonth(),
        'zapi_instance_id' => null, // Para modo shared, não precisa
        'zapi_token' => null,
        'zapi_client_token' => null,
    ]
);

echo "✅ Conexão WhatsApp criada/atualizada:\n";
echo "   - ID: {$connection->id}\n";
echo "   - Modo: {$connection->mode}\n";
echo "   - Status: {$connection->status}\n";
echo "   - Quota: {$connection->messages_sent_month} / {$connection->messages_quota}\n";
echo "   - Reset: {$connection->quota_reset_date}\n\n";

echo str_repeat('=', 50) . "\n";
echo "✅ Concluído!\n";
