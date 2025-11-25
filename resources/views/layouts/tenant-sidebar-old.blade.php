@php
    $menuItems = [
        [
            'section' => 'Principal',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => 'dashboard',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                ],
                [
                    'label' => 'Agenda',
                    'route' => 'agenda.index',
                    'active' => 'agenda.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
                ],
                [
                    'label' => 'Atendimentos',
                    'route' => 'atendimentos.index',
                    'active' => 'atendimentos.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
                ],
            ]
        ],
        [
            'section' => 'Financeiro',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'financeiro.dashboard',
                    'active' => 'financeiro.dashboard',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                ],
                [
                    'label' => 'Caixa',
                    'route' => 'financeiro.caixa.index',
                    'active' => 'financeiro.caixa.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                ],
                [
                    'label' => 'Lançamentos',
                    'route' => 'financeiro.lancamentos.index',
                    'active' => 'financeiro.lancamentos.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                ],
                [
                    'label' => 'Categorias',
                    'route' => 'financeiro.categorias.index',
                    'active' => 'financeiro.categorias.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>',
                ],
                [
                    'label' => 'Formas de Pagamento',
                    'route' => 'financeiro.formas-pagamento.index',
                    'active' => 'financeiro.formas-pagamento.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                ],
            ]
        ],
        [
            'section' => 'Cadastros',
            'items' => [
                [
                    'label' => 'Pacientes',
                    'route' => 'pacientes.index',
                    'active' => 'pacientes.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                ],
                [
                    'label' => 'Vacinas',
                    'route' => 'vacinas.index',
                    'active' => 'vacinas.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
                ],
                [
                    'label' => 'Campanhas',
                    'route' => 'campanhas.index',
                    'active' => 'campanhas.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>',
                ],
            ]
        ],
        [
            'section' => 'Comunicação',
            'items' => [
                [
                    'label' => 'Notificações',
                    'route' => 'notificacoes.index',
                    'active' => 'notificacoes.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>',
                ],
                [
                    'label' => 'Central de Ajuda',
                    'route' => 'ajuda.index',
                    'active' => 'ajuda.*',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                ],
            ]
        ],
    ];
@endphp

<!-- Sidebar para Desktop -->
<aside 
    class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:z-50 lg:w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white"
    x-data="{ openSections: {} }"
>
    <!-- Logo -->
    <div class="flex items-center gap-3 px-6 py-5 border-b border-blue-700">
        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-bold">{{ tenant('clinic_name') ?? 'MultiImune' }}</h2>
            <p class="text-xs text-blue-200">Gestão Completa</p>
        </div>
    </div>

    <!-- Menu de Navegação -->
    <nav class="flex-1 px-3 py-4 overflow-y-auto">
        @foreach($menuItems as $group)
            <div class="mb-6">
                <h3 class="px-3 mb-2 text-xs font-semibold text-blue-300 uppercase tracking-wider">
                    {{ $group['section'] }}
                </h3>
                <ul class="space-y-1">
                    @foreach($group['items'] as $item)
                        <li>
                            <a 
                                href="{{ route($item['route']) }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs($item['active']) ? 'bg-blue-700 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-700/50' }}"
                            >
                                <span class="{{ request()->routeIs($item['active']) ? 'text-white' : 'text-blue-300' }}">
                                    {!! $item['icon'] !!}
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <!-- Usuário -->
    <div class="px-3 py-4 border-t border-blue-700">
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="flex items-center justify-center w-9 h-9 bg-blue-600 rounded-full">
                <span class="text-sm font-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                <p class="text-xs text-blue-300 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700/50 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sair
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Header -->
<div class="lg:hidden sticky top-0 z-40 flex items-center gap-4 px-4 py-3 bg-gradient-to-r from-blue-900 to-blue-800 text-white shadow-lg">
    <button 
        @click="$store.sidebar.toggle()" 
        class="p-2 rounded-lg hover:bg-blue-700 transition"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="flex-1">
        <h1 class="text-lg font-bold">{{ tenant('clinic_name') ?? 'MultiImune' }}</h1>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-sm hidden sm:inline">{{ auth()->user()->name ?? '' }}</span>
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
            <span class="text-xs font-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div 
    x-show="$store.sidebar.isOpen" 
    @click="$store.sidebar.close()"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="lg:hidden fixed inset-0 z-50 bg-black/50"
    style="display: none;"
></div>

<aside 
    x-show="$store.sidebar.isOpen"
    @click.away="$store.sidebar.close()"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="lg:hidden fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white overflow-y-auto"
    style="display: none;"
>
    <!-- Logo -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-blue-700">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold">{{ tenant('clinic_name') ?? 'MultiImune' }}</h2>
                <p class="text-xs text-blue-200">Gestão Completa</p>
            </div>
        </div>
        <button @click="$store.sidebar.close()" class="p-1 hover:bg-blue-700 rounded">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Menu de Navegação Mobile -->
    <nav class="px-3 py-4">
        @foreach($menuItems as $group)
            <div class="mb-6">
                <h3 class="px-3 mb-2 text-xs font-semibold text-blue-300 uppercase tracking-wider">
                    {{ $group['section'] }}
                </h3>
                <ul class="space-y-1">
                    @foreach($group['items'] as $item)
                        <li>
                            <a 
                                href="{{ route($item['route']) }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs($item['active']) ? 'bg-blue-700 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-700/50' }}"
                            >
                                <span class="{{ request()->routeIs($item['active']) ? 'text-white' : 'text-blue-300' }}">
                                    {!! $item['icon'] !!}
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <!-- Usuário Mobile -->
    <div class="px-3 py-4 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700/50 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sair
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            isOpen: false,
            toggle() {
                this.isOpen = !this.isOpen;
            },
            close() {
                this.isOpen = false;
            }
        });
    });
</script>
