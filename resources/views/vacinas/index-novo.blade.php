@extends('layouts.tenant-app')

@section('title', 'Controle de Vacinas - ' . (tenant('clinic_name') ?? 'MultiImune'))

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
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
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
                $estoqueTotal = $vacinas->sum('estoque_atual');
                $vacinasEstoqueBaixo = $vacinas->where('estoque_baixo', true)->count();
                $valorTotalEstoque = $vacinas->sum('valor_estoque');
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
                if ($vacina->estoque_atual == 0) {
                    $classeEstoque = 'estoque-critico';
                } elseif ($vacina->estoque_baixo) {
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
                            @if($vacina->status === 'Ativo')
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">
                                    Ativa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                                    {{ $vacina->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Informações de Estoque -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Estoque Atual</p>
                                <p class="text-2xl font-bold {{ $vacina->estoque_atual == 0 ? 'text-red-600' : ($vacina->estoque_baixo ? 'text-amber-600' : 'text-green-600') }}">
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
                        <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors">
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
@endsection