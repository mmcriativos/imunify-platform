<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviço Indisponível - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Serviço Temporariamente Indisponível</h1>
                <p class="text-gray-600">Estamos com dificuldades para acessar seus dados</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="space-y-4">
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800 font-medium">
                                    O sistema não conseguiu estabelecer conexão com o banco de dados desta conta.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="font-semibold text-gray-900">Possíveis causas:</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Manutenção temporária do sistema
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Problema de configuração da conta
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Conta ainda não foi completamente configurada
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                        <h3 class="font-semibold text-blue-900 mb-2">O que fazer?</h3>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800">
                            <li>Aguarde alguns minutos e tente novamente</li>
                            <li>Verifique se digitou o endereço corretamente</li>
                            <li>Se o problema persistir, entre em contato com o suporte</li>
                        </ol>
                    </div>

                    @if(isset($tenant))
                    <div class="border-t pt-4 mt-4">
                        <p class="text-xs text-gray-500">
                            <strong>ID da Conta:</strong> {{ $tenant->id }}<br>
                            <strong>Domínio:</strong> {{ request()->getHost() }}<br>
                            <strong>Código do Erro:</strong> DB_CONNECTION_FAILED
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center space-y-3">
                <button onclick="window.location.reload()" 
                        class="block w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Tentar Novamente
                </button>
                <a href="/" class="block text-gray-600 hover:text-gray-800 font-medium">
                    Voltar para Página Inicial
                </a>
                <p class="text-sm text-gray-500">
                    Precisa de ajuda urgente? 
                    <a href="mailto:suporte@imunify.com.br" class="text-blue-600 hover:text-blue-700 font-medium">
                        suporte@imunify.com.br
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
