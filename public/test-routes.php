<?php

/**
 * Teste simples de auto-login
 * Acesse via: https://multiimune.imunify.com.br/test-routes.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Simular request HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Criar request para o domínio do tenant
$request = Illuminate\Http\Request::create(
    'https://multiimune.imunify.com.br/auto-login?token=test123',
    'GET',
    [],
    [],
    [],
    ['HTTP_HOST' => 'multiimune.imunify.com.br']
);

try {
    $response = $kernel->handle($request);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Headers:\n";
    foreach ($response->headers->all() as $key => $values) {
        foreach ($values as $value) {
            echo "  {$key}: {$value}\n";
        }
    }
    echo "\nContent:\n";
    echo $response->getContent();
    
    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
}
