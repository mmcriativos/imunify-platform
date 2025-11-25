<!-- Header Premium com Gradiente Imunify -->
<header class="bg-white border-b border-gray-200 shadow-md sticky top-0 z-40">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left Section: Logo & Welcome (Mobile Menu Toggle) -->
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#3ebddb] rounded-lg p-2 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Breadcrumb / Page Title -->
                <div class="hidden sm:flex items-center gap-2">
                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-[#3ebddb] font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </a>
                        @if(!request()->routeIs('dashboard'))
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-gray-900 font-semibold">@yield('page-title', 'Página')</span>
                        @else
                            <span class="text-gray-900 font-semibold ml-2">Dashboard</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Section: Actions & User Menu -->
            <div class="flex items-center gap-3">
                <!-- Quick Actions -->
                <div class="hidden md:flex items-center gap-2">
                    <!-- Novo Atendimento -->
                    <a href="{{ route('atendimentos.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-[#3ebddb] to-[#5bc9d4] hover:from-[#2a9fb8] hover:to-[#3ebddb] text-white font-bold px-4 py-2 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden xl:inline">Novo Atendimento</span>
                    </a>

                    <!-- Novo Paciente -->
                    <a href="{{ route('pacientes.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-[#77ca73] to-[#63b55f] hover:from-[#63b55f] hover:to-[#4fa048] text-white font-bold px-4 py-2 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="hidden xl:inline">Novo Paciente</span>
                    </a>
                </div>

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="relative p-2 text-gray-600 hover:text-[#3ebddb] hover:bg-gray-100 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-[#3ebddb]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <!-- Notification Badge -->
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50"
                         style="display: none;">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] px-4 py-3">
                            <h3 class="text-white font-bold text-sm">Notificações</h3>
                        </div>
                        <!-- Notifications List -->
                        <div class="max-h-96 overflow-y-auto">
                            <div class="p-4 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm font-medium">Nenhuma notificação</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center gap-3 p-2 pr-4 hover:bg-gray-100 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-[#3ebddb]">
                        <!-- Avatar -->
                        <div class="w-10 h-10 bg-gradient-to-br from-[#3ebddb] to-[#77ca73] rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <!-- User Info -->
                        <div class="hidden lg:block text-left">
                            <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ tenant('clinic_name') ?? 'Clínica' }}</p>
                        </div>
                        <!-- Dropdown Icon -->
                        <svg class="w-4 h-4 text-gray-600 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- User Dropdown -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50"
                         style="display: none;">
                        <!-- User Info Header -->
                        <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg border-2 border-white/50">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-white font-bold text-sm">{{ auth()->user()->name }}</p>
                                    <p class="text-white/90 text-xs">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="{{ route('clinic.config') }}" 
                               class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-[#3ebddb]/10 hover:to-[#77ca73]/10 hover:text-[#3ebddb] transition font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Configurações da Clínica</span>
                            </a>
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-[#3ebddb]/10 hover:to-[#77ca73]/10 hover:text-[#3ebddb] transition font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                            <div class="border-t border-gray-200 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
