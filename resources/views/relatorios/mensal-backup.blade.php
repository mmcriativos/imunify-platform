@extends('layouts.tenant-app')

@section('title', 'Relatório Mensal - MultiImune')

@section('content')
<!-- Header Compacto -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Relatório Mensal</h1>
            <p class="text-sm text-gray-600 mt-1">
                {{ \Carbon\Carbon::create($ano, $mes, 1)->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}
            </p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" 
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimir
            </button>
            <a href="{{ route('dashboard') }}" 
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition text-sm">
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('relatorios.mensal') }}" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Mês</label>
            <select name="mes" class="px-3 py-2 border-2 border-gray-200 rounded-lg text-sm focus:border-purple-500 hover:border-purple-300 transition">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $mes == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->locale('pt_BR')->isoFormat('MMMM') }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Ano</label>
            <select name="ano" class="px-3 py-2 border-2 border-gray-200 rounded-lg text-sm focus:border-purple-500 hover:border-purple-300 transition">
                @for($a = date('Y'); $a >= date('Y') - 5; $a--)
                    <option value="{{ $a }}" {{ $ano == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition text-sm">
            Filtrar
        </button>
    </form>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Total de Atendimentos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Total Atendimentos</span>
            <div class="bg-purple-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ number_format($totalAtendimentos, 0, ',', '.') }}</div>
    </div>

    <!-- Faturamento Total -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Faturamento Total</span>
            <div class="bg-green-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">R$ {{ number_format($totalFaturamento, 2, ',', '.') }}</div>
    </div>

    <!-- Ticket Médio -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Ticket Médio</span>
            <div class="bg-blue-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">
            R$ {{ $totalAtendimentos > 0 ? number_format($totalFaturamento / $totalAtendimentos, 2, ',', '.') : '0,00' }}
        </div>
    </div>
</div>

<!-- Tabela de Atendimentos -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header da Tabela -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Detalhamento dos Atendimentos
        </h2>
    </div>

    @if($atendimentos->isEmpty())
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Nenhum atendimento encontrado</h3>
            <p class="text-sm text-gray-500">Não há atendimentos registrados neste período.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Data</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Paciente</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Local/Cidade</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Vacinas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Valor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($atendimentos as $atendimento)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($atendimento->data)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $atendimento->paciente->nome }}</div>
                                <div class="text-xs text-gray-500">CPF: {{ $atendimento->paciente->cpf }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($atendimento->tipo == 'clinica')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        Clínica
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        Domiciliar
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @if($atendimento->tipo == 'clinica')
                                    {{ $atendimento->local_aplicacao ?? 'Clínica' }}
                                @else
                                    {{ $atendimento->cidade->nome ?? 'N/A' }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($atendimento->vacinas as $vacina)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                            {{ $vacina->nome }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Nenhuma</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                R$ {{ number_format($atendimento->valor_total, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-right text-sm font-semibold text-gray-700 uppercase">
                            Total Geral:
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-base font-bold text-purple-600">
                            R$ {{ number_format($totalFaturamento, 2, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

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
    }
</style>
@endsection
