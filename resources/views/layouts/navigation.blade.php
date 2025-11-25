@php
    // Itens principais (sempre visíveis)
    $mainNavLinks = [
        [
            'label' => 'Início',
            'route' => 'dashboard',
            'active' => 'dashboard',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
        ],
        [
            'label' => 'Atendimentos',
            'route' => 'atendimentos.index',
            'active' => 'atendimentos.*',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
        ],
        [
            'label' => 'Agenda',
            'route' => 'agenda.index',
            'active' => 'agenda.*',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
        ],
        [
            'label' => 'Financeiro',
            'route' => 'financeiro.dashboard',
            'active' => 'financeiro.*',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
    ];

    // Menu "Mais" com itens secundários
    $moreMenuItems = [
        [
            'label' => 'Cadastros',
            'type' => 'section',
            'items' => [
                ['label' => 'Pacientes', 'route' => 'pacientes.index', 'icon' => '👤'],
                ['label' => 'Vacinas', 'route' => 'vacinas.index', 'icon' => '💉'],
                ['label' => 'Cidades', 'route' => 'cidades.index', 'icon' => '📍'],
            ]
        ],
        [
            'label' => 'Notificações',
            'type' => 'section',
            'items' => [
                ['label' => 'Lembretes', 'route' => 'lembretes.index', 'icon' => '🔔'],
                ['label' => 'Analytics', 'route' => 'lembretes.analytics', 'icon' => '📊'],
                ['label' => 'Confirmações', 'route' => 'confirmacoes.index', 'icon' => '✅'],
            ]
        ],
        [
            'label' => 'Integrações',
            'type' => 'section',
            'items' => [
                ['label' => 'SIPNI', 'route' => 'sipni.config', 'icon' => '🏥', 'badge' => 'Premium'],
                ['label' => 'WhatsApp', 'route' => 'whatsapp.config', 'icon' => '💬'],
            ]
        ],
    ];

    $isMoreMenuActive = request()->routeIs('pacientes.*', 'vacinas.*', 'cidades.*', 'lembretes.*', 'confirmacoes.*', 'sipni.*', 'whatsapp.*', 'financeiro.*');
@endphp

<nav class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white border-b-4 border-blue-400/30 shadow-[0_20px_40px_-24px_rgba(15,23,42,0.45)]" style="margin: 0; padding: 0;">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <!-- Logo e Brand -->
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 sm:gap-3 group">
                    <div class="bg-white/20 backdrop-blur-sm p-2 sm:p-2.5 rounded-lg sm:rounded-xl shadow-lg ring-2 ring-white/30 group-hover:ring-white/50 transition-all duration-300 group-hover:scale-110">
                        <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-lg sm:text-2xl font-extrabold tracking-tight drop-shadow-lg">MultiImune</span>
                        <p class="text-blue-200 text-xs font-medium hidden md:block">Sistema de Vacinação</p>
                    </div>
                </a>

                <!-- Links de navegação desktop -->
                <div class="hidden lg:flex items-center space-x-1 ml-4">
                    <!-- Links principais -->
                    @foreach ($mainNavLinks as $link)
                        @php $isActive = request()->routeIs($link['active']); @endphp
                        <a href="{{ route($link['route']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-300 {{ $isActive ? 'bg-white/20 ring-2 ring-white/30' : '' }}">
                            {!! $link['icon'] !!}
                            <span class="font-semibold text-sm whitespace-nowrap">{{ $link['label'] }}</span>
                        </a>
                    @endforeach

                    <!-- Menu "Mais" -->
                    <div class="relative group">
                        <button type="button" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-300 {{ $isMoreMenuActive ? 'bg-white/20 ring-2 ring-white/30' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <span class="font-semibold text-sm whitespace-nowrap">Mais</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Mega Dropdown -->
                        <div class="absolute top-full right-0 mt-1 w-72 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-100">
                            <div class="p-2">
                                @foreach($moreMenuItems as $section)
                                    <div class="mb-3 last:mb-0">
                                        <div class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            {{ $section['label'] }}
                                        </div>
                                        <div class="space-y-1">
                                            @foreach($section['items'] as $item)
                                                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors group/item">
                                                    <span class="text-xl">{{ $item['icon'] }}</span>
                                                    <span class="font-medium text-sm group-hover/item:text-blue-600 flex-1">{{ $item['label'] }}</span>
                                                    @if(isset($item['badge']))
                                                        <span class="px-2 py-0.5 text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full">
                                                            {{ $item['badge'] }}
                                                        </span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions à direita -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Notificações -->
                <button class="relative p-2 rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-300 group" type="button">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full border-2 border-blue-700 animate-pulse"></span>
                </button>

                <!-- Menu hamburguer mobile -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-300" type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Botão Sair (desktop) -->
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-white text-indigo-700 font-semibold shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-50 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 10-6 0v1"></path>
                            </svg>
                            <span>Sair</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Menu mobile dropdown -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-white/10 bg-blue-700/50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-3 py-4 space-y-2">
            <!-- Links principais -->
            @foreach ($mainNavLinks as $link)
                @php $isActive = request()->routeIs($link['active']); @endphp
                <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/20 transition-all {{ $isActive ? 'bg-white/20 ring-1 ring-white/30' : 'bg-white/5' }}">
                    {!! $link['icon'] !!}
                    <span class="font-semibold">{{ $link['label'] }}</span>
                </a>
            @endforeach

            <!-- Seções do menu "Mais" -->
            @foreach($moreMenuItems as $section)
                <div class="space-y-1 pt-2">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg font-bold text-xs uppercase tracking-wider">
                        <span>{{ $section['label'] }}</span>
                    </div>
                    @foreach($section['items'] as $item)
                        <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-4 py-3 ml-4 rounded-lg hover:bg-white/20 transition-all bg-white/5">
                            <span class="text-lg">{{ $item['icon'] }}</span>
                            <span class="font-semibold text-sm flex-1">{{ $item['label'] }}</span>
                            @if(isset($item['badge']))
                                <span class="px-2 py-0.5 text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
            
            @auth
                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-white text-indigo-700 font-semibold shadow-lg hover:bg-blue-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 10-6 0v1"></path>
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>
