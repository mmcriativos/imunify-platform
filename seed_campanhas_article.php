<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

echo "🎯 Adicionando artigo sobre Campanhas de Vacinação...\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "📋 Tenant: {$tenant->id}\n";
    
    $tenant->run(function () use ($tenant) {
        // Verificar se já existe
        $existente = HelpArticle::where('slug', 'como-criar-campanhas-vacinacao')->first();
        
        if ($existente) {
            echo "   ⚠️  Artigo já existe, atualizando...\n";
            $existente->delete();
        }
        
        HelpArticle::create([
            'categoria_slug' => 'vacinas',
            'titulo' => 'Como Criar e Gerenciar Campanhas de Vacinação',
            'slug' => 'como-criar-campanhas-vacinacao',
            'resumo' => 'Entenda como funcionam as campanhas sazonais e como elas personalizam os lembretes automáticos sem enviar spam.',
            'conteudo_html' => '<h2>🎯 O que são Campanhas de Vacinação?</h2>
            <p>Campanhas de vacinação são <strong>períodos sazonais</strong> onde você organiza a aplicação de vacinas específicas para públicos-alvo, como:</p>
            <ul>
                <li><strong>Influenza 2025</strong>: para idosos acima de 60 anos (Março a Maio)</li>
                <li><strong>COVID-19 Reforço</strong>: para todos os pacientes (Abril a Junho)</li>
                <li><strong>HPV Adolescentes</strong>: 9 a 14 anos (Agosto a Setembro)</li>
            </ul>
            
            <h2>⚠️ Importante: Campanhas NÃO enviam spam!</h2>
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 1rem; margin: 1rem 0;">
                <p><strong>🚨 Atenção:</strong> Campanhas <strong>não disparam mensagens em massa</strong> para todos os pacientes!</p>
                <p>Elas apenas <strong>personalizam os lembretes automáticos</strong> que são enviados quando os pacientes <strong>já têm agendamentos confirmados</strong>.</p>
            </div>
            
            <h3>✅ Como funciona na prática:</h3>
            <ol>
                <li><strong>Você cria a campanha</strong> com período, vacina e público-alvo</li>
                <li><strong>Pacientes agendam normalmente</strong> ao longo do período</li>
                <li><strong>Sistema detecta agendamentos</strong> que correspondem à campanha</li>
                <li><strong>Lembretes são personalizados</strong> com informações da campanha</li>
                <li><strong>Envios são graduais</strong> conforme os agendamentos (7 dias antes, 1 dia antes, no dia)</li>
            </ol>
            
            <h2>📊 Exemplo Real: Campanha Influenza</h2>
            <p>Imagine que você tem 2.000 pacientes cadastrados e cria uma campanha de Influenza para idosos 60+:</p>
            
            <h3>❌ O que NÃO acontece:</h3>
            <ul>
                <li>Sistema envia 2.000 mensagens de uma vez</li>
                <li>WhatsApp considera spam e bloqueia número</li>
                <li>Quota do plano estoura em 1 dia</li>
            </ul>
            
            <h3>✅ O que REALMENTE acontece:</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
                <thead style="background: #F3F4F6;">
                    <tr>
                        <th style="padding: 0.75rem; border: 1px solid #E5E7EB;">Período</th>
                        <th style="padding: 0.75rem; border: 1px solid #E5E7EB;">Agendamentos</th>
                        <th style="padding: 0.75rem; border: 1px solid #E5E7EB;">Mensagens</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">Semana 1 (Março)</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">50 agendamentos</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">150 mensagens</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">Semana 2</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">60 agendamentos</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">180 mensagens</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">Semana 3</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">70 agendamentos</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">210 mensagens</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">Semana 4</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">80 agendamentos</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">240 mensagens</td>
                    </tr>
                    <tr style="background: #F0FDF4; font-weight: bold;">
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">Total Março</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">260 pacientes</td>
                        <td style="padding: 0.75rem; border: 1px solid #E5E7EB;">780 mensagens ✅</td>
                    </tr>
                </tbody>
            </table>
            
            <p><strong>Resultado:</strong> 780 mensagens ao longo do mês = <strong>dentro da quota de 1.000 msg/mês</strong> ✅</p>
            
            <h2>🔧 Como Criar uma Campanha</h2>
            <ol>
                <li>Acesse <strong>Campanhas → Nova Campanha</strong></li>
                <li>Preencha os dados:
                    <ul>
                        <li><strong>Nome</strong>: "Campanha Influenza 2025"</li>
                        <li><strong>Vacina</strong>: "Influenza"</li>
                        <li><strong>Período</strong>: 01/03/2025 a 31/05/2025</li>
                        <li><strong>Público-Alvo</strong>: "Idosos acima de 60 anos"</li>
                        <li><strong>Idade Mínima</strong>: 60</li>
                        <li><strong>Prioridade</strong>: Alta</li>
                    </ul>
                </li>
                <li>Marque <strong>"Ativar campanha imediatamente"</strong></li>
                <li>Clique em <strong>Criar Campanha</strong></li>
            </ol>
            
            <h2>📱 Como as Mensagens Ficam</h2>
            <h3>Sem Campanha (mensagem padrão):</h3>
            <div style="background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; padding: 1rem; margin: 1rem 0; font-family: monospace; font-size: 0.9rem;">
                🩺 <strong>MultiImune - Lembrete</strong><br><br>
                Olá, Maria!<br><br>
                📅 Você tem vacinação em 7 dias:<br>
                💉 Vacina: Influenza<br>
                📅 Data: 12/03/2025<br>
                🕐 Horário: 14:00
            </div>
            
            <h3>Com Campanha (mensagem personalizada):</h3>
            <div style="background: #EFF6FF; border: 2px solid #3B82F6; border-radius: 8px; padding: 1rem; margin: 1rem 0; font-family: monospace; font-size: 0.9rem;">
                🩺 <strong>MultiImune - Lembrete</strong><br><br>
                Olá, Maria!<br><br>
                🎯 <strong>Campanha Influenza 2025</strong><br>
                🔴 Prioridade: Alta<br><br>
                📅 Seu agendamento é em 7 dias:<br>
                💉 Vacina: Influenza<br>
                📅 Data: 12/03/2025<br>
                🕐 Horário: 14:00<br><br>
                ℹ️ A vacina Influenza protege idosos contra gripe sazonal e complicações respiratórias.
            </div>
            
            <h2>✅ Benefícios das Campanhas</h2>
            <ul>
                <li>✅ <strong>Organização</strong>: agrupe vacinações sazonais</li>
                <li>✅ <strong>Comunicação profissional</strong>: mensagens contextualizadas</li>
                <li>✅ <strong>Segurança</strong>: sem risco de ban do WhatsApp</li>
                <li>✅ <strong>Respeita quota</strong>: envios graduais ao longo do período</li>
                <li>✅ <strong>Filtros inteligentes</strong>: só atinge público-alvo correto</li>
            </ul>
            
            <h2>🎯 Gerenciamento de Campanhas</h2>
            <p>No painel <strong>Campanhas</strong> você pode:</p>
            <ul>
                <li><strong>Ver estatísticas</strong>: quantas ativas, agendadas, encerradas</li>
                <li><strong>Editar campanhas</strong>: ajustar período ou descrição</li>
                <li><strong>Pausar/Ativar</strong>: controlar quando a personalização acontece</li>
                <li><strong>Excluir campanhas</strong>: remover campanhas antigas</li>
            </ul>
            
            <h2>❓ Perguntas Frequentes</h2>
            <h3>P: Se eu ativar uma campanha, todos os pacientes receberão mensagem?</h3>
            <p><strong>R:</strong> NÃO! Apenas pacientes que <strong>agendarem consultas</strong> durante o período da campanha receberão lembretes personalizados.</p>
            
            <h3>P: Posso ter múltiplas campanhas ativas ao mesmo tempo?</h3>
            <p><strong>R:</strong> Sim! Por exemplo, Influenza (60+) e HPV (9-14 anos) podem rodar simultaneamente. O sistema identifica qual campanha aplicar para cada paciente.</p>
            
            <h3>P: A campanha consome mais mensagens do plano?</h3>
            <p><strong>R:</strong> NÃO! Os lembretes seriam enviados de qualquer forma. A campanha apenas personaliza o conteúdo.</p>
            
            <h3>P: Posso criar campanha sem data de término?</h3>
            <p><strong>R:</strong> Não, todas as campanhas precisam de data de início e fim. Isso garante controle e organização.</p>
            
            <blockquote>💡 <strong>Dica Pro</strong>: Use a descrição da campanha para educar os pacientes sobre a importância da vacina. Essa informação aparecerá nas mensagens!</blockquote>',
            'tags' => ['campanhas', 'vacinas', 'whatsapp', 'automação', 'lembretes'],
            'ordem' => 3,
            'destaque' => true,
            'ativo' => true,
        ]);
        
        echo "   ✅ Artigo adicionado!\n";
    });
}

echo "\n✅ Concluído! Artigo sobre Campanhas adicionado em todos os tenants.\n";
