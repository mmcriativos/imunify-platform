<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Inicializar tenancy
tenancy()->initialize('multiimune');

// Buscar usuário
$user = \App\Models\User::where('email', 'admin@multiimune.com')->first();

if ($user) {
    $user->password = bcrypt('123456');
    $user->email_verified_at = now();
    $user->save();
    
    echo "✅ Senha resetada com sucesso!\n";
    echo "Email: admin@multiimune.com\n";
    echo "Senha: 123456\n";
    echo "Email verificado: " . $user->email_verified_at . "\n";
} else {
    echo "❌ Usuário não encontrado!\n";
}
