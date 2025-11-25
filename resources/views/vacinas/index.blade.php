@extends('layouts.tenant-app')

@section('title', 'Controle de Vacinas - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Vacinas')

@push('styles')
<style>
    .estoque-critico { border-left: 4px solid #ef4444; }
    .estoque-baixo { border-left: 4px solid #f59e0b; }
    .estoque-ok { border-left: 4px solid #10b981; }
    .lote-vencendo { background: linear-gradient(135deg, #fef3c7, #fed7aa); }
    .lote-vencido { background: linear-gradient(135deg, #fee2e2, #fecaca); }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header com Estatísticas -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    Controle de Vacinas
                </h1>
                <p class="text-gray-600 mt-2">Gestão completa do estoque e rastreabilidade</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('vacinas.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Vacina
                </a>
                <button onclick="openModalEntradaLote()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    Entrada de Lote
                </button>
            </div>
        </div>

        <!-- Estatísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            @php
                $totalVacinas = $vacinas->total();
                $estoqueTotal = $vacinas->sum('estoque_atual') ?? 0;
                $vacinasEstoqueBaixo = 0;
                $valorTotalEstoque = 0;
                
                // Calcular estatísticas
                foreach($vacinas as $v) {
                    // Contar vacinas com estoque baixo
                    if(($v->estoque_atual ?? 0) < ($v->estoque_minimo ?? 5)) {
                        $vacinasEstoqueBaixo++;
                    }
                    
                    // Calcular valor total do estoque
                    // Prioriza custo_medio (dos lotes), mas usa preco_custo como fallback
                    $custo = $v->custo_medio ?? $v->preco_custo ?? 0;
                    if($custo > 0 && $v->estoque_atual > 0) {
                        $valorTotalEstoque += ($v->estoque_atual * $custo);
                    }
                }
            @endphp
            
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalVacinas }}</p>
                        <p class="text-sm text-blue-600">Tipos de Vacinas</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($estoqueTotal) }}</p>
                        <p class="text-sm text-green-600">Doses Disponíveis</p>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 p-2 rounded">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-amber-600">{{ $vacinasEstoqueBaixo }}</p>
                        <p class="text-sm text-amber-600">Estoque Baixo</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($valorTotalEstoque, 2, ',', '.') }}</p>
                        <p class="text-sm text-purple-600">Valor do Estoque</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Vacinas com Controle de Estoque -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($vacinas as $vacina)
            @php
                $classeEstoque = 'estoque-ok';
                $estoqueAtual = $vacina->estoque_atual ?? 0;
                $estoqueMinimo = $vacina->estoque_minimo ?? 5;
                
                if ($estoqueAtual == 0) {
                    $classeEstoque = 'estoque-critico';
                } elseif ($estoqueAtual < $estoqueMinimo) {
                    $classeEstoque = 'estoque-baixo';
                }
            @endphp
            
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 {{ $classeEstoque }}">
                <!-- Header da Vacina -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $vacina->nome }}</h3>
                            @if($vacina->fabricante)
                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $vacina->fabricante }}
                                </p>
                            @endif
                            
                            @if($vacina->categoria)
                                <span class="inline-block mt-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                    {{ $vacina->categoria }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="text-right">
                            @if($vacina->ativo)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">
                                    Ativa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                                    Inativa
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Informações de Estoque -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Estoque Atual</p>
                                <p class="text-2xl font-bold {{ $estoqueAtual == 0 ? 'text-red-600' : ($estoqueAtual < $estoqueMinimo ? 'text-amber-600' : 'text-green-600') }}">
                                    {{ number_format($vacina->estoque_atual) }}
                                </p>
                                <p class="text-xs text-gray-500">Mín: {{ $vacina->estoque_minimo }} | Ideal: {{ $vacina->estoque_ideal }}</p>
                            </div>
                            
                            <div>
                                @if($vacina->custo_medio)
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Valor Estoque</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        R$ {{ number_format($vacina->valor_estoque, 2, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">Custo médio: R$ {{ number_format($vacina->custo_medio, 2, ',', '.') }}</p>
                                @else
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Preço Venda</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        R$ {{ number_format($vacina->preco_venda_pix ?? 0, 2, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Barra de Progresso do Estoque -->
                        <div class="mt-3">
                            @php
                                $porcentagem = $vacina->estoque_ideal > 0 ? min(100, ($vacina->estoque_atual / $vacina->estoque_ideal) * 100) : 0;
                                $corBarra = $porcentagem <= 25 ? 'bg-red-500' : ($porcentagem <= 50 ? 'bg-amber-500' : 'bg-green-500');
                            @endphp
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Nível do Estoque</span>
                                <span>{{ number_format($porcentagem, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="{{ $corBarra }} h-2 rounded-full transition-all duration-500" style="width: {{ $porcentagem }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Lotes Disponíveis -->
                    @if($vacina->lotes && $vacina->lotes->count() > 0)
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Lotes Disponíveis ({{ $vacina->lotes->count() }})
                            </h4>
                            <div class="space-y-1 max-h-32 overflow-y-auto">
                                @foreach($vacina->lotes->take(3) as $lote)
                                    <div class="text-xs bg-white border rounded p-2 flex justify-between items-center {{ $lote->vencendo ? 'lote-vencendo' : ($lote->vencido ? 'lote-vencido' : '') }}">
                                        <div>
                                            <span class="font-medium">{{ $lote->numero_lote }}</span>
                                            <span class="text-gray-500">• {{ $lote->quantidade_atual }} un.</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium {{ $lote->vencido ? 'text-red-600' : ($lote->vencendo ? 'text-amber-600' : 'text-gray-600') }}">
                                                {{ $lote->data_validade->format('d/m/Y') }}
                                            </div>
                                            @if($lote->vencido)
                                                <span class="text-red-600 text-xs">Vencido</span>
                                            @elseif($lote->vencendo)
                                                <span class="text-amber-600 text-xs">{{ abs($lote->dias_para_vencer) }} dias</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @if($vacina->lotes->count() > 3)
                                    <p class="text-xs text-gray-500 text-center">... e mais {{ $vacina->lotes->count() - 3 }} lotes</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Indicador de Esquema de Doses -->
                    @php
                        $temEsquema = $vacina->esquemaDoses->isNotEmpty();
                        $totalDoses = $vacina->esquemaDoses->count();
                    @endphp
                    <div class="mb-4">
                        @if($temEsquema)
                            <div class="flex items-center gap-2 text-xs bg-purple-50 border border-purple-200 rounded-lg p-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-purple-800 font-medium">Esquema configurado: {{ $totalDoses }} {{ $totalDoses == 1 ? 'dose' : 'doses' }}</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-xs bg-amber-50 border border-amber-300 rounded-lg p-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="text-amber-800 font-medium">Esquema não configurado</span>
                                <a href="{{ route('vacinas.esquema', $vacina) }}" class="ml-auto text-amber-700 hover:text-amber-900 underline">
                                    Configurar
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Ações -->
                    <div class="flex gap-2">
                        <a href="{{ route('vacinas.show', $vacina) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                            Ver Detalhes
                        </a>
                        <a href="{{ route('vacinas.edit', $vacina) }}" 
                           class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                            Editar
                        </a>
                        <a href="{{ route('vacinas.esquema', $vacina) }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors" 
                           title="Esquema de Doses">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </a>
                        <button onclick="openModalAjusteRapido({{ $vacina->id }}, '{{ $vacina->nome }}', {{ $vacina->estoque_atual ?? 0 }})" 
                                class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors" 
                                title="Ajuste Rápido de Estoque">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma vacina encontrada</h3>
                    <p class="text-gray-600 mb-6">Comece cadastrando sua primeira vacina no sistema.</p>
                    <a href="{{ route('vacinas.create') }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Cadastrar Primeira Vacina
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($vacinas->hasPages())
        <div class="flex justify-center mt-8">
            {{ $vacinas->links() }}
        </div>
    @endif
</div>

<!-- Modal Ajuste Rápido de Estoque -->
<div id="modalAjusteRapido" class="hidden fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
    <div class="relative top-20 mx-auto p-6 w-full max-w-lg animate-slideDown">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Ajuste Rápido</h3>
                            <p class="text-blue-100 text-sm" id="ajuste-vacina-nome"></p>
                        </div>
                    </div>
                    <button onclick="closeModalAjusteRapido()" class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formAjusteRapido" class="p-6">
                @csrf
                <input type="hidden" id="vacina_ajuste_id" name="vacina_id">
                
                <!-- Estoque Atual -->
                <div class="bg-gray-50 rounded-xl p-4 mb-5 text-center border-2 border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Estoque Atual</p>
                    <p class="text-4xl font-bold text-gray-900" id="ajuste-estoque-atual">0</p>
                    <p class="text-xs text-gray-500 mt-1">doses disponíveis</p>
                </div>
                
                <!-- Tipo de Ajuste -->
                <input type="hidden" id="tipo_ajuste" name="tipo" value="adicionar">
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <button type="button" id="btn-adicionar" 
                            onclick="document.getElementById('tipo_ajuste').value='adicionar'; toggleTipoAjuste();"
                            class="py-3 px-4 rounded-xl font-semibold transition-all bg-green-600 text-white flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Adicionar
                    </button>
                    <button type="button" id="btn-remover"
                            onclick="document.getElementById('tipo_ajuste').value='remover'; toggleTipoAjuste();"
                            class="py-3 px-4 rounded-xl font-semibold transition-all bg-gray-200 text-gray-600 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                        Remover
                    </button>
                </div>
                
                <!-- Quantidade -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Quantidade <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantidade" id="quantidade_ajuste" required min="1"
                           class="w-full px-4 py-3 text-2xl font-bold text-center border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="0">
                </div>
                
                <!-- Motivo -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Motivo <span class="text-red-500">*</span>
                    </label>
                    <select name="motivo" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Selecione...</option>
                        <option value="Compra">Compra</option>
                        <option value="Doação">Doação</option>
                        <option value="Ajuste de Inventário">Ajuste de Inventário</option>
                        <option value="Correção Manual">Correção Manual</option>
                        <option value="Perda">Perda</option>
                        <option value="Vencimento">Vencimento</option>
                        <option value="Devolução">Devolução</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                
                <!-- Observações -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Observações
                    </label>
                    <textarea name="observacoes" rows="2"
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                              placeholder="Informações adicionais..."></textarea>
                </div>
                
                <!-- Botões -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeModalAjusteRapido()"
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all font-semibold">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-semibold shadow-lg">
                        Confirmar Ajuste
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Entrada de Lote -->
<div id="modalEntradaLote" class="hidden fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
    <div class="relative top-10 mx-auto p-6 w-full max-w-3xl animate-slideDown">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header com gradiente -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Entrada de Novo Lote</h3>
                            <p class="text-green-100 text-sm mt-1">Registre a chegada de um novo lote de vacinas</p>
                        </div>
                    </div>
                    <button onclick="closeModalEntradaLote()" class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
        <form id="formEntradaLote" class="p-6">
            @csrf
            <div class="space-y-5">
                <!-- Vacina -->
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        Vacina <span class="text-red-500">*</span>
                    </label>
                    <select name="vacina_id" id="vacina_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white">
                        <option value="">Selecione a vacina</option>
                        @foreach($vacinas as $v)
                            <option value="{{ $v->id }}">{{ $v->nome }} @if($v->fabricante)- {{ $v->fabricante }}@endif</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Número do Lote -->
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Número do Lote <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="numero_lote" required
                               class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
                               placeholder="Ex: L2024001">
                    </div>
                    
                    <!-- Quantidade -->
                    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Quantidade de Doses <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantidade_recebida" required min="1"
                               class="w-full px-4 py-3 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white"
                               placeholder="Ex: 100">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Data de Fabricação -->
                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Data de Fabricação
                        </label>
                        <input type="date" name="data_fabricacao"
                               class="w-full px-4 py-3 border border-purple-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all bg-white">
                    </div>
                    
                    <!-- Data de Validade -->
                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Data de Validade <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="data_validade" required
                               class="w-full px-4 py-3 border border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all bg-white">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Preço Unitário -->
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Preço Unitário de Compra (R$) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">R$</span>
                            <input type="text" name="preco_unitario_compra" id="preco_unitario_lote" required inputmode="decimal"
                                   class="w-full pl-12 pr-4 py-3 border border-emerald-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all bg-white"
                                   placeholder="0,00">
                        </div>
                    </div>
                    
                    <!-- Nota Fiscal -->
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Número da Nota Fiscal
                        </label>
                        <input type="text" name="numero_nota_fiscal"
                               class="w-full px-4 py-3 border border-indigo-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white"
                               placeholder="Ex: NF-12345">
                    </div>
                </div>
                
                <!-- Fornecedor -->
                <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-200">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Fornecedor
                    </label>
                    <input type="text" name="fornecedor_lote"
                           class="w-full px-4 py-3 border border-cyan-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all bg-white"
                           placeholder="Nome do fornecedor">
                </div>
                
                <!-- Observações -->
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Observações
                    </label>
                    <textarea name="observacoes" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-500 focus:border-transparent transition-all bg-white resize-none"
                              placeholder="Informações adicionais sobre o lote..."></textarea>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 flex justify-between items-center gap-3 border-t">
                <button type="button" onclick="closeModalEntradaLote()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </button>
                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Registrar Entrada
                </button>
            </div>
        </form>
    </div>
    </div>
</div>

@push('styles')
<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}

/* Animação para o backdrop */
#modalEntradaLote:not(.hidden) {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
@endpush

@push('scripts')
<script>
// Função de máscara de moeda
function mascaraMoeda(campo) {
    let valor = campo.value.replace(/\D/g, '');
    
    if (!valor) {
        campo.value = '';
        return;
    }
    
    const numero = parseInt(valor, 10);
    
    if (Number.isNaN(numero)) {
        campo.value = '';
        return;
    }
    
    const resultado = (numero / 100).toFixed(2);
    const [inteira, decimal] = resultado.split('.');
    const inteiraFormatada = inteira.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    campo.value = `${inteiraFormatada},${decimal}`;
}

function openModalEntradaLote() {
    document.getElementById('modalEntradaLote').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevenir scroll do body
}

function closeModalEntradaLote() {
    document.getElementById('modalEntradaLote').classList.add('hidden');
    document.getElementById('formEntradaLote').reset();
    document.body.style.overflow = ''; // Restaurar scroll
}

// Modal de Ajuste Rápido
let vacinaAjusteAtual = null;

function openModalAjusteRapido(vacinaId, vacinaNome, estoqueAtual) {
    vacinaAjusteAtual = { id: vacinaId, nome: vacinaNome, estoque: estoqueAtual };
    
    document.getElementById('ajuste-vacina-nome').textContent = vacinaNome;
    document.getElementById('ajuste-estoque-atual').textContent = estoqueAtual;
    document.getElementById('modalAjusteRapido').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Resetar form
    document.getElementById('formAjusteRapido').reset();
    document.getElementById('tipo_ajuste').value = 'adicionar';
    toggleTipoAjuste();
}

function closeModalAjusteRapido() {
    document.getElementById('modalAjusteRapido').classList.add('hidden');
    document.getElementById('formAjusteRapido').reset();
    document.body.style.overflow = '';
    vacinaAjusteAtual = null;
}

function toggleTipoAjuste() {
    const tipo = document.getElementById('tipo_ajuste').value;
    const btnAdicionar = document.getElementById('btn-adicionar');
    const btnRemover = document.getElementById('btn-remover');
    
    if (tipo === 'adicionar') {
        btnAdicionar.classList.add('bg-green-600', 'text-white');
        btnAdicionar.classList.remove('bg-gray-200', 'text-gray-600');
        btnRemover.classList.remove('bg-red-600', 'text-white');
        btnRemover.classList.add('bg-gray-200', 'text-gray-600');
    } else {
        btnRemover.classList.add('bg-red-600', 'text-white');
        btnRemover.classList.remove('bg-gray-200', 'text-gray-600');
        btnAdicionar.classList.remove('bg-green-600', 'text-white');
        btnAdicionar.classList.add('bg-gray-200', 'text-gray-600');
    }
}

// Submit do formulário de ajuste rápido
document.getElementById('formAjusteRapido').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!vacinaAjusteAtual) return;
    
    const formData = new FormData(this);
    const tipo = document.getElementById('tipo_ajuste').value;
    const quantidade = parseInt(document.getElementById('quantidade_ajuste').value);
    
    // Validar estoque para remoção
    if (tipo === 'remover' && quantidade > vacinaAjusteAtual.estoque) {
        showNotification('❌ Quantidade maior que o estoque disponível!', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processando...';
    
    try {
        const route = tipo === 'adicionar' 
            ? '{{ url("/estoque/adicionar") }}/' + vacinaAjusteAtual.id
            : '{{ url("/estoque/remover") }}/' + vacinaAjusteAtual.id;
            
        const response = await fetch(route, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success || response.ok) {
            showNotification('✅ Estoque atualizado com sucesso!', 'success');
            closeModalAjusteRapido();
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification('❌ ' + (data.message || 'Erro ao atualizar estoque'), 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('❌ Erro ao processar ajuste. Tente novamente.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

// Fechar modal ao clicar fora
document.getElementById('modalAjusteRapido')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModalAjusteRapido();
    }
});

// Fechar modal ao clicar fora
document.getElementById('modalEntradaLote')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModalEntradaLote();
    }
});

// Aplicar máscara no campo de preço
document.addEventListener('DOMContentLoaded', function() {
    const campoPreco = document.getElementById('preco_unitario_lote');
    if (campoPreco) {
        campoPreco.addEventListener('input', function() {
            mascaraMoeda(this);
            
            // Feedback visual
            this.classList.add('ring-2', 'ring-emerald-300');
            setTimeout(() => {
                this.classList.remove('ring-2', 'ring-emerald-300');
            }, 300);
        });
    }
});

// Submit do formulário
document.getElementById('formEntradaLote').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Converter valor formatado para decimal
    const precoInput = document.getElementById('preco_unitario_lote');
    if (precoInput && precoInput.value) {
        const valorDecimal = precoInput.value.replace(/\./g, '').replace(',', '.');
        formData.set('preco_unitario_compra', valorDecimal);
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Desabilitar botão e mostrar loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processando...';
    
    try {
        const response = await fetch('{{ route("lotes.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Mostrar notificação de sucesso
            showNotification('✅ ' + data.message, 'success');
            closeModalEntradaLote();
            // Recarregar página para atualizar estoque
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('❌ Erro ao processar entrada de lote. Tente novamente.', 'error');
    } finally {
        // Restaurar botão
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

// Função para mostrar notificações
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl z-[9999] animate-slideDown`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.style.transition = 'all 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection