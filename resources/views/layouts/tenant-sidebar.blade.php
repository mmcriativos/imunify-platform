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
            'section' => 'Configurações',
            'permission' => 'manage_users', // Apenas admin pode ver esta seção
            'items' => [
                [
                    'label' => 'Usuários',
                    'route' => 'users.index',
                    'active' => 'users.*',
                    'permission' => 'manage_users',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                    'badge' => function() {
                        $tenant = tenant();
                        $plan = $tenant->plan;
                        $maxUsers = $plan->max_users ?? 1;
                        $currentUsers = \App\Models\User::where('is_active', true)->count();
                        return $currentUsers . '/' . $maxUsers;
                    },
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
    class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:z-50 lg:w-64 bg-gradient-to-br from-[#2a9fb8] via-[#3ebddb] to-[#5bc9d4] text-white shadow-2xl"
    x-data="{ openSections: {} }"
>
    <!-- Logo Premium -->
    <div class="flex items-center gap-3 px-5 py-6 border-b border-white/20">
        <div class="flex items-center justify-center w-12 h-12 bg-white/25 rounded-2xl backdrop-blur-md shadow-lg border border-white/30">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-black tracking-tight">{{ tenant('clinic_name') ?? 'Imunify' }}</h2>
            <p class="text-xs text-white/80 font-medium">Gestão Inteligente</p>
        </div>
    </div>

    <!-- Menu de Navegação -->
    <nav class="flex-1 px-4 py-4 overflow-y-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
        @foreach($menuItems as $group)
            {{-- Verificar se usuário tem permissão para ver a seção --}}
            @if(!isset($group['permission']) || auth()->user()->hasPermission($group['permission']))
                <div class="mb-6">
                    <h3 class="px-3 mb-3 text-xs font-extrabold text-white/60 uppercase tracking-wider">
                        {{ $group['section'] }}
                    </h3>
                    <ul class="space-y-1.5">
                        @foreach($group['items'] as $item)
                            {{-- Verificar se usuário tem permissão para ver o item --}}
                            @if(!isset($item['permission']) || auth()->user()->hasPermission($item['permission']))
                                <li>
                                    <a 
                                        href="{{ route($item['route']) }}" 
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group
                                            {{ request()->routeIs($item['active']) 
                                                ? 'bg-white text-[#3ebddb] shadow-lg transform scale-[1.02]' 
                                                : 'text-white/90 hover:bg-white/20 hover:text-white hover:translate-x-1' }}"
                                    >
                                        <span class="{{ request()->routeIs($item['active']) ? 'text-[#3ebddb]' : 'text-white/80 group-hover:text-white' }}">
                                            {!! $item['icon'] !!}
                                        </span>
                                        <span class="flex-1">{{ $item['label'] }}</span>
                                        @if(isset($item['badge']))
                                            <span class="px-2 py-0.5 text-xs font-bold {{ request()->routeIs($item['active']) ? 'bg-[#3ebddb] text-white' : 'bg-white/20 text-white' }} rounded-full">
                                                {{ is_callable($item['badge']) ? $item['badge']() : $item['badge'] }}
                                            </span>
                                        @endif
                                        @if(request()->routeIs($item['active']))
                                            <div class="w-2 h-2 bg-[#77ca73] rounded-full shadow-lg"></div>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    <!-- Usuário -->
    <div class="px-4 py-5 border-t border-white/20">
        <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-white/20 backdrop-blur-md border border-white/20 shadow-lg mb-3">
            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-[#77ca73] to-[#63b55f] rounded-xl shadow-md">
                <span class="text-base font-black text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                <p class="text-xs text-white/70 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-sm font-semibold text-white/90 hover:bg-red-500/30 hover:text-white rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sair
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Header -->
<div class="lg:hidden sticky top-0 z-40 flex items-center gap-4 px-4 py-3 bg-gradient-to-r from-[#2a9fb8] to-[#3ebddb] text-white shadow-xl">
    <button 
        @click="$store.sidebar.toggle()" 
        class="p-2 rounded-xl hover:bg-white/20 transition-all"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="flex-1">
        <h1 class="text-lg font-black">{{ tenant('clinic_name') ?? 'Imunify' }}</h1>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-sm font-medium hidden sm:inline">{{ auth()->user()->name ?? '' }}</span>
        <div class="w-9 h-9 bg-gradient-to-br from-[#77ca73] to-[#63b55f] rounded-xl flex items-center justify-center shadow-md">
            <span class="text-sm font-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
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
    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 lg:hidden"
    style="display: none;"
>
    <div 
        @click.stop
        x-show="$store.sidebar.isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="w-64 h-full bg-gradient-to-br from-[#2a9fb8] via-[#3ebddb] to-[#5bc9d4] shadow-2xl flex flex-col"
    >
        <!-- Logo Mobile -->
        <div class="flex items-center gap-3 px-5 py-6 border-b border-white/20">
            <div class="flex items-center justify-center w-12 h-12 bg-white/25 rounded-2xl backdrop-blur-md shadow-lg border border-white/30">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black">{{ tenant('clinic_name') ?? 'Imunify' }}</h2>
                <p class="text-xs text-white/80 font-medium">Gestão Inteligente</p>
            </div>
        </div>

        <!-- Menu Mobile -->
        <nav class="flex-1 px-4 py-4 overflow-y-auto">
            @foreach($menuItems as $group)
                {{-- Verificar permissão para seção --}}
                @if(!isset($group['permission']) || auth()->user()->hasPermission($group['permission']))
                    <div class="mb-6">
                        <h3 class="px-3 mb-3 text-xs font-extrabold text-white/60 uppercase tracking-wider">
                            {{ $group['section'] }}
                        </h3>
                        <ul class="space-y-1.5">
                            @foreach($group['items'] as $item)
                                {{-- Verificar permissão para item --}}
                                @if(!isset($item['permission']) || auth()->user()->hasPermission($item['permission']))
                                    <li>
                                        <a 
                                            href="{{ route($item['route']) }}" 
                                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all
                                                {{ request()->routeIs($item['active']) 
                                                    ? 'bg-white text-[#3ebddb] shadow-lg' 
                                                    : 'text-white/90 hover:bg-white/20' }}"
                                        >
                                            <span class="{{ request()->routeIs($item['active']) ? 'text-[#3ebddb]' : 'text-white/80' }}">
                                                {!! $item['icon'] !!}
                                            </span>
                                            <span class="flex-1">{{ $item['label'] }}</span>
                                            @if(isset($item['badge']))
                                                <span class="px-2 py-0.5 text-xs font-bold {{ request()->routeIs($item['active']) ? 'bg-[#3ebddb] text-white' : 'bg-white/20 text-white' }} rounded-full">
                                                    {{ is_callable($item['badge']) ? $item['badge']() : $item['badge'] }}
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
        </nav>

        <!-- User Mobile -->
        <div class="px-4 py-5 border-t border-white/20">
            <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-white/20 backdrop-blur-md mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#77ca73] to-[#63b55f] rounded-xl flex items-center justify-center shadow-md">
                    <span class="text-base font-black text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                    <p class="text-xs text-white/70 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-sm font-semibold text-white/90 hover:bg-red-500/30 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('sidebar', {
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        close() {
            this.isOpen = false;
        },
        open() {
            this.isOpen = true;
        }
    });
});
</script>
