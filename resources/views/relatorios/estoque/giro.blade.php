@extends('layouts.tenant-app')

@section('title', 'Giro de Estoque - ' . (tenant('clinic_name') ?? 'MultiImune'))

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('relatorios.estoque.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Análise de Giro de Estoque</h1>
                    <p class="text-gray-600 mt-1">Performance e rotatividade das vacinas no período</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="window.print()" 
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimir
                </button>
                
                <button onclick="exportarAnalise()" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 3l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Exportar Análise
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Período de Análise</label>
                <select name="periodo" onchange="ajustarDatas(this.value)" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="30" {{ request('periodo', '90') == '30' ? 'selected' : '' }}>Últimos 30 dias</option>
                    <option value="90" {{ request('periodo', '90') == '90' ? 'selected' : '' }}>Últimos 90 dias</option>
                    <option value="180" {{ request('periodo') == '180' ? 'selected' : '' }}>Últimos 180 dias</option>
                    <option value="365" {{ request('periodo') == '365' ? 'selected' : '' }}>Último ano</option>
                    <option value="custom" {{ request('periodo') == 'custom' ? 'selected' : '' }}>Personalizado</option>
                </select>
            </div>
            
            <div id="dataInicio" class="{{ request('periodo') == 'custom' ? '' : 'opacity-50' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio', now()->subDays(90)->format('Y-m-d')) }}" 
                       {{ request('periodo') == 'custom' ? '' : 'readonly' }}
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div id="dataFim" class="{{ request('periodo') == 'custom' ? '' : 'opacity-50' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                <input type="date" name="data_fim" value="{{ request('data_fim', now()->format('Y-m-d')) }}" 
                       {{ request('periodo') == 'custom' ? '' : 'readonly' }}
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Analisar
                </button>
            </div>
        </form>
    </div>

    <!-- Métricas Gerais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($metricas['giro_medio'], 2, ',', '.') }}x</p>
                    <p class="text-sm text-gray-600">Giro Médio</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($metricas['cobertura_dias']) }}</p>
                    <p class="text-sm text-gray-600">Dias de Cobertura</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($metricas['aplicacoes_periodo']) }}</p>
                    <p class="text-sm text-gray-600">Aplicações no Período</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-amber-600">R$ {{ number_format($metricas['receita_periodo'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Receita no Período</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Classificação de Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Top Performers -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Alto Giro</h3>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">
                    {{ count($classificacao['alto_giro']) }}
                </span>
            </div>
            
            <div class="space-y-3">
                @forelse($classificacao['alto_giro'] as $vacina)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $vacina->nome }}</h4>
                            <p class="text-xs text-gray-600">{{ number_format($vacina->aplicacoes_periodo) }} aplicações</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-green-600">{{ number_format($vacina->giro, 1) }}x</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">Nenhuma vacina com alto giro no período.</p>
                @endforelse
            </div>
        </div>

        <!-- Giro Moderado -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="bg-amber-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Giro Moderado</h3>
                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full font-medium">
                    {{ count($classificacao['giro_moderado']) }}
                </span>
            </div>
            
            <div class="space-y-3">
                @forelse($classificacao['giro_moderado'] as $vacina)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $vacina->nome }}</h4>
                            <p class="text-xs text-gray-600">{{ number_format($vacina->aplicacoes_periodo) }} aplicações</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-amber-600">{{ number_format($vacina->giro, 1) }}x</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">Nenhuma vacina com giro moderado no período.</p>
                @endforelse
            </div>
        </div>

        <!-- Baixo Giro -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="bg-red-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Baixo Giro</h3>
                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                    {{ count($classificacao['baixo_giro']) }}
                </span>
            </div>
            
            <div class="space-y-3">
                @forelse($classificacao['baixo_giro'] as $vacina)
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $vacina->nome }}</h4>
                            <p class="text-xs text-gray-600">{{ number_format($vacina->aplicacoes_periodo) }} aplicações</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-red-600">{{ number_format($vacina->giro, 1) }}x</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">Nenhuma vacina com baixo giro no período.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Análise Detalhada -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Análise Detalhada por Vacina</h2>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Ordenar por:</label>
                    <select onchange="window.location.href = updateUrlParameter(window.location.href, 'ordem', this.value)"
                            class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="giro_desc" {{ request('ordem', 'giro_desc') === 'giro_desc' ? 'selected' : '' }}>Giro ↓</option>
                        <option value="giro_asc" {{ request('ordem') === 'giro_asc' ? 'selected' : '' }}>Giro ↑</option>
                        <option value="aplicacoes_desc" {{ request('ordem') === 'aplicacoes_desc' ? 'selected' : '' }}>Aplicações ↓</option>
                        <option value="receita_desc" {{ request('ordem') === 'receita_desc' ? 'selected' : '' }}>Receita ↓</option>
                        <option value="nome_asc" {{ request('ordem') === 'nome_asc' ? 'selected' : '' }}>Nome A-Z</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vacina</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Médio</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aplicações</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Índice de Giro</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cobertura (dias)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Receita</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($analiseDetalhada as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br {{ $item->cor_gradiente }} flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($item->nome, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nome }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->categoria ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ number_format($item->estoque_medio, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">doses</div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ number_format($item->aplicacoes_periodo) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format($item->aplicacoes_por_dia, 1) }}/dia
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-2xl font-bold {{ $item->cor_giro }}">
                                    {{ number_format($item->giro, 2) }}x
                                </div>
                                <div class="text-xs {{ $item->cor_giro }}">
                                    {{ $item->classificacao_giro }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ number_format($item->cobertura_dias) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format($item->cobertura_dias / 30, 1) }} meses
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-bold text-purple-600">
                                    R$ {{ number_format($item->receita_periodo, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    R$ {{ number_format($item->receita_por_aplicacao, 2, ',', '.') }}/dose
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <!-- Indicador Visual de Performance -->
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $item->estrelas_performance ? $item->cor_performance : 'text-gray-300' }}" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $item->classe_performance }}">
                                        {{ $item->classificacao_performance }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sem dados para análise</h3>
                                    <p class="mt-1 text-sm text-gray-500">Não há movimentações suficientes no período selecionado para calcular o giro de estoque.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recomendações -->
    @if(count($recomendacoes) > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Recomendações de Otimização</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($recomendacoes as $recomendacao)
                    <div class="border-l-4 {{ $recomendacao['cor'] }} p-4 bg-gray-50 rounded-r-lg">
                        <div class="flex">
                            <div>
                                <h3 class="text-sm font-bold {{ str_replace('border-', 'text-', $recomendacao['cor']) }}">
                                    {{ $recomendacao['titulo'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $recomendacao['descricao'] }}</p>
                                @if(isset($recomendacao['vacinas']) && count($recomendacao['vacinas']) > 0)
                                    <p class="text-xs text-gray-500 mt-2">
                                        Vacinas: {{ implode(', ', array_slice($recomendacao['vacinas'], 0, 3)) }}
                                        @if(count($recomendacao['vacinas']) > 3)
                                            e mais {{ count($recomendacao['vacinas']) - 3 }}...
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function ajustarDatas(periodo) {
    const dataInicio = document.querySelector('input[name="data_inicio"]');
    const dataFim = document.querySelector('input[name="data_fim"]');
    const divInicio = document.getElementById('dataInicio');
    const divFim = document.getElementById('dataFim');
    
    if (periodo === 'custom') {
        dataInicio.removeAttribute('readonly');
        dataFim.removeAttribute('readonly');
        divInicio.classList.remove('opacity-50');
        divFim.classList.remove('opacity-50');
    } else {
        const hoje = new Date();
        const inicio = new Date(hoje.getTime() - (parseInt(periodo) * 24 * 60 * 60 * 1000));
        
        dataInicio.value = inicio.toISOString().split('T')[0];
        dataFim.value = hoje.toISOString().split('T')[0];
        
        dataInicio.setAttribute('readonly', 'readonly');
        dataFim.setAttribute('readonly', 'readonly');
        divInicio.classList.add('opacity-50');
        divFim.classList.add('opacity-50');
    }
}

function exportarAnalise() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'xlsx');
    
    const exportUrl = '{{ route("relatorios.estoque.giro") }}?' + params.toString();
    window.open(exportUrl, '_blank');
}

function updateUrlParameter(url, param, paramVal) {
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

// Inicializar baseado no período selecionado
document.addEventListener('DOMContentLoaded', function() {
    const periodoSelect = document.querySelector('select[name="periodo"]');
    if (periodoSelect) {
        ajustarDatas(periodoSelect.value);
    }
});
</script>

@endsection