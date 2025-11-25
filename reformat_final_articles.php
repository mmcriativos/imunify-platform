<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Reformatando últimos artigos (Pacientes + Sistema)...\n\n";

$artigos = [
    // === PACIENTES ===
    [
        'slug' => 'cadastrar-novo-paciente',
        'conteudo' => '<div style="background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">👤 Como Cadastrar um Novo Paciente</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Crie cadastros completos em menos de 2 minutos e tenha todo o histórico em um só lugar!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EC4899; padding-bottom: 0.5rem; margin-top: 3rem;">🚀 Acesso Rápido</h2>

<div style="background: #FCE7F3; border-left: 6px solid #EC4899; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <p style="margin: 0; font-size: 1.1rem; color: #831843;">
        <strong>Menu Principal → Pacientes → Novo Paciente</strong><br>
        <span style="color: #9F1239;">Ou use o atalho <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; color: #1F2937;">Ctrl + N</code> quando estiver na lista de pacientes</span>
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EC4899; padding-bottom: 0.5rem; margin-top: 3rem;">📝 Dados Necessários</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <h3 style="color: #1F2937; margin: 0 0 1.5rem 0; font-size: 1.4rem;">✱ Informações Obrigatórias</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #EF4444;">
            <strong style="color: #1F2937;">Nome Completo</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Conforme documento oficial</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #EF4444;">
            <strong style="color: #1F2937;">Data de Nascimento</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Para cálculo de idade e vacinas</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #EF4444;">
            <strong style="color: #1F2937;">CPF</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Identificação única no sistema</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #EF4444;">
            <strong style="color: #1F2937;">Telefone/WhatsApp</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Para notificações automáticas</p>
        </div>
    </div>
</div>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <h3 style="color: #1F2937; margin: 0 0 1.5rem 0; font-size: 1.4rem;">○ Informações Opcionais (Recomendadas)</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #10B981;">
            <strong style="color: #1F2937;">E-mail</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Envio de comprovantes</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #10B981;">
            <strong style="color: #1F2937;">Endereço Completo</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">CEP, rua, número, etc.</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #10B981;">
            <strong style="color: #1F2937;">Nome da Mãe</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Obrigatório para alguns relatórios</p>
        </div>
        
        <div style="background: white; padding: 1.25rem; border-radius: 0.5rem; border-left: 4px solid #10B981;">
            <strong style="color: #1F2937;">Responsável Legal</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Se for menor de idade</p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EC4899; padding-bottom: 0.5rem; margin-top: 3rem;">🔍 Recursos Inteligentes</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #DBEAFE; border: 2px solid #3B82F6; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">🔎</div>
        <h3 style="color: #1E40AF; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Busca por CPF</h3>
        <p style="color: #1E3A8A; margin: 0; font-size: 0.95rem; text-align: center;">Sistema avisa se paciente já existe</p>
    </div>
    
    <div style="background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">📍</div>
        <h3 style="color: #92400E; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Busca por CEP</h3>
        <p style="color: #78350F; margin: 0; font-size: 0.95rem; text-align: center;">Preenche endereço automaticamente</p>
    </div>
    
    <div style="background: #D1FAE5; border: 2px solid #10B981; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">✅</div>
        <h3 style="color: #065F46; margin: 0.5rem 0; font-size: 1.2rem; text-align: center;">Validação de Dados</h3>
        <p style="color: #064E3B; margin: 0; font-size: 0.95rem; text-align: center;">CPF, telefone e e-mail verificados</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #EC4899; padding-bottom: 0.5rem; margin-top: 3rem;">👶 Cadastrando Menores de Idade</h2>

<div style="background: #FCE7F3; border: 3px solid #EC4899; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: start; gap: 1rem;">
        <span style="font-size: 3rem; flex-shrink: 0;">👨‍👩‍👧</span>
        <div>
            <h3 style="color: #831843; margin: 0 0 1rem 0;">Dados Adicionais Necessários</h3>
            <ul style="color: #9F1239; margin: 0; padding-left: 1.5rem; line-height: 2;">
                <li><strong>Nome do responsável legal</strong></li>
                <li><strong>CPF do responsável</strong></li>
                <li><strong>Grau de parentesco</strong> (pai, mãe, tutor, etc.)</li>
                <li><strong>Telefone do responsável</strong> (pode ser diferente)</li>
            </ul>
        </div>
    </div>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">💡 Dica: Campos Personalizados</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Precisa armazenar <strong>informações adicionais</strong> como alergias, condições de saúde ou observações especiais? Use a seção "Observações Médicas" no final do formulário!
    </p>
</div>

<div style="background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Cadastro Ultra Rápido</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Após salvar, você pode <strong>agendar imediatamente</strong> clicando em "Agendar Atendimento". Não precisa voltar ao menu!
    </p>
</div>'
    ],

    [
        'slug' => 'buscar-editar-paciente',
        'conteudo' => '<div style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🔍 Como Buscar e Editar Dados de Pacientes</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Encontre qualquer paciente em segundos e mantenha cadastros sempre atualizados!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">🔎 Formas de Buscar</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: linear-gradient(to bottom, #EDE9FE, #DDD6FE); border: 2px solid #8B5CF6; border-radius: 0.75rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">👤</div>
        <h3 style="color: #5B21B6; margin: 0 0 1rem 0; font-size: 1.3rem;">Por Nome</h3>
        <p style="color: #6B21A8; margin: 0;">Digite qualquer parte do nome</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; margin-top: 1rem;">
            <code style="color: #1F2937; font-size: 0.9rem;">maria silva</code>
        </div>
    </div>
    
    <div style="background: linear-gradient(to bottom, #DBEAFE, #BFDBFE); border: 2px solid #3B82F6; border-radius: 0.75rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🆔</div>
        <h3 style="color: #1E40AF; margin: 0 0 1rem 0; font-size: 1.3rem;">Por CPF</h3>
        <p style="color: #1E3A8A; margin: 0;">Busca exata e rápida</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; margin-top: 1rem;">
            <code style="color: #1F2937; font-size: 0.9rem;">123.456.789-00</code>
        </div>
    </div>
    
    <div style="background: linear-gradient(to bottom, #D1FAE5, #A7F3D0); border: 2px solid #10B981; border-radius: 0.75rem; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
        <h3 style="color: #065F46; margin: 0 0 1rem 0; font-size: 1.3rem;">Por Telefone</h3>
        <p style="color: #064E3B; margin: 0;">Encontre pelo WhatsApp</p>
        <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; margin-top: 1rem;">
            <code style="color: #1F2937; font-size: 0.9rem;">(11) 98765-4321</code>
        </div>
    </div>
</div>

<div style="background: #FEF3C7; border-left: 6px solid #F59E0B; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #92400E; margin-top: 0;">💡 Busca Inteligente</h3>
    <p style="color: #78350F; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Não precisa digitar o nome completo! O sistema busca por <strong>qualquer parte</strong> do nome. Experimente buscar apenas "silva" ou "josé"!
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">✏️ Como Editar Cadastro</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #8B5CF6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Localize o Paciente</h4>
                <p style="margin: 0; color: #4B5563;">Use a busca para encontrar o cadastro desejado</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #8B5CF6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Clique no Nome do Paciente</h4>
                <p style="margin: 0; color: #4B5563;">Abrirá a ficha completa com histórico</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #8B5CF6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Clique em "Editar"</h4>
                <p style="margin: 0; color: #4B5563;">Botão no canto superior direito da ficha</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <span style="font-size: 2rem; background: #8B5CF6; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Altere os Dados Necessários</h4>
                <p style="margin: 0; color: #4B5563;">Todos os campos são editáveis</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: #EDE9FE; padding: 1.5rem; border-radius: 0.75rem; border: 2px solid #8B5CF6;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div>
                <h4 style="margin: 0 0 0.5rem 0; color: #5B21B6; font-size: 1.2rem;">Salvar Alterações</h4>
                <p style="margin: 0; color: #6B21A8;">Sistema registra automaticamente quem fez a alteração e quando</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #8B5CF6; padding-bottom: 0.5rem; margin-top: 3rem;">🚀 Atalhos Úteis</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">📅</span>
            <strong style="color: #1F2937; font-size: 1.1rem;">Agendar Direto</strong>
        </div>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Botão "Agendar" na ficha do paciente</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">📖</span>
            <strong style="color: #1F2937; font-size: 1.1rem;">Ver Histórico</strong>
        </div>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Todas as vacinas aplicadas aparecem na ficha</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">📱</span>
            <strong style="color: #1F2937; font-size: 1.1rem;">Enviar Mensagem</strong>
        </div>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">WhatsApp direto da ficha do paciente</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="font-size: 2rem;">📄</span>
            <strong style="color: #1F2937; font-size: 1.1rem;">Imprimir Caderneta</strong>
        </div>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Gere PDF da caderneta de vacinação</p>
    </div>
</div>

<div style="background: #FEE2E2; border: 3px solid #EF4444; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 3rem;">⚠️</span>
        <h3 style="color: #991B1B; margin: 0;">Atenção: Dados Sensíveis</h3>
    </div>
    <p style="color: #7F1D1D; font-size: 1.05rem; margin: 0; line-height: 1.6;">
        Alterações em dados de pacientes são <strong>registradas no log do sistema</strong> para auditoria. Sempre confira os dados antes de salvar!
    </p>
</div>

<div style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Mantenha especialmente <strong>telefones e e-mails atualizados</strong>! Isso garante que as notificações automáticas sempre cheguem ao paciente.
    </p>
</div>'
    ],

    // === SISTEMA ===
    [
        'slug' => 'visao-geral-sistema',
        'conteudo' => '<div style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🏥 Visão Geral do Sistema Imunify</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Conheça todos os módulos e funcionalidades da plataforma completa de gestão de clínicas de vacinação!</p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #6366F1; padding-bottom: 0.5rem; margin-top: 3rem;">📋 Módulos Principais</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: linear-gradient(to bottom, #DBEAFE, #BFDBFE); border: 2px solid #3B82F6; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">👥</div>
        <h3 style="color: #1E40AF; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">Gestão de Pacientes</h3>
        <ul style="color: #1E3A8A; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Cadastro completo</li>
            <li>Histórico de vacinação</li>
            <li>Caderneta digital</li>
            <li>Busca inteligente</li>
        </ul>
    </div>
    
    <div style="background: linear-gradient(to bottom, #FEF3C7, #FDE68A); border: 2px solid #F59E0B; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">💉</div>
        <h3 style="color: #92400E; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">Controle de Vacinas</h3>
        <ul style="color: #78350F; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Catálogo completo</li>
            <li>Gestão de lotes</li>
            <li>Controle de validade</li>
            <li>Rastreabilidade</li>
        </ul>
    </div>
    
    <div style="background: linear-gradient(to bottom, #D1FAE5, #A7F3D0); border: 2px solid #10B981; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">📅</div>
        <h3 style="color: #065F46; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">Agendamentos</h3>
        <ul style="color: #064E3B; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Calendário inteligente</li>
            <li>Confirmações automáticas</li>
            <li>Lembretes via WhatsApp</li>
            <li>Gestão de horários</li>
        </ul>
    </div>
    
    <div style="background: linear-gradient(to bottom, #FCE7F3, #FBCFE8); border: 2px solid #EC4899; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">📱</div>
        <h3 style="color: #831843; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">WhatsApp Business</h3>
        <ul style="color: #9F1239; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Mensagens automáticas</li>
            <li>Dashboard de envios</li>
            <li>Templates personalizados</li>
            <li>Controle de quota</li>
        </ul>
    </div>
    
    <div style="background: linear-gradient(to bottom, #EDE9FE, #DDD6FE); border: 2px solid #8B5CF6; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">⭐</div>
        <h3 style="color: #5B21B6; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">Campanhas Sazonais</h3>
        <ul style="color: #6B21A8; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Filtros inteligentes</li>
            <li>Mensagens personalizadas</li>
            <li>Público-alvo específico</li>
            <li>Anti-spam integrado</li>
        </ul>
    </div>
    
    <div style="background: linear-gradient(to bottom, #FEE2E2, #FECACA); border: 2px solid #EF4444; border-radius: 1rem; padding: 2rem;">
        <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">📊</div>
        <h3 style="color: #991B1B; margin: 0 0 1rem 0; font-size: 1.4rem; text-align: center;">Relatórios e Analytics</h3>
        <ul style="color: #7F1D1D; margin: 0; padding-left: 1.5rem; line-height: 2;">
            <li>Dashboards visuais</li>
            <li>Exportação Excel/PDF</li>
            <li>Métricas em tempo real</li>
            <li>Análise de desempenho</li>
        </ul>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #6366F1; padding-bottom: 0.5rem; margin-top: 3rem;">🚀 Funcionalidades Destacadas</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.5rem;">🤖</span> Automação Completa
            </h4>
            <p style="margin: 0; color: #4B5563;">Lembretes automáticos via WhatsApp em 7 dias, 1 dia e no dia do agendamento. Paciente nunca esquece!</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #3B82F6;">
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.5rem;">📱</span> Caderneta Digital
            </h4>
            <p style="margin: 0; color: #4B5563;">Paciente acessa histórico completo de vacinação pelo celular, com QR code e validação oficial.</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #8B5CF6;">
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.5rem;">🔍</span> Rastreabilidade Total
            </h4>
            <p style="margin: 0; color: #4B5563;">Controle de lote, validade e origem de cada dose aplicada. Pronto para auditorias e certificações.</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #F59E0B;">
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.5rem;">☁️</span> Multi-tenant Cloud
            </h4>
            <p style="margin: 0; color: #4B5563;">Sistema 100% online, acessível de qualquer lugar. Cada clínica tem ambiente isolado e seguro.</p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #6366F1; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Navegação Rápida</h2>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin: 2rem 0;">
    <div style="background: #DBEAFE; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #3B82F6;">
        <strong style="color: #1E40AF;">Menu Principal</strong>
        <p style="color: #1E3A8A; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Dashboard, Pacientes, Vacinas, Agendamentos</p>
    </div>
    
    <div style="background: #D1FAE5; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #10B981;">
        <strong style="color: #065F46;">Configurações</strong>
        <p style="color: #064E3B; margin: 0.5rem 0 0 0; font-size: 0.95rem;">WhatsApp, Notificações, Usuários, Perfil</p>
    </div>
    
    <div style="background: #FEF3C7; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #F59E0B;">
        <strong style="color: #92400E;">Relatórios</strong>
        <p style="color: #78350F; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Atendimentos, Estoque, Financeiro, Analytics</p>
    </div>
    
    <div style="background: #EDE9FE; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #8B5CF6;">
        <strong style="color: #5B21B6;">Ajuda</strong>
        <p style="color: #6B21A8; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Tutoriais, FAQ, Suporte, Documentação</p>
    </div>
</div>

<div style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Precisa de Ajuda?</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Explore a <strong>Central de Ajuda</strong> para tutoriais detalhados de cada funcionalidade.<br>
        Ou entre em contato com nosso suporte técnico a qualquer momento!
    </p>
</div>'
    ],

    [
        'slug' => 'primeiros-passos',
        'conteudo' => '<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🚀 Primeiros Passos no Imunify</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Guia rápido para começar a usar o sistema em menos de 10 minutos!</p>
</div>

<div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0;">👋 Bem-vindo ao Imunify!</h3>
    <p style="color: #1E3A8A; margin: 0; font-size: 1.05rem; line-height: 1.6;">
        Este guia vai te ajudar a <strong>configurar sua clínica</strong> e realizar o <strong>primeiro agendamento</strong> em poucos passos!
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">✅ Checklist de Configuração Inicial</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Complete seu Perfil</h4>
                <p style="margin: 0 0 0.5rem 0; color: #4B5563;">Menu → Configurações → Perfil da Clínica</p>
                <ul style="margin: 0.5rem 0 0 1rem; color: #6B7280; line-height: 1.8; font-size: 0.95rem;">
                    <li>Nome fantasia e razão social</li>
                    <li>CNPJ e inscrições</li>
                    <li>Endereço completo</li>
                    <li>Telefone e e-mail de contato</li>
                    <li>Logo da clínica</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Configure o WhatsApp</h4>
                <p style="margin: 0 0 0.5rem 0; color: #4B5563;">Menu → Configurações → WhatsApp</p>
                <div style="background: #D1FAE5; padding: 1rem; border-radius: 0.5rem; margin-top: 0.5rem;">
                    <strong style="color: #065F46;">✅ Modo Compartilhado</strong>
                    <p style="color: #064E3B; margin: 0.5rem 0 0 0; font-size: 0.95rem;">Já vem ativo! Não precisa fazer nada, está pronto para usar.</p>
                </div>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Cadastre as Vacinas</h4>
                <p style="margin: 0 0 0.5rem 0; color: #4B5563;">Menu → Vacinas → Nova Vacina</p>
                <ul style="margin: 0.5rem 0 0 1rem; color: #6B7280; line-height: 1.8; font-size: 0.95rem;">
                    <li>Adicione as vacinas que você trabalha</li>
                    <li>Informe lotes e validades</li>
                    <li>Configure doses e intervalos</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: white; padding: 1.5rem; border-radius: 0.75rem; border-left: 5px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Configure Horários de Atendimento</h4>
                <p style="margin: 0 0 0.5rem 0; color: #4B5563;">Menu → Configurações → Horários</p>
                <ul style="margin: 0.5rem 0 0 1rem; color: #6B7280; line-height: 1.8; font-size: 0.95rem;">
                    <li>Defina dias e horários de funcionamento</li>
                    <li>Configure intervalo entre atendimentos</li>
                    <li>Bloqueie feriados e folgas</li>
                </ul>
            </div>
        </div>
        
        <div style="display: flex; align-items: start; gap: 1rem; background: #D1FAE5; padding: 1.5rem; border-radius: 0.75rem; border: 2px solid #10B981;">
            <span style="font-size: 2rem; background: #10B981; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">✓</span>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 0.5rem 0; color: #065F46; font-size: 1.2rem;">Pronto! Já Pode Começar a Agendar</h4>
                <p style="margin: 0; color: #064E3B; font-size: 1.05rem;">Sistema está 100% configurado e pronto para receber pacientes!</p>
            </div>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">🎯 Seu Primeiro Agendamento</h2>

<div style="background: linear-gradient(to bottom, #FEF3C7, #FDE68A); border: 2px solid #F59E0B; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <h3 style="color: #92400E; margin: 0 0 1.5rem 0; text-align: center; font-size: 1.5rem;">Siga Estes 4 Passos</h3>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">👤</div>
            <strong style="color: #1F2937; font-size: 1.1rem;">1. Cadastre o Paciente</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.9rem;">Menu → Pacientes → Novo</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">💉</div>
            <strong style="color: #1F2937; font-size: 1.1rem;">2. Escolha a Vacina</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.9rem;">Sistema sugere por idade</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">📅</div>
            <strong style="color: #1F2937; font-size: 1.1rem;">3. Marque Data/Hora</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.9rem;">Calendário mostra vagas</p>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">✅</div>
            <strong style="color: #1F2937; font-size: 1.1rem;">4. Confirme!</strong>
            <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.9rem;">WhatsApp enviado automaticamente</p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #10B981; padding-bottom: 0.5rem; margin-top: 3rem;">📚 Próximos Passos Recomendados</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📖</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Explore a Central de Ajuda</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Tutoriais detalhados de cada função</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👥</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Adicione Usuários</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Cadastre sua equipe com permissões</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">⭐</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Crie Campanhas</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Para vacinas sazonais (Influenza, etc)</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📊</div>
        <h3 style="color: #1F2937; margin: 0.5rem 0; font-size: 1.2rem;">Confira Relatórios</h3>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Acompanhe métricas e desempenho</p>
    </div>
</div>

<div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Precisa de Ajuda?</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Nossa equipe de suporte está disponível <strong>Segunda a Sexta, 9h às 18h</strong>.<br>
        Entre em contato pelo WhatsApp ou e-mail sempre que precisar!
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

echo "\n✅ Todos os artigos reformatados com sucesso!\n";
