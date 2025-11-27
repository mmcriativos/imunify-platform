<?php
// Script para verificar se as rotas tenant estão sendo carregadas
// Execute: php check_routes.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Route;

echo "🔍 VERIFICAÇÃO DE ROTAS CARREGADAS\n";
echo "===================================\n\n";

$routes = Route::getRoutes();
$totalRoutes = $routes->count();

echo "Total de rotas registradas: {$totalRoutes}\n\n";

// Filtrar rotas que contêm 'auto-login'
$autoLoginRoutes = [];

foreach ($routes as $route) {
    if (str_contains($route->uri(), 'auto-login')) {
        $autoLoginRoutes[] = $route;
    }
}

if (count($autoLoginRoutes) > 0) {
    echo "✅ Rotas auto-login encontradas: " . count($autoLoginRoutes) . "\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($autoLoginRoutes as $route) {
        echo "• " . implode('|', $route->methods()) . " /" . $route->uri() . "\n";
        echo "  Nome: " . ($route->getName() ?: 'N/A') . "\n";
        echo "  Controller: " . $route->getActionName() . "\n";
        echo "  Middleware: " . implode(', ', $route->middleware()) . "\n\n";
    }
} else {
    echo "❌ Nenhuma rota auto-login encontrada!\n\n";
    
    echo "Primeiras 30 rotas registradas:\n";
    echo str_repeat("-", 50) . "\n";
    
    $count = 0;
    foreach ($routes as $route) {
        echo ($count + 1) . ". " . implode('|', $route->methods()) . " /" . $route->uri();
        
        if ($route->getName()) {
            echo " [" . $route->getName() . "]";
        }
        
        echo "\n";
        
        $count++;
        if ($count >= 30) {
            break;
        }
    }
}

echo "\n📊 ANÁLISE:\n";
echo str_repeat("=", 50) . "\n";

if (count($autoLoginRoutes) > 0) {
    echo "✅ As rotas tenant estão sendo carregadas.\n";
    echo "   O problema pode ser no middleware de identificação.\n\n";
    echo "💡 Próximo passo:\n";
    echo "   Verifique se o middleware InitializeTenancyByDomain\n";
    echo "   está conseguindo identificar o tenant pelo domínio.\n";
} else {
    echo "❌ As rotas tenant NÃO estão sendo carregadas!\n\n";
    echo "💡 Verifique:\n";
    echo "   1. O arquivo routes/tenant.php existe?\n";
    echo "   2. O TenancyServiceProvider está registrado em config/app.php?\n";
    echo "   3. O método mapRoutes() está sendo chamado no provider?\n";
}
