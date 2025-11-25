<?php

namespace Database\Seeders;

use App\Models\HelpArticle;
use Illuminate\Database\Seeder;

class HelpArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $artigos = [
            // === WHATSAPP ===
            [
                'categoria_slug' => 'whatsapp',
                'titulo' => 'Como Configurar o WhatsApp Business no Sistema',
                'slug' => 'como-configurar-whatsapp-business',
                'resumo' => 'Aprenda a conectar sua conta WhatsApp Business ao Imunify e começar a enviar mensagens automaticamente.',
                'conteudo_html' => '<h2>📱 Introdução</h2>
                <p>O Imunify permite que você envie mensagens automáticas via WhatsApp para seus pacientes. Há dois modos disponíveis:</p>
                <ul>
                    <li><strong>Número Compartilhado</strong>: Use o número oficial da Imunify (incluído no plano)</li>
                    <li><strong>Número Próprio</strong>: Configure seu próprio número WhatsApp Business (planos Premium)</li>
                </ul>
                
                <h2>🎯 Passo a Passo - Número Compartilhado</h2>
                <ol>
                    <li>Acesse <strong>Configurações → WhatsApp</strong></li>
                    <li>O modo compartilhado já vem ativado automaticamente</li>
                    <li>Confira sua quota mensal de mensagens no painel</li>
                    <li>Pronto! Já pode enviar notificações</li>
                </ol>
                
                <h2>🔧 Passo a Passo - Número Próprio</h2>
                <ol>
                    <li>Acesse <strong>Configurações → WhatsApp</strong></li>
                    <li>Clique em "Usar Meu Número"</li>
                    <li>Insira as credenciais de conexão fornecidas pela Imunify</li>
                    <li>Escaneie o QR Code com seu WhatsApp Business</li>
                    <li>Aguarde a conexão ser estabelecida</li>
                </ol>
                
                <blockquote>💡 <strong>Dica</strong>: O modo compartilhado é ideal para começar. Você pode migrar para número próprio a qualquer momento!</blockquote>',
                'tags' => ['whatsapp', 'configuração', 'primeiros-passos', 'api'],
                'ordem' => 1,
                'destaque' => true,
                'ativo' => true,
            ],
            
            [
                'categoria_slug' => 'whatsapp',
                'titulo' => 'Entendendo o Dashboard de Notificações WhatsApp',
                'slug' => 'dashboard-notificacoes-whatsapp',
                'resumo' => 'Visualize métricas em tempo real de todas as mensagens enviadas, pendentes e falhas.',
                'conteudo_html' => '<h2>📊 O Que é o Dashboard</h2>
                <p>O Dashboard de Notificações é sua central de controle para acompanhar todas as mensagens WhatsApp enviadas pelo sistema.</p>
                
                <h2>📈 Métricas Principais</h2>
                <h3>1. Mensagens Enviadas Hoje</h3>
                <p>Mostra quantas mensagens foram enviadas com sucesso no dia atual, com comparação ao dia anterior (%) para você avaliar o crescimento.</p>
                
                <h3>2. Mensagens Pendentes</h3>
                <p>Notificações agendadas mas ainda não enviadas. Isso inclui lembretes programados para horários futuros.</p>
                
                <h3>3. Falhas de Envio</h3>
                <p>Mensagens que não puderam ser entregues. Você pode clicar para ver detalhes e reenviar manualmente.</p>
                
                <h2>📊 Gráfico de Evolução</h2>
                <p>O gráfico de linha mostra os últimos 7 dias de envios, permitindo identificar padrões e picos de uso.</p>
                
                <h2>🔍 Filtros Disponíveis</h2>
                <ul>
                    <li><strong>Busca por Paciente</strong>: Digite nome ou telefone</li>
                    <li><strong>Período</strong>: Hoje, últimos 7 dias, últimos 30 dias ou personalizado</li>
                    <li><strong>Tipo de Notificação</strong>: Dose próxima, campanha terminando, dose atrasada</li>
                    <li><strong>Status</strong>: Enviado, pendente, falhou</li>
                </ul>
                
                <blockquote>💡 Acesse em: <strong>Dashboard → Notificações</strong></blockquote>',
                'tags' => ['dashboard', 'métricas', 'relatórios', 'whatsapp'],
                'ordem' => 2,
                'destaque' => true,
                'ativo' => true,
            ],

            [
                'categoria_slug' => 'whatsapp',
                'titulo' => 'Como Reenviar Mensagens que Falharam',
                'slug' => 'reenviar-mensagens-falhadas',
                'resumo' => 'Aprenda a identificar e reenviar mensagens WhatsApp que falharam no primeiro envio.',
                'conteudo_html' => '<h2>🔴 Por Que Mensagens Falham?</h2>
                <p>Mensagens podem falhar por diversos motivos:</p>
                <ul>
                    <li>Número inválido ou bloqueado</li>
                    <li>Paciente bloqueou o número do WhatsApp</li>
                    <li>Problemas temporários na API do WhatsApp</li>
                    <li>Quota mensal esgotada</li>
                </ul>
                
                <h2>🔄 Como Reenviar</h2>
                <ol>
                    <li>Acesse <strong>Dashboard → Notificações</strong></li>
                    <li>Procure mensagens com badge vermelho "Falhou"</li>
                    <li>Clique no botão <strong>"Reenviar"</strong> ao lado da mensagem</li>
                    <li>Confirme o reenvio</li>
                    <li>O sistema tentará enviar novamente imediatamente</li>
                </ol>
                
                <blockquote>⚠️ <strong>Importante</strong>: Verifique se o telefone do paciente está correto antes de reenviar!</blockquote>',
                'tags' => ['whatsapp', 'troubleshooting', 'reenvio'],
                'ordem' => 3,
                'destaque' => false,
                'ativo' => true,
            ],

            // === VACINAS ===
            [
                'categoria_slug' => 'vacinas',
                'titulo' => 'Como Funciona o Lembrete Automático de Vacinação',
                'slug' => 'lembrete-automatico-vacinacao',
                'resumo' => 'Entenda como o sistema detecta doses atrasadas e envia lembretes automáticos via WhatsApp.',
                'conteudo_html' => '<h2>🤖 Sistema Totalmente Automático</h2>
                <p>O Imunify analisa diariamente todos os pacientes e identifica doses de vacinas que estão:</p>
                <ul>
                    <li>✅ <strong>Atrasadas</strong>: já passou do prazo recomendado</li>
                    <li>⏰ <strong>Próximas</strong>: faltam poucos dias para aplicar</li>
                    <li>📅 <strong>Dentro de campanhas</strong>: período de campanha sazonal ativo</li>
                </ul>
                
                <h2>📅 Quando os Lembretes São Enviados?</h2>
                <p>O sistema roda <strong>automaticamente todo dia às 9h da manhã</strong>. Ele:</p>
                <ol>
                    <li>Verifica todos os pacientes cadastrados</li>
                    <li>Cruza com esquemas vacinais e campanhas ativas</li>
                    <li>Identifica doses pendentes</li>
                    <li>Envia mensagens personalizadas via WhatsApp</li>
                </ol>
                
                <h2>💬 Exemplo de Mensagem</h2>
                <pre>Olá Maria Silva! 👋

A vacina *Tríplice Viral* da Sofia está com a 2ª dose atrasada.

📅 Data recomendada: 15/10/2024
⚠️ Status: 15 dias de atraso

📍 Agende em {{ nome_da_clinica }}
📞 {{ telefone_clinica }}</pre>
                
                <h2>🎯 Personalizando Mensagens</h2>
                <p>As mensagens são automaticamente personalizadas com:</p>
                <ul>
                    <li>Nome do paciente e/ou responsável</li>
                    <li>Nome da vacina e número da dose</li>
                    <li>Data recomendada para aplicação</li>
                    <li>Nome e telefone da sua clínica</li>
                </ul>
                
                <blockquote>💡 <strong>Dica</strong>: Quanto mais completo o cadastro do paciente, melhores serão os lembretes!</blockquote>',
                'tags' => ['vacinas', 'lembretes', 'automação', 'whatsapp'],
                'ordem' => 1,
                'destaque' => true,
                'ativo' => true,
            ],

            [
                'categoria_slug' => 'vacinas',
                'titulo' => 'Cadastrando Esquemas Vacinais Personalizados',
                'slug' => 'esquemas-vacinais-personalizados',
                'resumo' => 'Crie esquemas de múltiplas doses com intervalos personalizados para cada vacina.',
                'conteudo_html' => '<h2>💉 O Que São Esquemas Vacinais?</h2>
                <p>Esquemas vacinais definem quantas doses uma vacina possui e o intervalo entre elas.</p>
                
                <h2>📝 Criando um Esquema</h2>
                <ol>
                    <li>Acesse <strong>Vacinas → Gerenciar Vacinas</strong></li>
                    <li>Selecione a vacina</li>
                    <li>Clique em "Editar Esquema de Doses"</li>
                    <li>Defina número de doses e intervalos</li>
                </ol>
                
                <h3>Exemplo: Tríplice Viral</h3>
                <ul>
                    <li>1ª dose: 12 meses</li>
                    <li>2ª dose: 15 meses (3 meses após a 1ª)</li>
                </ul>
                
                <blockquote>✅ O sistema calculará automaticamente as datas recomendadas para cada paciente!</blockquote>',
                'tags' => ['vacinas', 'esquema', 'doses'],
                'ordem' => 2,
                'destaque' => false,
                'ativo' => true,
            ],

            // === AGENDAMENTOS ===
            [
                'categoria_slug' => 'agendamentos',
                'titulo' => 'Como Criar e Gerenciar Agendamentos',
                'slug' => 'criar-gerenciar-agendamentos',
                'resumo' => 'Guia completo para agendar consultas, aplicações de vacinas e outros atendimentos.',
                'conteudo_html' => '<h2>📅 Tipos de Agendamento</h2>
                <p>O sistema suporta:</p>
                <ul>
                    <li>🩺 <strong>Consultas</strong></li>
                    <li>💉 <strong>Aplicação de Vacinas</strong></li>
                    <li>🔔 <strong>Lembretes Gerais</strong></li>
                    <li>📋 <strong>Outros Atendimentos</strong></li>
                </ul>
                
                <h2>➕ Criando Novo Agendamento</h2>
                <ol>
                    <li>Acesse <strong>Agendamentos → Novo</strong></li>
                    <li>Selecione o paciente</li>
                    <li>Escolha data e horário</li>
                    <li>Defina tipo e descrição</li>
                    <li>Salve</li>
                </ol>
                
                <h2>✅ Confirmando Presença</h2>
                <p>Quando o paciente chegar, marque como "Confirmado" ou "Realizado" no calendário.</p>
                
                <blockquote>💡 Agendamentos de vacinas enviarão confirmação automática via WhatsApp!</blockquote>',
                'tags' => ['agendamentos', 'calendário', 'consultas'],
                'ordem' => 1,
                'destaque' => true,
                'ativo' => true,
            ],

            // === PACIENTES ===
            [
                'categoria_slug' => 'pacientes',
                'titulo' => 'Cadastrando Pacientes Completos',
                'slug' => 'cadastrando-pacientes-completos',
                'resumo' => 'Preencha todos os dados importantes para otimizar lembretes e atendimentos.',
                'conteudo_html' => '<h2>👤 Informações Essenciais</h2>
                <p>Um cadastro completo deve conter:</p>
                <ul>
                    <li>Nome completo</li>
                    <li>Data de nascimento</li>
                    <li><strong>Telefone com WhatsApp</strong> (para receber notificações)</li>
                    <li>CPF (opcional mas recomendado)</li>
                    <li>Endereço completo</li>
                </ul>
                
                <h2>📱 Validação de Telefone</h2>
                <p>Certifique-se de incluir o DDD e usar formato: <code>(11) 98765-4321</code></p>
                
                <h2>🔒 Segurança de Dados</h2>
                <p>Todos os dados são criptografados e protegidos conforme LGPD.</p>
                
                <blockquote>⚠️ Sem WhatsApp válido, o paciente não receberá lembretes automáticos!</blockquote>',
                'tags' => ['pacientes', 'cadastro', 'lgpd'],
                'ordem' => 1,
                'destaque' => true,
                'ativo' => true,
            ],

            // === RELATÓRIOS ===
            [
                'categoria_slug' => 'relatorios',
                'titulo' => 'Exportando Relatórios em Excel',
                'slug' => 'exportando-relatorios-excel',
                'resumo' => 'Baixe relatórios completos de vacinas, atendimentos e pacientes em formato Excel.',
                'conteudo_html' => '<h2>📊 Tipos de Relatórios</h2>
                <ul>
                    <li>Vacinas aplicadas por período</li>
                    <li>Pacientes ativos/inativos</li>
                    <li>Notificações enviadas</li>
                    <li>Agendamentos futuros</li>
                </ul>
                
                <h2>📥 Como Exportar</h2>
                <ol>
                    <li>Acesse a seção desejada</li>
                    <li>Aplique filtros (se necessário)</li>
                    <li>Clique no botão "Exportar Excel"</li>
                    <li>Aguarde o download</li>
                </ol>
                
                <blockquote>💡 Exporte regularmente para backup e análises externas!</blockquote>',
                'tags' => ['relatórios', 'excel', 'exportação'],
                'ordem' => 1,
                'destaque' => false,
                'ativo' => true,
            ],

            // === CONFIGURAÇÕES ===
            [
                'categoria_slug' => 'configuracoes',
                'titulo' => 'Personalizando as Cores e Logo da Sua Clínica',
                'slug' => 'personalizando-cores-logo-clinica',
                'resumo' => 'Deixe o sistema com a identidade visual da sua clínica em poucos cliques.',
                'conteudo_html' => '<h2>🎨 Personalizando Aparência</h2>
                <ol>
                    <li>Acesse <strong>Configurações → Personalização</strong></li>
                    <li>Faça upload do logo da clínica (PNG/JPG, máx 2MB)</li>
                    <li>Escolha a cor primária do sistema</li>
                    <li>Salve as alterações</li>
                </ol>
                
                <h2>📸 Requisitos do Logo</h2>
                <ul>
                    <li>Formato: PNG ou JPG</li>
                    <li>Tamanho: até 2MB</li>
                    <li>Dimensões recomendadas: 200x200px</li>
                    <li>Fundo transparente (PNG) funciona melhor</li>
                </ul>
                
                <blockquote>🎯 A cor escolhida será usada em botões, menus e destaques!</blockquote>',
                'tags' => ['configurações', 'personalização', 'branding'],
                'ordem' => 1,
                'destaque' => false,
                'ativo' => true,
            ],

            // === CAMPANHAS ===
            [
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
            ],
        ];

        foreach ($artigos as $artigo) {
            HelpArticle::create($artigo);
        }
    }
}
