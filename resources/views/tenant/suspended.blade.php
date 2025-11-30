<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta Suspensa - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Conta Suspensa</h1>
                <p class="text-gray-600">Seu acesso ao sistema está temporariamente bloqueado</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="space-y-4">
                    <div class="border-l-4 border-red-500 bg-red-50 p-4 rounded">
                        <p class="text-sm text-red-800 font-medium mb-2">Por que minha conta foi suspensa?</p>
                        <p class="text-sm text-red-700">
                            Sua conta foi suspensa porque o período de avaliação gratuita e o período de graça expiraram sem a ativação de uma assinatura.
                        </p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 mb-2">📦 Seus dados estão seguros</h3>
                        <p class="text-sm text-blue-800">
                            Todos os seus dados permanecem armazenados com segurança por <strong>30 dias</strong>. 
                            Ao reativar sua conta, tudo estará exatamente como você deixou.
                        </p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="font-semibold text-yellow-900 mb-2">⚠️ Prazo de exclusão</h3>
                        <p class="text-sm text-yellow-800">
                            Após 30 dias de suspensão, sua conta será arquivada. Se não reativar em <strong>90 dias totais</strong>, 
                            todos os dados serão <strong>permanentemente excluídos</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center space-y-3">
                <a href="#" class="block w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Reativar Minha Conta Agora
                </a>
                <p class="text-sm text-gray-500">
                    Precisa de ajuda? 
                    <a href="mailto:suporte@imunify.com.br" class="text-blue-600 hover:text-blue-700 font-medium">
                        Entre em contato
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
