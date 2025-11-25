<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->clinic_name ?? 'Clínica' }} - Sistema de Vacinação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Cores customizadas serão implementadas depois -->
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo/Nome da Clínica -->
                <div class="flex items-center space-x-3">
                    @if($tenant->clinic_logo)
                        <img src="{{ $tenant->clinic_logo }}" alt="{{ $tenant->clinic_name }}" class="h-10 w-auto">
                    @else
                        <div class="h-10 w-10 bg-primary-500 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $tenant->clinic_name ?? 'Clínica de Vacinação' }}</h1>
                        @if($tenant->clinic_subtitle)
                            <p class="text-sm text-gray-600">{{ $tenant->clinic_subtitle }}</p>
                        @endif
                    </div>
                </div>

                <!-- Menu de Navegação -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#sobre" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Sobre</a>
                    <a href="#servicos" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Serviços</a>
                    <a href="#contato" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Contato</a>
                    <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Acesso da Equipe
                    </a>
                </nav>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button class="text-gray-600 hover:text-primary-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-50 to-blue-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Conteúdo -->
                <div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Sua saúde em 
                        <span class="text-primary-500">boas mãos</span>
                    </h2>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        {{ $tenant->clinic_description ?? 'Oferecemos serviços completos de vacinação com tecnologia moderna e atendimento humanizado.' }}
                    </p>

                    <!-- Informações da Clínica -->
                    @if($tenant->contact_info)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="h-5 w-5 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Informações de Contato
                        </h3>
                        <div class="text-gray-600 whitespace-pre-line">{{ $tenant->contact_info }}</div>
                    </div>
                    @endif

                    <!-- Botões de Ação -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors text-center">
                            Portal da Equipe
                        </a>
                        <a href="#servicos" class="border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white px-8 py-3 rounded-lg font-semibold transition-colors text-center">
                            Nossos Serviços
                        </a>
                    </div>
                </div>

                <!-- Imagem -->
                <div class="relative">
                    <div class="bg-primary-500 rounded-2xl shadow-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&h=400&fit=crop" 
                             alt="Vacinação" 
                             class="w-full h-80 object-cover opacity-90">
                    </div>
                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-xl p-6 shadow-lg border border-gray-200 hidden lg:block">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Vacinação Segura</p>
                                <p class="text-sm text-gray-600">Protocolos rigorosos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="servicos" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Nossos Serviços</h3>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Oferecemos uma ampla gama de serviços de vacinação com tecnologia moderna.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Serviço 1 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl">
                    <div class="bg-primary-100 p-4 rounded-full w-16 h-16 mx-auto mb-6 flex items-center justify-center">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Vacinação Geral</h4>
                    <p class="text-gray-600">Vacinas para todas as idades seguindo o calendário oficial.</p>
                </div>

                <!-- Serviço 2 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl">
                    <div class="bg-primary-100 p-4 rounded-full w-16 h-16 mx-auto mb-6 flex items-center justify-center">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Carteira Digital</h4>
                    <p class="text-gray-600">Acesso digital ao histórico de vacinação completo.</p>
                </div>

                <!-- Serviço 3 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl">
                    <div class="bg-primary-100 p-4 rounded-full w-16 h-16 mx-auto mb-6 flex items-center justify-center">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Lembretes Automáticos</h4>
                    <p class="text-gray-600">Notificações para não esquecer das próximas doses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">{{ $tenant->clinic_name ?? 'Clínica' }}</h4>
                    <p class="text-gray-300 mb-4">
                        {{ $tenant->clinic_description ?? 'Cuidando da sua saúde com tecnologia e humanização.' }}
                    </p>
                </div>
                
                @if($tenant->contact_info)
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contato</h4>
                    <div class="text-gray-300 whitespace-pre-line">{{ $tenant->contact_info }}</div>
                </div>
                @endif

                <div>
                    <h4 class="text-lg font-semibold mb-4">Acesso Rápido</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">Portal da Equipe</a></li>
                        <li><a href="#servicos" class="text-gray-300 hover:text-white transition-colors">Serviços</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 mt-8 text-center">
                <p class="text-gray-400">
                    © {{ date('Y') }} {{ $tenant->clinic_name ?? 'Clínica' }}. 
                    Powered by <span class="text-primary-500 font-semibold">Imunify</span>
                </p>
            </div>
        </div>
    </footer>

</body>
</html>