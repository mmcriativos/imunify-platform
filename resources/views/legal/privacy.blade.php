<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidade - Imunify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    {{-- Header --}}
    <nav class="bg-white shadow-sm py-4 sticky top-0 z-50">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Imunify" class="h-9">
            </a>
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Voltar</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Política de Privacidade</h1>
                <p class="text-gray-600">Última atualização: {{ date('d/m/Y') }}</p>
                <div class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-secondary-100 text-secondary-700 rounded-full text-sm font-semibold">
                    <i class="fas fa-shield-alt"></i>
                    LGPD Compliance
                </div>
            </div>

            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Introdução</h2>
                <p class="text-gray-700 mb-4">
                    Esta Política de Privacidade descreve como o <strong>Imunify</strong> coleta, usa, armazena e 
                    protege as informações pessoais de seus usuários, em conformidade com a Lei Geral de Proteção 
                    de Dados (LGPD - Lei nº 13.709/2018).
                </p>
                <p class="text-gray-700 mb-4">
                    Ao utilizar nossa plataforma, você consente com as práticas descritas nesta política.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Definições</h2>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li><strong>Dados Pessoais:</strong> Informações relacionadas a pessoa natural identificada ou identificável</li>
                    <li><strong>Titular:</strong> Pessoa natural a quem se referem os dados pessoais</li>
                    <li><strong>Controlador:</strong> Imunify, responsável pelas decisões sobre o tratamento de dados</li>
                    <li><strong>Operador:</strong> Pessoa que realiza o tratamento em nome do controlador</li>
                    <li><strong>Tratamento:</strong> Qualquer operação realizada com dados pessoais</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Dados Coletados</h2>
                
                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">3.1. Dados da Clínica (Usuário Contratante)</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Nome da clínica</li>
                    <li>CNPJ</li>
                    <li>Endereço completo</li>
                    <li>Telefone e email de contato</li>
                    <li>Nome e dados do administrador responsável</li>
                    <li>Informações de pagamento (processadas por gateway seguro)</li>
                </ul>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">3.2. Dados dos Pacientes</h3>
                <p class="text-gray-700 mb-4">
                    <strong>Importante:</strong> Você (clínica) é o Controlador dos dados dos pacientes. 
                    O Imunify atua como Operador, processando dados conforme suas instruções.
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Nome completo</li>
                    <li>CPF</li>
                    <li>Data de nascimento</li>
                    <li>Sexo</li>
                    <li>Telefone e email</li>
                    <li>Endereço</li>
                    <li>Histórico de vacinação</li>
                    <li>Reações adversas a vacinas</li>
                    <li>Informações de agendamentos</li>
                </ul>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">3.3. Dados de Uso da Plataforma</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Logs de acesso (IP, data/hora, ações realizadas)</li>
                    <li>Informações de navegação (cookies)</li>
                    <li>Dados de desempenho e analytics</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Finalidades do Tratamento</h2>
                <p class="text-gray-700 mb-4">
                    Utilizamos os dados coletados para as seguintes finalidades:
                </p>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">4.1. Dados da Clínica</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Criação e gestão de sua conta</li>
                    <li>Processamento de pagamentos</li>
                    <li>Envio de comunicações sobre o serviço</li>
                    <li>Suporte técnico</li>
                    <li>Cumprimento de obrigações legais</li>
                </ul>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">4.2. Dados dos Pacientes</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Gestão de agendamentos</li>
                    <li>Controle de histórico de vacinação</li>
                    <li>Envio de lembretes automáticos via WhatsApp</li>
                    <li>Geração de relatórios e estatísticas</li>
                    <li>Emissão de carteira de vacinação digital</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Base Legal do Tratamento</h2>
                <p class="text-gray-700 mb-4">
                    O tratamento de dados pessoais é fundamentado nas seguintes bases legais da LGPD:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li><strong>Execução de contrato (Art. 7º, V):</strong> Para prestação dos serviços contratados</li>
                    <li><strong>Consentimento (Art. 7º, I):</strong> Para envio de comunicações de marketing</li>
                    <li><strong>Cumprimento de obrigação legal (Art. 7º, II):</strong> Para emissão de notas fiscais e retenção de registros</li>
                    <li><strong>Legítimo interesse (Art. 7º, IX):</strong> Para melhorias da plataforma e segurança</li>
                    <li><strong>Tutela da saúde (Art. 7º, VII e Art. 11º, II, f):</strong> Para dados sensíveis de saúde dos pacientes</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Compartilhamento de Dados</h2>
                <p class="text-gray-700 mb-4">
                    Não vendemos, alugamos ou comercializamos seus dados. Compartilhamos informações apenas nas seguintes situações:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li><strong>Prestadores de serviço:</strong> Gateway de pagamento, serviço de email, WhatsApp Business API</li>
                    <li><strong>Obrigações legais:</strong> Quando exigido por lei ou ordem judicial</li>
                    <li><strong>Proteção de direitos:</strong> Para proteger direitos, propriedade ou segurança</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Armazenamento e Segurança</h2>
                
                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">7.1. Localização dos Dados</h3>
                <p class="text-gray-700 mb-4">
                    Todos os dados são armazenados em servidores localizados no Brasil, em conformidade com a LGPD.
                </p>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">7.2. Medidas de Segurança</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Criptografia de dados em trânsito (SSL/TLS)</li>
                    <li>Criptografia de dados em repouso</li>
                    <li>Autenticação de dois fatores (2FA)</li>
                    <li>Controle de acesso baseado em funções</li>
                    <li>Backups diários automatizados</li>
                    <li>Monitoramento de segurança 24/7</li>
                    <li>Logs de auditoria de acesso</li>
                </ul>

                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">7.3. Período de Retenção</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li><strong>Dados da clínica:</strong> Durante a vigência do contrato + 5 anos (prazo legal)</li>
                    <li><strong>Dados dos pacientes:</strong> Conforme determinado por você (clínica), respeitando legislação sanitária</li>
                    <li><strong>Dados de pagamento:</strong> 5 anos (legislação tributária)</li>
                    <li><strong>Logs de acesso:</strong> 6 meses (Marco Civil da Internet)</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Direitos dos Titulares (LGPD)</h2>
                <p class="text-gray-700 mb-4">
                    Conforme a LGPD, você tem os seguintes direitos sobre seus dados pessoais:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li><strong>Confirmação e acesso:</strong> Saber se tratamos seus dados e acessá-los</li>
                    <li><strong>Correção:</strong> Corrigir dados incompletos, inexatos ou desatualizados</li>
                    <li><strong>Anonimização, bloqueio ou eliminação:</strong> De dados desnecessários ou tratados em desconformidade</li>
                    <li><strong>Portabilidade:</strong> Transferir dados a outro fornecedor de serviço</li>
                    <li><strong>Eliminação:</strong> Dos dados tratados com consentimento</li>
                    <li><strong>Informação:</strong> Sobre compartilhamento de dados</li>
                    <li><strong>Revogação do consentimento:</strong> A qualquer momento</li>
                    <li><strong>Oposição:</strong> Ao tratamento realizado sem consentimento</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Cookies</h2>
                <p class="text-gray-700 mb-4">
                    Utilizamos cookies para:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Manter sua sessão ativa</li>
                    <li>Lembrar suas preferências</li>
                    <li>Analisar uso da plataforma</li>
                    <li>Melhorar a experiência do usuário</li>
                </ul>
                <p class="text-gray-700 mb-4">
                    Você pode desabilitar cookies nas configurações do navegador, mas isso pode afetar o funcionamento da plataforma.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">10. Dados de Menores de Idade</h2>
                <p class="text-gray-700 mb-4">
                    A plataforma não coleta intencionalmente dados de menores de 18 anos sem o consentimento dos pais ou responsáveis. 
                    Para pacientes menores de idade, a clínica deve obter o consentimento adequado.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">11. Alterações nesta Política</h2>
                <p class="text-gray-700 mb-4">
                    Podemos atualizar esta Política de Privacidade periodicamente. Notificaremos sobre alterações significativas por:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Email enviado ao endereço cadastrado</li>
                    <li>Aviso destacado na plataforma</li>
                    <li>Atualização da data no topo deste documento</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">12. Encarregado de Proteção de Dados (DPO)</h2>
                <p class="text-gray-700 mb-4">
                    Para exercer seus direitos ou esclarecer dúvidas sobre o tratamento de dados pessoais, entre em contato com nosso DPO:
                </p>
                <ul class="list-none pl-0 mb-4 text-gray-700 space-y-2">
                    <li><strong>Nome:</strong> [Nome do DPO]</li>
                    <li><strong>Email:</strong> dpo@imunify.com.br</li>
                    <li><strong>Prazo de resposta:</strong> Até 15 dias úteis</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">13. Autoridade Nacional de Proteção de Dados (ANPD)</h2>
                <p class="text-gray-700 mb-4">
                    Caso não fique satisfeito com nossas respostas, você pode registrar reclamação na ANPD:
                </p>
                <ul class="list-none pl-0 mb-4 text-gray-700 space-y-2">
                    <li><strong>Website:</strong> www.gov.br/anpd</li>
                    <li><strong>Email:</strong> comunicacao@anpd.gov.br</li>
                </ul>

                <div class="mt-12 p-6 bg-secondary-50 border-l-4 border-secondary-500 rounded">
                    <p class="text-gray-700 mb-2">
                        <strong><i class="fas fa-shield-alt mr-2"></i>Compromisso com sua Privacidade</strong>
                    </p>
                    <p class="text-gray-700">
                        Levamos a proteção de dados muito a sério. Esta Política de Privacidade foi desenvolvida 
                        em conformidade com a LGPD e reflete nosso compromisso com a transparência e segurança 
                        das informações que nos são confiadas.
                    </p>
                </div>

                <div class="mt-6 p-6 bg-primary-50 border-l-4 border-primary-500 rounded">
                    <p class="text-gray-700">
                        <strong>Importante para Clínicas:</strong> Você é responsável por obter o consentimento 
                        adequado dos pacientes para coleta e tratamento de seus dados de saúde, em conformidade 
                        com a LGPD e resoluções do CFM e ANVISA.
                    </p>
                </div>

            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 <span class="text-white font-semibold">Imunify</span>. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>
