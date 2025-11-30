<?php
/**
 * Script para conceder permissões aos databases do pool
 * 
 * USO EM PRODUÇÃO:
 * 1. Faça upload deste arquivo para o servidor
 * 2. Execute: php grant_pool_permissions.php
 * 
 * IMPORTANTE: Este script requer que você tenha um usuário MySQL
 * com permissões de GRANT (geralmente root via phpMyAdmin ou SSH)
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "═══════════════════════════════════════════════════════\n";
echo "   CONCEDER PERMISSÕES AOS DATABASES DO POOL\n";
echo "═══════════════════════════════════════════════════════\n\n";

// Obter credenciais do .env
$user = env('DB_USERNAME');
$host = env('DB_HOST', 'localhost');

echo "🔍 Usuário: {$user}@{$host}\n";
echo "🔍 Procurando databases do pool...\n\n";

try {
    // Buscar todos os databases que começam com o prefixo do tenant
    $prefix = config('tenancy.database.prefix', 'imunifycom_tenant_');
    
    $databases = DB::select("SHOW DATABASES LIKE '{$prefix}%'");
    
    if (empty($databases)) {
        echo "❌ Nenhum database do pool encontrado!\n";
        echo "   Certifique-se de ter criado os databases do pool no cPanel.\n";
        exit(1);
    }
    
    echo "📊 Encontrados " . count($databases) . " databases:\n";
    
    $success = 0;
    $failed = 0;
    
    foreach ($databases as $db) {
        $dbName = array_values((array)$db)[0];
        
        try {
            // Conceder ALL PRIVILEGES
            DB::statement("GRANT ALL PRIVILEGES ON `{$dbName}`.* TO '{$user}'@'{$host}'");
            echo "   ✅ {$dbName}\n";
            $success++;
        } catch (\Exception $e) {
            echo "   ❌ {$dbName} - ERRO: " . $e->getMessage() . "\n";
            $failed++;
        }
    }
    
    // Flush privileges
    echo "\n🔄 Aplicando permissões (FLUSH PRIVILEGES)...\n";
    DB::statement("FLUSH PRIVILEGES");
    echo "   ✅ Permissões aplicadas!\n";
    
    echo "\n═══════════════════════════════════════════════════════\n";
    echo "   RESULTADO:\n";
    echo "═══════════════════════════════════════════════════════\n";
    echo "   ✅ Sucesso: {$success} databases\n";
    if ($failed > 0) {
        echo "   ❌ Falhas: {$failed} databases\n";
    }
    echo "\n";
    
    if ($failed === 0) {
        echo "🎉 Todas as permissões foram concedidas com sucesso!\n";
        echo "\nPróximos passos:\n";
        echo "1. Execute: php test_tenant_permissions.php\n";
        echo "2. Teste criar um tenant em: /registrar\n";
    } else {
        echo "⚠️  Algumas permissões falharam.\n";
        echo "Verifique se o usuário '{$user}' tem permissão de GRANT.\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERRO FATAL: " . $e->getMessage() . "\n";
    echo "\nPossíveis causas:\n";
    echo "- O usuário '{$user}' não tem permissão de GRANT\n";
    echo "- Problema de conexão com o banco de dados\n";
    echo "\nSolução:\n";
    echo "- Use phpMyAdmin com usuário root\n";
    echo "- Ou execute via SSH com usuário privilegiado\n";
    exit(1);
}
