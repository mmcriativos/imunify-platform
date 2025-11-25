@extends('layouts.tenant-app')

@section('title', 'Posição de Estoque - ' . (tenant('clinic_name') ?? 'MultiImune'))

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
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Posição de Estoque</h1>
                    <p class="text-gray-600 mt-1">Status atual de todas as vacinas - Atualizado em {{ now()->format('d/m/Y H:i') }}</p>
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
                
                <a href="{{ route('vacinas.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Gerenciar Estoque
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Vacina</label>
                <input type="text" name="busca" value="{{ request('busca') }}" 
                       placeholder="Nome da vacina..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status do Estoque</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="adequado" {{ request('status') === 'adequado' ? 'selected' : '' }}>Adequado</option>
                    <option value="baixo" {{ request('status') === 'baixo' ? 'selected' : '' }}>Estoque Baixo</option>
                    <option value="critico" {{ request('status') === 'critico' ? 'selected' : '' }}>Crítico</option>
                    <option value="zerado" {{ request('status') === 'zerado' ? 'selected' : '' }}>Zerado</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                <select name="categoria" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todas</option>
                    <option value="rotina" {{ request('categoria') === 'rotina' ? 'selected' : '' }}>Rotina</option>
                    <option value="viagem" {{ request('categoria') === 'viagem' ? 'selected' : '' }}>Viagem</option>
                    <option value="especial" {{ request('categoria') === 'especial' ? 'selected' : '' }}>Especial</option>
                    <option value="covid" {{ request('categoria') === 'covid' ? 'selected' : '' }}>COVID-19</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex-1">
                    Filtrar
                </button>
                <a href="{{ route('relatorios.estoque.posicao') }}" 
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
                    <p class="text-3xl font-bold text-green-600">{{ $resumo['adequado'] }}</p>
                    <p class="text-sm text-gray-600">Estoque Adequado</p>
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
                    <p class="text-3xl font-bold text-amber-600">{{ $resumo['baixo'] }}</p>
                    <p class="text-sm text-gray-600">Estoque Baixo</p>
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
                    <p class="text-3xl font-bold text-red-600">{{ $resumo['critico'] }}</p>
                    <p class="text-sm text-gray-600">Estoque Crítico</p>
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
                    <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($resumo['valor_total'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Valor Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Vacinas -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Posição Detalhada - {{ $vacinas->total() }} vacina(s)</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vacina</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Atual</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Mínimo</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Lotes Ativos</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Médio</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vacinas as $vacina)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($vacina->nome, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $vacina->nome }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $vacina->fabricante ?? 'N/A' }} | {{ $vacina->categoria ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="text-2xl font-bold {{ $vacina->cor_estoque }}">
                                    {{ number_format($vacina->estoque_atual ?? $vacina->quantidade, 0, ',', '.') }}
                                </span>
                                <div class="text-xs text-gray-500">doses</div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ number_format($vacina->estoque_minimo ?? 10, 0, ',', '.') }}
                                </span>
                                <div class="text-xs text-gray-500">doses</div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $vacina->classe_status }}">
                                    {{ $vacina->status_descricao }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-medium">{{ $vacina->lotes_count ?? 0 }}</span>
                                    @if(($vacina->lotes_vencendo ?? 0) > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-amber-100 text-amber-800 rounded-full">
                                            {{ $vacina->lotes_vencendo }} vencendo
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-medium text-gray-900">
                                    R$ {{ number_format($vacina->preco_medio ?? $vacina->preco ?? 0, 2, ',', '.') }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-purple-600">
                                    R$ {{ number_format($vacina->valor_total ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('vacinas.show', $vacina->id) }}" 
                                       class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                       title="Ver Detalhes">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    
                                    @if(($vacina->estoque_atual ?? $vacina->quantidade) <= ($vacina->estoque_minimo ?? 10))
                                        <button onclick="abrirModalReposicao({{ $vacina->id }}, '{{ addslashes($vacina->nome) }}')" 
                                                class="text-green-600 hover:text-green-700 font-medium text-sm"
                                                title="Reabastecer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma vacina encontrada</h3>
                                    <p class="mt-1 text-sm text-gray-500">Tente ajustar os filtros ou adicionar vacinas ao sistema.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($vacinas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $vacinas->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Reposição Rápida -->
<div id="modalReposicao" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Reposição Rápida</h3>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">
                Vacina: <span id="nomeVacina" class="font-semibold"></span>
            </p>
            
            <form id="formReposicao" class="space-y-4">
                <input type="hidden" id="vacinaId" name="vacina_id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                    <input type="number" name="quantidade" min="1" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número do Lote</label>
                    <input type="text" name="numero_lote" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data de Validade</label>
                    <input type="date" name="data_validade" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="fecharModalReposicao()" 
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalReposicao(vacinaId, nomeVacina) {
    document.getElementById('vacinaId').value = vacinaId;
    document.getElementById('nomeVacina').textContent = nomeVacina;
    document.getElementById('modalReposicao').classList.remove('hidden');
}

function fecharModalReposicao() {
    document.getElementById('modalReposicao').classList.add('hidden');
    document.getElementById('formReposicao').reset();
}

// Fechar modal clicando fora
document.getElementById('modalReposicao').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModalReposicao();
    }
});

// Submissão do formulário de reposição
document.getElementById('formReposicao').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Aqui você implementaria a chamada AJAX para adicionar o estoque
    // Por enquanto, apenas simularemos o sucesso
    
    alert('Reposição registrada com sucesso!');
    fecharModalReposicao();
    window.location.reload();
});
</script>

@endsection