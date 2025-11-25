<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Reformatando TODOS os artigos do Help Center...\n\n";

$artigos = [
    // === WHATSAPP ===
    [
        'slug' => 'como-configurar-whatsapp-business',
        'conteudo' => '<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">📱 Configurando WhatsApp Business</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Conecte o WhatsApp ao Imunify e comece a enviar mensagens automáticas para seus pacientes em minutos!</p>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">💡 Você sabia?</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem;">O Imunify oferece <strong>dois modos de conexão</strong>: Número Compartilhado (grátis) e Número Próprio (planos Premium).</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Modo 1: Número Compartilhado (Recomendado)</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
        <span style="font-size: 3rem; background: #10B981; color: white; width: 4rem; height: 4rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">✅</span>
        <div>
            <h3 style="margin: 0; color: #1F2937; font-size: 1.4rem;">Já vem ativo automaticamente!</h3>
            <p style="margin: 0; color: #6B7280;">Não precisa fazer nada, está pronto para usar</p>
        </div>
    </div>
    
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1rem; border-radius: 0.5rem;">
            <span style="font-size: 2rem;">1️⃣</span>
            <div>
                <strong style="color: #1F2937;">Acesse Configurações → WhatsApp</strong>
                <p style="margin: 0; color: #6B7280; font-size: 0.95rem;">Veja o status da conexão compartilhada</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1rem; border-radius: 0.5rem;">
            <span style="font-size: 2rem;">2️⃣</span>
            <div>
                <strong style="color: #1F2937;">Confira sua quota mensal</strong>
                <p style="margin: 0; color: #6B7280; font-size: 0.95rem;">Veja quantas mensagens você pode enviar</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1rem; border-radius: 0.5rem;">
            <span style="font-size: 2rem;">3️⃣</span>
            <div>
                <strong style="color: #1F2937;">Pronto! Já pode enviar notificações</strong>
                <p style="margin: 0; color: #6B7280; font-size: 0.95rem;">Sistema funciona automaticamente</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">🔧 Modo 2: Número Próprio (Premium)</h2>

<div style="background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 1rem; padding: 1.5rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 2.5rem;">👑</span>
        <h3 style="margin: 0; color: #92400E;">Disponível nos planos Premium e Enterprise</h3>
    </div>
    <p style="color: #78350F; margin: 0;">Use seu próprio número WhatsApp Business com quota ilimitada!</p>
</div>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <ol style="font-size: 1.05rem; line-height: 2; color: #1F2937; margin: 0; padding-left: 1.5rem;">
        <li style="margin-bottom: 1.5rem;">
            <strong>Acesse Configurações → WhatsApp</strong><br>
            <span style="color: #6B7280;">Clique em "Usar Meu Número"</span>
        </li>
        <li style="margin-bottom: 1.5rem;">
            <strong>Insira as credenciais fornecidas pela Imunify</strong><br>
            <span style="color: #6B7280;">Você receberá Instance ID, Token e Client Token</span>
        </li>
        <li style="margin-bottom: 1.5rem;">
            <strong>Escaneie o QR Code</strong><br>
            <span style="color: #6B7280;">Use seu WhatsApp Business no celular</span>
        </li>
        <li>
            <strong>Aguarde a conexão</strong><br>
            <span style="color: #6B7280;">Em alguns segundos estará conectado!</span>
        </li>
    </ol>
</div>

<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        O <strong>modo compartilhado</strong> é ideal para começar. Você pode migrar para número próprio a qualquer momento quando precisar de mais volume!
    </p>
</div>'
    ],

    [
        'slug' => 'dashboard-notificacoes-whatsapp',
        'conteudo' => '<div style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">📊 Dashboard de Notificações WhatsApp</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Acompanhe em tempo real todas as mensagens enviadas, status de entrega e interações dos pacientes.</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">📍 Onde Encontrar</h2>

<div style="background: #EDE9FE; border-left: 6px solid #8B5CF6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <p style="margin: 0; font-size: 1.1rem; color: #5B21B6;">
        <strong>Menu Principal → Notificações</strong><br>
        <span style="color: #6B21A8;">Ou acesse <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; color: #1F2937;">/dashboard/notificacoes</code></span>
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 O que Você Vê no Dashboard</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📤</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Mensagens Enviadas</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Total de notificações disparadas pelo sistema</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">✅</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Entregues</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Mensagens que chegaram ao destinatário</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👁️</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Lidas</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Pacientes que abriram e leram</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">❌</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Falhas</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Erros de envio que precisam atenção</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">🔍 Filtros Disponíveis</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #8B5CF6;">
            <strong style="color: #1F2937; font-size: 1.1rem;">📅 Por Data</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0;">Filtre por dia, semana ou mês específico</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #8B5CF6;">
            <strong style="color: #1F2937; font-size: 1.1rem;">📊 Por Status</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0;">Veja apenas enviadas, entregues, lidas ou com erro</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #8B5CF6;">
            <strong style="color: #1F2937; font-size: 1.1rem;">👤 Por Paciente</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0;">Busque pelo nome do paciente específico</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #8B5CF6;">
            <strong style="color: #1F2937; font-size: 1.1rem;">🏷️ Por Tipo</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0;">Lembretes, confirmações, avisos, etc.</p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">⚙️ Ações Disponíveis</h2>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #DBEAFE; border: 2px solid #3B82F6; border-radius: 0.75rem; padding: 1.5rem;">
        <h3 style="color: #1E40AF; margin: 0 0 1rem 0; font-size: 1.3rem;">🔄 Reenviar Mensagem</h3>
        <p style="color: #1E3A8A; margin: 0;">Clique no botão "Reenviar" em mensagens que falharam para tentar novamente</p>
    </div>
    
    <div style="background: #FEE2E2; border: 2px solid #EF4444; border-radius: 0.75rem; padding: 1.5rem;">
        <h3 style="color: #991B1B; margin: 0 0 1rem 0; font-size: 1.3rem;">📋 Ver Detalhes</h3>
        <p style="color: #7F1D1D; margin: 0;">Clique em qualquer linha para ver conteúdo completo da mensagem e histórico</p>
    </div>
</div>

<div style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Monitore diariamente as <strong>mensagens com erro</strong>. Geralmente são números desatualizados que precisam ser corrigidos no cadastro do paciente!
    </p>
</div>'
    ],

    [
        'slug' => 'reenviar-mensagens-falhadas',
        'conteudo' => '<div style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🔄 Como Reenviar Mensagens que Falharam</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Aprenda a identificar e resolver problemas de envio de mensagens WhatsApp de forma rápida e eficiente.</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EF4444; padding-bottom: 0.5rem; margin-top: 3rem;">❓ Por que Mensagens Falham?</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
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
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Acesse o Dashboard de Notificações</h4>
                <p style="margin: 0; color: #4B5563;">Menu Principal → Notificações</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Filtre por "Com Erro"</h4>
                <p style="margin: 0; color: #4B5563;">Use o filtro de status para ver apenas mensagens que falharam</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Clique em "Ver Detalhes"</h4>
                <p style="margin: 0; color: #4B5563;">Veja o motivo exato da falha</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem;">
            <span style="font-size: 2rem; background: #EF4444; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Corrija o Problema</h4>
                <p style="margin: 0; color: #4B5563;">Atualize o telefone do paciente se necessário</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem;">
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
</div>'
    ],
];

echo "Total de artigos a reformatar: " . count($artigos) . "\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($artigos) {
        foreach ($artigos as $dados) {
            $artigo = HelpArticle::where('slug', $dados['slug'])->first();
            
            if ($artigo) {
                $artigo->update(['conteudo_html' => $dados['conteudo']]);
                echo "   ✅ {$artigo->titulo}\n";
            }
        }
    });
    
    echo "\n";
}

echo "✅ Concluído! Artigos reformatados em todos os tenants.\n";
