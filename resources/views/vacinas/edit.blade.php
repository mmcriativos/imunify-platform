@extends('layouts.tenant-app')

@section('title', 'Editar Vacina - MultiImune')
@section('page-title', 'Editar Vacina')

@section('content')
<!-- Header Simplificado -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-orange-400 to-red-500 rounded-xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="text-white">
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar: {{ $vacina->nome }}
                </h1>
                <p class="text-orange-100 mt-1">{{ $vacina->fabricante ?? 'Sem fabricante' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('vacinas.estoque') }}?vacina={{ $vacina->id }}" 
                   class="bg-indigo-500/80 hover:bg-indigo-600/90 text-white px-4 py-2 rounded-lg text-sm flex items-center transition-all">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                    </svg>
                    📦 Estoque
                </a>
                <a href="{{ route('vacinas.show', $vacina) }}" 
                   class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm">
                    Visualizar
                </a>
                <a href="{{ route('vacinas.index') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Layout com Colunas -->
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Coluna Principal - Formulário (2/3) -->
        <div class="lg:col-span-2">
            <form action="{{ route('vacinas.update', $vacina) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
        
        <!-- Card 1: Informações Básicas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                Informações Básicas
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nome -->
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome da Vacina *
                    </label>
                    <input type="text" name="nome" id="nome" required 
                           value="{{ old('nome', $vacina->nome) }}"
                           placeholder="Ex: COVID-19, Hepatite B, Gripe"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('nome')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fabricante -->
                <div>
                    <label for="fabricante" class="block text-sm font-medium text-gray-700 mb-2">
                        Fabricante
                    </label>
                    <input type="text" name="fabricante" id="fabricante" 
                           value="{{ old('fabricante', $vacina->fabricante) }}"
                           placeholder="Ex: Pfizer, Butantan, GSK"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Card 2: Esquema Vacinal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                Esquema Vacinal
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Número de Doses -->
                <div>
                    <label for="numero_doses" class="block text-sm font-medium text-gray-700 mb-2">
                        Número de Doses *
                    </label>
                    <select name="numero_doses" id="numero_doses" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Selecione...</option>
                        <option value="1" {{ old('numero_doses', $vacina->numero_doses) == 1 ? 'selected' : '' }}>1 dose (única)</option>
                        <option value="2" {{ old('numero_doses', $vacina->numero_doses) == 2 ? 'selected' : '' }}>2 doses</option>
                        <option value="3" {{ old('numero_doses', $vacina->numero_doses) == 3 ? 'selected' : '' }}>3 doses</option>
                        <option value="4" {{ old('numero_doses', $vacina->numero_doses) == 4 ? 'selected' : '' }}>4+ doses</option>
                    </select>
                </div>

                <!-- Intervalo entre Doses -->
                <div id="intervaloContainer">
                    <label for="intervalo_doses_dias" class="block text-sm font-medium text-gray-700 mb-2">
                        Intervalo entre Doses (dias)
                    </label>
                    <input type="number" name="intervalo_doses_dias" id="intervalo_doses_dias" min="0"
                           value="{{ old('intervalo_doses_dias', $vacina->intervalo_doses_dias) }}"
                           placeholder="Ex: 30, 60, 90"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <p class="text-xs text-gray-500 mt-1">Deixe em branco se for dose única</p>
                </div>
            </div>

            <!-- Validade da Proteção -->
            <div class="mt-4">
                <label for="validade_dias" class="block text-sm font-medium text-gray-700 mb-2">
                    Validade da Proteção (dias)
                </label>
                <input type="number" name="validade_dias" id="validade_dias" min="0"
                       value="{{ old('validade_dias', $vacina->validade_dias) }}"
                       placeholder="Ex: 365 (1 ano), 1095 (3 anos)"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <p class="text-xs text-gray-500 mt-1">Tempo de proteção após completar o esquema vacinal</p>
            </div>
        </div>

        <!-- Card 3: Preços -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                Preços
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Preço à Vista -->
                <div>
                    <label for="preco_venda_pix" class="block text-sm font-medium text-gray-700 mb-2">
                        Preço à Vista/PIX (R$) *
                    </label>
                    <input type="text" name="preco_venda_pix" id="preco_venda_pix" 
                           value="{{ old('preco_venda_pix', $vacina->preco_venda_pix) }}"
                           placeholder="0,00"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">Preço com desconto para pagamento à vista</p>
                </div>

                <!-- Preço no Cartão -->
                <div>
                    <label for="preco_venda_cartao" class="block text-sm font-medium text-gray-700 mb-2">
                        Preço no Cartão (R$) *
                    </label>
                    <input type="text" name="preco_venda_cartao" id="preco_venda_cartao" 
                           value="{{ old('preco_venda_cartao', $vacina->preco_venda_cartao) }}"
                           placeholder="0,00"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">Preço para pagamentos no cartão</p>
                </div>

                <!-- Preço de Custo -->
                <div>
                    <label for="preco_custo" class="block text-sm font-medium text-gray-700 mb-2">
                        Preço de Custo (R$)
                    </label>
                    <input type="text" name="preco_custo" id="preco_custo" 
                           value="{{ old('preco_custo', $vacina->preco_custo) }}"
                           placeholder="0,00"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">Seu custo por dose (para controle interno)</p>
                </div>

                <!-- Preço Promocional -->
                <div>
                    <label for="preco_promocional" class="block text-sm font-medium text-gray-700 mb-2">
                        Preço Promocional (R$)
                    </label>
                    <input type="text" name="preco_promocional" id="preco_promocional" 
                           value="{{ old('preco_promocional', $vacina->preco_promocional) }}"
                           placeholder="0,00"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">Preço especial em campanhas (opcional)</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Configurações -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                Configurações
            </h3>
            
            <div class="space-y-4">
                <!-- Descrição Simplificada -->
                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                        Observações (opcional)
                    </label>
                    <textarea name="descricao" id="descricao" rows="3"
                              placeholder="Informações adicionais, contraindicações ou observações importantes"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('descricao', $vacina->descricao) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Adicione apenas informações essenciais para sua equipe</p>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="ativo" id="ativo" value="1" 
                           {{ old('ativo', $vacina->ativo) ? 'checked' : '' }}
                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                    <label for="ativo" class="ml-2 text-sm font-medium text-gray-700">
                        Vacina ativa (disponível para agendamentos)
                    </label>
                </div>
            </div>
        </div>

                <!-- Botões de Ação -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('vacinas.index') }}" 
                       class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-opacity-30">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-8 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 focus:ring-2 focus:ring-orange-500 focus:ring-opacity-30 font-medium">
                        💾 Salvar Alterações
                    </button>
                </div>
            </form>
        </div>

        <!-- Coluna Lateral - Cards Informativos (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Card: Status da Vacina -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 shadow-lg border border-yellow-100 card-hover">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">Status Atual</h4>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-600 font-medium">Nome:</span>
                        <span class="font-semibold text-gray-800">{{ Str::limit($vacina->nome, 20) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-600 font-medium">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $vacina->ativo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $vacina->ativo ? '✅ Ativa' : '❌ Inativa' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-600 font-medium">Criada em:</span>
                        <span class="font-semibold text-gray-800">{{ $vacina->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                        <span class="text-gray-600 font-medium">Atualizada:</span>
                        <span class="font-semibold text-gray-800">{{ $vacina->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Card: Resumo de Estoque -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 shadow-lg border border-indigo-100 card-hover">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">📦 Estoque</h4>
                </div>
                
                @php
                    $estoqueAtual = $vacina->estoque_atual ?? 0;
                    $estoqueMinimo = $vacina->estoque_minimo ?? 10;
                    $status = $estoqueAtual == 0 ? 'danger' : ($estoqueAtual <= $estoqueMinimo ? 'warning' : 'success');
                    $statusText = $estoqueAtual == 0 ? 'Zerado' : ($estoqueAtual <= $estoqueMinimo ? 'Baixo' : 'Normal');
                    $statusColor = $estoqueAtual == 0 ? 'red' : ($estoqueAtual <= $estoqueMinimo ? 'yellow' : 'green');
                    $loteAtual = $vacina->lote_atual ?? null;
                    $validadeLote = isset($vacina->validade_lote) ? $vacina->validade_lote : null;
                @endphp
                
                <div class="space-y-3 text-sm">
                    <div class="p-4 bg-white rounded-lg border-l-4 border-{{ $statusColor }}-400">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 font-medium">Estoque Atual:</span>
                            <span class="font-bold text-2xl text-{{ $statusColor }}-600">{{ $estoqueAtual }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">Status:</span>
                            <span class="px-2 py-1 text-xs font-semibold bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 rounded-full">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>
                    
                    @if($estoqueMinimo > 0)
                    <div class="p-3 bg-white rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Estoque Mínimo:</span>
                            <span class="font-semibold text-gray-800">{{ $estoqueMinimo }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($loteAtual)
                    <div class="p-3 bg-white rounded-lg">
                        <div class="text-gray-600 font-medium text-xs mb-1">Lote Atual:</div>
                        <div class="font-semibold text-gray-800">{{ $loteAtual }}</div>
                        @if($validadeLote)
                        <div class="text-xs text-gray-500 mt-1">
                            Válido até: {{ \Carbon\Carbon::parse($validadeLote)->format('d/m/Y') }}
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Botão para Gestão -->
                <div class="mt-4 pt-4 border-t border-indigo-100">
                    <a href="{{ route('vacinas.estoque') }}?vacina={{ $vacina->id }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg btn-action text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                        </svg>
                        🔧 Gerenciar Estoque
                    </a>
                </div>
            </div>

            <!-- Card: Dicas de Edição -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 shadow-lg border border-blue-100 card-hover">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">💡 Dicas Importantes</h4>
                </div>
                
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-start p-3 bg-white rounded-lg">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs">1</span>
                        </div>
                        <span>Verifique se o <strong>número de doses</strong> está correto para o protocolo</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-lg">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs">2</span>
                        </div>
                        <span>Atualize os <strong>preços</strong> conforme mudanças de fornecedor</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-lg">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs">3</span>
                        </div>
                        <span>Use <strong>observações</strong> para info importante da equipe</span>
                    </li>
                    <li class="flex items-start p-3 bg-white rounded-lg">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs">4</span>
                        </div>
                        <span>Alterações afetam apenas <strong>novos agendamentos</strong></span>
                    </li>
                </ul>
            </div>

            <!-- Card: Informações de Preços -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 shadow-lg border border-green-100 card-hover">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">💰 Gestão de Preços</h4>
                </div>
                
                <div class="space-y-3 text-sm">
                    @if($vacina->preco_venda_pix)
                    <div class="p-3 bg-white rounded-lg border-l-4 border-green-400">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">💳 À Vista/PIX:</span>
                            <span class="font-bold text-green-600">R$ {{ number_format($vacina->preco_venda_pix, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($vacina->preco_venda_cartao)
                    <div class="p-3 bg-white rounded-lg border-l-4 border-blue-400">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">💳 Cartão:</span>
                            <span class="font-bold text-blue-600">R$ {{ number_format($vacina->preco_venda_cartao, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($vacina->preco_promocional)
                    <div class="p-3 bg-white rounded-lg border-l-4 border-purple-400">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">🏷️ Promocional:</span>
                            <span class="font-bold text-purple-600">R$ {{ number_format($vacina->preco_promocional, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card: Ações Rápidas -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 shadow-lg border border-purple-100 card-hover">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">⚡ Ações Rápidas</h4>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('vacinas.show', $vacina) }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg btn-action text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        👁️ Visualizar Detalhes
                    </a>
                    
                    <a href="{{ route('vacinas.create') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg shadow-md hover:shadow-lg btn-action text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        ➕ Nova Vacina
                    </a>
                    
                    <a href="{{ route('vacinas.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-lg shadow-md hover:shadow-lg btn-action text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        📋 Listar Todas
                    </a>
                    
                    <a href="{{ route('vacinas.index') }}?tab=estoque" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg btn-action text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                        </svg>
                        📦 Gestão de Estoque
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Efeitos para os cards laterais */
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    /* Animações suaves para botões */
    .btn-action {
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Efeito pulse para elementos importantes */
    .pulse-gentle {
        animation: pulse-gentle 2s infinite;
    }

    @keyframes pulse-gentle {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* Gradientes suaves */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Bordas coloridas para cards de preço */
    .price-card {
        position: relative;
        overflow: hidden;
    }
    
    .price-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #059669);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Controle do intervalo de doses
    function toggleIntervaloDoses() {
        const numeroDoses = document.getElementById('numero_doses');
        const intervaloContainer = document.getElementById('intervaloContainer');
        const intervaloInput = document.getElementById('intervalo_doses_dias');

        if (!numeroDoses || !intervaloContainer || !intervaloInput) return;

        const isUnicaDose = Number(numeroDoses.value) === 1;
        
        if (isUnicaDose) {
            intervaloContainer.style.opacity = '0.5';
            intervaloInput.disabled = true;
            intervaloInput.value = '';
            intervaloInput.placeholder = 'Não aplicável para dose única';
        } else {
            intervaloContainer.style.opacity = '1';
            intervaloInput.disabled = false;
            intervaloInput.placeholder = 'Ex: 30, 60, 90';
        }
    }

    // Máscara para valores monetários
    function mascaraMoeda(campo) {
        let valor = campo.value.replace(/\D/g, '');
        if (!valor) {
            campo.value = '';
            return;
        }
        
        const centavos = parseInt(valor, 10);
        if (isNaN(centavos)) {
            campo.value = '';
            return;
        }

        const reais = (centavos / 100).toFixed(2);
        const [inteira, decimal] = reais.split('.');
        const inteiraFormatada = inteira.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        
        campo.value = `${inteiraFormatada},${decimal}`;
    }

    // Inicialização
    const numeroDosesField = document.getElementById('numero_doses');
    if (numeroDosesField) {
        numeroDosesField.addEventListener('change', toggleIntervaloDoses);
        toggleIntervaloDoses(); // Executa na inicialização
    }

    // Aplicar máscara nos campos de preço
    const camposPreco = ['preco_custo', 'preco_venda_cartao', 'preco_venda_pix', 'preco_promocional'];
    camposPreco.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener('input', function() {
                mascaraMoeda(this);
            });
            
            // Formatar valor inicial
            if (campo.value) {
                mascaraMoeda(campo);
            }
        }
    });

    // Converter valores antes do envio
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            camposPreco.forEach(id => {
                const campo = document.getElementById(id);
                if (campo && campo.value) {
                    let valor = campo.value.replace(/\./g, '').replace(',', '.');
                    const numero = parseFloat(valor);
                    campo.value = isNaN(numero) ? '' : numero.toFixed(2);
                }
            });
        });
    }
});
</script>
@endpush
@endsection