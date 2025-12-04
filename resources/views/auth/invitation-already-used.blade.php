<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite Já Utilizado - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-green-200 p-8">
            <div class="inline-block bg-gradient-to-r from-green-500 to-blue-500 p-4 rounded-2xl shadow-lg mb-6">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                ✓ Convite Já Aceito
            </h1>
            
            <p class="text-gray-600 mb-8">
                Este convite já foi utilizado para criar uma conta.
                <br><br>
                Se você já criou sua conta, faça login abaixo.
            </p>
            
            <a href="{{ route('login') }}" 
                class="inline-block px-8 py-3 bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                Fazer Login →
            </a>
        </div>
    </div>
</body>
</html>
