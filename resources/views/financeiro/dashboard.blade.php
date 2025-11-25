@extends('layouts.tenant-app')

@section('title', 'Dashboard Financeiro')
@section('page-title', 'Dashboard Financeiro')

@section('content')
<!-- Header Premium com Gradiente -->
<div class="mb-8">
    <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-3xl shadow-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-teal-400 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative px-6 sm:px-8 py-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <!-- Título -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-2xl border border-white/30 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                                Dashboard Financeiro 💰
                            </h1>
                            <p class="text-white/90 text-sm font-medium mt-1">Visão completa das finanças da clínica</p>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('financeiro.lancamentos.create') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm border-2 border-white/40 text-white rounded-xl px-6 py-3 font-bold text-sm shadow-lg hover:shadow-xl transition-all flex items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Novo Lançamento
                    </a>
                    @if(!$caixaAberto)
                        <a href="{{ route('financeiro.caixa.index') }}" class="bg-white hover:bg-gray-50 text-emerald-600 rounded-xl px-6 py-3 font-bold text-sm shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                            </svg>
                            Abrir Caixa
                        </a>
                    @else
                        <a href="{{ route('financeiro.caixa.show', $caixaAberto) }}" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white rounded-xl px-6 py-3 font-bold text-sm shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Caixa Aberto
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-6">

    <!-- Filtro de Período -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
            <h3 class="text-lg font-black text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Período de Análise
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" class="flex gap-4 items-end flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ $inicio->format('Y-m-d') }}" 
                           class="w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all px-4 py-2.5 font-medium">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ $fim->format('Y-m-d') }}" 
                           class="w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all px-4 py-2.5 font-medium">
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar
                </button>
            </form>
        </div>
    </div>

    <!-- Cards de Resumo Premium -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Receitas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-8">
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Receitas</p>
                        <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-white drop-shadow-md">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
                        <p class="text-white text-sm font-semibold drop-shadow-sm mt-2">total do período</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-emerald-500/10 to-green-600/10 px-6 py-4">
                <div class="flex items-center text-emerald-600 font-bold text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Receitas confirmadas
                </div>
            </div>
        </div>

        <!-- Total Despesas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="bg-gradient-to-br from-red-500 to-rose-600 p-8">
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Despesas</p>
                        <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-white drop-shadow-md">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</p>
                        <p class="text-white text-sm font-semibold drop-shadow-sm mt-2">total do período</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-500/10 to-rose-600/10 px-6 py-4">
                <div class="flex items-center text-red-600 font-bold text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Despesas registradas
                </div>
            </div>
        </div>

        <!-- Saldo -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="bg-gradient-to-br from-blue-500 via-cyan-500 to-teal-500 p-8">
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Saldo</p>
                        <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-black text-white drop-shadow-md">R$ {{ number_format($saldo, 2, ',', '.') }}</p>
                        <p class="text-white text-sm font-semibold drop-shadow-sm mt-2">{{ $saldo >= 0 ? 'saldo positivo' : 'saldo negativo' }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500/10 to-teal-500/10 px-6 py-4">
                <div class="flex items-center {{ $saldo >= 0 ? 'text-blue-600' : 'text-red-600' }} font-bold text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Receitas - Despesas
                </div>
            </div>
        </div>

        <!-- Contas Vencidas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="bg-gradient-to-br from-orange-500 to-amber-600 p-8">
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Contas Vencidas</p>
                        <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl lg:text-4xl font-black text-white drop-shadow-md">{{ $contasVencidas }}</p>
                        <p class="text-white text-sm font-semibold drop-shadow-sm mt-2">R$ {{ number_format($valorVencido, 2, ',', '.') }} em atraso</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-500/10 to-amber-600/10 px-6 py-4">
                <div class="flex items-center text-orange-600 font-bold text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Requer atenção
                </div>
            </div>
        </div>
    </div>

            <!-- Acesso Rápido -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Acesso Rápido
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Categorias -->
                    <a href="{{ route('financeiro.categorias.index') }}" class="bg-white hover:bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 transition group shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition">Categorias</h4>
                                <p class="text-xs text-gray-600">Gerenciar categorias</p>
                            </div>
                        </div>
                    </a>

                    <!-- Formas de Pagamento -->
                    <a href="{{ route('financeiro.formas-pagamento.index') }}" class="bg-white hover:bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 transition group shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition">Formas de Pagamento</h4>
                                <p class="text-xs text-gray-600">Gerenciar formas de pagamento</p>
                            </div>
                        </div>
                    </a>

                    <!-- Lançamentos -->
                    <a href="{{ route('financeiro.lancamentos.index') }}" class="bg-white hover:bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 transition group shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition">Lançamentos</h4>
                                <p class="text-xs text-gray-600">Ver todos lançamentos</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

    <!-- Gráficos com Cores -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Receitas por Categoria -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Receitas por Categoria
                </h3>
            </div>
            <div class="p-6">
                @if($receitasPorCategoria->count() > 0)
                    <div class="space-y-4">
                        @foreach($receitasPorCategoria as $item)
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="flex items-center gap-2 font-semibold text-gray-700">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $item['cor'] }}"></span>
                                        {{ $item['categoria'] }}
                                    </span>
                                    <span class="font-bold text-emerald-600">R$ {{ number_format($item['total'], 2, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                                    <div class="h-3 rounded-full transition-all duration-500 shadow-sm" style="width: {{ ($item['total'] / $totalReceitas) * 100 }}%; background-color: {{ $item['cor'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">Nenhuma receita no período</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Despesas por Categoria -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Despesas por Categoria
                </h3>
            </div>
            <div class="p-6">
                @if($despesasPorCategoria->count() > 0)
                    <div class="space-y-4">
                        @foreach($despesasPorCategoria as $item)
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="flex items-center gap-2 font-semibold text-gray-700">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $item['cor'] }}"></span>
                                        {{ $item['categoria'] }}
                                    </span>
                                    <span class="font-bold text-red-600">R$ {{ number_format($item['total'], 2, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                                    <div class="h-3 rounded-full transition-all duration-500 shadow-sm" style="width: {{ ($item['total'] / $totalDespesas) * 100 }}%; background-color: {{ $item['cor'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">Nenhuma despesa no período</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Evolução Mensal -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
            <h3 class="text-xl font-black text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
                Evolução Mensal (Últimos 6 Meses)
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Mês</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Receitas</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Despesas</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($evolucaoMensal as $mes)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $mes['mes'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-emerald-600">R$ {{ number_format($mes['receitas'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-red-600">R$ {{ number_format($mes['despesas'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black {{ $mes['saldo'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    R$ {{ number_format($mes['saldo'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Últimos Lançamentos -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-black text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Últimos Lançamentos
                </h3>
                <a href="{{ route('financeiro.lancamentos.index') }}" class="text-white hover:text-gray-200 text-sm font-bold flex items-center gap-1 transition">
                    Ver todos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-blue-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Forma Pgto</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Valor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ultimosLancamentos as $lanc)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $lanc->data->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $lanc->descricao }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $lanc->categoria->cor }}20; color: {{ $lanc->categoria->cor }}">
                                    {{ $lanc->categoria->nome }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $lanc->formaPagamento->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black {{ $lanc->tipo == 'receita' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $lanc->tipo == 'receita' ? '+' : '-' }} R$ {{ number_format($lanc->valor, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">Nenhum lançamento encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
