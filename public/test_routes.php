<?php
/**
 * Testa se as rotas de registro estão funcionando
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;

header('Content-Type: text/plain; charset=utf-8');

echo "=== TESTE DE ROTAS ===\n\n";

// Listar todas as rotas
$routes = Route::getRoutes();

echo "1. Procurando rotas de registro:\n\n";

foreach ($routes as $route) {
    $uri = $route->uri();
    if (str_contains($uri, 'registrar') || str_contains($uri, 'register')) {
        echo "   URI: {$uri}\n";
        echo "   Nome: " . ($route->getName() ?? 'sem nome') . "\n";
        echo "   Métodos: " . implode(', ', $route->methods()) . "\n";
        echo "   Action: " . $route->getActionName() . "\n";
        echo "   Middleware: " . implode(', ', $route->middleware()) . "\n";
        echo "   " . str_repeat('-', 70) . "\n";
    }
}

echo "\n2. Testando se rota '/registrar' resolve:\n";
try {
    $route = Route::getRoutes()->match(
        \Illuminate\Http\Request::create('/registrar', 'GET')
    );
    echo "   ✓ Rota GET /registrar encontrada!\n";
    echo "   Controller: " . $route->getActionName() . "\n";
} catch (\Exception $e) {
    echo "   ✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n3. Testando se rota POST '/registrar' resolve:\n";
try {
    $route = Route::getRoutes()->match(
        \Illuminate\Http\Request::create('/registrar', 'POST')
    );
    echo "   ✓ Rota POST /registrar encontrada!\n";
    echo "   Controller: " . $route->getActionName() . "\n";
} catch (\Exception $e) {
    echo "   ✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n=== FIM ===\n";
