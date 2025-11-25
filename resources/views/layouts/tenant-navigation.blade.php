@php
    // Itens principais (sempre visíveis no desktop)
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

    // Menu "Mais" com itens secundários organizados por seção
    $moreMenuItems = [
        [
            'label' => 'Cadastros',
            'type' => 'section',
            'items' => [
                ['label' => 'Pacientes', 'route' => 'pacientes.index', 'active' => 'pacientes.*', 'icon' => '👥'],
                ['label' => 'Vacinas', 'route' => 'vacinas.index', 'active' => 'vacinas.*', 'icon' => '💉'],
                ['label' => 'Campanhas', 'route' => 'campanhas.index', 'active' => 'campanhas.*', 'icon' => '⭐'],
            ]
        ],
        [
            'label' => 'Comunicação',
            'type' => 'section',
            'items' => [
                ['label' => 'Notificações', 'route' => 'notificacoes.index', 'active' => 'notificacoes.*', 'icon' => '💬'],
                ['label' => 'Ajuda', 'route' => 'ajuda.index', 'active' => 'ajuda.*', 'icon' => '❓'],
            ]
        ],
    ];

    $isMoreMenuActive = request()->routeIs('pacientes.*', 'vacinas.*', 'campanhas.*', 'notificacoes.*', 'ajuda.*');
@endphp

<nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-bold">{{ tenant('clinic_name') ?? 'MultiImune' }}</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden lg:flex items-center space-x-1">
                <!-- Links principais -->
                @foreach ($mainNavLinks as $link)
                    @php $isActive = request()->routeIs($link['active']); @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 transition-colors {{ $isActive ? 'bg-white/20 ring-2 ring-white/30' : '' }}">
                        {!! $link['icon'] !!}
                        <span class="font-medium text-sm whitespace-nowrap">{{ $link['label'] }}</span>
                    </a>
                @endforeach

                <!-- Menu "Mais" -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 transition-colors {{ $isMoreMenuActive ? 'bg-white/20 ring-2 ring-white/30' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="font-medium text-sm whitespace-nowrap">Mais</span>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Mega Dropdown -->
                    <div class="absolute top-full right-0 mt-1 w-64 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-100">
                        <div class="p-2">
                            @foreach($moreMenuItems as $section)
                                <div class="mb-3 last:mb-0">
                                    <div class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        {{ $section['label'] }}
                                    </div>
                                    <div class="space-y-1">
                                        @foreach($section['items'] as $item)
                                            @php $isItemActive = request()->routeIs($item['active']); @endphp
                                            <a href="{{ route($item['route']) }}" 
                                               class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors group/item {{ $isItemActive ? 'bg-blue-50 text-blue-600' : '' }}">
                                                <span class="text-xl">{{ $item['icon'] }}</span>
                                                <span class="font-medium text-sm group-hover/item:text-blue-600">{{ $item['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-3">
                <span class="hidden lg:block text-sm font-medium">Olá, {{ auth()->user()->name }}</span>
                
                <!-- Botão hamburguer mobile -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden p-2 rounded-lg hover:bg-white/20 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Sair
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-white/20 pb-3">
            <div class="pt-3 space-y-2">
                <!-- Links principais -->
                @foreach ($mainNavLinks as $link)
                    @php $isActive = request()->routeIs($link['active']); @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 transition-colors text-sm {{ $isActive ? 'bg-white/20 ring-1 ring-white/30' : '' }}">
                        {!! $link['icon'] !!}
                        <span class="font-medium">{{ $link['label'] }}</span>
                    </a>
                @endforeach

                <!-- Seções do menu "Mais" -->
                @foreach($moreMenuItems as $section)
                    <div class="space-y-1 pt-2">
                        <div class="px-3 py-2 text-xs font-bold text-white/70 uppercase tracking-wider">
                            {{ $section['label'] }}
                        </div>
                        @foreach($section['items'] as $item)
                            @php $isItemActive = request()->routeIs($item['active']); @endphp
                            <a href="{{ route($item['route']) }}" 
                               class="flex items-center gap-3 px-3 py-2 ml-2 rounded-lg hover:bg-white/20 transition-colors text-sm {{ $isItemActive ? 'bg-white/20' : '' }}">
                                <span class="text-lg">{{ $item['icon'] }}</span>
                                <span class="font-medium">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach

                <!-- Botão Sair (mobile) -->
                <div class="pt-3 border-t border-white/20 mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>