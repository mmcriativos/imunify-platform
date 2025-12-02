@extends('layouts.tenant-app')

@section('title', 'Gerenciar Usuários')
@section('page-title', 'Gerenciar Usuários')

@section('content')
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
