<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Ajustando grid do artigo: Reenviar Mensagens Falhadas\n\n";

$novoConteudo = '<div style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🔄 Como Reenviar Mensagens que Falharam</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Aprenda a identificar e resolver problemas de envio de mensagens WhatsApp de forma rápida e eficiente.</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EF4444; padding-bottom: 0.5rem; margin-top: 3rem;">❓ Por que Mensagens Falham?</h2>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #FEE2E2; border-left: 6px solid #DC2626; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📱</span>
            <strong style="color: #991B1B; font-size: 1.1rem;">Número Inválido</strong>
        </div>
        <p style="color: #7F1D1D; margin: 0; font-size: 0.95rem;">Telefone digitado errado ou desatualizado</p>
    </div>
    
    <div style="background: #FEF3C7; border-left: 6px solid #F59E0B; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">🚫</span>
            <strong style="color: #92400E; font-size: 1.1rem;">Número Bloqueado</strong>
        </div>
        <p style="color: #78350F; margin: 0; font-size: 0.95rem;">Paciente bloqueou o número do sistema</p>
    </div>
    
    <div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📡</span>
            <strong style="color: #1E40AF; font-size: 1.1rem;">Erro Temporário</strong>
        </div>
        <p style="color: #1E3A8A; margin: 0; font-size: 0.95rem;">Problema na conexão com WhatsApp</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EF4444; padding-bottom: 0.5rem; margin-top: 3rem;">🔧 Como Reenviar (Passo a Passo)</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #EF4444;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Acesse o Dashboard de Notificações</h4>
                <p style="margin: 0; color: #4B5563;">Menu Principal → Notificações</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #EF4444;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Filtre por "Com Erro"</h4>
                <p style="margin: 0; color: #4B5563;">Use o filtro de status para ver apenas mensagens que falharam</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #EF4444;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Clique em "Ver Detalhes"</h4>
                <p style="margin: 0; color: #4B5563;">Veja o motivo exato da falha</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #EF4444;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Corrija o Problema</h4>
                <p style="margin: 0; color: #4B5563;">Atualize o telefone do paciente se necessário</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #EF4444;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">5</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Clique em "Reenviar"</h4>
                <p style="margin: 0; color: #4B5563;">Sistema tentará enviar novamente automaticamente</p>
            </div>
        </div>
    </div>
</div>

<div style="background: #FEF3C7; border: 3px solid #F59E0B; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 3rem;">⚠️</span>
        <h3 style="color: #92400E; margin: 0;">Atenção Importante</h3>
    </div>
    <p style="color: #78350F; font-size: 1.05rem; margin: 0; line-height: 1.6;">
        Se o número estiver <strong>incorreto no cadastro</strong>, o reenvio falhará novamente. Sempre <strong>atualize o cadastro do paciente primeiro</strong> antes de tentar reenviar!
    </p>
</div>

<div style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Configure <strong>alertas automáticos</strong> para receber notificação quando houver muitas falhas. Isso evita que problemas passem despercebidos!
    </p>
</div>';

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($novoConteudo) {
        $artigo = HelpArticle::where('slug', 'reenviar-mensagens-falhadas')->first();
        
        if ($artigo) {
            $artigo->update(['conteudo_html' => $novoConteudo]);
            echo "   ✅ Grid de 3 colunas aplicado\n";
        }
    });
}

echo "\n✅ Artigo corrigido!\n";
