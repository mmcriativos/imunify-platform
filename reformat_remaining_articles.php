<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Reformatando artigos restantes...\n\n";

$artigos = [
    // === VACINAS ===
    [
        'slug' => 'adicionar-nova-vacina',
        'conteudo' => '<div style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">💉 Como Adicionar uma Nova Vacina ao Sistema</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Cadastre novas vacinas em segundos e comece a agendar imediatamente!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #F59E0B; padding-bottom: 0.5rem; margin-top: 3rem;">🚀 Passo a Passo Rápido</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <span style="font-size: 2rem; background: #F59E0B; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Acesse o Menu de Vacinas</h4>
                <p style="margin: 0; color: #4B5563;">Menu Principal → Vacinas → Nova Vacina</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <span style="font-size: 2rem; background: #F59E0B; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Preencha os Dados Básicos</h4>
                <ul style="margin: 0.5rem 0 0 1rem; color: #4B5563; line-height: 1.8;">
                    <li>Nome da vacina (ex: Tríplice Viral)</li>
                    <li>Fabricante</li>
                    <li>Lote atual</li>
                    <li>Validade</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <span style="font-size: 2rem; background: #F59E0B; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Configure Doses e Intervalo</h4>
                <p style="margin: 0; color: #4B5563;">Informe quantas doses são necessárias e o intervalo mínimo entre elas</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <span style="font-size: 2rem; background: #F59E0B; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Defina Idade Recomendada</h4>
                <p style="margin: 0; color: #4B5563;">Faixa etária para aplicação (ex: 12 a 23 meses)</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Salvar e Pronto!</h4>
                <p style="margin: 0; color: #4B5563;">A vacina já estará disponível para agendamentos</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #F59E0B; padding-bottom: 0.5rem; margin-top: 3rem;">📋 Campos Obrigatórios vs Opcionais</h2>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #FEE2E2; border: 2px solid #EF4444; border-radius: 0.75rem; padding: 1.5rem;">
        <h3 style="color: #991B1B; margin: 0 0 1rem 0; font-size: 1.3rem;">✱ Obrigatórios</h3>
        <ul style="color: #7F1D1D; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Nome da vacina</li>
            <li>Número de doses</li>
            <li>Faixa etária mínima</li>
        </ul>
    </div>
    
    <div style="background: #D1FAE5; border: 2px solid #10B981; border-radius: 0.75rem; padding: 1.5rem;">
        <h3 style="color: #065F46; margin: 0 0 1rem 0; font-size: 1.3rem;">○ Opcionais</h3>
        <ul style="color: #064E3B; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Fabricante</li>
            <li>Lote</li>
            <li>Validade</li>
            <li>Observações</li>
        </ul>
    </div>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">💡 Dica: Cadastro por Lote</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Se você trabalha com <strong>controle de lote rigoroso</strong>, recomendamos cadastrar a mesma vacina com nomes diferentes para cada lote (ex: "Influenza - Lote 2024A", "Influenza - Lote 2024B"). Isso facilita rastreabilidade!
    </p>
</div>

<div style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Cadastro Rápido</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Em média, leva <strong>menos de 1 minuto</strong> para adicionar uma nova vacina. Quanto mais detalhes você incluir, mais preciso será o controle de estoque!
    </p>
</div>'
    ],

    [
        'slug' => 'agendar-atendimento',
        'conteudo' => '<div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">📅 Como Agendar um Atendimento de Vacinação</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Crie agendamentos em segundos e receba confirmações automáticas via WhatsApp!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #3B82F6; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Métodos de Agendamento</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
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

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🔄</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Reagendar</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Mude data/hora sem criar novo agendamento</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">❌</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Cancelar</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Cancele e notifique paciente automaticamente</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">✅</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Confirmar Presença</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Marque quando paciente confirmar</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📋</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Ver Histórico</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Todas as doses anteriores do paciente</p>
    </div>
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
</div>'
    ],

    [
        'slug' => 'registrar-atendimento-realizado',
        'conteudo' => '<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">✅ Como Registrar um Atendimento Realizado</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Documente aplicações de vacinas de forma rápida e completa para manter histórico atualizado!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Quando Registrar?</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #D1FAE5; border-left: 6px solid #10B981; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">📅</span>
            <strong style="color: #065F46; font-size: 1.1rem;">Após Atendimento Agendado</strong>
        </div>
        <p style="color: #064E3B; margin: 0; font-size: 0.95rem;">Paciente veio no horário marcado</p>
    </div>
    
    <div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">🚶</span>
            <strong style="color: #1E40AF; font-size: 1.1rem;">Walk-in (Sem Agendamento)</strong>
        </div>
        <p style="color: #1E3A8A; margin: 0; font-size: 0.95rem;">Paciente chegou sem marcar</p>
    </div>
    
    <div style="background: #FEF3C7; border-left: 6px solid #F59E0B; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <span style="font-size: 1.5rem;">🏥</span>
            <strong style="color: #92400E; font-size: 1.1rem;">Campanha Externa</strong>
        </div>
        <p style="color: #78350F; margin: 0; font-size: 0.95rem;">Aplicação em empresa, escola, etc.</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">📝 Passo a Passo Completo</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Localize o Agendamento ou Paciente</h4>
                <p style="margin: 0; color: #4B5563;"><strong>Com agendamento:</strong> Menu → Agendamentos → Clique em "Registrar"<br>
                <strong>Sem agendamento:</strong> Menu → Atendimentos → Novo Atendimento</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Confirme os Dados da Vacina</h4>
                <ul style="margin: 0.5rem 0 0 1rem; color: #4B5563; line-height: 1.8;">
                    <li>Nome da vacina</li>
                    <li>Dose aplicada (1ª, 2ª, 3ª, reforço)</li>
                    <li>Lote usado</li>
                    <li>Validade</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Registre Detalhes da Aplicação</h4>
                <ul style="margin: 0.5rem 0 0 1rem; color: #4B5563; line-height: 1.8;">
                    <li>Via de administração (IM, SC, oral)</li>
                    <li>Local (braço direito, coxa esquerda, etc.)</li>
                    <li>Profissional que aplicou</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Adicione Observações (Se Necessário)</h4>
                <p style="margin: 0; color: #4B5563;">Reações imediatas, intercorrências, etc.</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: #D1FAE5; padding: 1.5rem; border-radius: 0.75rem; border: 2px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #065F46; font-size: 1.2rem;">Salvar Atendimento</h4>
                <p style="margin: 0; color: #064E3B;">Sistema atualiza automaticamente: estoque, histórico do paciente e caderneta digital!</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">🎁 O que Acontece Automaticamente</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📉</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Estoque Atualizado</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Dose descontada do lote</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📖</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Histórico Completo</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Registro no prontuário</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📱</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Caderneta Digital</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Disponível para paciente</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🔔</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Próxima Dose</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Sugestão de agendamento</p>
    </div>
</div>

<div style="background: #FEF3C7; border: 3px solid #F59E0B; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 3rem;">⚠️</span>
        <h3 style="color: #92400E; margin: 0;">Importante: Rastreabilidade</h3>
    </div>
    <p style="color: #78350F; font-size: 1.05rem; margin: 0; line-height: 1.6;">
        Sempre registre o <strong>lote e validade</strong> da vacina aplicada. Isso é essencial para rastreamento em caso de recall ou eventos adversos!
    </p>
</div>

<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Se o paciente precisa de <strong>doses adicionais</strong>, clique em "Agendar Próxima Dose" após registrar. O sistema calcula automaticamente a data ideal baseada no intervalo da vacina!
    </p>
</div>'
    ],
];

foreach ($artigos as $dados) {
    $tenants = Tenant::all();
    
    foreach ($tenants as $tenant) {
        $tenant->run(function () use ($dados) {
            $artigo = HelpArticle::where('slug', $dados['slug'])->first();
            
            if ($artigo) {
                $artigo->update(['conteudo_html' => $dados['conteudo']]);
                echo "✅ {$artigo->titulo}\n";
            }
        });
    }
}

echo "\n✅ Artigos de Vacinas reformatados!\n";
