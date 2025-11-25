<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Criar segundo tenant
$tenant = \App\Models\Tenant::create([
    'id' => 'clinica-demo',
]);

$tenant->plan_id = 3; // Enterprise
$tenant->clinic_name = 'Clínica Demo Premium';
$tenant->email = 'contato@clinicademo.com.br';
$tenant->phone = '11988888888';
$tenant->status = 'active';
$tenant->whatsapp_enabled = true;
$tenant->timezone = 'America/Sao_Paulo';
$tenant->save();

$tenant->domains()->create([
    'domain' => 'clinica-demo.localhost'
]);

echo "✅ Segundo tenant criado!\n";
echo "ID: {$tenant->id}\n";
echo "Plano: Enterprise (ID: 3)\n";
echo "Domínio: clinica-demo.localhost\n";
