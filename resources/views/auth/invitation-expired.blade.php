<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite Expirado - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-red-200 p-8">
            <div class="inline-block bg-gradient-to-r from-red-500 to-orange-500 p-4 rounded-2xl shadow-lg mb-6">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                ⏱️ Convite Expirado
            </h1>
            
            <p class="text-gray-600 mb-8">
                Este link de convite expirou e não pode mais ser usado.
                <br><br>
                Entre em contato com o administrador para receber um novo convite.
            </p>
            
            <a href="{{ route('login') }}" 
                class="inline-block px-8 py-3 bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                ← Voltar para o Login
            </a>
        </div>
    </div>
</body>
</html>
