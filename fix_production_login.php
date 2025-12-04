<?php

/*
 * Script para testar login do usuário existente em produção
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTE DE LOGIN - PRODUÇÃO ===\n\n";

// Inicializar tenant multiimune
$tenant = \App\Models\Tenant::where('id', 'multiimune')->first();

if (!$tenant) {
    echo "❌ Tenant multiimune não encontrado!\n";
    exit(1);
}

echo "✅ Tenant: {$tenant->id}\n";
echo "   Nome: {$tenant->name}\n\n";

$tenant->run(function () {
    echo "Database: " . DB::connection()->getDatabaseName() . "\n\n";
    
    // Verificar usuário existente
    $email = 'atendimento@multiimune.com.br';
    $user = \App\Models\User::where('email', $email)->first();
    
    if (!$user) {
        echo "❌ Usuário $email não encontrado!\n";
        return;
    }
    
    echo "✅ Usuário encontrado:\n";
    echo "   ID: {$user->id}\n";
    echo "   Nome: {$user->name}\n";
    echo "   Email: {$user->email}\n";
    echo "   Role: {$user->role}\n";
    echo "   Ativo: " . ($user->is_active ? 'SIM' : 'NÃO') . "\n";
    echo "   Created: {$user->created_at}\n\n";
    
    // Testar senhas comuns
    echo "TESTANDO SENHAS COMUNS:\n";
    $senhasTeste = [
        '12345678',
        'multiimune',
        'Multiimune@123',
        'atendimento',
        'senha123',
        'admin123',
    ];
    
    foreach ($senhasTeste as $senha) {
        $resultado = \Hash::check($senha, $user->password);
        $icone = $resultado ? '✅' : '❌';
        echo "   $icone '$senha': " . ($resultado ? 'CORRETA!' : 'incorreta') . "\n";
        
        if ($resultado) {
            echo "\n🎉 SENHA ENCONTRADA: '$senha'\n";
            echo "   Use estas credenciais para login:\n";
            echo "   Email: $email\n";
            echo "   Senha: $senha\n\n";
            return;
        }
    }
    
    echo "\n❌ Nenhuma senha comum funcionou.\n\n";
    
    // Opção: resetar senha
    echo "DESEJA RESETAR A SENHA PARA '12345678'? (s/n): ";
    $handle = fopen("php://stdin", "r");
    $resposta = trim(fgets($handle));
    
    if (strtolower($resposta) === 's') {
        $user->password = \Hash::make('12345678');
        $user->save();
        
        echo "\n✅ SENHA RESETADA COM SUCESSO!\n";
        echo "   Email: $email\n";
        echo "   Nova senha: 12345678\n";
        echo "   Tente fazer login agora!\n";
    } else {
        echo "\n❌ Senha não foi alterada.\n";
        echo "   Entre em contato com o administrador para resetar a senha.\n";
    }
});

echo "\n=== FIM DO TESTE ===\n";
