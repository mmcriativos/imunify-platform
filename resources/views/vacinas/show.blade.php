@extends('layouts.tenant-app')

@section('title', $vacina->nome . ' - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Detalhes da Vacina')

@section('content')
<!-- Header Compacto -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $vacina->nome }}</h1>
                <p class="text-sm text-gray-600">Detalhes e informações completas</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('vacinas.edit', $vacina) }}" 
               class="flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <a href="{{ route('vacinas.index') }}" 
               class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Layout com Cards Compactos -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna Principal (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Card de Informações Principais -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informações Gerais
                </h2>
            </div>

            <div class="p-6 space-y-4">
                <!-- Nome -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                    <label class="text-xs font-semibold text-gray-600 uppercase">Nome da Vacina</label>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ $vacina->nome }}</p>
                </div>

                <!-- Fabricante -->
                @if($vacina->fabricante)
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-600 uppercase">Fabricante</label>
                        <p class="text-base font-semibold text-gray-800 mt-1">{{ $vacina->fabricante }}</p>
                    </div>
                </div>
                @endif

                <!-- Descrição -->
                @if($vacina->descricao)
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-600 uppercase">Descrição</label>
                        <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $vacina->descricao }}</p>
                    </div>
                </div>
                @endif

                <!-- Modo de Agir -->
                @if($vacina->modo_agir)
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-600 uppercase">Modo de Agir</label>
                        <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $vacina->modo_agir }}</p>
                    </div>
                </div>
                @endif

                <!-- Indicações -->
                @if($vacina->indicacoes)
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg">
                    <div class="bg-teal-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs font-semibold text-gray-600 uppercase">Indicações</label>
                        <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $vacina->indicacoes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Card de Valores -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Valores e Prazos
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Preço de Custo -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-lg border border-gray-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase flex items-center gap-1">
                            💵 Custo
                        </label>
                        <p class="text-xl font-bold text-gray-800 mt-2">
                            R$ {{ number_format($vacina->preco_custo ?? 0, 2, ',', '.') }}
                        </p>
                    </div>

                    <!-- Preço Venda Cartão -->
                    @if($vacina->preco_venda_cartao)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase flex items-center gap-1">
                            💳 Cartão
                        </label>
                        <p class="text-xl font-bold text-blue-700 mt-2">
                            R$ {{ number_format($vacina->preco_venda_cartao, 2, ',', '.') }}
                        </p>
                    </div>
                    @endif

                    <!-- Preço Venda PIX -->
                    @if($vacina->preco_venda_pix)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide flex items-center gap-2">
                            💰 Venda PIX/Dinheiro
                        </label>
                        <p class="text-2xl font-bold text-green-700 mt-2">
                            R$ {{ number_format($vacina->preco_venda_pix, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">À vista</p>
                    </div>
                    @endif

                    <!-- Preço Promocional -->
                    @if($vacina->preco_promocional)
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 p-6 rounded-xl border-2 border-red-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                            PROMOÇÃO
                        </div>
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide flex items-center gap-2">
                            🏷️ Promocional
                        </label>
                        <p class="text-2xl font-bold text-red-600 mt-2">
                            R$ {{ number_format($vacina->preco_promocional, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Preço especial</p>
                    </div>
                    @endif
                </div>

                <!-- Validade -->
                @if($vacina->validade_dias)
                <div class="mt-6">
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-xl border border-blue-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Período de Proteção
                        </label>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $vacina->validade_dias }} dias</p>
                        <p class="text-sm text-gray-600 mt-1">≈ {{ round($vacina->validade_dias / 365, 1) }} anos</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Card de Esquema de Dosagem -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    Esquema de Dosagem
                </h2>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Número de Doses -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Número de Doses</label>
                        <div class="mt-3">
                            @if($vacina->numero_doses == 1)
                                <span class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-3 rounded-xl font-bold text-lg shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Dose Única
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl font-bold text-lg shadow-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9 4a1 1 0 102 0 1 1 0 00-2 0zm-3 1a1 1 0 100-2 1 1 0 000 2zm-3 1a1 1 0 102 0 1 1 0 00-2 0zm3 1a1 1 0 100-2 1 1 0 000 2zm3-1a1 1 0 102 0 1 1 0 00-2 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $vacina->numero_doses }} doses
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Intervalo -->
                    @if($vacina->intervalo_doses_dias)
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-xl border border-amber-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Intervalo entre Doses</label>
                        <div class="mt-3">
                            <p class="text-3xl font-bold text-amber-600">{{ $vacina->intervalo_doses_dias }} dias</p>
                            <p class="text-sm text-gray-600 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Aproximadamente {{ round($vacina->intervalo_doses_dias / 30, 1) }} meses
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Timeline Visual (apenas para múltiplas doses) -->
                @if($vacina->numero_doses > 1)
                <div class="mt-6 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 p-6 rounded-xl border border-blue-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Cronograma de Vacinação
                    </h4>
                    <div class="flex items-center gap-2 overflow-x-auto pb-2">
                        @for($i = 1; $i <= $vacina->numero_doses; $i++)
                            <div class="flex items-center">
                                <div class="flex flex-col items-center min-w-[100px]">
                                    <div class="bg-gradient-to-br from-indigo-500 to-purple-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold shadow-lg">
                                        {{ $i }}ª
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2 text-center">
                                        @if($i == 1)
                                            Inicial
                                        @else
                                            +{{ ($i-1) * $vacina->intervalo_doses_dias }} dias
                                        @endif
                                    </p>
                                </div>
                                @if($i < $vacina->numero_doses)
                                    <div class="flex-1 h-1 bg-gradient-to-r from-indigo-300 to-purple-300 mx-2 min-w-[60px]"></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Coluna Lateral (1/3) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Card de Status -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status
                </h3>
            </div>
            <div class="p-6">
                @if($vacina->ativo)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border-2 border-green-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-500 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-700">ATIVA</p>
                                <p class="text-xs text-green-600">Disponível para uso</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-red-50 to-rose-50 p-4 rounded-xl border-2 border-red-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-500 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-red-700">INATIVA</p>
                                <p class="text-xs text-red-600">Indisponível no momento</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Card de Ações Rápidas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Ações Rápidas
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('vacinas.edit', $vacina) }}" 
                   class="flex items-center gap-3 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 hover:from-yellow-100 hover:to-orange-100 rounded-xl border border-yellow-200 transition duration-300 group">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-2 rounded-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Editar Vacina</p>
                        <p class="text-xs text-gray-600">Alterar informações</p>
                    </div>
                </a>

                <a href="{{ route('vacinas.index') }}" 
                   class="flex items-center gap-3 p-4 bg-gradient-to-r from-gray-50 to-slate-50 hover:from-gray-100 hover:to-slate-100 rounded-xl border border-gray-200 transition duration-300 group">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 p-2 rounded-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Ver Todas</p>
                        <p class="text-xs text-gray-600">Voltar à listagem</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card de Informações Adicionais -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl border border-indigo-200 shadow-lg">
            <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Dica Importante
            </h4>
            <p class="text-sm text-gray-700 leading-relaxed">
                @if($vacina->numero_doses > 1)
                    Esta vacina requer <strong>{{ $vacina->numero_doses }} doses</strong> para imunização completa. 
                    Certifique-se de orientar o paciente sobre o cronograma correto.
                @else
                    Esta vacina possui <strong>dose única</strong>, garantindo proteção completa após uma aplicação.
                @endif
            </p>
        </div>

        <!-- SVG Illustration -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <!-- Vaccine Bottle -->
                <defs>
                    <linearGradient id="bottleGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="liquidGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#06b6d4;stop-opacity:0.8" />
                        <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:0.8" />
                    </linearGradient>
                </defs>
                
                <!-- Bottle Body -->
                <rect x="70" y="60" width="60" height="100" rx="5" fill="url(#bottleGrad)" opacity="0.2"/>
                <rect x="75" y="65" width="50" height="90" rx="3" fill="url(#liquidGrad)"/>
                
                <!-- Bottle Cap -->
                <rect x="85" y="45" width="30" height="20" rx="3" fill="#6366f1"/>
                <rect x="88" y="40" width="24" height="10" rx="2" fill="#818cf8"/>
                
                <!-- Label -->
                <rect x="80" y="95" width="40" height="25" rx="2" fill="white" opacity="0.9"/>
                <text x="100" y="107" text-anchor="middle" font-size="10" fill="#3b82f6" font-weight="bold">VACINA</text>
                <text x="100" y="116" text-anchor="middle" font-size="6" fill="#6366f1">MultiImune</text>
                
                <!-- Syringe -->
                <rect x="30" y="120" width="8" height="40" rx="1" fill="#94a3b8"/>
                <rect x="32" y="125" width="4" height="35" fill="#cbd5e1"/>
                <polygon points="30,165 38,165 34,175" fill="#475569"/>
                <circle cx="34" cy="115" r="5" fill="#e2e8f0"/>
                
                <!-- Shield Icon -->
                <path d="M150 95 L165 85 L180 95 L180 115 Q180 130 165 140 Q150 130 150 115 Z" 
                      fill="#10b981" opacity="0.3" stroke="#059669" stroke-width="2"/>
                <path d="M160 105 L163 110 L170 100" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</div>
@endsection

