<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🔍 VERIFICANDO USUÁRIOS NO TENANT\n";
echo str_repeat('=', 60) . "\n\n";

// Inicializar tenant
tenancy()->initialize('multiimune');

echo "📊 Tenant: " . tenant('id') . "\n";
echo "📁 Database: " . config('database.connections.mysql.database') . "\n\n";

$users = User::all();

if ($users->isEmpty()) {
    echo "❌ Nenhum usuário encontrado no banco!\n\n";
    
    echo "🔧 Criando usuário de teste...\n";
    $user = User::create([
        'name' => 'Teste Admin',
        'email' => 'admin@teste.com',
        'password' => Hash::make('12345678'),
        'role' => 'master',
        'is_active' => true,
    ]);
    
    echo "✅ Usuário criado:\n";
    echo "   Email: {$user->email}\n";
    echo "   Senha: 12345678\n";
    echo "   Role: {$user->role}\n\n";
} else {
    echo "👥 Usuários encontrados:\n";
    echo str_repeat('-', 60) . "\n";
    
    foreach ($users as $user) {
        echo "\n";
        echo "ID: {$user->id}\n";
        echo "Nome: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: {$user->role}\n";
        echo "Ativo: " . ($user->is_active ? 'Sim' : 'Não') . "\n";
        echo "Criado: {$user->created_at}\n";
        echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";
        
        // Testar senha
        echo "\n🔐 Testando senhas comuns:\n";
        $senhasParaTestar = ['12345678', 'password', 'admin123', 'teste123'];
        
        foreach ($senhasParaTestar as $senha) {
            if (Hash::check($senha, $user->password)) {
                echo "   ✅ Senha correta: {$senha}\n";
            }
        }
    }
}

echo "\n" . str_repeat('=', 60) . "\n";
echo "💡 Para resetar senha de um usuário específico:\n";
echo "   \$user = User::where('email', 'seu@email.com')->first();\n";
echo "   \$user->password = Hash::make('novaSenha123');\n";
echo "   \$user->save();\n";
