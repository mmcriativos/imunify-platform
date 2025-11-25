<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TENANTS REGISTRADOS ===\n\n";

$tenants = DB::table('tenants')->get();

foreach ($tenants as $tenant) {
    echo "Tenant ID: {$tenant->id}\n";
    
    $domains = DB::table('domains')->where('tenant_id', $tenant->id)->get();
    echo "Domínios:\n";
    foreach ($domains as $domain) {
        echo "  - {$domain->domain}\n";
    }
    echo "\n";
}
