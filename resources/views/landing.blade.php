<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imunify - Sistema de Gestão para Clínicas de Vacinação</title>
    <meta name="description" content="Sistema completo de gestão para clínicas de vacinação. Agendamento online, lembretes automáticos via WhatsApp, controle de estoque e muito mais.">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0' stop-color='%233ebddb'/><stop offset='1' stop-color='%2377ca73'/></linearGradient></defs><path d='M50 10 L85 25 L85 55 C85 75 70 90 50 95 C30 90 15 75 15 55 L15 25 Z' fill='none' stroke='url(%23g)' stroke-width='4'/><ellipse cx='50' cy='50' rx='17' ry='22' fill='url(%23g)' opacity='0.2'/><path d='M37 50 L45 58 L62 38' fill='none' stroke='url(%23g)' stroke-width='4' stroke-linecap='round'/></svg>" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased">

    {{-- Header/Navbar --}}
    <nav class="fixed w-full z-50 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }" 
         @scroll.window="scrolled = window.pageYOffset > 20"
         :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-lg' : 'bg-white/60 backdrop-blur-sm'">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Imunify" class="h-9 transition-all duration-300 group-hover:scale-105">
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#recursos" class="text-gray-600 hover:text-primary-600 font-medium transition-colors relative group">
                        <span>Recursos</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#planos" class="text-gray-600 hover:text-primary-600 font-medium transition-colors relative group">
                        <span>Planos</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#depoimentos" class="text-gray-600 hover:text-primary-600 font-medium transition-colors relative group">
                        <span>Depoimentos</span>
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 transition-all group-hover:w-full"></span>
                    </a>
                    
                    {{-- CTA Buttons --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-primary-600 font-semibold transition-all px-5 py-2 rounded-lg border-2 border-gray-200 hover:border-primary-500 hover:bg-primary-50">
                            Login
                        </a>
                        <a href="{{ route('register.form') }}" 
                           class="relative bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:scale-105 overflow-hidden group">
                            <span class="relative z-10 flex items-center gap-2">
                                <i class="fas fa-rocket text-sm"></i>
                                Começar Grátis
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </a>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" 
                 x-cloak
                 @click.away="mobileOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="lg:hidden border-t border-gray-100 py-4 bg-white/95 backdrop-blur-md">
                <div class="flex flex-col gap-2">
                    <a href="#recursos" @click="mobileOpen = false" class="text-gray-700 hover:text-primary-600 font-medium px-4 py-2.5 rounded-lg hover:bg-primary-50 transition-colors">
                        Recursos
                    </a>
                    <a href="#planos" @click="mobileOpen = false" class="text-gray-700 hover:text-primary-600 font-medium px-4 py-2.5 rounded-lg hover:bg-primary-50 transition-colors">
                        Planos
                    </a>
                    <a href="#depoimentos" @click="mobileOpen = false" class="text-gray-700 hover:text-primary-600 font-medium px-4 py-2.5 rounded-lg hover:bg-primary-50 transition-colors">
                        Depoimentos
                    </a>
                    <div class="h-px bg-gray-200 my-2"></div>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 font-semibold px-4 py-2.5 rounded-lg border-2 border-gray-200 hover:border-primary-500 hover:bg-primary-50 transition-all text-center">
                        Login
                    </a>
                    <a href="{{ route('register.form') }}" class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-6 py-3 rounded-xl font-semibold text-center shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-rocket mr-2"></i>
                        Começar Grátis
                    </a>
                </div>
            </div>
        </div>
    </nav>


    {{-- Hero Section --}}
    <section class="relative pt-24 pb-32 overflow-hidden">
        {{-- Background com gradiente e formas --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-secondary-50"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-br from-primary-100/40 to-secondary-100/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/2 bg-gradient-to-tr from-secondary-100/30 to-primary-100/30 blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Content --}}
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-primary-100 mb-6 hover:scale-105 transition-transform">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-secondary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary-500"></span>
                        </span>
                        <span class="text-sm font-semibold text-gray-700">+500 clínicas já automatizadas</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                        Gerencie sua clínica de 
                        <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-primary-500 to-secondary-500 bg-clip-text text-transparent">vacinação</span>
                            <svg class="absolute -bottom-2 left-0 w-full" height="12" viewBox="0 0 200 12" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 8 Q50 0 100 8 T200 8" stroke="url(#gradient)" stroke-width="3" fill="none"/>
                                <defs>
                                    <linearGradient id="gradient">
                                        <stop offset="0%" stop-color="#3ebddb"/>
                                        <stop offset="100%" stop-color="#77ca73"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>
                        de forma inteligente
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistema completo com <strong>agendamento online</strong>, <strong>lembretes automáticos via WhatsApp</strong>, 
                        controle de estoque e relatórios em tempo real.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ route('register.form') }}" 
                           class="group relative bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl hover:shadow-primary-500/50 transition-all duration-300 hover:scale-105 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <i class="fas fa-rocket"></i>
                                Teste Grátis por 7 Dias
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </a>
                        <a href="#recursos" 
                           class="group bg-white text-gray-700 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-50 transition-all shadow-lg border-2 border-gray-200 hover:border-primary-300">
                            <span class="flex items-center justify-center gap-2">
                                <i class="fas fa-play-circle text-primary-500"></i>
                                Ver Como Funciona
                            </span>
                        </a>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-secondary-500"></i>
                            <span>Sem cartão de crédito</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-secondary-500"></i>
                            <span>Cancele quando quiser</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-secondary-500"></i>
                            <span>Suporte em português</span>
                        </div>
                    </div>
                </div>

                {{-- Image/Dashboard Preview --}}
                <div class="relative hidden lg:block">
                    {{-- Floating cards decorativos --}}
                    <div class="absolute -top-10 -left-10 bg-white rounded-2xl shadow-2xl p-4 transform hover:scale-110 transition-transform z-10 border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-xl">
                                <i class="fas fa-calendar-check text-white"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Agendamentos Hoje</div>
                                <div class="text-2xl font-bold text-gray-900">47</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-10 -right-10 bg-white rounded-2xl shadow-2xl p-4 transform hover:scale-110 transition-transform z-10 border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl">
                                <i class="fab fa-whatsapp text-white"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Lembretes Enviados</div>
                                <div class="text-2xl font-bold text-gray-900">128</div>
                            </div>
                        </div>
                    </div>

                    {{-- Main dashboard image --}}
                    <div class="relative bg-white rounded-2xl shadow-2xl p-6 transform hover:rotate-0 rotate-1 transition-all duration-500 border-4 border-gray-100">
                        <div class="aspect-video bg-gradient-to-br from-primary-50 to-secondary-50 rounded-xl overflow-hidden shadow-inner">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&h=600&fit=crop" 
                                 alt="Dashboard Imunify" 
                                 class="w-full h-full object-cover opacity-90">
                        </div>
                        {{-- Browser chrome decorativo --}}
                        <div class="absolute top-8 left-8 right-8 flex items-center gap-2">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Problemas que Resolve --}}
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
        {{-- Background decorativo --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-200/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">
                    O Poder da Automação
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Pare de perder tempo com <br class="hidden md:block">
                    <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">planilhas e papel</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Automatize sua clínica e foque no que realmente importa: seus pacientes
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Problema --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-red-400 to-red-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl mb-6 shadow-lg shadow-red-500/50">
                            <i class="fas fa-times text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Problema</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Pacientes esquecem das doses de reforço e não comparecem aos agendamentos.
                        </p>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center text-red-600 font-semibold text-sm">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span>Alto índice de faltas</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Solução --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl mb-6 shadow-lg shadow-primary-500/50">
                            <i class="fas fa-check text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Solução</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lembretes automáticos via WhatsApp enviados 7 dias antes, 1 dia antes e no dia do agendamento.
                        </p>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center text-primary-600 font-semibold text-sm">
                                <i class="fab fa-whatsapp mr-2"></i>
                                <span>Automação inteligente</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resultado --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-400 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl mb-6 shadow-lg shadow-blue-500/50">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Resultado</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Redução de 75% em faltas e aumento de 40% na taxa de retorno.
                        </p>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center text-blue-600 font-semibold text-sm">
                                <i class="fas fa-arrow-trend-up mr-2"></i>
                                <span>Crescimento comprovado</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats bar --}}
            <div class="mt-16 bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg border border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                            75%
                        </div>
                        <div class="text-sm text-gray-600">Menos faltas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                            40%
                        </div>
                        <div class="text-sm text-gray-600">Mais retorno</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                            3h
                        </div>
                        <div class="text-sm text-gray-600">Economia/dia</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                            100%
                        </div>
                        <div class="text-sm text-gray-600">Automático</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Recursos --}}
    <section id="recursos" class="py-24 bg-white relative overflow-hidden">
        {{-- Background decorativo --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-100/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-100/20 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-primary-100 to-secondary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">
                    Recursos Completos
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Tudo que você precisa <br class="hidden md:block">
                    <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">em um só lugar</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Ferramentas profissionais para modernizar sua clínica de vacinação
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                {{-- Agendamento Online --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl mb-6 shadow-lg shadow-primary-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Agendamento Online</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Seus pacientes agendam pelo celular 24/7. Você recebe notificação instantânea e confirma com um clique.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Agenda digital completa</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Confirmação automática</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Controle de horários</span>
                        </li>
                    </ul>
                </div>

                {{-- WhatsApp Automático --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl mb-6 shadow-lg shadow-secondary-500/30 group-hover:scale-110 transition-transform">
                        <i class="fab fa-whatsapp text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">WhatsApp Automático</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Envie lembretes automáticos, confirmações e avisos importantes diretamente pelo WhatsApp oficial.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Lembretes de doses</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Confirmação de presença</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Avisos personalizados</span>
                        </li>
                    </ul>
                </div>

                {{-- Controle de Vacinas --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-syringe text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Controle de Vacinas</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Gerencie todo estoque de vacinas, lotes, validades e aplicações em um só sistema.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Controle de estoque</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Rastreamento de lotes</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Alerta de validade</span>
                        </li>
                    </ul>
                </div>

                {{-- Prontuário Digital --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-medical text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Prontuário Digital</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Histórico completo de vacinação de cada paciente, acessível de qualquer dispositivo.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Carteira digital</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Histórico completo</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Acesso mobile</span>
                        </li>
                    </ul>
                </div>

                {{-- Relatórios --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl mb-6 shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-pie text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Relatórios e Analytics</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Visualize dados importantes da sua clínica em tempo real com dashboards intuitivos.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Dashboard em tempo real</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Relatórios personalizados</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Exportação de dados</span>
                        </li>
                    </ul>
                </div>

                {{-- Campanhas --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-2xl mb-6 shadow-lg shadow-primary-400/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-bullhorn text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Campanhas Sazonais</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Crie campanhas de vacinação e envie convites automaticamente para o público-alvo.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Segmentação automática</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Envio em massa</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span>Acompanhamento de resultados</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Planos e Preços --}}
    <section id="planos" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
        {{-- Background decorativo --}}
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-primary-100/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-secondary-100/30 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-primary-100 to-secondary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">
                    Preços Transparentes
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Planos que <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">crescem com você</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Escolha o plano ideal para o tamanho da sua clínica. Cancele quando quiser.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto items-center">
                {{-- Plano Básico --}}
                <div class="group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Básico</h3>
                        <p class="text-gray-600">Para clínicas iniciantes</p>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">R$ 97</span>
                            <span class="text-gray-600">/mês</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Até 2 usuários</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">500 pacientes</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">200 agendamentos/mês</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Agenda digital</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Prontuário digital</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-gray-300 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-400">WhatsApp automático</span>
                        </li>
                    </ul>
                    <a href="{{ route('register.form') }}" class="block w-full bg-gray-100 text-gray-800 text-center py-4 rounded-xl font-semibold hover:bg-gray-200 hover:scale-105 transition-all duration-200">
                        Começar Teste Grátis
                    </a>
                </div>

                {{-- Plano Profissional (DESTAQUE) --}}
                <div class="relative transform md:scale-110">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 z-20">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                            ⭐ MAIS POPULAR
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 rounded-2xl p-8 shadow-2xl shadow-primary-500/30 hover:shadow-primary-500/50 transition-all duration-300">
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-white mb-2">Profissional</h3>
                            <p class="text-primary-100">Para clínicas em crescimento</p>
                        </div>
                        <div class="mb-8">
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-bold text-white">R$ 197</span>
                                <span class="text-primary-100">/mês</span>
                            </div>
                        </div>
                        <ul class="space-y-4 mb-8 text-white">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span>Até 5 usuários</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span>2.000 pacientes</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span>1.000 agendamentos/mês</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span><strong>WhatsApp com número próprio</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span><strong>Lembretes automáticos</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span><strong>Analytics avançado</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
                                <span>Suporte prioritário</span>
                            </li>
                        </ul>
                        <a href="{{ route('register.form') }}" class="block w-full bg-white text-primary-600 text-center py-4 rounded-xl font-bold hover:bg-primary-50 hover:scale-105 transition-all duration-200 shadow-lg">
                            Começar Teste Grátis
                        </a>
                    </div>
                </div>

                {{-- Plano Enterprise --}}
                <div class="group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Enterprise</h3>
                        <p class="text-gray-600">Para grandes redes</p>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">R$ 397</span>
                            <span class="text-gray-600">/mês</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700"><strong>Usuários ilimitados</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">10.000 pacientes</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">5.000 agendamentos/mês</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700"><strong>Multi-unidade</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700"><strong>API completa</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Onboarding personalizado</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-secondary-500 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Gerente de conta dedicado</span>
                        </li>
                    </ul>
                    <a href="{{ route('register.form') }}" class="block w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white text-center py-4 rounded-xl font-semibold hover:from-primary-700 hover:to-secondary-700 hover:scale-105 transition-all duration-200 shadow-lg shadow-primary-600/30">
                        Começar Teste Grátis
                    </a>
                </div>
            </div>

            {{-- Benefícios dos planos --}}
            <div class="mt-16 text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-6 bg-white/80 backdrop-blur-sm rounded-2xl px-8 py-6 shadow-lg">
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-check-circle text-secondary-500"></i>
                        <span class="font-semibold">7 dias de teste grátis</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-check-circle text-secondary-500"></i>
                        <span class="font-semibold">Sem cartão de crédito</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-check-circle text-secondary-500"></i>
                        <span class="font-semibold">Cancele quando quiser</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-check-circle text-secondary-500"></i>
                        <span class="font-semibold">Suporte incluído</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Depoimentos --}}
    <section id="depoimentos" class="py-24 bg-white relative overflow-hidden">
        {{-- Background decorativo --}}
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-secondary-100/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-primary-100/20 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-primary-100 to-secondary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">
                    Casos de Sucesso
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    O que dizem <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">nossos clientes</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Mais de 500 clínicas confiam no Imunify para gerir suas operações
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Depoimento 1 --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center gap-1 mb-6">
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                    </div>
                    <p class="text-gray-700 mb-8 leading-relaxed">
                        "O Imunify revolucionou nossa clínica. Reduzimos faltas em <strong class="text-secondary-600">70%</strong> com os lembretes automáticos. Não consigo mais imaginar trabalhar sem!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            DM
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Dra. Maria Silva</div>
                            <div class="text-sm text-gray-600">Clínica VacinaSP</div>
                        </div>
                    </div>
                </div>

                {{-- Depoimento 2 --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center gap-1 mb-6">
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                    </div>
                    <p class="text-gray-700 mb-8 leading-relaxed">
                        "A integração com WhatsApp é perfeita. Nossos pacientes amam receber os lembretes e a taxa de retorno aumentou <strong class="text-secondary-600">40%</strong>."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            JC
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Dr. João Costa</div>
                            <div class="text-sm text-gray-600">ImunoCare</div>
                        </div>
                    </div>
                </div>

                {{-- Depoimento 3 --}}
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center gap-1 mb-6">
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                    </div>
                    <p class="text-gray-700 mb-8 leading-relaxed">
                        "Sistema intuitivo e fácil de usar. Em <strong class="text-secondary-600">1 dia</strong> já estava operando. O suporte é excelente e sempre rápido para responder."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            AS
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Ana Santos</div>
                            <div class="text-sm text-gray-600">Clínica Saúde Total</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Final --}}
    <section class="py-24 bg-gradient-to-br from-primary-600 via-primary-500 to-secondary-500 text-white relative overflow-hidden">
        {{-- Background animado --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-6">
                    ⚡ Comece em menos de 5 minutos
                </div>
                <h2 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Pronto para modernizar <br class="hidden md:block">sua clínica de vacinação?
                </h2>
                <p class="text-xl md:text-2xl mb-10 text-primary-100">
                    Comece hoje mesmo com <strong class="text-white">7 dias grátis</strong>. Sem cartão de crédito. Cancele quando quiser.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
                    <a href="{{ route('register.form') }}" class="group inline-flex items-center gap-3 bg-white text-primary-600 px-10 py-5 rounded-xl font-bold text-lg hover:bg-primary-50 transition-all duration-200 shadow-2xl hover:scale-105">
                        <i class="fas fa-rocket group-hover:rotate-45 transition-transform"></i>
                        Criar Minha Clínica Agora
                    </a>
                    <a href="#recursos" class="inline-flex items-center gap-2 text-white border-2 border-white/50 px-8 py-5 rounded-xl font-semibold text-lg hover:bg-white/10 transition-all duration-200">
                        <i class="fas fa-play-circle"></i>
                        Ver Como Funciona
                    </a>
                </div>

                {{-- Trust badges --}}
                <div class="flex flex-wrap items-center justify-center gap-8 text-primary-100">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-2xl"></i>
                        <span>7 dias grátis</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-2xl"></i>
                        <span>Dados seguros</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-headset text-2xl"></i>
                        <span>Suporte dedicado</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-2xl"></i>
                        <span>+500 clínicas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 relative overflow-hidden">
        {{-- Gradient border top --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500"></div>
        
        <div class="container mx-auto px-4 py-16">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                {{-- Logo e descrição --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Imunify" class="h-8">
                    </div>
                    <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                        Sistema completo de gestão para clínicas de vacinação. Moderno, seguro e fácil de usar.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-primary-600 hover:to-secondary-600 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-primary-600 hover:to-secondary-600 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-primary-600 hover:to-secondary-600 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-primary-600 hover:to-secondary-600 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                {{-- Produto --}}
                <div>
                    <h4 class="font-bold text-white mb-4 text-lg">Produto</h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="#recursos" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Recursos</span>
                            </a>
                        </li>
                        <li>
                            <a href="#planos" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Planos e Preços</span>
                            </a>
                        </li>
                        <li>
                            <a href="#depoimentos" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Casos de Sucesso</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Segurança</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Integrações</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Empresa --}}
                <div>
                    <h4 class="font-bold text-white mb-4 text-lg">Empresa</h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Sobre Nós</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Carreiras</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Contato</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Parcerias</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Suporte e Legal --}}
                <div>
                    <h4 class="font-bold text-white mb-4 text-lg">Suporte</h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Central de Ajuda</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Documentação</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Status do Sistema</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Termos de Uso</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.terms') }}" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Termos de Uso</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.privacy') }}" class="text-gray-400 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                                <span class="group-hover:translate-x-1 transition-transform">Política de Privacidade</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">
                        &copy; 2025 <span class="text-white font-semibold">Imunify</span>. Todos os direitos reservados.
                    </p>
                    <div class="flex items-center gap-6 text-sm text-gray-500">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-shield-alt text-secondary-500"></i>
                            100% Seguro
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-lock text-secondary-500"></i>
                            LGPD Compliance
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-heart text-red-500"></i>
                            Feito no Brasil
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
