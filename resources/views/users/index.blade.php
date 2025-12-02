@extends('layouts.tenant-app')

@section('title', 'Gerenciar Equipe')
@section('page-title', 'Gerenciar Equipe')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Premium com Estatísticas -->
    <div class="bg-gradient-to-br from-white via-blue-50/30 to-purple-50/30 rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <!-- Título e Descrição -->
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Minha Equipe</h1>
                        <p class="text-gray-600">Gerencie os membros da sua clínica</p>
                    </div>
                </div>
            </div>

            <!-- Card de Estatísticas -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Quota de Usuários -->
                <div class="bg-white rounded-xl p-5 shadow-md border border-gray-100 min-w-[140px]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Usuários</span>
                        @if($currentUsers >= $maxUsers)
                            <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $currentUsers }}<span class="text-gray-400">/{{ $maxUsers }}</span></div>
                    <div class="mt-2 bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-500" 
                             style="width: {{ min(100, ($currentUsers / $maxUsers) * 100) }}%"></div>
                    </div>
                </div>

                <!-- Usuários Ativos -->
                <div class="bg-white rounded-xl p-5 shadow-md border border-gray-100 min-w-[140px]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Ativos</span>
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $users->where('is_active', true)->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">{{ $users->where('is_active', false)->count() }} inativos</p>
                </div>
            </div>
        </div>

        <!-- Botão de Adicionar -->
        <div class="mt-6 flex items-center justify-between gap-4">
            @if(!$canAddMore)
                <div class="flex-1 bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold text-orange-900 text-sm">Limite de usuários atingido!</p>
                            <p class="text-sm text-orange-800 mt-1">
                                Seu plano atual permite <strong>{{ $maxUsers }}</strong> {{ $maxUsers == 1 ? 'usuário' : 'usuários' }}. 
                                <a href="#" class="font-bold underline hover:text-orange-900 transition-colors">Faça upgrade</a> 
                                para adicionar mais membros à sua equipe.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-600">
                    Você pode adicionar mais <strong class="text-gray-900">{{ $maxUsers - $currentUsers }}</strong> 
                    {{ ($maxUsers - $currentUsers) == 1 ? 'usuário' : 'usuários' }}
                </p>
            @endif

            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200
                      {{ $canAddMore ? 'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700' : 'bg-gray-400 cursor-not-allowed opacity-60' }}"
               {{ !$canAddMore ? 'onclick="return false;"' : '' }}>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Adicionar Membro
            </a>
        </div>
    </div>

    <!-- Grid de Cards de Usuários -->
    @if($users->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum membro ainda</h3>
            <p class="text-gray-600 mb-6">Comece adicionando os primeiros membros da sua equipe</p>
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adicionar Primeiro Membro
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1
                            {{ !$user->is_active ? 'opacity-60' : '' }}">
                    <!-- Header do Card -->
                    <div class="relative bg-gradient-to-br from-blue-500 to-purple-600 p-6 pb-16">
                        <!-- Badge de Status -->
                        <div class="absolute top-4 right-4">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    Ativo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    Inativo
                                </span>
                            @endif
                        </div>

                        <!-- Avatar -->
                        <div class="flex justify-center">
                            <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-xl transform rotate-3 hover:rotate-0 transition-transform">
                                <span class="text-4xl font-black bg-gradient-to-br from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Conteúdo do Card -->
                    <div class="p-6 -mt-10 relative">
                        <!-- Badge de Role -->
                        <div class="flex justify-center mb-4">
                            @php
                                $roleBadges = [
                                    'admin' => ['Administrador', 'from-purple-500 to-pink-600', '👑'],
                                    'manager' => ['Gerente', 'from-blue-500 to-cyan-600', '📊'],
                                    'operator' => ['Operador', 'from-green-500 to-emerald-600', '👤'],
                                    'viewer' => ['Visualizador', 'from-gray-500 to-slate-600', '👁️'],
                                ];
                                [$label, $gradient, $icon] = $roleBadges[$user->role] ?? ['Desconhecido', 'from-gray-500 to-gray-600', '❓'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r {{ $gradient }} text-white text-sm font-bold rounded-xl shadow-lg">
                                <span class="text-lg">{{ $icon }}</span>
                                {{ $label }}
                            </span>
                        </div>

                        <!-- Informações -->
                        <div class="text-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-1 flex items-center justify-center gap-2">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold">Você</span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            @if($user->phone)
                                <p class="text-sm text-gray-500 mt-1">📞 {{ $user->phone }}</p>
                            @endif
                        </div>

                        <!-- Último Acesso -->
                        <div class="bg-gray-50 rounded-xl p-3 mb-4">
                            <div class="flex items-center justify-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @if($user->last_login_at)
                                    Último acesso {{ $user->last_login_at->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">Nunca acessou</span>
                                @endif
                            </div>
                        </div>

                        <!-- Ações -->
                        @if($user->id !== auth()->id())
                            <div class="flex gap-2">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                                
                                <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 {{ $user->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            Desativar
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Ativar
                                        @endif
                                    </button>
                                </form>
                                
                                <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('⚠️ Tem certeza que deseja remover {{ $user->name }}?\n\nEsta ação não pode ser desfeita!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-3 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                                <p class="text-sm font-semibold text-gray-600">Este é você! Use o menu de perfil para editar seus dados.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Legenda de Permissões -->
    <div class="mt-8 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-2xl border-2 border-blue-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Níveis de Acesso e Permissões
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">👑</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">Administrador</h4>
                        <p class="text-sm text-gray-600">Acesso total ao sistema, pode gerenciar usuários, configurações e todas as funcionalidades</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">📊</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">Gerente</h4>
                        <p class="text-sm text-gray-600">Gerencia pacientes, agendamentos, estoque e visualiza relatórios completos</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">👤</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">Operador</h4>
                        <p class="text-sm text-gray-600">Gerencia pacientes e agendamentos do dia a dia, sem acesso a configurações</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">👁️</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">Visualizador</h4>
                        <p class="text-sm text-gray-600">Apenas visualização de dados, não pode criar, editar ou excluir informações</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<div class="max-w-6xl mx-auto">
    <!-- Header com Informações do Plano -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Equipe</h2>
                <p class="text-gray-600 mt-1">Gerencie os usuários com acesso ao sistema</p>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Contador de Usuários -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                    <div class="text-sm text-blue-600 font-medium">Usuários Ativos</div>
                    <div class="text-2xl font-bold text-blue-900">
                        {{ $currentUsers }} / {{ $maxUsers }}
                    </div>
                    @if($currentUsers >= $maxUsers)
                        <div class="text-xs text-orange-600 mt-1">⚠️ Limite atingido</div>
                    @endif
                </div>

                @if($canAddMore)
                    <a href="{{ route('users.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-[#3ebddb] to-[#77ca73] text-white px-4 py-2.5 rounded-lg font-semibold hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Adicionar Usuário
                    </a>
                @else
                    <button disabled 
                            class="inline-flex items-center gap-2 bg-gray-300 text-gray-500 px-4 py-2.5 rounded-lg font-semibold cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Limite Atingido
                    </button>
                @endif
            </div>
        </div>

        @if(!$canAddMore)
            <div class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-orange-800">Limite de usuários atingido</p>
                        <p class="text-sm text-orange-700 mt-1">
                            Seu plano atual permite até {{ $maxUsers }} usuário(s). 
                            <a href="#" class="font-semibold underline hover:text-orange-900">Faça upgrade</a> para adicionar mais membros à sua equipe.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Tabela de Usuários -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Usuário
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Papel
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contato
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Último Acesso
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="{{ !$user->is_active ? 'bg-gray-50 opacity-60' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#3ebddb] to-[#77ca73] flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Você</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $roleBadges = [
                                    'admin' => ['Administrador', 'bg-purple-100 text-purple-800', '👑'],
                                    'manager' => ['Gerente', 'bg-blue-100 text-blue-800', '📊'],
                                    'operator' => ['Operador', 'bg-green-100 text-green-800', '👤'],
                                    'viewer' => ['Visualizador', 'bg-gray-100 text-gray-800', '👁️'],
                                ];
                                [$label, $class, $icon] = $roleBadges[$user->role] ?? ['Desconhecido', 'bg-gray-100 text-gray-800', '❓'];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                {{ $icon }} {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->phone ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ● Ativo
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    ○ Inativo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($user->last_login_at)
                                {{ $user->last_login_at->diffForHumans() }}
                            @else
                                Nunca
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($user->id !== auth()->id())
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Editar
                                    </a>
                                    
                                    <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-orange-600 hover:text-orange-900">
                                            {{ $user->is_active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Tem certeza que deseja remover este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Remover
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Nenhum usuário cadastrado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Legenda de Permissões -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-semibold text-blue-900 mb-3">Níveis de Acesso</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <div>
                <strong class="text-blue-900">👑 Administrador:</strong>
                <span class="text-blue-800">Acesso total ao sistema, pode gerenciar usuários e configurações</span>
            </div>
            <div>
                <strong class="text-blue-900">📊 Gerente:</strong>
                <span class="text-blue-800">Gerencia pacientes, agendamentos, estoque e relatórios</span>
            </div>
            <div>
                <strong class="text-blue-900">👤 Operador:</strong>
                <span class="text-blue-800">Gerencia pacientes e agendamentos do dia a dia</span>
            </div>
            <div>
                <strong class="text-blue-900">👁️ Visualizador:</strong>
                <span class="text-blue-800">Apenas visualização, não pode criar ou editar</span>
            </div>
        </div>
    </div>
</div>
@endsection
