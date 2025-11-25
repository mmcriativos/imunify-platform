<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Inicializar tenant
$tenantId = 'multiimune';
$tenant = \App\Models\Tenant::find($tenantId);

if (!$tenant) {
    die("❌ Tenant não encontrado!\n");
}

$tenant->run(function () {
    echo "=== Populando Credenciais WhatsApp do .env ===\n\n";
    
    // Buscar ou criar conexão
    $conn = \App\Models\WhatsAppConnection::firstOrNew(['id' => 1]);
    
    // Pegar credenciais do .env via config
    $instanceId = config('services.zapi.shared_instance_id');
    $token = config('services.zapi.shared_token');
    $clientToken = config('services.zapi.shared_client_token');
    
    echo "Credenciais do .env:\n";
    echo "Instance ID: " . ($instanceId ?: '❌ não configurado') . "\n";
    echo "Token: " . ($token ? '✅ ' . substr($token, 0, 10) . '...' : '❌ não configurado') . "\n";
    echo "Client Token: " . ($clientToken ? '✅ ' . substr($clientToken, 0, 10) . '...' : '❌ não configurado') . "\n\n";
    
    if (!$instanceId || !$token || !$clientToken) {
        die("❌ Credenciais incompletas no .env!\n");
    }
    
    // Atualizar conexão
    $conn->mode = 'shared';
    $conn->zapi_instance_id = $instanceId;
    $conn->zapi_token = $token;
    $conn->zapi_client_token = $clientToken;
    $conn->status = 'connected';
    $conn->save();
    
    echo "✅ Credenciais salvas na tabela whatsapp_connections!\n\n";
    
    echo "Verificação:\n";
    echo "Instance: " . $conn->zapi_instance_id . "\n";
    echo "Token: " . substr($conn->zapi_token, 0, 15) . "...\n";
    echo "Client Token: " . substr($conn->zapi_client_token, 0, 15) . "...\n";
    echo "Status: " . $conn->status . "\n";
    echo "Mode: " . $conn->mode . "\n";
});
