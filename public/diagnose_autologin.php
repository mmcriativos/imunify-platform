<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO COMPLETO - AUTO-LOGIN 404\n";
echo "==========================================\n\n";

$testDomain = 'multiimune.imunify.com.br';
$testToken = 'Ti4wgInS4l3RWuu8q87zDXDtTof8OmtpRTQSWJRmA2iIykh8krPBk7ebIET7';

echo "🌐 Domínio testado: {$testDomain}\n";
echo "🔑 Token testado: {$testToken}\n\n";

echo "=" . str_repeat("=", 50) . "\n\n";

// 1. Verificar domínio
echo "1️⃣ DOMÍNIO NO BANCO CENTRAL:\n";
echo str_repeat("-", 50) . "\n";

$domain = DB::connection('central')
    ->table('domains')
    ->where('domain', $testDomain)
    ->first();

if ($domain) {
    echo "✅ Domínio existe: {$domain->domain}\n";
    echo "   Tenant ID: {$domain->tenant_id}\n\n";
} else {
    echo "❌ Domínio NÃO existe!\n\n";
    echo "Domínios cadastrados:\n";
    $allDomains = DB::connection('central')->table('domains')->get();
    foreach ($allDomains as $d) {
        echo "  • {$d->domain} -> {$d->tenant_id}\n";
    }
    exit;
}

// 2. Verificar tenant
echo "2️⃣ TENANT NO BANCO CENTRAL:\n";
echo str_repeat("-", 50) . "\n";

$tenant = DB::connection('central')
    ->table('tenants')
    ->where('id', $domain->tenant_id)
    ->first();

if ($tenant) {
    echo "✅ Tenant existe: {$tenant->id}\n";
    echo "   Database: {$tenant->tenancy_db_name}\n";
    echo "   Criado: {$tenant->created_at}\n\n";
} else {
    echo "❌ Tenant NÃO existe!\n\n";
    exit;
}

// 3. Verificar token no cache
echo "3️⃣ TOKEN NO CACHE:\n";
echo str_repeat("-", 50) . "\n";

try {
    $cacheKey = 'login_token_' . $testToken;
    $cachedUserId = app('cache')->store()->get($cacheKey);
    
    if ($cachedUserId) {
        echo "✅ Token encontrado no cache!\n";
        echo "   User ID: {$cachedUserId}\n\n";
    } else {
        echo "❌ Token NÃO encontrado no cache!\n";
        echo "   Cache key procurada: {$cacheKey}\n\n";
        
        // Tentar listar todas as chaves de cache
        echo "Tentando verificar cache do tenant...\n";
    }
} catch (\Exception $e) {
    echo "❌ Erro ao acessar cache: {$e->getMessage()}\n\n";
}

// 4. Verificar rotas tenant
echo "4️⃣ ROTAS TENANT CARREGADAS:\n";
echo str_repeat("-", 50) . "\n";

try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $autoLoginRoute = null;
    
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'auto-login')) {
            $autoLoginRoute = $route;
            echo "✅ Rota auto-login encontrada!\n";
            echo "   URI: {$route->uri()}\n";
            echo "   Nome: {$route->getName()}\n";
            echo "   Ação: {$route->getActionName()}\n";
            echo "   Middleware: " . implode(', ', $route->middleware()) . "\n\n";
            break;
        }
    }
    
    if (!$autoLoginRoute) {
        echo "❌ Rota auto-login NÃO encontrada!\n\n";
    }
} catch (\Exception $e) {
    echo "❌ Erro ao verificar rotas: {$e->getMessage()}\n\n";
}

// 5. Verificar arquivo de rotas tenant
echo "5️⃣ ARQUIVO DE ROTAS TENANT:\n";
echo str_repeat("-", 50) . "\n";

$tenantRoutesFile = base_path('routes/tenant.php');
if (file_exists($tenantRoutesFile)) {
    echo "✅ Arquivo existe: routes/tenant.php\n";
    
    $content = file_get_contents($tenantRoutesFile);
    if (str_contains($content, 'auto-login')) {
        echo "✅ Rota auto-login definida no arquivo\n\n";
    } else {
        echo "❌ Rota auto-login NÃO definida no arquivo\n\n";
    }
} else {
    echo "❌ Arquivo routes/tenant.php NÃO existe!\n\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 RESUMO:\n";
echo str_repeat("=", 50) . "\n";
echo "Domínio: " . ($domain ? "✅" : "❌") . "\n";
echo "Tenant: " . ($tenant ? "✅" : "❌") . "\n";
echo "Token no cache: " . ($cachedUserId ?? false ? "✅" : "❌") . "\n";
echo "Rota auto-login: " . ($autoLoginRoute ?? false ? "✅" : "❌") . "\n";
