<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎨 Atualizando formatação do artigo de Campanhas...\n\n";

$conteudoNovo = '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
    <h2 style="color: white; margin-top: 0; font-size: 1.8rem;">🎯 O que são Campanhas de Vacinação?</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">Campanhas são <strong>períodos sazonais</strong> onde você organiza vacinações específicas para públicos-alvo.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: #FEF3C7; border-left: 6px solid #F59E0B; padding: 1.5rem; border-radius: 0.5rem;">
        <h3 style="color: #92400E; margin-top: 0; font-size: 1.3rem;">🦠 Influenza 2025</h3>
        <p style="color: #78350F; margin-bottom: 0.5rem;"><strong>Público:</strong> Idosos 60+</p>
        <p style="color: #78350F; margin: 0;"><strong>Período:</strong> Março a Maio</p>
    </div>
    
    <div style="background: #DBEAFE; border-left: 6px solid #3B82F6; padding: 1.5rem; border-radius: 0.5rem;">
        <h3 style="color: #1E40AF; margin-top: 0; font-size: 1.3rem;">💉 COVID-19 Reforço</h3>
        <p style="color: #1E3A8A; margin-bottom: 0.5rem;"><strong>Público:</strong> Todos</p>
        <p style="color: #1E3A8A; margin: 0;"><strong>Período:</strong> Abril a Junho</p>
    </div>
    
    <div style="background: #FCE7F3; border-left: 6px solid #EC4899; padding: 1.5rem; border-radius: 0.5rem;">
        <h3 style="color: #9F1239; margin-top: 0; font-size: 1.3rem;">🎀 HPV Adolescentes</h3>
        <p style="color: #831843; margin-bottom: 0.5rem;"><strong>Público:</strong> 9 a 14 anos</p>
        <p style="color: #831843; margin: 0;"><strong>Período:</strong> Agosto a Setembro</p>
    </div>
</div>

<div style="background: #FEF3C7; border: 3px solid #F59E0B; border-radius: 1rem; padding: 2rem; margin: 3rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 3rem;">⚠️</span>
        <h2 style="color: #92400E; margin: 0; font-size: 1.8rem;">Importante: Campanhas NÃO enviam spam!</h2>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.5rem; margin-top: 1.5rem;">
        <p style="font-size: 1.2rem; color: #1F2937; line-height: 1.8; margin: 0;">
            <strong style="color: #DC2626;">🚫 Campanhas NÃO disparam mensagens em massa</strong> para todos os pacientes!<br><br>
            <strong style="color: #059669;">✅ Elas apenas personalizam os lembretes automáticos</strong> enviados quando pacientes <strong>já têm agendamentos confirmados</strong>.
        </p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">✅ Como funciona na prática</h2>

<div style="display: flex; flex-direction: column; gap: 1rem; margin: 2rem 0;">
    <div style="display: flex; align-items: start; gap: 1rem; background: #F3F4F6; padding: 1.5rem; border-radius: 0.75rem;">
        <span style="font-size: 2rem; background: #667eea; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">1</span>
        <div>
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Você cria a campanha</h4>
            <p style="margin: 0; color: #4B5563;">Define período, vacina e público-alvo no sistema</p>
        </div>
    </div>
    
    <div style="display: flex; align-items: start; gap: 1rem; background: #F3F4F6; padding: 1.5rem; border-radius: 0.75rem;">
        <span style="font-size: 2rem; background: #667eea; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">2</span>
        <div>
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Pacientes agendam normalmente</h4>
            <p style="margin: 0; color: #4B5563;">Ao longo do período, vão marcando consultas</p>
        </div>
    </div>
    
    <div style="display: flex; align-items: start; gap: 1rem; background: #F3F4F6; padding: 1.5rem; border-radius: 0.75rem;">
        <span style="font-size: 2rem; background: #667eea; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">3</span>
        <div>
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Sistema detecta agendamentos</h4>
            <p style="margin: 0; color: #4B5563;">Identifica automaticamente quais correspondem à campanha</p>
        </div>
    </div>
    
    <div style="display: flex; align-items: start; gap: 1rem; background: #F3F4F6; padding: 1.5rem; border-radius: 0.75rem;">
        <span style="font-size: 2rem; background: #667eea; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">4</span>
        <div>
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Lembretes personalizados</h4>
            <p style="margin: 0; color: #4B5563;">Mensagens incluem nome e detalhes da campanha</p>
        </div>
    </div>
    
    <div style="display: flex; align-items: start; gap: 1rem; background: #F3F4F6; padding: 1.5rem; border-radius: 0.75rem;">
        <span style="font-size: 2rem; background: #667eea; color: white; width: 3rem; height: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">5</span>
        <div>
            <h4 style="margin: 0 0 0.5rem 0; color: #1F2937; font-size: 1.2rem;">Envios graduais</h4>
            <p style="margin: 0; color: #4B5563;">7 dias antes, 1 dia antes e no dia do agendamento</p>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">📊 Exemplo Real: 2.000 Pacientes</h2>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
    <div style="background: #FEE2E2; border: 2px solid #DC2626; border-radius: 1rem; padding: 2rem;">
        <h3 style="color: #991B1B; margin-top: 0; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span style="font-size: 2rem;">❌</span> O que NÃO acontece
        </h3>
        <ul style="color: #7F1D1D; font-size: 1.1rem; line-height: 1.8;">
            <li>Envio de 2.000 mensagens de uma vez</li>
            <li>WhatsApp bloqueia o número por spam</li>
            <li>Quota do plano estoura em 1 dia</li>
            <li>Pacientes recebem mensagens sem contexto</li>
        </ul>
    </div>
    
    <div style="background: #D1FAE5; border: 2px solid #059669; border-radius: 1rem; padding: 2rem;">
        <h3 style="color: #065F46; margin-top: 0; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span style="font-size: 2rem;">✅</span> O que REALMENTE acontece
        </h3>
        <ul style="color: #064E3B; font-size: 1.1rem; line-height: 1.8;">
            <li>Envio gradual ao longo do mês</li>
            <li>Apenas para quem tem agendamento</li>
            <li>Respeita quota do plano (780/1.000)</li>
            <li>Mensagens relevantes e esperadas</li>
        </ul>
    </div>
</div>

<div style="background: #EFF6FF; border: 2px solid #3B82F6; border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <h3 style="color: #1E40AF; margin-top: 0; font-size: 1.4rem;">📈 Distribuição Mensal</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #DBEAFE;">
                <th style="padding: 1rem; text-align: left; color: #1E40AF; border: 1px solid #93C5FD;">Semana</th>
                <th style="padding: 1rem; text-align: center; color: #1E40AF; border: 1px solid #93C5FD;">Agendamentos</th>
                <th style="padding: 1rem; text-align: center; color: #1E40AF; border: 1px solid #93C5FD;">Mensagens</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 1rem; border: 1px solid #93C5FD;">Semana 1</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD;">50</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD; font-weight: bold;">150</td>
            </tr>
            <tr style="background: #F0F9FF;">
                <td style="padding: 1rem; border: 1px solid #93C5FD;">Semana 2</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD;">60</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD; font-weight: bold;">180</td>
            </tr>
            <tr>
                <td style="padding: 1rem; border: 1px solid #93C5FD;">Semana 3</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD;">70</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD; font-weight: bold;">210</td>
            </tr>
            <tr style="background: #F0F9FF;">
                <td style="padding: 1rem; border: 1px solid #93C5FD;">Semana 4</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD;">80</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD; font-weight: bold;">240</td>
            </tr>
            <tr style="background: #D1FAE5; font-weight: bold; color: #065F46;">
                <td style="padding: 1rem; border: 1px solid #93C5FD;">TOTAL MARÇO</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD;">260 pacientes</td>
                <td style="padding: 1rem; text-align: center; border: 1px solid #93C5FD; font-size: 1.2rem;">780 msgs ✅</td>
            </tr>
        </tbody>
    </table>
    <p style="text-align: center; margin-top: 1rem; color: #065F46; font-size: 1.2rem; font-weight: bold;">
        ✅ Dentro da quota de 1.000 mensagens/mês
    </p>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">🔧 Como Criar uma Campanha</h2>

<div style="background: linear-gradient(to right, #F9FAFB, #F3F4F6); border-radius: 1rem; padding: 2rem; margin: 2rem 0;">
    <ol style="font-size: 1.1rem; line-height: 2; color: #1F2937;">
        <li style="margin-bottom: 1rem;">
            <strong>Acesse o menu</strong><br>
            <span style="color: #6B7280;">Vá em <code style="background: #E5E7EB; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">Campanhas → Nova Campanha</code></span>
        </li>
        <li style="margin-bottom: 1rem;">
            <strong>Preencha os dados básicos</strong><br>
            <span style="color: #6B7280;">Nome: "Campanha Influenza 2025"<br>Vacina: "Influenza"</span>
        </li>
        <li style="margin-bottom: 1rem;">
            <strong>Defina o período</strong><br>
            <span style="color: #6B7280;">Início: 01/03/2025 | Término: 31/05/2025</span>
        </li>
        <li style="margin-bottom: 1rem;">
            <strong>Configure o público-alvo</strong><br>
            <span style="color: #6B7280;">Descrição: "Idosos acima de 60 anos"<br>Idade Mínima: 60</span>
        </li>
        <li style="margin-bottom: 1rem;">
            <strong>Defina a prioridade</strong><br>
            <span style="color: #6B7280;">Alta, Média ou Baixa</span>
        </li>
        <li>
            <strong>Ative a campanha</strong><br>
            <span style="color: #6B7280;">Marque "Ativar campanha imediatamente" e salve</span>
        </li>
    </ol>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">📱 Comparação: Antes vs Depois</h2>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
    <div>
        <h3 style="color: #6B7280; margin-bottom: 1rem;">Sem Campanha (padrão)</h3>
        <div style="background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; font-family: monospace; font-size: 0.95rem; line-height: 1.8;">
            <div style="font-weight: bold; margin-bottom: 1rem;">🩺 MultiImune</div>
            Olá, Maria!<br><br>
            📅 Você tem vacinação em 7 dias<br>
            💉 Vacina: Influenza<br>
            📅 Data: 12/03/2025<br>
            🕐 Horário: 14:00
        </div>
    </div>
    
    <div>
        <h3 style="color: #059669; margin-bottom: 1rem;">Com Campanha (personalizado)</h3>
        <div style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border: 3px solid #3B82F6; border-radius: 0.75rem; padding: 1.5rem; font-family: monospace; font-size: 0.95rem; line-height: 1.8;">
            <div style="font-weight: bold; margin-bottom: 1rem;">🩺 MultiImune</div>
            Olá, Maria!<br><br>
            <div style="background: white; padding: 0.5rem; border-radius: 0.5rem; margin: 0.5rem 0;">
                <strong>🎯 Campanha Influenza 2025</strong><br>
                🔴 Prioridade: Alta
            </div>
            📅 Seu agendamento é em 7 dias<br>
            💉 Vacina: Influenza<br>
            📅 Data: 12/03/2025<br>
            🕐 Horário: 14:00<br><br>
            <em style="color: #1E40AF;">ℹ️ A Influenza protege idosos contra gripe sazonal...</em>
        </div>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">✅ Benefícios</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📋</div>
        <h4 style="color: #1F2937; margin: 0.5rem 0;">Organização</h4>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Agrupe vacinações sazonais em períodos</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">💬</div>
        <h4 style="color: #1F2937; margin: 0.5rem 0;">Profissional</h4>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Mensagens contextualizadas e educativas</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🛡️</div>
        <h4 style="color: #1F2937; margin: 0.5rem 0;">Segurança</h4>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Zero risco de ban do WhatsApp</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📊</div>
        <h4 style="color: #1F2937; margin: 0.5rem 0;">Quota</h4>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Respeita limites do plano</p>
    </div>
    
    <div style="background: white; border: 2px solid #E5E7EB; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🎯</div>
        <h4 style="color: #1F2937; margin: 0.5rem 0;">Precisão</h4>
        <p style="color: #6B7280; margin: 0; font-size: 0.95rem;">Filtros por idade e público</p>
    </div>
</div>

<h2 style="font-size: 1.8rem; color: #1F2937; border-bottom: 3px solid #667eea; padding-bottom: 0.5rem; margin-top: 3rem;">❓ Perguntas Frequentes</h2>

<div style="margin: 2rem 0;">
    <details style="background: #F9FAFB; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1rem; cursor: pointer;">
        <summary style="font-weight: bold; color: #1F2937; font-size: 1.1rem; cursor: pointer;">Se eu ativar uma campanha, todos os pacientes receberão mensagem?</summary>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #E5E7EB; color: #4B5563; line-height: 1.6;">
            <strong style="color: #DC2626;">NÃO!</strong> Apenas pacientes que <strong>agendarem consultas</strong> durante o período da campanha receberão lembretes personalizados.
        </div>
    </details>
    
    <details style="background: #F9FAFB; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1rem; cursor: pointer;">
        <summary style="font-weight: bold; color: #1F2937; font-size: 1.1rem; cursor: pointer;">Posso ter múltiplas campanhas ativas ao mesmo tempo?</summary>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #E5E7EB; color: #4B5563; line-height: 1.6;">
            <strong style="color: #059669;">SIM!</strong> Por exemplo, Influenza (60+) e HPV (9-14 anos) podem rodar simultaneamente. O sistema identifica qual campanha aplicar para cada paciente.
        </div>
    </details>
    
    <details style="background: #F9FAFB; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1rem; cursor: pointer;">
        <summary style="font-weight: bold; color: #1F2937; font-size: 1.1rem; cursor: pointer;">A campanha consome mais mensagens do plano?</summary>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #E5E7EB; color: #4B5563; line-height: 1.6;">
            <strong style="color: #DC2626;">NÃO!</strong> Os lembretes seriam enviados de qualquer forma. A campanha apenas personaliza o conteúdo.
        </div>
    </details>
    
    <details style="background: #F9FAFB; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1rem; cursor: pointer;">
        <summary style="font-weight: bold; color: #1F2937; font-size: 1.1rem; cursor: pointer;">Posso criar campanha sem data de término?</summary>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #E5E7EB; color: #4B5563; line-height: 1.6;">
            <strong style="color: #DC2626;">NÃO!</strong> Todas as campanhas precisam de data de início e fim. Isso garante controle e organização.
        </div>
    </details>
</div>

<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 1rem; margin-top: 3rem; text-align: center;">
    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
    <h3 style="color: white; margin: 0 0 1rem 0; font-size: 1.5rem;">Dica Profissional</h3>
    <p style="font-size: 1.1rem; line-height: 1.6; margin: 0;">
        Use a <strong>descrição da campanha</strong> para educar os pacientes sobre a importância da vacina. Essa informação aparecerá nas mensagens WhatsApp!
    </p>
</div>';

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($conteudoNovo) {
        $artigo = HelpArticle::where('slug', 'como-criar-campanhas-vacinacao')->first();
        
        if ($artigo) {
            $artigo->update(['conteudo_html' => $conteudoNovo]);
            echo "   ✅ Artigo atualizado com nova formatação!\n";
        } else {
            echo "   ⚠️  Artigo não encontrado!\n";
        }
    });
}

echo "\n✅ Concluído! Artigo reformatado em todos os tenants.\n";
