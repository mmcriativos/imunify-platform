@extends('layouts.app')

@section('title', 'Relatório por Cidade - MultiImune')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-emerald-600">
                        Relatório por Cidade
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Atendimentos Domiciliares - {{ \Carbon\Carbon::create($ano, $mes, 1)->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimir
            </button>
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 border border-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Filtros de Período -->
<div class="bg-white shadow-xl rounded-2xl p-6 mb-8 border border-gray-100">
    <form method="GET" action="{{ route('relatorios.cidade') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-bold text-gray-700 mb-2">Mês</label>
            <select name="mes" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $mes == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->locale('pt_BR')->isoFormat('MMMM') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-bold text-gray-700 mb-2">Ano</label>
            <select name="ano" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                @for($a = date('Y'); $a >= date('Y') - 5; $a--)
                    <option value="{{ $a }}" {{ $ano == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Filtrar
        </button>
    </form>
</div>

<!-- Cards de Resumo -->
@php
    $totalGeral = $atendimentosPorCidade->sum('total');
    $faturamentoGeral = $atendimentosPorCidade->sum('faturamento');
    $totalCidades = $atendimentosPorCidade->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total de Cidades -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider mb-1">Cidades Atendidas</p>
                <p class="text-4xl font-bold">{{ $totalCidades }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total de Atendimentos Domiciliares -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-semibold uppercase tracking-wider mb-1">Total de Atendimentos</p>
                <p class="text-4xl font-bold">{{ number_format($totalGeral, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Faturamento Total -->
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wider mb-1">Faturamento Total</p>
                <p class="text-4xl font-bold">R$ {{ number_format($faturamentoGeral, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de Atendimentos por Cidade -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <!-- Header da Tabela -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-8 py-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Atendimentos por Cidade
        </h2>
    </div>

    @if($atendimentosPorCidade->isEmpty())
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Nenhum atendimento domiciliar encontrado</h3>
            <p class="text-gray-500">Não há atendimentos domiciliares registrados neste período.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                #
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Cidade
                            </div>
                        </th>
                        <th class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Atendimentos
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Faturamento
                            </div>
                        </th>
                        <th class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                % do Total
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($atendimentosPorCidade->sortByDesc('total') as $index => $item)
                        <tr class="hover:bg-emerald-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-700 rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-r from-emerald-100 to-teal-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $item->cidade->nome ?? 'Cidade não informada' }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->cidade->estado ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-100 text-blue-700 font-bold text-lg">
                                    {{ number_format($item->total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-base font-bold text-gray-900">
                                    R$ {{ number_format($item->faturamento, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $percentual = $totalGeral > 0 ? ($item->total / $totalGeral) * 100 : 0;
                                @endphp
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-sm font-bold text-emerald-600">
                                        {{ number_format($percentual, 1, ',', '.') }}%
                                    </span>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full transition-all duration-500" 
                                             style="width: {{ $percentual }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr class="border-t-2 border-emerald-200">
                        <td colspan="2" class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-gray-700 uppercase">Totais:</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-bold text-emerald-600">{{ number_format($totalGeral, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-lg font-bold text-emerald-600">R$ {{ number_format($faturamentoGeral, 2, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-emerald-600">100%</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

<!-- Gráfico Visual (Opcional) -->
@if($atendimentosPorCidade->isNotEmpty())
<div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100 mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        Distribuição de Atendimentos
    </h3>
    <div class="space-y-4">
        @foreach($atendimentosPorCidade->sortByDesc('total')->take(10) as $item)
            @php
                $percentual = $totalGeral > 0 ? ($item->total / $totalGeral) * 100 : 0;
            @endphp
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-semibold text-gray-700">{{ $item->cidade->nome ?? 'N/A' }}</span>
                    <span class="text-sm font-bold text-emerald-600">{{ $item->total }} atendimentos ({{ number_format($percentual, 1) }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-3 rounded-full transition-all duration-500 shadow-sm" 
                         style="width: {{ $percentual }}%">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Estilos para Impressão -->
<style>
    @media print {
        body {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
        
        nav, .no-print {
            display: none !important;
        }
        
        .bg-gradient-to-r, .bg-gradient-to-br {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endsection
