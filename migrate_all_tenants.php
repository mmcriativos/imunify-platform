<?php

/**
 * Script para executar TODAS as migrations pendentes em todos os tenants
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║      Executar Todas as Migrations em Todos os Tenants      ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$tenants = Tenant::all();

if ($tenants->isEmpty()) {
    echo "⚠️  Nenhum tenant encontrado.\n";
    exit(0);
}

echo "📋 Total de tenants: " . $tenants->count() . "\n\n";

$success = 0;
$errors = 0;

foreach ($tenants as $tenant) {
    echo "Processing: {$tenant->id}...\n";
    
    try {
        // Inicializar contexto do tenant
        tenancy()->initialize($tenant);
        
        // Executar TODAS as migrations pendentes
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
        
        echo "  └─ Migrations executadas\n";
        
        // Atualizar usuários existentes para admin (se houver)
        $users = User::all();
        
        if ($users->count() > 0) {
            echo "  └─ Encontrados {$users->count()} usuário(s)\n";
            
            foreach ($users as $user) {
                // Se não tem role definida, definir como admin
                if (empty($user->role) || $user->role === 'operator') {
                    $user->role = 'admin';
                    $user->is_active = true;
                    $user->save();
                    echo "  └─ Usuário '{$user->name}' definido como admin\n";
                }
            }
        } else {
            echo "  └─ Nenhum usuário encontrado\n";
        }
        
        // Finalizar contexto do tenant
        tenancy()->end();
        
        echo "  ✓ Sucesso\n\n";
        $success++;
        
    } catch (\Exception $e) {
        tenancy()->end();
        echo "  ✗ Erro: " . $e->getMessage() . "\n\n";
        $errors++;
    }
}

echo str_repeat("─", 60) . "\n";
echo "📊 Resumo:\n";
echo "   ✓ Sucesso: $success\n";
echo "   ✗ Erros: $errors\n";
echo "   📋 Total: " . $tenants->count() . "\n";
echo str_repeat("─", 60) . "\n\n";

if ($errors === 0) {
    echo "✅ Todas as migrations foram executadas com sucesso!\n";
} else {
    echo "⚠️  Algumas migrations falharam. Verifique os erros acima.\n";
}
