<?php

/*
 * Script de Diagnóstico de Login
 * Execute no servidor de produção para verificar a configuração
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DIAGNÓSTICO DE LOGIN ===\n\n";

// 1. Verificar se o arquivo de log existe e tem permissões
$logPath = storage_path('logs/laravel.log');
echo "1. VERIFICANDO ARQUIVO DE LOG:\n";
echo "   Caminho: $logPath\n";
echo "   Existe: " . (file_exists($logPath) ? "✅ SIM" : "❌ NÃO") . "\n";

if (file_exists($logPath)) {
    $perms = substr(sprintf('%o', fileperms($logPath)), -4);
    $size = filesize($logPath);
    $writable = is_writable($logPath);
    
    echo "   Permissões: $perms\n";
    echo "   Tamanho: " . number_format($size) . " bytes\n";
    echo "   Gravável: " . ($writable ? "✅ SIM" : "❌ NÃO") . "\n";
    
    // Últimas linhas do log
    echo "\n   Últimas 5 linhas do log:\n";
    $lines = file($logPath);
    $lastLines = array_slice($lines, -5);
    foreach ($lastLines as $line) {
        echo "   " . trim($line) . "\n";
    }
}

echo "\n";

// 2. Verificar configuração de logging
echo "2. CONFIGURAÇÃO DE LOGGING:\n";
echo "   LOG_CHANNEL: " . env('LOG_CHANNEL', 'stack') . "\n";
echo "   LOG_LEVEL: " . env('LOG_LEVEL', 'debug') . "\n";

$logConfig = config('logging.channels.single');
if ($logConfig) {
    echo "   Canal 'single':\n";
    echo "     - path: " . ($logConfig['path'] ?? 'não definido') . "\n";
    echo "     - level: " . ($logConfig['level'] ?? 'não definido') . "\n";
}

echo "\n";

// 3. Testar escrita no log
echo "3. TESTANDO ESCRITA NO LOG:\n";
try {
    \Log::info('=== TESTE DE LOG - ' . now() . ' ===');
    \Log::info('✅ Se você está vendo isso, o log está funcionando!');
    echo "   ✅ Log escrito com sucesso!\n";
    echo "   Verifique o arquivo: tail -5 storage/logs/laravel.log\n";
} catch (\Exception $e) {
    echo "   ❌ Erro ao escrever no log: " . $e->getMessage() . "\n";
}

echo "\n";

// 4. Verificar rota de login
echo "4. VERIFICANDO ROTA DE LOGIN:\n";
try {
    $loginRoute = \Route::getRoutes()->getByName('login');
    if ($loginRoute) {
        echo "   ✅ Rota 'login' encontrada\n";
        echo "   URI: " . $loginRoute->uri() . "\n";
        echo "   Métodos: " . implode(', ', $loginRoute->methods()) . "\n";
        echo "   Action: " . $loginRoute->getActionName() . "\n";
        
        // Middleware
        $middleware = $loginRoute->middleware();
        echo "   Middleware: " . (count($middleware) ? implode(', ', $middleware) : 'nenhum') . "\n";
    } else {
        echo "   ❌ Rota 'login' NÃO encontrada\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Erro: " . $e->getMessage() . "\n";
}

echo "\n";

// 5. Verificar LoginController
echo "5. VERIFICANDO LoginController:\n";
$controllerPath = app_path('Http/Controllers/Auth/LoginController.php');
echo "   Caminho: $controllerPath\n";
echo "   Existe: " . (file_exists($controllerPath) ? "✅ SIM" : "❌ NÃO") . "\n";

if (file_exists($controllerPath)) {
    $content = file_get_contents($controllerPath);
    $hasLogging = strpos($content, 'Log::info') !== false || strpos($content, '\Log::info') !== false;
    echo "   Tem logging: " . ($hasLogging ? "✅ SIM" : "❌ NÃO") . "\n";
    
    // Contar quantos Log::info existem
    $logCount = substr_count($content, 'Log::info');
    echo "   Quantidade de logs: $logCount\n";
}

echo "\n";

// 6. Verificar se tenancy está ativo
echo "6. VERIFICANDO TENANCY:\n";
echo "   Tenant atual: " . (tenancy()->initialized ? tenant('id') : 'NÃO INICIALIZADO') . "\n";

if (tenancy()->initialized) {
    $tenant = tenant();
    echo "   Nome: " . $tenant->name . "\n";
    echo "   Domínio: " . $tenant->domains->first()->domain ?? 'N/A' . "\n";
    echo "   Database: " . DB::connection()->getDatabaseName() . "\n";
}

echo "\n";

// 7. Verificar usuário de teste
echo "7. VERIFICANDO USUÁRIO DE TESTE:\n";
echo "   Domínio para teste: multiimune.imunify.com.br\n";

try {
    // Inicializar tenant multiimune
    $tenant = \App\Models\Tenant::where('id', 'multiimune')->first();
    
    if ($tenant) {
        echo "   ✅ Tenant 'multiimune' encontrado\n";
        
        $tenant->run(function () {
            echo "   Database conectado: " . DB::connection()->getDatabaseName() . "\n";
            
            $user = \App\Models\User::where('email', 'admin@teste.com')->first();
            
            if ($user) {
                echo "   ✅ Usuário admin@teste.com encontrado\n";
                echo "   ID: " . $user->id . "\n";
                echo "   Nome: " . $user->name . "\n";
                echo "   Role: " . $user->role . "\n";
                echo "   Ativo: " . ($user->is_active ? 'SIM' : 'NÃO') . "\n";
                
                // Testar senha
                $senhaCorreta = \Hash::check('12345678', $user->password);
                echo "   Senha '12345678': " . ($senhaCorreta ? "✅ CORRETA" : "❌ INCORRETA") . "\n";
            } else {
                echo "   ❌ Usuário admin@teste.com NÃO encontrado\n";
                
                // Listar usuários existentes
                $users = \App\Models\User::all();
                echo "   Usuários existentes: " . $users->count() . "\n";
                foreach ($users as $u) {
                    echo "     - {$u->email} (role: {$u->role})\n";
                }
            }
        });
    } else {
        echo "   ❌ Tenant 'multiimune' NÃO encontrado\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Erro: " . $e->getMessage() . "\n";
}

echo "\n=== FIM DO DIAGNÓSTICO ===\n";
