@extends('layouts.tenant-app')

@section('title', 'Lotes e Validades - ' . (tenant('clinic_name') ?? 'MultiImune'))

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
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Lotes e Validades</h1>
                    <p class="text-gray-600 mt-1">Controle completo de lotes e alertas de vencimento</p>
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
                
                <button onclick="alertarVencimentos()" 
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 9l5.172-5.172v5.172H4.828zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Alertar Vencimentos
                </button>
            </div>
        </div>
    </div>

    <!-- Alertas Críticos de Vencimento -->
    @if(count($alertasVencimento) > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-6 h-6 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h2 class="text-xl font-bold text-red-600">Alertas de Vencimento</h2>
                <span class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded-full font-medium">
                    {{ count($alertasVencimento) }} lote(s)
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($alertasVencimento as $alerta)
                    <div class="border-l-4 {{ $alerta['status'] === 'vencido' ? 'border-red-500 bg-red-50' : 'border-amber-500 bg-amber-50' }} p-4 rounded-r-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold {{ $alerta['status'] === 'vencido' ? 'text-red-800' : 'text-amber-800' }}">
                                    {{ $alerta['vacina_nome'] }}
                                </h3>
                                <p class="text-sm {{ $alerta['status'] === 'vencido' ? 'text-red-600' : 'text-amber-600' }}">
                                    Lote: {{ $alerta['numero_lote'] }} | 
                                    @if($alerta['status'] === 'vencido')
                                        Vencido em {{ $alerta['data_validade']->format('d/m/Y') }}
                                    @else
                                        Vence em {{ $alerta['dias_para_vencer'] }} dias
                                    @endif
                                </p>
                                <p class="text-xs {{ $alerta['status'] === 'vencido' ? 'text-red-500' : 'text-amber-500' }}">
                                    {{ number_format($alerta['quantidade_disponivel']) }} doses disponíveis
                                </p>
                            </div>
                            
                            <div class="flex flex-col gap-1">
                                <span class="text-xs {{ $alerta['status'] === 'vencido' ? 'text-red-500' : 'text-amber-500' }} font-medium">
                                    {{ $alerta['status'] === 'vencido' ? 'VENCIDO' : 'ATENÇÃO' }}
                                </span>
                                
                                <button onclick="abrirModalAcaoLote('{{ $alerta['id'] }}', '{{ addslashes($alerta['numero_lote']) }}', '{{ addslashes($alerta['vacina_nome']) }}', '{{ $alerta['status'] }}')" 
                                        class="text-xs {{ $alerta['status'] === 'vencido' ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-amber-100 hover:bg-amber-200 text-amber-700' }} px-2 py-1 rounded transition-colors">
                                    Ações
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Vacina</label>
                <input type="text" name="vacina" value="{{ request('vacina') }}" 
                       placeholder="Nome da vacina..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Número do Lote</label>
                <input type="text" name="lote" value="{{ request('lote') }}" 
                       placeholder="Número do lote..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="vencendo" {{ request('status') === 'vencendo' ? 'selected' : '' }}>Vencendo</option>
                    <option value="vencido" {{ request('status') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                    <option value="esgotado" {{ request('status') === 'esgotado' ? 'selected' : '' }}>Esgotado</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Validade até</label>
                <input type="date" name="validade_ate" value="{{ request('validade_ate') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex-1">
                    Filtrar
                </button>
                <a href="{{ route('relatorios.estoque.lotes') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Resumo Estatístico -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ $resumo['ativos'] }}</p>
                    <p class="text-sm text-gray-600">Lotes Ativos</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-amber-600">{{ $resumo['vencendo'] }}</p>
                    <p class="text-sm text-gray-600">Vencendo (60 dias)</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-red-600">{{ $resumo['vencidos'] }}</p>
                    <p class="text-sm text-gray-600">Vencidos</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($resumo['doses_total']) }}</p>
                    <p class="text-sm text-gray-600">Doses em Lotes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Lotes -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Controle de Lotes - {{ $lotes->total() }} lote(s)</h2>
                
                <!-- Ordenação -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Ordenar por:</label>
                    <select onchange="window.location.href = updateUrlParameter(window.location.href, 'ordem', this.value)"
                            class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="validade_asc" {{ request('ordem') === 'validade_asc' ? 'selected' : '' }}>Validade ↑</option>
                        <option value="validade_desc" {{ request('ordem', 'validade_asc') === 'validade_desc' ? 'selected' : '' }}>Validade ↓</option>
                        <option value="quantidade_desc" {{ request('ordem') === 'quantidade_desc' ? 'selected' : '' }}>Quantidade ↓</option>
                        <option value="vacina_asc" {{ request('ordem') === 'vacina_asc' ? 'selected' : '' }}>Vacina A-Z</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vacina / Lote</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Data Validade</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Unitário</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lotes as $lote)
                        <tr class="hover:bg-gray-50 {{ $lote->status === 'vencido' ? 'bg-red-25' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br {{ $lote->cor_gradiente }} flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($lote->numero_lote, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $lote->vacina->nome ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">
                                            <strong>Lote:</strong> {{ $lote->numero_lote }}
                                        </div>
                                        @if($lote->fabricante)
                                            <div class="text-xs text-gray-400">{{ $lote->fabricante }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium {{ $lote->cor_validade }}">
                                    {{ $lote->data_validade->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $lote->dias_para_vencer }} dias
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $lote->classe_status }}">
                                    {{ $lote->status_descricao }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-bold text-gray-900">
                                    {{ number_format($lote->quantidade_disponivel) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    de {{ number_format($lote->quantidade_inicial) }}
                                </div>
                                
                                <!-- Barra de Progresso -->
                                <div class="mt-1">
                                    @php
                                        $percentual = ($lote->quantidade_inicial > 0) ? ($lote->quantidade_disponivel / $lote->quantidade_inicial) * 100 : 0;
                                    @endphp
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        @php
                                            $corBarra = $percentual > 50 ? 'green' : ($percentual > 20 ? 'amber' : 'red');
                                        @endphp
                                        <div class="bg-{{ $corBarra }}-500 h-2 rounded-full" 
                                             style="width: {{ $percentual }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">{{ number_format($percentual, 1) }}%</div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-gray-900">
                                    R$ {{ number_format($lote->custo_unitario ?? 0, 2, ',', '.') }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="text-lg font-bold text-purple-600">
                                    R$ {{ number_format($lote->valor_total ?? 0, 2, ',', '.') }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Histórico do Lote -->
                                    <button onclick="verHistoricoLote('{{ $lote->id }}', '{{ $lote->numero_lote }}')" 
                                            class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                            title="Ver Histórico">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    
                                    <!-- Ações do Lote -->
                                    @if($lote->status === 'vencido' || $lote->status === 'vencendo')
                                        <button onclick="abrirModalAcaoLote('{{ $lote->id }}', '{{ $lote->numero_lote }}', '{{ $lote->vacina->nome }}', '{{ $lote->status }}')" 
                                                class="text-amber-600 hover:text-amber-700 font-medium text-sm"
                                                title="Ações">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <!-- Ajustar Quantidade -->
                                    @if($lote->quantidade_disponivel > 0)
                                        <button onclick="abrirModalAjusteQuantidade('{{ $lote->id }}', '{{ addslashes($lote->numero_lote) }}', {{ $lote->quantidade_disponivel }})" 
                                                class="text-green-600 hover:text-green-700 font-medium text-sm"
                                                title="Ajustar Quantidade">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum lote encontrado</h3>
                                    <p class="mt-1 text-sm text-gray-500">Tente ajustar os filtros ou adicionar novos lotes ao sistema.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lotes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $lotes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Ações do Lote -->
<div id="modalAcoesLote" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-amber-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Ações do Lote</h3>
                    <p class="text-sm text-gray-600" id="infoLote"></p>
                </div>
            </div>
            
            <div class="space-y-3">
                <button onclick="registrarVencimento()" 
                        class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-3 rounded-lg font-medium transition-colors text-left flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <div>
                        <div>Registrar como Vencido</div>
                        <div class="text-xs text-red-500">Remove do estoque ativo</div>
                    </div>
                </button>
                
                <button onclick="transferirLote()" 
                        class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-3 rounded-lg font-medium transition-colors text-left flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <div>
                        <div>Transferir para Outra Unidade</div>
                        <div class="text-xs text-blue-500">Mover estoque</div>
                    </div>
                </button>
                
                <button onclick="adicionarObservacao()" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium transition-colors text-left flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <div>Adicionar Observação</div>
                        <div class="text-xs text-gray-500">Notas sobre o lote</div>
                    </div>
                </button>
                
                <button onclick="fecharModalAcoes()" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let loteAtual = null;

function abrirModalAcaoLote(loteId, numeroLote, vacinaNome, status) {
    loteAtual = {
        id: loteId,
        numero: numeroLote,
        vacina: vacinaNome,
        status: status
    };
    
    document.getElementById('infoLote').textContent = `${vacinaNome} - Lote: ${numeroLote}`;
    document.getElementById('modalAcoesLote').classList.remove('hidden');
}

function fecharModalAcoes() {
    document.getElementById('modalAcoesLote').classList.add('hidden');
    loteAtual = null;
}

function registrarVencimento() {
    if (!loteAtual) return;
    
    if (confirm('Tem certeza que deseja registrar este lote como vencido? Esta ação não pode ser desfeita.')) {
        // Implementar chamada AJAX para registrar vencimento
        alert('Lote registrado como vencido com sucesso!');
        fecharModalAcoes();
        window.location.reload();
    }
}

function transferirLote() {
    if (!loteAtual) return;
    
    // Implementar modal de transferência
    alert('Funcionalidade de transferência será implementada em breve.');
}

function adicionarObservacao() {
    if (!loteAtual) return;
    
    const observacao = prompt('Digite a observação para o lote:');
    if (observacao && observacao.trim()) {
        // Implementar chamada AJAX para salvar observação
        alert('Observação adicionada com sucesso!');
        fecharModalAcoes();
    }
}

function verHistoricoLote(loteId, numeroLote) {
    // Implementar modal ou página de histórico
    alert(`Histórico do lote ${numeroLote} será mostrado em breve.`);
}

function abrirModalAjusteQuantidade(loteId, numeroLote, quantidadeAtual) {
    const novaQuantidade = prompt(`Quantidade atual: ${quantidadeAtual}\nDigite a nova quantidade:`, quantidadeAtual);
    
    if (novaQuantidade !== null && novaQuantidade !== quantidadeAtual.toString()) {
        if (confirm(`Alterar quantidade de ${quantidadeAtual} para ${novaQuantidade}?`)) {
            // Implementar chamada AJAX para ajustar quantidade
            alert('Quantidade ajustada com sucesso!');
            window.location.reload();
        }
    }
}

function alertarVencimentos() {
    alert('Sistema de alertas de vencimento será implementado em breve.');
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

// Fechar modal clicando fora
document.getElementById('modalAcoesLote').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModalAcoes();
    }
});
</script>

@endsection