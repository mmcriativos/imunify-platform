<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Usar o model customizado
$tenant = \App\Models\Tenant::create([
    'id' => 'clinica-teste',
]);

// Definir dados adicionais
$tenant->plan_id = 2;
$tenant->clinic_name = 'Clínica Teste';
$tenant->email = 'contato@clinicateste.com.br';
$tenant->phone = '11999999999';
$tenant->status = 'active';
$tenant->whatsapp_enabled = true;
$tenant->timezone = 'America/Sao_Paulo';
$tenant->save();

// Criar domínio
$tenant->domains()->create([
    'domain' => 'clinica-teste.localhost'
]);

echo "✅ Tenant criado com sucesso!\n";
echo "ID: {$tenant->id}\n";
echo "Plano: Profissional (ID: 2)\n";
echo "Domínio: clinica-teste.localhost\n";
echo "\nPróximo passo: php artisan tenants:migrate --tenants=clinica-teste\n";
