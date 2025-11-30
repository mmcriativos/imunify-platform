<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinatura Necessária - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Continue Usando o ImuniFy</h1>
                <p class="text-gray-600">Seu período de avaliação gratuita terminou</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="space-y-4">
                    <div class="text-center py-4">
                        <p class="text-gray-700 mb-4">
                            Para continuar gerenciando suas vacinas, pacientes e agendamentos, 
                            escolha um plano que se adapte às suas necessidades.
                        </p>
                    </div>

                    <!-- Plano destaque -->
                    <div class="border-2 border-blue-600 rounded-lg p-4 bg-blue-50">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Plano Profissional</h3>
                                <p class="text-sm text-gray-600">Mais popular</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600">R$ 97</div>
                                <div class="text-xs text-gray-600">/mês</div>
                            </div>
                        </div>
                        <ul class="space-y-2 mb-4">
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pacientes ilimitados
                            </li>
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Lembretes automáticos via WhatsApp
                            </li>
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Integração com SIPNI
                            </li>
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Suporte prioritário
                            </li>
                        </ul>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">
                            <strong>🎁 Oferta especial:</strong> Ative agora e ganhe 20% de desconto no primeiro mês!
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center space-y-3">
                <a href="#" class="block w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Ativar Assinatura Agora
                </a>
                <a href="#" class="block w-full text-gray-600 font-medium py-2 hover:text-gray-800 transition-colors">
                    Ver Todos os Planos
                </a>
                <p class="text-sm text-gray-500">
                    Dúvidas? 
                    <a href="mailto:vendas@imunify.com.br" class="text-blue-600 hover:text-blue-700 font-medium">
                        Fale com nossa equipe
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
