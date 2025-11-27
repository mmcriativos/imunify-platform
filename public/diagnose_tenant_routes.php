<?php
// Teste de identificação de tenant via domínio

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO COMPLETO - 404 NO AUTO-LOGIN\n";
echo "=============================================\n\n";

$testDomain = 'multiimune.imunify.com.br';

// 1. Domínio no banco
echo "1️⃣ Domínio no banco de dados:\n";
echo str_repeat("-", 50) . "\n";

$domain = DB::connection('central')->table('domains')->where('domain', $testDomain)->first();

if ($domain) {
    echo "✅ Domínio existe: {$domain->domain}\n";
    echo "   Tenant ID: {$domain->tenant_id}\n\n";
} else {
    echo "❌ Domínio NÃO existe no banco!\n\n";
    exit;
}

// 2. Central domains
echo "2️⃣ Configuração central_domains:\n";
echo str_repeat("-", 50) . "\n";

$centralDomains = config('tenancy.central_domains');
echo "Domínios centrais:\n";
foreach ($centralDomains as $cd) {
    echo "   • {$cd}\n";
}

if (in_array($testDomain, $centralDomains)) {
    echo "\n❌ PROBLEMA: {$testDomain} está em central_domains!\n";
    echo "   Isso impede que seja reconhecido como tenant.\n\n";
} else {
    echo "\n✅ {$testDomain} NÃO está em central_domains\n\n";
}

// 3. Arquivo de rotas tenant
echo "3️⃣ Arquivo routes/tenant.php:\n";
echo str_repeat("-", 50) . "\n";

$tenantRoutesFile = base_path('routes/tenant.php');
if (file_exists($tenantRoutesFile)) {
    echo "✅ Arquivo existe\n";
    
    $content = file_get_contents($tenantRoutesFile);
    if (str_contains($content, 'auto-login')) {
        echo "✅ Contém rota auto-login\n\n";
        
        // Mostrar a linha da rota
        $lines = explode("\n", $content);
        foreach ($lines as $i => $line) {
            if (str_contains($line, 'auto-login')) {
                echo "   Linha " . ($i + 1) . ": " . trim($line) . "\n";
            }
        }
        echo "\n";
    } else {
        echo "❌ NÃO contém rota auto-login\n\n";
    }
} else {
    echo "❌ Arquivo NÃO existe\n\n";
}

// 4. Provider de tenancy
echo "4️⃣ TenancyServiceProvider:\n";
echo str_repeat("-", 50) . "\n";

$providers = config('app.providers');
$tenancyProvider = array_filter($providers, function($p) {
    return str_contains($p, 'TenancyServiceProvider');
});

if (count($tenancyProvider) > 0) {
    echo "✅ TenancyServiceProvider registrado\n";
    foreach ($tenancyProvider as $p) {
        echo "   • {$p}\n";
    }
    echo "\n";
} else {
    echo "❌ TenancyServiceProvider NÃO registrado!\n\n";
}

echo "\n📋 RESUMO:\n";
echo str_repeat("=", 50) . "\n";
echo "• Domínio no banco: " . ($domain ? "✅" : "❌") . "\n";
echo "• NOT in central_domains: " . (!in_array($testDomain, $centralDomains) ? "✅" : "❌") . "\n";
echo "• routes/tenant.php existe: " . (file_exists($tenantRoutesFile) ? "✅" : "❌") . "\n";
echo "• TenancyServiceProvider: " . (count($tenancyProvider) > 0 ? "✅" : "❌") . "\n";

echo "\n💡 PRÓXIMOS PASSOS:\n";
echo str_repeat("=", 50) . "\n";

if (in_array($testDomain, $centralDomains)) {
    echo "❌ ERRO: Remova '{$testDomain}' de central_domains!\n";
    echo "   Apenas 'imunify.com.br' deve estar lá.\n";
} elseif (!$domain) {
    echo "❌ ERRO: Domínio não existe no banco!\n";
    echo "   Execute o registro novamente.\n";
} else {
    echo "✅ Configuração parece correta.\n";
    echo "   Tente acessar via navegador:\n";
    echo "   https://{$testDomain}/auto-login?token=SEU_TOKEN\n";
}
