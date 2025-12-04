<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;

echo "🚀 ATIVANDO TENANT PARA PRODUÇÃO\n";
echo str_repeat('=', 50) . "\n\n";

// Buscar o tenant multiimune
$tenant = Tenant::find('multiimune');

if (!$tenant) {
    echo "❌ Tenant 'multiimune' não encontrado!\n";
    exit(1);
}

echo "📋 Tenant encontrado: {$tenant->clinic_name}\n";
echo "   Plano atual: {$tenant->plan->name}\n";
echo "   Status atual: {$tenant->status}\n\n";

// Definir como ativo com assinatura de 1 ano
$tenant->status = 'active';
$tenant->trial_ends_at = null; // Remove trial
$tenant->grace_period_ends_at = null; // Remove grace period
$tenant->suspended_at = null; // Remove suspensão
$tenant->archived_at = null; // Remove arquivamento
$tenant->subscription_ends_at = now()->addYear(); // 1 ano de acesso
$tenant->save();

echo "✅ Tenant ativado com sucesso!\n\n";

echo "📊 Nova configuração:\n";
echo str_repeat('-', 50) . "\n";
echo "   Status: {$tenant->status}\n";
echo "   Assinatura válida até: " . $tenant->subscription_ends_at->format('d/m/Y H:i') . "\n";
echo "   Trial: " . ($tenant->trial_ends_at ? $tenant->trial_ends_at->format('d/m/Y') : 'Nenhum') . "\n";
echo "   Grace Period: " . ($tenant->grace_period_ends_at ? $tenant->grace_period_ends_at->format('d/m/Y') : 'Nenhum') . "\n";
echo "   Suspenso: " . ($tenant->suspended_at ? 'Sim' : 'Não') . "\n";
echo "   Arquivado: " . ($tenant->archived_at ? 'Sim' : 'Não') . "\n\n";

echo "🔍 Verificações:\n";
echo str_repeat('-', 50) . "\n";
echo "   isActive(): " . ($tenant->isActive() ? '✅ Sim' : '❌ Não') . "\n";
echo "   canAccess(): " . ($tenant->canAccess() ? '✅ Sim' : '❌ Não') . "\n";
echo "   hasActiveSubscription(): " . ($tenant->hasActiveSubscription() ? '✅ Sim' : '❌ Não') . "\n";
echo "   onTrial(): " . ($tenant->onTrial() ? '✅ Sim' : '❌ Não') . "\n";
echo "   isReadOnly(): " . ($tenant->isReadOnly() ? '⚠️ Sim' : '✅ Não') . "\n";
echo "   isSuspended(): " . ($tenant->isSuspended() ? '❌ Sim' : '✅ Não') . "\n\n";

if ($tenant->canAccess()) {
    echo "🎉 PERFEITO! O tenant está 100% ativo e funcional!\n";
    echo "   Acesso garantido até: " . $tenant->subscription_ends_at->format('d/m/Y') . "\n";
} else {
    echo "⚠️ ATENÇÃO! Ainda há algum problema de acesso.\n";
}

echo "\n" . str_repeat('=', 50) . "\n";
echo "✨ Pronto para produção!\n";
