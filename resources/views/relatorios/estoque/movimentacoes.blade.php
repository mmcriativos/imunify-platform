@extends('layouts.tenant-app')

@section('title', 'Movimentações de Estoque - ' . (tenant('clinic_name') ?? 'MultiImune'))

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
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Movimentações de Estoque</h1>
                    <p class="text-gray-600 mt-1">Histórico completo de entradas, saídas e ajustes de estoque</p>
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
                
                <button onclick="exportarMovimentacoes()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                    </svg>
                    Exportar CSV
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros Avançados -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ request('data_inicio', now()->subDays(30)->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ request('data_fim', now()->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vacina</label>
                    <input type="text" name="vacina" value="{{ request('vacina') }}" 
                           placeholder="Nome da vacina..." 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="tipo" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') === 'saida' ? 'selected' : '' }}>Saída</option>
                        <option value="aplicacao" {{ request('tipo') === 'aplicacao' ? 'selected' : '' }}>Aplicação</option>
                        <option value="ajuste" {{ request('tipo') === 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                        <option value="devolucao" {{ request('tipo') === 'devolucao' ? 'selected' : '' }}>Devolução</option>
                        <option value="vencimento" {{ request('tipo') === 'vencimento' ? 'selected' : '' }}>Vencimento</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Usuário</label>
                    <input type="text" name="usuario" value="{{ request('usuario') }}" 
                           placeholder="Nome do usuário..." 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Filtrar
                    </button>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('relatorios.estoque.movimentacoes') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-sm transition-colors">
                    Limpar Filtros
                </a>
                <span class="text-sm text-gray-500">|</span>
                <span class="text-sm text-gray-600">{{ $movimentacoes->total() }} movimentação(ões) encontrada(s)</span>
            </div>
        </form>
    </div>

    <!-- Resumo do Período -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($resumo['total_entradas']) }}</p>
                    <p class="text-sm text-gray-600">Total Entradas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-red-600">{{ number_format($resumo['total_saidas']) }}</p>
                    <p class="text-sm text-gray-600">Total Saídas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($resumo['total_aplicacoes']) }}</p>
                    <p class="text-sm text-gray-600">Aplicações</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold {{ ($resumo['saldo_periodo'] >= 0) ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($resumo['saldo_periodo'] >= 0) ? '+' : '' }}{{ number_format($resumo['saldo_periodo']) }}
                    </p>
                    <p class="text-sm text-gray-600">Saldo do Período</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline de Movimentações -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Histórico de Movimentações</h2>
                
                <!-- Controles de Paginação Superior -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">
                        Mostrando {{ $movimentacoes->firstItem() }}-{{ $movimentacoes->lastItem() }} de {{ $movimentacoes->total() }}
                    </span>
                    
                    <div class="flex items-center gap-1">
                        @if($movimentacoes->onFirstPage())
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded">Anterior</span>
                        @else
                            <a href="{{ $movimentacoes->previousPageUrl() }}" 
                               class="px-3 py-1 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded transition-colors">
                                Anterior
                            </a>
                        @endif
                        
                        @if($movimentacoes->hasMorePages())
                            <a href="{{ $movimentacoes->nextPageUrl() }}" 
                               class="px-3 py-1 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded transition-colors">
                                Próximo
                            </a>
                        @else
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded">Próximo</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            @forelse($movimentacoes as $data => $movimentacoesDia)
                <!-- Separador de Data -->
                <div class="flex items-center my-6 first:mt-0">
                    <div class="flex-shrink-0 bg-gray-100 px-4 py-2 rounded-full">
                        <span class="text-sm font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="flex-grow h-px bg-gray-200 ml-4"></div>
                </div>
                
                <!-- Movimentações do Dia -->
                <div class="space-y-4 ml-4">
                    @foreach($movimentacoesDia as $movimentacao)
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <!-- Ícone do Tipo -->
                            <div class="flex-shrink-0 {{ $movimentacao->classe_icone }} p-2 rounded-full">
                                {!! $movimentacao->icone_svg !!}
                            </div>
                            
                            <!-- Conteúdo Principal -->
                            <div class="flex-grow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <!-- Título da Movimentação -->
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ $movimentacao->vacina->nome ?? 'Vacina não identificada' }}
                                        </h4>
                                        
                                        <!-- Detalhes da Movimentação -->
                                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $movimentacao->classe_tipo }}">
                                                {{ $movimentacao->tipo_descricao }}
                                            </span>
                                            
                                            <span>{{ $movimentacao->created_at->format('H:i') }}</span>
                                            
                                            @if($movimentacao->lote)
                                                <span>Lote: {{ $movimentacao->lote->numero_lote }}</span>
                                            @endif
                                            
                                            @if($movimentacao->user)
                                                <span>por {{ $movimentacao->user->name }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Descrição Adicional -->
                                        @if($movimentacao->observacoes)
                                            <p class="mt-2 text-sm text-gray-600">
                                                {{ $movimentacao->observacoes }}
                                            </p>
                                        @endif
                                        
                                        <!-- Contexto da Movimentação -->
                                        @if($movimentacao->paciente)
                                            <div class="mt-2 text-sm text-blue-600">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Paciente: {{ $movimentacao->paciente->nome }}
                                            </div>
                                        @endif
                                        
                                        @if($movimentacao->atendimento)
                                            <div class="mt-1 text-sm text-purple-600">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                Atendimento #{{ $movimentacao->atendimento->id }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Quantidade e Valor -->
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <div class="text-2xl font-bold {{ $movimentacao->cor_quantidade }}">
                                            {{ $movimentacao->sinal_quantidade }}{{ number_format($movimentacao->quantidade) }}
                                        </div>
                                        <div class="text-xs text-gray-500">doses</div>
                                        
                                        @if($movimentacao->valor_unitario)
                                            <div class="text-sm text-gray-600 mt-1">
                                                R$ {{ number_format($movimentacao->valor_unitario, 2, ',', '.') }}/dose
                                            </div>
                                            
                                            @if($movimentacao->valor_total)
                                                <div class="text-sm font-semibold text-purple-600">
                                                    Total: R$ {{ number_format($movimentacao->valor_total, 2, ',', '.') }}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhuma movimentação encontrada</h3>
                    <p class="mt-2 text-gray-500">
                        Não há movimentações de estoque no período selecionado.
                        <br>Tente ajustar os filtros ou selecionar um período maior.
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Paginação Inferior -->
        @if($movimentacoes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $movimentacoes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function exportarMovimentacoes() {
    // Pega os parâmetros atuais da URL
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    
    // Cria a URL de exportação
    const exportUrl = '{{ route("relatorios.estoque.movimentacoes") }}?' + params.toString();
    
    // Abre em nova janela para download
    window.open(exportUrl, '_blank');
}

// Auto-submit form quando mudar período rápido
function setPeriodoRapido(dias) {
    const hoje = new Date();
    const inicio = new Date(hoje.getTime() - (dias * 24 * 60 * 60 * 1000));
    
    document.querySelector('input[name="data_inicio"]').value = inicio.toISOString().split('T')[0];
    document.querySelector('input[name="data_fim"]').value = hoje.toISOString().split('T')[0];
    
    document.querySelector('form').submit();
}

// Adicionar botões de período rápido se não existirem
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form && !document.querySelector('.periodo-rapido')) {
        const periodosDiv = document.createElement('div');
        periodosDiv.className = 'flex items-center gap-2 periodo-rapido';
        periodosDiv.innerHTML = `
            <span class="text-sm text-gray-600">Períodos rápidos:</span>
            <button type="button" onclick="setPeriodoRapido(7)" class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition-colors">7 dias</button>
            <button type="button" onclick="setPeriodoRapido(30)" class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition-colors">30 dias</button>
            <button type="button" onclick="setPeriodoRapido(90)" class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition-colors">90 dias</button>
        `;
        
        // Inserir antes do div de controles
        const controlesDiv = form.querySelector('.flex.items-center.gap-2');
        if (controlesDiv) {
            form.insertBefore(periodosDiv, controlesDiv);
        }
    }
});
</script>

@endsection