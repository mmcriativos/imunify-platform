<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use App\Models\User;

$tenant = Tenant::find('clinica-demo');
tenancy()->initialize($tenant);

$users = User::all(['id', 'name', 'email', 'role']);

echo "Usuários do tenant clinica-demo:\n\n";
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - {$user->role}\n";
}
