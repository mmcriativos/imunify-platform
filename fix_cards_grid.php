<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Ajustando grid dos cards para 3 colunas...\n\n";

// Vou ajustar apenas o artigo de lembretes que tem esse problema
$novoConteudo = '<div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🤖 Como Funciona o Lembrete Automático de Vacinação</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Sistema inteligente que monitora e notifica pacientes automaticamente sobre vacinas pendentes via WhatsApp!</p>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">✨ 100% Automático - Zero Trabalho Manual</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        O Imunify <strong>roda sozinho todos os dias</strong> e envia mensagens personalizadas para cada paciente no momento certo. Você não precisa fazer nada!
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 O que o Sistema Detecta Automaticamente</h2>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #FEE2E2; border-left: 6px solid #EF4444; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">🚨</span>
            <strong style="color: #991B1B; font-size: 1.2rem;">Vacinas Atrasadas</strong>
        </div>
        <p style="color: #7F1D1D; margin: 0; font-size: 0.95rem;">Doses que já passaram do prazo recomendado</p>
    </div>
    
    <div style="background: #FEF3C7; border-left: 6px solid #F59E0B; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">⏰</span>
            <strong style="color: #92400E; font-size: 1.2rem;">Doses Próximas</strong>
        </div>
        <p style="color: #78350F; margin: 0; font-size: 0.95rem;">Faltam poucos dias para o período ideal</p>
    </div>
    
    <div style="background: #D1FAE5; border-left: 6px solid #10B981; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">⭐</span>
            <strong style="color: #065F46; font-size: 1.2rem;">Campanhas Ativas</strong>
        </div>
        <p style="color: #064E3B; margin: 0; font-size: 0.95rem;">Vacinas dentro de campanhas sazonais</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">📅 Horários de Execução</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center; border: 2px solid #3B82F6;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">🌅</div>
            <strong style="color: #1F2937; font-size: 1.2rem; display: block; margin-bottom: 0.5rem;">9h da Manhã</strong>
            <p style="color: #6B7280; margin: 0; font-size: 0.9rem;">Segunda a Sexta</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center; border: 2px solid #10B981;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">🌆</div>
            <strong style="color: #1F2937; font-size: 1.2rem; display: block; margin-bottom: 0.5rem;">18h da Tarde</strong>
            <p style="color: #6B7280; margin: 0; font-size: 0.9rem;">Segunda a Sexta</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center; border: 2px solid #F59E0B;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">📅</div>
            <strong style="color: #1F2937; font-size: 1.2rem; display: block; margin-bottom: 0.5rem;">8h e 10h</strong>
            <p style="color: #6B7280; margin: 0; font-size: 0.9rem;">Apenas Segundas</p>
        </div>
    </div>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">💡 Por que múltiplos horários?</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Isso garante que <strong>nenhum paciente seja esquecido</strong> e que as mensagens sejam enviadas em horários de maior engajamento!
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">🔄 Como Funciona o Processo</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #3B82F6;">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Análise Completa do Banco</h4>
                <p style="margin: 0; color: #4B5563;">Sistema varre todos os pacientes cadastrados e suas cadernetas de vacinação</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #3B82F6;">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Identificação de Pendências</h4>
                <p style="margin: 0; color: #4B5563;">Compara idade do paciente, doses já tomadas e calendário vacinal recomendado</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #3B82F6;">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Verificação de Campanhas</h4>
                <p style="margin: 0; color: #4B5563;">Checa se existe campanha ativa para a vacina e se o paciente está no público-alvo</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #3B82F6;">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Personalização da Mensagem</h4>
                <p style="margin: 0; color: #4B5563;">Cria mensagem específica com nome do paciente, nome da vacina e informações da campanha (se houver)</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: #D1FAE5; padding: 1.5rem; border-radius: 0.75rem; border: 2px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #065F46; font-size: 1.2rem;">Envio via WhatsApp</h4>
                <p style="margin: 0; color: #064E3B;">Mensagem enviada automaticamente para o telefone cadastrado do paciente</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">📱 Exemplo de Mensagem Enviada</h2>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin: 2rem 0;">
    <div>
        <h3 style="color: #1F2937; margin: 0 0 1rem 0;">🔴 Sem Campanha Ativa</h3>
        <div style="background: #F3F4F6; border: 2px solid #D1D5DB; border-radius: 0.75rem; padding: 1.5rem;">
            <p style="color: #1F2937; margin: 0; font-family: monospace; line-height: 1.8; font-size: 0.95rem;">
                Olá, Maria! 👋<br><br>
                Identificamos que está na hora de aplicar a vacina <strong>Hepatite B (2ª dose)</strong>.<br><br>
                Agende seu atendimento conosco!<br><br>
                📞 Entre em contato para marcar.
            </p>
        </div>
    </div>
    
    <div>
        <h3 style="color: #1F2937; margin: 0 0 1rem 0;">🟢 Com Campanha Ativa</h3>
        <div style="background: linear-gradient(to bottom right, #DBEAFE, #E0E7FF); border: 2px solid #3B82F6; border-radius: 0.75rem; padding: 1.5rem;">
            <p style="color: #1F2937; margin: 0; font-family: monospace; line-height: 1.8; font-size: 0.95rem;">
                Olá, João! 👋<br><br>
                🎯 <strong style="color: #DC2626;">CAMPANHA INFLUENZA 2025</strong><br>
                🏅 Prioridade: <strong style="color: #F59E0B;">ALTA</strong><br><br>
                Você está no público-alvo! Vacina disponível agora.<br><br>
                📞 Agende já seu horário!
            </p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">⚙️ O que NÃO É Enviado</h2>

<div style="background: #FEE2E2; border: 3px solid #EF4444; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 3rem;">🚫</span>
        <h3 style="color: #991B1B; margin: 0;">Filtros de Proteção Anti-Spam</h3>
    </div>
    <ul style="color: #7F1D1D; font-size: 1.05rem; line-height: 2; margin: 0; padding-left: 1.5rem;">
        <li><strong>Pacientes sem WhatsApp cadastrado</strong></li>
        <li><strong>Vacinas já aplicadas</strong> (sistema verifica histórico)</li>
        <li><strong>Fora da faixa etária</strong> recomendada</li>
        <li><strong>Intervalo mínimo não cumprido</strong> entre doses</li>
        <li><strong>Mesmo paciente notificado recentemente</strong> (evita spam)</li>
    </ul>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">📊 Onde Acompanhar os Envios</h2>

<div style="background: #EDE9FE; border-left: 6px solid #8B5CF6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #5B21B6; margin-top: 0;">Dashboard de Notificações</h3>
    <p style="color: #6B21A8; margin: 0 0 1rem 0; font-size: 1.05rem;">
        <strong>Menu → Notificações</strong>
    </p>
    <p style="color: #6B21A8; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Veja todas as mensagens enviadas, status de entrega, leituras e possíveis erros. Você pode reenviar mensagens que falharam diretamente por lá!
    </p>
</div>

<div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        O sistema respeita automaticamente a <strong>quota mensal do WhatsApp</strong>. Se você usar número compartilhado (plano básico), o limite é de 1000 mensagens/mês. Faça upgrade para número próprio e tenha <strong>envios ilimitados</strong>!
    </p>
</div>';

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($novoConteudo) {
        $artigo = HelpArticle::where('slug', 'lembrete-automatico-vacinacao')->first();
        
        if ($artigo) {
            $artigo->update(['conteudo_html' => $novoConteudo]);
            echo "   ✅ Cards ajustados para 3 colunas fixas\n";
        }
    });
}

echo "\n✅ Layout dos cards corrigido! Agora ficam os 3 na mesma linha.\n";
