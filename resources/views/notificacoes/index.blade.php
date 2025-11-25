@extends('layouts.tenant-app')

@section('page-title', 'Notificações')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div>
                        <span>Notificações WhatsApp</span>
                        <p class="text-sm font-normal text-gray-600 mt-1">Acompanhe todas as mensagens enviadas automaticamente</p>
                    </div>
                </h1>
            </div>
            <a href="{{ route('whatsapp.config') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configurações
            </a>
        </div>

        <!-- Toast Notifications -->
        @if(session('success'))
        <div id="toast-success" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="toast-error" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Cards de Métricas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Enviadas Hoje -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-6 shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700 mb-1">Enviadas Hoje</p>
                        <p class="text-4xl font-bold text-green-800">{{ $enviadasHoje }}</p>
                        @if($variacaoPercentual != 0)
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                            @if($variacaoPercentual > 0)
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                +{{ $variacaoPercentual }}% vs ontem
                            @else
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $variacaoPercentual }}% vs ontem
                            @endif
                        </p>
                        @endif
                    </div>
                    <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pendentes -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-xl p-6 shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-700 mb-1">Pendentes</p>
                        <p class="text-4xl font-bold text-yellow-800">{{ $pendentes }}</p>
                        <p class="text-xs text-yellow-600 mt-2">Na fila de envio</p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Falhas Hoje -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl p-6 shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-700 mb-1">Falhas Hoje</p>
                        <p class="text-4xl font-bold text-red-800">{{ $falhasHoje }}</p>
                        @if($falhasHoje > 0)
                        <p class="text-xs text-red-600 mt-2 underline cursor-pointer">📝 Ver logs de erro</p>
                        @else
                        <p class="text-xs text-green-600 mt-2">✅ Nenhum erro hoje!</p>
                        @endif
                    </div>
                    <div class="w-14 h-14 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uso da Quota -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Uso da Quota WhatsApp
            </h3>

            <div class="mb-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-700">
                        @if($usageInfo['quota_unlimited'])
                            <span class="font-bold text-green-600">Mensagens Ilimitadas</span> 🎉
                        @else
                            <span class="font-semibold">{{ $usageInfo['sent'] }} / {{ $usageInfo['quota'] }} mensagens</span>
                        @endif
                    </span>
                    @if(!$usageInfo['quota_unlimited'])
                    <span class="font-bold text-gray-900">{{ $usageInfo['percentage'] ?? 0 }}%</span>
                    @endif
                </div>
                
                @if(!$usageInfo['quota_unlimited'])
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    @php
                        $percentage = $usageInfo['percentage'] ?? 0;
                        $colorClass = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-gradient-to-r from-blue-500 to-indigo-600');
                    @endphp
                    <div class="{{ $colorClass }} h-4 rounded-full transition-all duration-300" style="width: {{ min(100, $percentage) }}%"></div>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between text-sm gap-4">
                <div class="flex-1">
                    @if($usageInfo['mode'] === 'shared')
                        <div class="flex items-start gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg text-xs font-semibold shadow-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                Número WhatsApp Compartilhado
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900 mb-0.5">🎁 Benefício Exclusivo Imunify</p>
                                <p class="text-xs text-gray-600 leading-relaxed">
                                    Número oficial comprado pela <strong class="text-indigo-600">Imunify</strong> para você usar sem custo adicional! 
                                    Suas mensagens são enviadas através da nossa infraestrutura WhatsApp Business.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg text-xs font-semibold shadow-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Número WhatsApp Próprio
                            </span>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-900 mb-0.5">👑 Plano Premium</p>
                                <p class="text-xs text-gray-600 leading-relaxed">
                                    Mensagens enviadas do <strong class="text-purple-600">número da sua clínica</strong>. 
                                    Seus pacientes reconhecem o remetente como sendo diretamente da sua empresa.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if(!$usageInfo['quota_unlimited'] && $usageInfo['percentage'] >= 80)
                <a href="{{ route('whatsapp.config') }}#upgrade" class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:from-purple-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Fazer Upgrade
                </a>
                @endif
            </div>

            @if(!$usageInfo['quota_unlimited'] && $usageInfo['percentage'] >= 90)
            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-800">
                    <strong>⚠️ Atenção!</strong> Você está próximo do limite. Faça upgrade para não interromper os envios automáticos.
                </p>
            </div>
            @endif
        </div>

        <!-- Estatísticas dos Últimos 7 Dias -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
                Estatísticas dos Últimos 7 Dias
            </h3>

            <canvas id="chartEnvios" height="80"></canvas>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Total de Envios</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $totalEnviados }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Taxa de Sucesso</p>
                    <p class="text-2xl font-bold text-green-600">{{ $taxaSucesso }}%</p>
                </div>
            </div>
        </div>

        <!-- Histórico de Notificações -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Histórico de Notificações
            </h3>

            <!-- Filtros Modernos -->
            <form method="GET" action="{{ route('notificacoes.index') }}" class="mb-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Buscar Paciente -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">
                                🔍 Buscar Paciente
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="busca" 
                                    value="{{ request('busca') }}" 
                                    placeholder="Digite o nome..." 
                                    class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400 text-sm font-medium hover:border-indigo-300"
                                >
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Período -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">
                                📅 Período
                            </label>
                            <div class="relative">
                                <select 
                                    name="periodo" 
                                    class="w-full appearance-none pl-10 pr-10 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm font-medium cursor-pointer hover:border-indigo-300"
                                >
                                    <option value="">Todos os períodos</option>
                                    <option value="hoje" {{ request('periodo') == 'hoje' ? 'selected' : '' }}>📆 Hoje</option>
                                    <option value="ontem" {{ request('periodo') == 'ontem' ? 'selected' : '' }}>🕐 Ontem</option>
                                    <option value="7dias" {{ request('periodo') == '7dias' ? 'selected' : '' }}>📊 Últimos 7 dias</option>
                                    <option value="30dias" {{ request('periodo') == '30dias' ? 'selected' : '' }}>📈 Últimos 30 dias</option>
                                </select>
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Tipo -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">
                                📱 Tipo de Notificação
                            </label>
                            <div class="relative">
                                <select 
                                    name="tipo" 
                                    class="w-full appearance-none pl-10 pr-10 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm font-medium cursor-pointer hover:border-indigo-300"
                                >
                                    <option value="">Todos os tipos</option>
                                    <option value="dose_proxima" {{ request('tipo') == 'dose_proxima' ? 'selected' : '' }}>🔔 Lembrete de Vacinação</option>
                                    <option value="dose_atrasada" {{ request('tipo') == 'dose_atrasada' ? 'selected' : '' }}>⚠️ Dose Atrasada</option>
                                    <option value="campanha_terminando" {{ request('tipo') == 'campanha_terminando' ? 'selected' : '' }}>📢 Campanha</option>
                                </select>
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">
                                ✅ Status do Envio
                            </label>
                            <div class="relative">
                                <select 
                                    name="status" 
                                    class="w-full appearance-none pl-10 pr-10 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm font-medium cursor-pointer hover:border-indigo-300"
                                >
                                    <option value="">Todos os status</option>
                                    <option value="enviado" {{ request('status') == 'enviado' ? 'selected' : '' }}>✅ Enviado</option>
                                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>⏳ Pendente</option>
                                    <option value="erro" {{ request('status') == 'erro' ? 'selected' : '' }}>❌ Erro</option>
                                </select>
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex flex-wrap gap-3 mt-6 pt-4 border-t border-gray-200">
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transform hover:-translate-y-0.5"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Aplicar Filtros
                        </button>
                        <a 
                            href="{{ route('notificacoes.index') }}" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Limpar Filtros
                        </a>
                        @if(request()->hasAny(['busca', 'periodo', 'tipo', 'status']))
                        <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Filtros ativos
                        </div>
                        @endif
                    </div>
                </div>
            </form>
                        🔄 Limpar Filtros
                    </a>
                </div>
            </form>

            <!-- Tabela -->
            <div class="space-y-4">
                @forelse($lembretes as $lembrete)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-2xl">
                                    @if($lembrete->tipo === 'dose_proxima') 🔔
                                    @elseif($lembrete->tipo === 'dose_atrasada') ⚠️
                                    @elseif($lembrete->tipo === 'campanha_terminando') 📢
                                    @else 📱
                                    @endif
                                </span>
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        @if($lembrete->tipo === 'dose_proxima') Lembrete de Vacinação
                                        @elseif($lembrete->tipo === 'dose_atrasada') Dose Atrasada
                                        @elseif($lembrete->tipo === 'campanha_terminando') Campanha de Vacinação
                                        @else Notificação
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        Para: <strong>{{ $lembrete->paciente->nome ?? 'N/A' }}</strong> 
                                        @if($lembrete->paciente && $lembrete->paciente->telefone)
                                            ({{ $lembrete->paciente->telefone }})
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($lembrete->metadata)
                            <div class="text-sm text-gray-700 ml-11">
                                @php $meta = is_string($lembrete->metadata) ? json_decode($lembrete->metadata, true) : $lembrete->metadata; @endphp
                                @if(isset($meta['vacina']))
                                    <p>💉 Vacina: <strong>{{ $meta['vacina'] }}</strong>
                                    @if(isset($meta['dose'])) - {{ $meta['dose'] }}@endif
                                    </p>
                                @endif
                                @if(isset($meta['data_prevista']))
                                    <p>📅 Data prevista: {{ \Carbon\Carbon::parse($meta['data_prevista'])->format('d/m/Y') }}</p>
                                @endif
                            </div>
                            @endif

                            @if($lembrete->status === 'erro' && $lembrete->erro_mensagem)
                            <div class="ml-11 mt-2 p-2 bg-red-50 border border-red-200 rounded text-sm text-red-700">
                                <strong>Erro:</strong> {{ $lembrete->erro_mensagem }}
                            </div>
                            @endif
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                @if($lembrete->status === 'enviado') bg-green-100 text-green-800
                                @elseif($lembrete->status === 'pendente') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($lembrete->status === 'enviado') ✅ Enviado
                                @elseif($lembrete->status === 'pendente') ⏳ Pendente
                                @else ❌ Falha
                                @endif
                            </span>

                            <span class="text-xs text-gray-500">
                                {{ $lembrete->data_envio ? $lembrete->data_envio->format('d/m/Y H:i') : $lembrete->created_at->format('d/m/Y H:i') }}
                            </span>

                            <div class="flex gap-2 mt-2">
                                <button onclick="verMensagem({{ $lembrete->id }})" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition text-xs font-medium">
                                    👁️ Ver
                                </button>
                                
                                @if($lembrete->status === 'erro')
                                <form method="POST" action="{{ route('notificacoes.reenviar', $lembrete->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200 transition text-xs font-medium">
                                        🔄 Reenviar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="mx-auto w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma notificação encontrada</h3>
                    <p class="text-gray-600">Tente ajustar os filtros ou aguarde o envio automático de lembretes.</p>
                </div>
                @endforelse
            </div>

            <!-- Paginação -->
            @if($lembretes->hasPages())
            <div class="mt-6">
                {{ $lembretes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Ver Mensagem -->
<div id="modalMensagem" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">📱 Mensagem Enviada</h3>
            <button onclick="fecharModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div id="modalContent" class="p-6">
            <!-- Conteúdo será carregado via JavaScript -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de envios
const ctx = document.getElementById('chartEnvios').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: 'Mensagens Enviadas',
            data: @json($chartData['data']),
            borderColor: 'rgb(79, 70, 229)',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgb(79, 70, 229)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 10
                }
            }
        }
    }
});

// Modal
function verMensagem(id) {
    const modal = document.getElementById('modalMensagem');
    const content = document.getElementById('modalContent');
    
    // Buscar dados do lembrete
    fetch(`/dashboard/notificacoes/${id}`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = `
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Destinatário</p>
                        <p class="font-semibold text-gray-900">${data.paciente}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Telefone</p>
                        <p class="font-semibold text-gray-900">${data.telefone}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Enviado em</p>
                        <p class="font-semibold text-gray-900">${data.data_envio}</p>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-sm text-gray-600 mb-2">Conteúdo da Mensagem:</p>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4">
                            <pre class="text-sm text-gray-800 whitespace-pre-wrap font-sans">${data.mensagem}</pre>
                        </div>
                    </div>
                </div>
            `;
            modal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar mensagem');
        });
}

function fecharModal() {
    document.getElementById('modalMensagem').classList.add('hidden');
}

// Fechar modal ao clicar fora
document.getElementById('modalMensagem').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModal();
    }
});

// Auto-hide toast messages
setTimeout(() => {
    const toasts = document.querySelectorAll('[id^="toast-"]');
    toasts.forEach(toast => {
        toast.style.transition = 'opacity 0.5s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    });
}, 5000);
</script>
@endsection
