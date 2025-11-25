<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Stancl\Tenancy\Database\Models\Tenant;

$tenants = Tenant::with('domains')->get();

foreach ($tenants as $tenant) {
    echo "\nTenant ID: {$tenant->id}\n";
    echo "Domínios:\n";
    foreach ($tenant->domains as $domain) {
        echo "  - {$domain->domain}\n";
    }
}
