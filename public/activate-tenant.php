<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ativar Tenant - Produção</title>
    <style>
        body { font-family: 'Courier New', monospace; background: #1a1a1a; color: #00ff00; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #000; padding: 30px; border-radius: 10px; border: 2px solid #00ff00; }
        h1 { color: #00ff00; text-align: center; }
        .section { margin: 20px 0; padding: 15px; border-left: 3px solid #00ff00; }
        .success { color: #00ff00; }
        .warning { color: #ffff00; }
        .error { color: #ff0000; }
        .info { color: #00aaff; }
        hr { border: 1px solid #00ff00; margin: 20px 0; }
        .check { display: flex; justify-content: space-between; padding: 5px 0; }
        .button { background: #00ff00; color: #000; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin: 10px 5px; }
        .button:hover { background: #00cc00; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 ATIVAÇÃO DE TENANT PARA PRODUÇÃO</h1>
        <hr>
        
        <?php
        if (isset($_POST['activate'])) {
            // Buscar o tenant multiimune
            $tenant = Tenant::find('multiimune');
            
            if (!$tenant) {
                echo '<div class="section error">❌ Tenant "multiimune" não encontrado!</div>';
                exit;
            }
            
            echo '<div class="section info">';
            echo "📋 Tenant encontrado: {$tenant->clinic_name}<br>";
            echo "   Status atual: {$tenant->status}<br>";
            echo "   Plano: " . ($tenant->plan?->name ?? 'Nenhum') . "<br>";
            echo '</div>';
            
            // Ativar tenant
            $tenant->status = 'active';
            $tenant->trial_ends_at = null;
            $tenant->grace_period_ends_at = null;
            $tenant->suspended_at = null;
            $tenant->archived_at = null;
            $tenant->subscription_ends_at = now()->addYear();
            $tenant->save();
            
            echo '<div class="section success">';
            echo "✅ Tenant ativado com sucesso!<br><br>";
            
            echo "📊 Nova configuração:<br>";
            echo "   Status: {$tenant->status}<br>";
            echo "   Assinatura válida até: " . $tenant->subscription_ends_at->format('d/m/Y H:i') . "<br>";
            echo "   Trial: " . ($tenant->trial_ends_at ? $tenant->trial_ends_at->format('d/m/Y') : 'Nenhum') . "<br>";
            echo "   Grace Period: " . ($tenant->grace_period_ends_at ? $tenant->grace_period_ends_at->format('d/m/Y') : 'Nenhum') . "<br>";
            echo "   Suspenso: " . ($tenant->suspended_at ? 'Sim' : 'Não') . "<br>";
            echo "   Arquivado: " . ($tenant->archived_at ? 'Sim' : 'Não') . "<br>";
            echo '</div>';
            
            echo '<div class="section info">';
            echo "🔍 Verificações:<br>";
            echo '<div class="check"><span>isActive():</span><span>' . ($tenant->isActive() ? '✅ Sim' : '❌ Não') . '</span></div>';
            echo '<div class="check"><span>canAccess():</span><span>' . ($tenant->canAccess() ? '✅ Sim' : '❌ Não') . '</span></div>';
            echo '<div class="check"><span>hasActiveSubscription():</span><span>' . ($tenant->hasActiveSubscription() ? '✅ Sim' : '❌ Não') . '</span></div>';
            echo '<div class="check"><span>onTrial():</span><span>' . ($tenant->onTrial() ? '✅ Sim' : '❌ Não') . '</span></div>';
            echo '<div class="check"><span>isReadOnly():</span><span>' . ($tenant->isReadOnly() ? '⚠️ Sim' : '✅ Não') . '</span></div>';
            echo '<div class="check"><span>isSuspended():</span><span>' . ($tenant->isSuspended() ? '❌ Sim' : '✅ Não') . '</span></div>';
            echo '</div>';
            
            if ($tenant->canAccess()) {
                echo '<div class="section success">';
                echo "🎉 PERFEITO! O tenant está 100% ativo e funcional!<br>";
                echo "   Acesso garantido até: " . $tenant->subscription_ends_at->format('d/m/Y') . "<br>";
                echo '</div>';
            } else {
                echo '<div class="section warning">';
                echo "⚠️ ATENÇÃO! Ainda há algum problema de acesso.<br>";
                echo '</div>';
            }
            
            echo '<hr>';
            echo '<div style="text-align: center;">';
            echo '<a href="' . $_SERVER['PHP_SELF'] . '"><button class="button">↻ Verificar Novamente</button></a>';
            echo '</div>';
            
        } else {
            // Mostrar status atual
            $tenant = Tenant::find('multiimune');
            
            if ($tenant) {
                echo '<div class="section info">';
                echo "📋 Status Atual do Tenant:<br><br>";
                echo "   ID: {$tenant->id}<br>";
                echo "   Clínica: {$tenant->clinic_name}<br>";
                echo "   Status: {$tenant->status}<br>";
                echo "   Plano: " . ($tenant->plan?->name ?? 'Nenhum') . "<br>";
                echo "   Subscription ends at: " . ($tenant->subscription_ends_at ? $tenant->subscription_ends_at->format('d/m/Y H:i') : '<span class="error">NULL ❌</span>') . "<br>";
                echo '</div>';
                
                echo '<div class="section">';
                echo '<div class="check"><span>canAccess():</span><span>' . ($tenant->canAccess() ? '<span class="success">✅ Sim</span>' : '<span class="error">❌ Não</span>') . '</span></div>';
                echo '<div class="check"><span>hasActiveSubscription():</span><span>' . ($tenant->hasActiveSubscription() ? '<span class="success">✅ Sim</span>' : '<span class="error">❌ Não</span>') . '</span></div>';
                echo '</div>';
                
                if (!$tenant->hasActiveSubscription()) {
                    echo '<div class="section warning">';
                    echo "⚠️ O tenant não possui assinatura ativa!<br>";
                    echo "   Clique no botão abaixo para ativar por 1 ano.<br>";
                    echo '</div>';
                }
            } else {
                echo '<div class="section error">❌ Tenant "multiimune" não encontrado!</div>';
            }
            
            echo '<hr>';
            echo '<form method="POST" style="text-align: center;">';
            echo '<button type="submit" name="activate" class="button">🚀 ATIVAR TENANT (1 ANO)</button>';
            echo '</form>';
        }
        ?>
        
        <hr>
        <div style="text-align: center; color: #666; font-size: 12px;">
            Script de ativação de tenant em produção | <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>
</body>
</html>
