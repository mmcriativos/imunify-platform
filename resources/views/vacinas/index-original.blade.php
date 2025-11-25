@extends('layouts.tenant-app')

@section('title', 'Vacinas - ' . (tenant('clinic_name') ?? 'MultiImune'))

@section('content')
<!-- Header Moderno com Gradiente -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
                💉 Catálogo de Vacinas
            </h1>
            <p class="text-gray-600 mt-2">Gerencie todas as vacinas disponíveis para aplicação</p>
        </div>
        <a href="{{ route('vacinas.create') }}" 
           class="bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Vacina
        </a>
    </div>
</div>

<!-- Grid de Cards Modernos -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($vacinas as $vacina)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100">
            <!-- Header do Card com Gradiente -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 p-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-bold text-white flex-1">{{ $vacina->nome }}</h3>
                    @if($vacina->ativo)
                        <span class="bg-white/20 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full font-semibold">
                            Ativa
                        </span>
                    @else
                        <span class="bg-red-500/80 text-white text-xs px-3 py-1 rounded-full font-semibold">
                            Inativa
                        </span>
                    @endif
                </div>
                
                @if($vacina->fabricante)
                    <p class="text-white/80 text-sm mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $vacina->fabricante }}
                    </p>
                @endif
            </div>

            <!-- Corpo do Card -->
            <div class="p-5">
                @if($vacina->descricao)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $vacina->descricao }}</p>
                @endif
                
                @php
                    $precos = collect([
                        [
                            'chave' => 'preco_promocional',
                            'label' => 'Promocional',
                            'valor' => $vacina->preco_promocional,
                            'icone' => '🏷️',
                        ],
                        [
                            'chave' => 'preco_venda_pix',
                            'label' => 'PIX/Dinheiro',
                            'valor' => $vacina->preco_venda_pix,
                            'icone' => '💰',
                        ],
                        [
                            'chave' => 'preco_venda_cartao',
                            'label' => 'Cartão',
                            'valor' => $vacina->preco_venda_cartao,
                            'icone' => '💳',
                        ],
                        [
                            'chave' => 'preco_custo',
                            'label' => 'Custo',
                            'valor' => $vacina->preco_custo,
                            'icone' => '💵',
                        ],
                    ])->filter(fn ($item) => !is_null($item['valor']));

                    $preferencia = ['preco_promocional', 'preco_venda_pix', 'preco_venda_cartao', 'preco_custo'];
                    $melhorPreco = null;
                    foreach ($preferencia as $campoPreferido) {
                        $melhorPreco = $precos->firstWhere('chave', $campoPreferido);
                        if ($melhorPreco) {
                            break;
                        }
                    }
                    $melhorPreco = $melhorPreco ?? $precos->first();
                @endphp

                @if($precos->isNotEmpty())
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Melhor Preço
                            </span>
                            <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
                                R$ {{ number_format($melhorPreco['valor'], 2, ',', '.') }}
                            </span>
                        </div>

                        @if($precos->count() > 1)
                            <div class="mt-4 grid grid-cols-1 gap-2">
                                @foreach($precos as $preco)
                                    <div class="flex items-center justify-between text-xs {{ $preco['chave'] === ($melhorPreco['chave'] ?? null) ? 'font-semibold text-gray-900' : 'text-gray-600' }}">
                                        <span class="flex items-center gap-2">
                                            <span>{{ $preco['icone'] }}</span>
                                            {{ $preco['label'] }}
                                            @if($preco['chave'] === ($melhorPreco['chave'] ?? null))
                                                <span class="px-2 py-0.5 text-[10px] uppercase bg-green-100 text-green-700 rounded-full">destaque</span>
                                            @endif
                                        </span>
                                        <span class="text-sm">R$ {{ number_format($preco['valor'], 2, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 mb-4">
                        <p class="text-sm text-gray-600">Sem preços cadastrados para esta vacina.</p>
                    </div>
                @endif

                @if($vacina->indicacoes)
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Indicada para</p>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-3">{{ $vacina->indicacoes }}</p>
                    </div>
                @endif

                <!-- Informações de Dosagem -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 flex items-center gap-1">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            Doses
                        </span>
                        @if($vacina->numero_doses == 1)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Dose Única
                            </span>
                        @else
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $vacina->numero_doses }} doses
                            </span>
                        @endif
                    </div>
                    
                    @if($vacina->intervalo_doses_dias)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 flex items-center gap-1">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Intervalo
                            </span>
                            <span class="text-gray-800 font-semibold">{{ $vacina->intervalo_doses_dias }} dias</span>
                        </div>
                    @endif
                    
                    @if($vacina->validade_dias)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 flex items-center gap-1">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Proteção
                            </span>
                            <span class="text-gray-800 font-semibold">{{ $vacina->validade_dias }} dias</span>
                        </div>
                    @endif
                </div>

                <!-- Botões de Ação Modernos -->
                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('vacinas.edit', $vacina) }}" 
                       class="flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('vacinas.show', $vacina) }}" 
                       class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-16">
            <div class="inline-block p-8 bg-gradient-to-br from-green-50 to-blue-50 rounded-3xl shadow-lg">
                <div class="text-7xl mb-4">💉</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Nenhuma vacina cadastrada</h3>
                <p class="text-gray-600 mb-6">Comece adicionando a primeira vacina ao catálogo</p>
                <a href="{{ route('vacinas.create') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Cadastrar Primeira Vacina
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginação Moderna -->
@if($vacinas->hasPages())
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $vacinas->links() }}
        </div>
    </div>
@endif
@endsection

