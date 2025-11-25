<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termos de Uso - Imunify</title>
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
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Termos de Uso</h1>
                <p class="text-gray-600">Última atualização: {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Aceitação dos Termos</h2>
                <p class="text-gray-700 mb-4">
                    Ao acessar e utilizar a plataforma Imunify, você concorda em cumprir e estar vinculado aos 
                    presentes Termos de Uso. Se você não concorda com qualquer parte destes termos, não deve 
                    utilizar nossa plataforma.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Descrição do Serviço</h2>
                <p class="text-gray-700 mb-4">
                    O Imunify é uma plataforma SaaS (Software as a Service) de gestão para clínicas de vacinação, 
                    oferecendo funcionalidades como:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Sistema de agendamento online</li>
                    <li>Controle de estoque de vacinas</li>
                    <li>Prontuário digital de pacientes</li>
                    <li>Integração com WhatsApp para lembretes automáticos</li>
                    <li>Relatórios e analytics</li>
                    <li>Gestão de campanhas de vacinação</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Período de Teste Gratuito</h2>
                <p class="text-gray-700 mb-4">
                    <strong>3.1.</strong> Oferecemos um período de teste gratuito de 7 (sete) dias para todos os novos usuários.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>3.2.</strong> Durante o período de teste, você terá acesso completo às funcionalidades do plano contratado.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>3.3.</strong> Não é necessário fornecer dados de cartão de crédito para iniciar o período de teste.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>3.4.</strong> Ao final do período de teste, você deverá contratar um plano pago para continuar utilizando a plataforma.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Planos e Pagamentos</h2>
                <p class="text-gray-700 mb-4">
                    <strong>4.1.</strong> Os planos disponíveis e seus respectivos valores estão descritos em nossa página de preços.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>4.2.</strong> O pagamento é realizado mensalmente, de forma recorrente, via cartão de crédito ou boleto bancário.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>4.3.</strong> Os valores podem ser reajustados mediante aviso prévio de 30 (trinta) dias.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>4.4.</strong> Em caso de inadimplência, o acesso à plataforma será suspenso até a regularização do pagamento.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Cancelamento</h2>
                <p class="text-gray-700 mb-4">
                    <strong>5.1.</strong> Você pode cancelar sua assinatura a qualquer momento através do painel administrativo.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>5.2.</strong> O cancelamento será efetivado ao final do período já pago.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>5.3.</strong> Não há reembolso proporcional em caso de cancelamento durante o período de vigência.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>5.4.</strong> Seus dados permanecerão armazenados por 30 (trinta) dias após o cancelamento, 
                    podendo ser recuperados caso reative a conta neste período.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Responsabilidades do Usuário</h2>
                <p class="text-gray-700 mb-4">
                    <strong>6.1.</strong> Você é responsável por:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Manter a confidencialidade de suas credenciais de acesso</li>
                    <li>Garantir a veracidade e legalidade das informações inseridas na plataforma</li>
                    <li>Cumprir todas as legislações aplicáveis, incluindo LGPD e regulamentações sanitárias</li>
                    <li>Realizar backup regular de seus dados</li>
                    <li>Não compartilhar sua conta com terceiros não autorizados</li>
                    <li>Não utilizar a plataforma para fins ilícitos ou não autorizados</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Propriedade Intelectual</h2>
                <p class="text-gray-700 mb-4">
                    <strong>7.1.</strong> Todos os direitos de propriedade intelectual relacionados à plataforma Imunify 
                    pertencem exclusivamente a nós.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>7.2.</strong> Os dados inseridos por você permanecem de sua propriedade, mas você nos concede 
                    licença para processá-los conforme necessário para prestação do serviço.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Limitações de Responsabilidade</h2>
                <p class="text-gray-700 mb-4">
                    <strong>8.1.</strong> A plataforma é fornecida "como está", sem garantias expressas ou implícitas.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>8.2.</strong> Não nos responsabilizamos por:
                </p>
                <ul class="list-disc pl-6 mb-4 text-gray-700 space-y-2">
                    <li>Perda de dados causada por ações do usuário</li>
                    <li>Interrupções temporárias do serviço para manutenção</li>
                    <li>Decisões médicas ou de saúde tomadas com base nas informações da plataforma</li>
                    <li>Danos indiretos, incidentais ou consequentes</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Segurança e Privacidade</h2>
                <p class="text-gray-700 mb-4">
                    <strong>9.1.</strong> Implementamos medidas de segurança técnicas e organizacionais para proteger seus dados.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>9.2.</strong> O tratamento de dados pessoais está detalhado em nossa 
                    <a href="{{ route('legal.privacy') }}" class="text-primary-600 hover:text-primary-700 underline">Política de Privacidade</a>.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">10. Modificações dos Termos</h2>
                <p class="text-gray-700 mb-4">
                    <strong>10.1.</strong> Reservamo-nos o direito de modificar estes Termos de Uso a qualquer momento.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>10.2.</strong> Você será notificado sobre alterações significativas por email ou através da plataforma.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>10.3.</strong> O uso continuado da plataforma após as modificações constitui aceitação dos novos termos.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">11. Suporte Técnico</h2>
                <p class="text-gray-700 mb-4">
                    <strong>11.1.</strong> Oferecemos suporte técnico através de email e chat durante horário comercial.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>11.2.</strong> O tempo de resposta varia conforme o plano contratado.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">12. Lei Aplicável e Foro</h2>
                <p class="text-gray-700 mb-4">
                    <strong>12.1.</strong> Estes Termos são regidos pelas leis da República Federativa do Brasil.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>12.2.</strong> Fica eleito o foro da comarca de [SUA CIDADE] para dirimir quaisquer 
                    controvérsias decorrentes destes Termos.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">13. Contato</h2>
                <p class="text-gray-700 mb-4">
                    Para dúvidas sobre estes Termos de Uso, entre em contato conosco:
                </p>
                <ul class="list-none pl-0 mb-4 text-gray-700 space-y-2">
                    <li><strong>Email:</strong> contato@imunify.com.br</li>
                    <li><strong>WhatsApp:</strong> (00) 00000-0000</li>
                </ul>

                <div class="mt-12 p-6 bg-primary-50 border-l-4 border-primary-500 rounded">
                    <p class="text-gray-700">
                        <strong>Importante:</strong> Ao utilizar a plataforma Imunify, você declara ter lido, 
                        compreendido e concordado com todos os termos aqui estabelecidos.
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
