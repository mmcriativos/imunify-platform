<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;

$tenant = Tenant::find('multiimune');

echo "\n📊 INFORMAÇÕES DO TENANT NA TABELA 'tenants'\n";
echo str_repeat('=', 60) . "\n\n";

echo "🏥 DADOS GERAIS:\n";
echo "   ID: {$tenant->id}\n";
echo "   Clínica: {$tenant->clinic_name}\n";
echo "   Email: {$tenant->email}\n";
echo "   Telefone: {$tenant->phone}\n\n";

echo "📋 PLANO E STATUS:\n";
echo "   Plan ID: " . ($tenant->plan_id ?? 'null') . "\n";
echo "   Plano: " . ($tenant->plan?->name ?? 'Nenhum') . "\n";
echo "   Status: {$tenant->status}\n\n";

echo "📅 DATAS IMPORTANTES:\n";
echo "   Trial ends at: " . ($tenant->trial_ends_at ? $tenant->trial_ends_at->format('d/m/Y H:i') : 'null') . "\n";
echo "   Grace period ends at: " . ($tenant->grace_period_ends_at ? $tenant->grace_period_ends_at->format('d/m/Y H:i') : 'null') . "\n";
echo "   Subscription ends at: " . ($tenant->subscription_ends_at ? $tenant->subscription_ends_at->format('d/m/Y H:i') : 'null') . "\n";
echo "   Suspended at: " . ($tenant->suspended_at ? $tenant->suspended_at->format('d/m/Y H:i') : 'null') . "\n";
echo "   Archived at: " . ($tenant->archived_at ? $tenant->archived_at->format('d/m/Y H:i') : 'null') . "\n";
echo "   Created at: " . $tenant->created_at->format('d/m/Y H:i') . "\n";
echo "   Updated at: " . $tenant->updated_at->format('d/m/Y H:i') . "\n\n";

echo "🗄️ BANCO DE DADOS:\n";
echo "   Nome: " . config('database.connections.mysql.database') . "\n";
echo "   Tabela: tenants\n";
echo "   Colunas principais:\n";
echo "      - id, plan_id, clinic_name, status\n";
echo "      - trial_ends_at, grace_period_ends_at\n";
echo "      - subscription_ends_at, suspended_at, archived_at\n\n";

echo str_repeat('=', 60) . "\n";
echo "💡 Para ver direto no MySQL:\n";
echo "   SELECT id, clinic_name, plan_id, status,\n";
echo "          trial_ends_at, subscription_ends_at\n";
echo "   FROM tenants WHERE id = 'multiimune';\n";
echo str_repeat('=', 60) . "\n";
