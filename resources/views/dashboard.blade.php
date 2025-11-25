<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ tenant('clinic_name') ?? 'Clínica' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        {{ tenant('clinic_name') ?? 'Dashboard' }}
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Olá, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Dashboard
                    </h2>
                    <p class="text-gray-600">
                        Você está logado! Bem-vindo ao sistema {{ tenant('clinic_name') ?? 'de vacinação' }}.
                    </p>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid md:grid-cols-4 gap-6">
                
                <!-- Pacientes -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pacientes</h3>
                            <p class="text-gray-600 text-sm">Gerenciar</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pacientes.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            Ver todos →
                        </a>
                    </div>
                </div>

                <!-- Agendamentos -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Agenda</h3>
                            <p class="text-gray-600 text-sm">Agendamentos</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('agenda.index') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">
                            Ver agenda →
                        </a>
                    </div>
                </div>

                <!-- Vacinas -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Vacinas</h3>
                            <p class="text-gray-600 text-sm">Cadastro</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('vacinas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                            Gerenciar →
                        </a>
                    </div>
                </div>

                <!-- Atendimentos -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Atendimentos</h3>
                            <p class="text-gray-600 text-sm">Histórico</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('atendimentos.index') }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">
                            Ver todos →
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
