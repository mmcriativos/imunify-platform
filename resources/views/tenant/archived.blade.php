<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta Arquivada - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Conta Arquivada</h1>
                <p class="text-gray-600">Sua conta está em processo de exclusão</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="space-y-4">
                    <div class="border-l-4 border-gray-500 bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-800 font-medium mb-2">Status da conta</p>
                        <p class="text-sm text-gray-700">
                            Sua conta foi arquivada após 30 dias de suspensão sem reativação.
                        </p>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h3 class="font-semibold text-red-900 mb-2">🚨 Última chance!</h3>
                        <p class="text-sm text-red-800 mb-3">
                            Seus dados serão <strong>permanentemente excluídos</strong> em breve. 
                            Esta é a última oportunidade de recuperar suas informações.
                        </p>
                        <p class="text-xs text-red-700 font-medium">
                            ⏰ Após a exclusão, não será possível recuperar nenhum dado.
                        </p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 mb-2">💾 Recupere seus dados</h3>
                        <p class="text-sm text-blue-800">
                            Reative sua conta agora para restaurar todos os seus pacientes, agendamentos, 
                            históricos de vacinação e configurações.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center space-y-3">
                <a href="#" class="block w-full bg-red-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-red-700 transition-colors">
                    Recuperar Minha Conta Agora
                </a>
                <p class="text-sm text-gray-500">
                    Precisa de ajuda urgente? 
                    <a href="mailto:suporte@imunify.com.br" class="text-blue-600 hover:text-blue-700 font-medium">
                        Fale com o suporte
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
