<?php

/**
 * Script para aplicar migration de roles em todos os tenants
 * e atualizar os usuários existentes para admin
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║    Aplicar Migration de Roles em Todos os Tenants         ║\n";
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
        
        // Executar a migration
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant/2025_12_02_160857_add_role_and_status_to_users_table.php',
            '--force' => true,
        ]);
        
        // Atualizar usuário existente para admin
        $users = User::all();
        echo "  └─ Encontrados {$users->count()} usuário(s)\n";
        
        foreach ($users as $user) {
            // Se não tem role definida, definir como admin (primeiro usuário)
            if (empty($user->role)) {
                $user->role = 'admin';
                $user->is_active = true;
                $user->save();
                echo "  └─ Usuário '{$user->name}' definido como admin\n";
            }
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
    echo "   Todos os usuários existentes foram definidos como administradores.\n";
} else {
    echo "⚠️  Algumas migrations falharam. Verifique os erros acima.\n";
}
