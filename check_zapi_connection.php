<?php

require __DIR__.'/vendor/autoload.php';

$instanceId = '3EA00D045BBA411272EA262C2401B26D';
$token = '53C7BCFE425BACB7D273D037';

echo "=== Verificar Conexão Z-API ===\n\n";

// Teste 1: Verificar Status
echo "1. Verificando status da instância...\n";
$url = "https://api.z-api.io/instances/{$instanceId}/token/{$token}/status";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status HTTP: $httpCode\n";
echo "Response: $response\n\n";

// Teste 2: Solicitar QR Code (se não conectado)
echo "2. Solicitando QR Code...\n";
$url = "https://api.z-api.io/instances/{$instanceId}/token/{$token}/qr-code/image";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status HTTP: $httpCode\n";

if ($httpCode == 200) {
    // Salvar QR Code como imagem
    file_put_contents('qrcode_zapi.png', $response);
    echo "✅ QR Code salvo em: qrcode_zapi.png\n";
    echo "Abra o arquivo e escaneie com seu WhatsApp!\n\n";
} else {
    echo "Response: $response\n\n";
}

// Teste 3: Verificar se já está conectado
echo "3. Verificando estado da conexão...\n";
$url = "https://api.z-api.io/instances/{$instanceId}/token/{$token}/phone";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status HTTP: $httpCode\n";
echo "Response: $response\n\n";

if ($httpCode == 200) {
    $data = json_decode($response, true);
    if (isset($data['phone'])) {
        echo "✅ WhatsApp conectado! Número: " . $data['phone'] . "\n";
    }
} else {
    echo "⚠️ WhatsApp não está conectado. Você precisa:\n";
    echo "1. Abrir o arquivo qrcode_zapi.png (se foi gerado)\n";
    echo "2. Escanear com seu WhatsApp: Configurações > Aparelhos conectados > Conectar um aparelho\n";
}
