<?php

/**
 * Script de diagnóstico de rotas
 * 
 * Acesse via: php diagnose_routes.php {subdomain}
 * Exemplo: php diagnose_routes.php multiimune
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$subdomain = $argv[1] ?? 'multiimune';
$domain = $subdomain . '.imunify.com.br';

echo "========================================\n";
echo "DIAGNÓSTICO DE ROTAS - TENANT\n";
echo "========================================\n\n";

echo "Domínio: {$domain}\n\n";

// Verificar cache de rotas
echo "1. Cache de Rotas:\n";
$routeCachePath = base_path('bootstrap/cache/routes-v7.php');
if (file_exists($routeCachePath)) {
    echo "   ❌ CACHE DE ROTAS ATIVO!\n";
    echo "   Arquivo: {$routeCachePath}\n";
    echo "   ⚠️  Multi-tenancy NÃO funciona com route cache!\n";
    echo "   Execute: php artisan route:clear\n\n";
} else {
    echo "   ✓ Cache de rotas desabilitado (correto)\n\n";
}

// Verificar se tenant existe
echo "2. Tenant:\n";
$tenant = \App\Models\Tenant::whereHas('domains', function($q) use ($domain) {
    $q->where('domain', $domain);
})->first();

if ($tenant) {
    echo "   ✓ Tenant encontrado: {$tenant->id}\n";
    echo "   Database: {$tenant->tenancy_db_name}\n\n";
    
    // Inicializar tenant
    echo "3. Inicializando contexto do tenant...\n";
    tenancy()->initialize($tenant);
    echo "   ✓ Tenant inicializado\n\n";
    
    // Listar rotas do tenant
    echo "4. Rotas disponíveis:\n";
    $routes = Route::getRoutes();
    
    $tenantRoutes = [];
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (str_contains($uri, 'auto-login') || str_contains($uri, 'login')) {
            $methods = implode('|', $route->methods());
            $name = $route->getName() ?? '(sem nome)';
            $tenantRoutes[] = "   {$methods} /{$uri} -> {$name}";
        }
    }
    
    if (empty($tenantRoutes)) {
        echo "   ❌ Nenhuma rota de login encontrada!\n";
    } else {
        foreach ($tenantRoutes as $r) {
            echo $r . "\n";
        }
    }
    
} else {
    echo "   ❌ Tenant NÃO encontrado para domínio: {$domain}\n";
}

echo "\n========================================\n";
