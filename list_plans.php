<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$plans = \App\Models\Plan::all();

echo "📋 Planos cadastrados: " . $plans->count() . "\n\n";

foreach ($plans as $plan) {
    echo "  - {$plan->name} ({$plan->slug})\n";
    echo "    Preço: R$ " . number_format($plan->price_monthly, 2, ',', '.') . "/mês\n";
    echo "    WhatsApp: {$plan->whatsapp_mode}\n";
    echo "    Quota: " . ($plan->whatsapp_unlimited ? 'Ilimitado' : $plan->whatsapp_quota . ' msgs/mês') . "\n\n";
}
