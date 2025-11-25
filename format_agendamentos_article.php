<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Reformatando: Como Criar e Gerenciar Agendamentos\n\n";

$novoConteudo = '<div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">📅 Como Criar e Gerenciar Agendamentos</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Aprenda a criar, editar e organizar agendamentos de vacinação de forma rápida e eficiente!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Métodos de Agendamento</h2>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: linear-gradient(to bottom, #DBEAFE, #BFDBFE); border: 2px solid #3B82F6; border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🖱️</div>
        <h3 style="color: #1E40AF; margin: 0 0 1rem 0; font-size: 1.4rem;">Manual</h3>
        <p style="color: #1E3A8A; margin: 0 0 1rem 0;">Você cria o agendamento pela interface</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem;">
            <strong style="color: #1F2937;">Menu → Agendamentos → Novo</strong>
        </div>
    </div>
    
    <div style="background: linear-gradient(to bottom, #D1FAE5, #A7F3D0); border: 2px solid #10B981; border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
        <h3 style="color: #065F46; margin: 0 0 1rem 0; font-size: 1.4rem;">Via WhatsApp</h3>
        <p style="color: #064E3B; margin: 0 0 1rem 0;">Paciente solicita pelo chat</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem;">
            <strong style="color: #1F2937;">Chat → Converter em Agendamento</strong>
        </div>
    </div>
    
    <div style="background: linear-gradient(to bottom, #FEF3C7, #FDE68A); border: 2px solid #F59E0B; border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔄</div>
        <h3 style="color: #92400E; margin: 0 0 1rem 0; font-size: 1.4rem;">Recorrente</h3>
        <p style="color: #78350F; margin: 0 0 1rem 0;">Para doses subsequentes</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem;">
            <strong style="color: #1F2937;">Atendimento → Agendar Próxima Dose</strong>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">📝 Criando Agendamento Manual</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Selecione o Paciente</h4>
                <p style="margin: 0; color: #4B5563;">Busque por nome, CPF ou telefone. Se não estiver cadastrado, crie rapidamente.</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Escolha a Vacina</h4>
                <p style="margin: 0; color: #4B5563;">Sistema mostra apenas vacinas compatíveis com a idade do paciente.</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Defina Data e Hora</h4>
                <p style="margin: 0; color: #4B5563;">Calendário inteligente mostra apenas horários disponíveis.</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #3B82F6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Adicione Observações (Opcional)</h4>
                <p style="margin: 0; color: #4B5563;">Alergias, condições especiais, etc.</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: #D1FAE5; padding: 1.5rem; border-radius: 0.75rem; border: 2px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #065F46; font-size: 1.2rem;">Confirme!</h4>
                <p style="margin: 0; color: #064E3B;"><strong>Paciente recebe WhatsApp automático</strong> confirmando data e hora.</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">⚡ Ações Rápidas Disponíveis</h2>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">🔄</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Reagendar</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem; text-align: center;">Mude data/hora sem criar novo agendamento</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">❌</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Cancelar</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem; text-align: center;">Cancele e notifique paciente automaticamente</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">✅</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Confirmar Presença</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem; text-align: center;">Marque quando paciente confirmar</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">📋</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Ver Histórico</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem; text-align: center;">Todas as doses anteriores do paciente</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">📊 Visualizações Disponíveis</h2>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #EDE9FE; border-left: 6px solid #8B5CF6; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📅</span>
            <strong style="color: #5B21B6; font-size: 1.1rem;">Calendário</strong>
        </div>
        <p style="color: #6B21A8; margin: 0; font-size: 0.95rem;">Visão mensal com cores por status</p>
    </div>
    
    <div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📋</span>
            <strong style="color: #1E40AF; font-size: 1.1rem;">Lista</strong>
        </div>
        <p style="color: #1E3A8A; margin: 0; font-size: 0.95rem;">Tabela com filtros avançados</p>
    </div>
    
    <div style="background: #D1FAE5; border-left: 6px solid #10B981; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📊</span>
            <strong style="color: #065F46; font-size: 1.1rem;">Timeline</strong>
        </div>
        <p style="color: #064E3B; margin: 0; font-size: 0.95rem;">Linha do tempo do dia</p>
    </div>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">💡 Dica: Filtros Inteligentes</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Use os filtros para visualizar apenas: <strong>Hoje</strong>, <strong>Esta Semana</strong>, <strong>Pendentes de Confirmação</strong>, <strong>Atrasados</strong>, etc. Economize tempo!
    </p>
</div>

<div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">🤖</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Automação Inteligente</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Após criar o agendamento, o sistema <strong>envia automaticamente</strong>:<br>
        ✅ Confirmação imediata<br>
        ✅ Lembrete 7 dias antes<br>
        ✅ Lembrete 1 dia antes<br>
        ✅ Lembrete no dia do atendimento
    </p>
</div>';

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($novoConteudo) {
        $artigo = HelpArticle::where('slug', 'criar-gerenciar-agendamentos')->first();
        
        if ($artigo) {
            $artigo->update(['conteudo_html' => $novoConteudo]);
            echo "   ✅ Formatação moderna aplicada\n";
        }
    });
}

echo "\n✅ Artigo reformatado com grids de 3 e 4 colunas!\n";
