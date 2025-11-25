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
    echo "=== Atualizando Client-Token ===\n\n";
    
    $conn = \App\Models\WhatsAppConnection::first();
    
    if (!$conn) {
        die("❌ Conexão não encontrada!\n");
    }
    
    // Atualizar client-token
    $conn->zapi_client_token = 'Fb978b8f59b9e441f972afc3798da7331S';
    $conn->save();
    
    echo "✅ Client-Token atualizado!\n\n";
    
    echo "Credenciais atuais:\n";
    echo "Instance: " . $conn->zapi_instance_id . "\n";
    echo "Token: " . substr($conn->zapi_token, 0, 15) . "...\n";
    echo "Client Token: " . substr($conn->zapi_client_token, 0, 15) . "...\n";
});
