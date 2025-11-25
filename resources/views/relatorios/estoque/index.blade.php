@extends('layouts.tenant-app')

@section('title', 'Relatórios de Estoque - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Relatórios de Estoque')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-3 rounded-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 3l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Relatórios de Estoque</h1>
                <p class="text-gray-600 mt-1">Analytics completo e rastreabilidade do seu estoque</p>
            </div>
        </div>
    </div>

    <!-- Alertas Críticos -->
    @if(count($alertas) > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h2 class="text-xl font-bold text-red-600">Alertas Críticos</h2>
                <span class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded-full font-medium">
                    {{ count($alertas) }} alerta(s)
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($alertas as $alerta)
                    <div class="border-l-4 {{ $alerta['prioridade'] === 'alta' ? 'border-red-500 bg-red-50' : 'border-amber-500 bg-amber-50' }} p-4 rounded-r-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold {{ $alerta['prioridade'] === 'alta' ? 'text-red-800' : 'text-amber-800' }}">
                                    {{ $alerta['vacina_nome'] }}
                                </h3>
                                <p class="text-sm {{ $alerta['prioridade'] === 'alta' ? 'text-red-600' : 'text-amber-600' }}">
                                    @if($alerta['tipo'] === 'estoque_baixo')
                                        Estoque baixo: {{ $alerta['estoque_atual'] }}/{{ $alerta['estoque_minimo'] }} doses
                                    @else
                                        Lote {{ $alerta['numero_lote'] }} - 
                                        @if($alerta['prioridade'] === 'alta')
                                            Vencido
                                        @else
                                            Vence em {{ $alerta['dias_para_vencer'] }} dias
                                        @endif
                                    @endif
                                </p>
                            </div>
                            <span class="text-xs {{ $alerta['prioridade'] === 'alta' ? 'text-red-500' : 'text-amber-500' }} font-medium">
                                {{ $alerta['prioridade'] === 'alta' ? 'URGENTE' : 'ATENÇÃO' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Estatísticas Gerais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-blue-600">{{ $estatisticas['total_vacinas'] }}</p>
                    <p class="text-sm text-gray-600">Tipos de Vacinas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($estatisticas['total_estoque']) }}</p>
                    <p class="text-sm text-gray-600">Doses Disponíveis</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($estatisticas['valor_total_estoque'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Valor Total do Estoque</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-amber-600">{{ $estatisticas['vacinas_estoque_baixo'] }}</p>
                    <p class="text-sm text-gray-600">Vacinas Estoque Baixo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu de Relatórios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Posição de Estoque -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="text-center">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Posição de Estoque</h3>
                <p class="text-gray-600 mb-4">Visão completa do estoque atual de todas as vacinas com alertas e valores</p>
                <a href="{{ route('relatorios.estoque.posicao') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                    Visualizar
                </a>
            </div>
        </div>

        <!-- Movimentações -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="text-center">
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Movimentações</h3>
                <p class="text-gray-600 mb-4">Histórico completo de entradas, saídas e movimentações por período</p>
                <a href="{{ route('relatorios.estoque.movimentacoes') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                    Visualizar
                </a>
            </div>
        </div>

        <!-- Lotes e Validades -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="text-center">
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lotes e Validades</h3>
                <p class="text-gray-600 mb-4">Controle de lotes, datas de validade e alertas de vencimento</p>
                <a href="{{ route('relatorios.estoque.lotes') }}" 
                   class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                    Visualizar
                </a>
            </div>
        </div>

        <!-- Giro de Estoque -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6">
            <div class="text-center">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Giro de Estoque</h3>
                <p class="text-gray-600 mb-4">Análise de rotatividade e performance de cada vacina no estoque</p>
                <a href="{{ route('relatorios.estoque.giro') }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                    Visualizar
                </a>
            </div>
        </div>

        <!-- Análise de Custos -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 opacity-75">
            <div class="text-center">
                <div class="bg-gradient-to-br from-red-500 to-red-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Análise de Custos</h3>
                <p class="text-gray-600 mb-4">Relatório financeiro detalhado com margens e rentabilidade</p>
                <span class="bg-gray-300 text-gray-600 px-6 py-2 rounded-lg font-medium cursor-not-allowed inline-block">
                    Em Breve
                </span>
            </div>
        </div>

        <!-- Previsão de Compras -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 opacity-75">
            <div class="text-center">
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-4 rounded-full inline-block mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Previsão de Compras</h3>
                <p class="text-gray-600 mb-4">IA para sugestão automática de reposição baseada no consumo</p>
                <span class="bg-gray-300 text-gray-600 px-6 py-2 rounded-lg font-medium cursor-not-allowed inline-block">
                    Em Breve
                </span>
            </div>
        </div>
    </div>

    <!-- Movimentações Recentes -->
    @if(count($movimentacoesRecentes) > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Movimentações Recentes</h2>
                <a href="{{ route('relatorios.estoque.movimentacoes') }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Ver Todas →
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vacina</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($movimentacoesRecentes as $mov)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $mov->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $mov->vacina->nome ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $mov->cor_tipo === 'green' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $mov->cor_tipo === 'red' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $mov->cor_tipo === 'blue' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $mov->cor_tipo === 'amber' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $mov->cor_tipo === 'purple' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ $mov->tipo_descricao }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono
                                    {{ in_array($mov->tipo, ['entrada', 'devolucao']) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ in_array($mov->tipo, ['entrada', 'devolucao']) ? '+' : '-' }}{{ $mov->quantidade }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $mov->user->name ?? 'Sistema' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection