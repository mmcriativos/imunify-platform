<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "TENANTS:\n";
$tenants = DB::table('tenants')->get();
print_r($tenants->toArray());

echo "\n\nDOMAINS:\n";
$domains = DB::table('domains')->get();
print_r($domains->toArray());

echo "\n\nPOOL multiimune:\n";
$pool = \App\Models\DatabasePool::where('database_name', 'imunifycom_tenant_multiimune')->first();
print_r($pool ? $pool->toArray() : 'NULL');

echo "\n";
