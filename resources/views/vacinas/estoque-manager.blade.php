@extends('layouts.tenant-app')

@section('title', 'Gestão de Estoque - MultiImune')

@section('content')
<!-- Header -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="text-white">
                <h1 class="text-3xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                    </svg>
                    Gestão de Estoque
                </h1>
                <p class="text-indigo-100 mt-2 text-lg">Controle completo dos estoques de vacinas</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('vacinas.index') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-lg transition-all">
                    ← Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total de Vacinas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total de Vacinas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $estatisticas['total_vacinas'] }}</p>
            </div>
        </div>
    </div>

    <!-- Estoque Baixo -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Estoque Baixo</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $estatisticas['estoque_baixo'] }}</p>
            </div>
        </div>
    </div>

    <!-- Estoque Zerado -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Estoque Zerado</p>
                <p class="text-2xl font-bold text-red-600">{{ $estatisticas['estoque_zerado'] }}</p>
            </div>
        </div>
    </div>

    <!-- Estoque Normal -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Estoque Normal</p>
                <p class="text-2xl font-bold text-green-600">{{ $estatisticas['estoque_normal'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros e Busca -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-4">
            <!-- Filtro por Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status do Estoque</label>
                <select id="filtro_status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="zerado">Estoque Zerado</option>
                    <option value="baixo">Estoque Baixo</option>
                    <option value="normal">Estoque Normal</option>
                </select>
            </div>

            <!-- Busca -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Vacina</label>
                <input type="text" id="busca_vacina" placeholder="Nome da vacina..." 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 w-64">
            </div>
        </div>

        <!-- Ações -->
        <div class="flex gap-3">
            <button onclick="atualizarTodos()" 
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Atualizar
            </button>
            <button onclick="exportarRelatorio()" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Exportar
            </button>
        </div>
    </div>
</div>

<!-- Lista de Vacinas -->
<div class="space-y-4">
    @foreach($vacinas as $vacina)
    @php
        $estoqueAtual = $vacina->estoque_atual ?? 0;
        $estoqueMinimo = $vacina->estoque_minimo ?? 10;
        $status = $estoqueAtual == 0 ? 'zerado' : ($estoqueAtual <= $estoqueMinimo ? 'baixo' : 'normal');
        $statusColor = $status == 'zerado' ? 'red' : ($status == 'baixo' ? 'yellow' : 'green');
    @endphp
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow vacina-card" 
         data-status="{{ $status }}" 
         data-nome="{{ strtolower($vacina->nome) }}">
        
        <div class="p-6">
            <div class="flex items-center justify-between">
                <!-- Info da Vacina -->
                <div class="flex items-center space-x-4 flex-1">
                    <div class="p-3 bg-{{ $statusColor }}-100 rounded-lg">
                        <svg class="w-8 h-8 text-{{ $statusColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $vacina->nome }}</h3>
                        <p class="text-gray-600">{{ $vacina->fabricante ?? 'Sem fabricante' }}</p>
                        
                        @if($vacina->lote_atual)
                        <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                            <span>Lote: <strong>{{ $vacina->lote_atual }}</strong></span>
                            @if($vacina->validade_lote)
                            <span>Válido até: <strong>{{ \Carbon\Carbon::parse($vacina->validade_lote)->format('d/m/Y') }}</strong></span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status e Controles -->
                <div class="flex items-center space-x-6">
                    <!-- Estoque Atual -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Estoque Atual</p>
                        <p class="text-3xl font-bold text-{{ $statusColor }}-600">{{ $estoqueAtual }}</p>
                        <span class="inline-block px-3 py-1 text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 rounded-full">
                            {{ $status == 'zerado' ? 'Zerado' : ($status == 'baixo' ? 'Baixo' : 'Normal') }}
                        </span>
                    </div>

                    <!-- Estoque Mínimo -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Mínimo</p>
                        <p class="text-xl font-semibold text-gray-700">{{ $estoqueMinimo }}</p>
                    </div>

                    <!-- Controles Rápidos -->
                    <div class="flex flex-col space-y-2">
                        <form action="{{ route('vacinas.estoque.ajustar', $vacina) }}" method="POST" class="estoque-form">
                            @csrf
                            <div class="flex items-center space-x-2">
                                <div class="relative">
                                    <select name="operacao" class="appearance-none bg-white border border-gray-300 hover:border-indigo-400 px-3 py-2 pr-8 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                        <option value="adicionar" class="flex items-center">
                                            <span class="text-green-600">+</span> Adicionar
                                        </option>
                                        <option value="remover" class="text-red-600">
                                            <span class="text-red-600">-</span> Remover
                                        </option>
                                        <option value="definir" class="text-blue-600">
                                            <span class="text-blue-600">=</span> Definir
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <input type="number" name="quantidade" min="1" max="9999" 
                                       placeholder="Qtd" required
                                       class="w-20 px-3 py-2 border border-gray-300 hover:border-indigo-400 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                    OK
                                </button>
                            </div>
                        </form>
                        
                        <!-- Botões Rápidos -->
                        <div class="flex space-x-2">
                            <button onclick="ajusteRapido({{ $vacina->id }}, 'adicionar', 10)" 
                                    class="px-3 py-1.5 bg-gradient-to-r from-green-100 to-green-200 hover:from-green-200 hover:to-green-300 text-green-700 rounded-lg text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-green-200">
                                <span class="font-bold">+10</span>
                            </button>
                            <button onclick="ajusteRapido({{ $vacina->id }}, 'remover', 10)" 
                                    class="px-3 py-1.5 bg-gradient-to-r from-red-100 to-red-200 hover:from-red-200 hover:to-red-300 text-red-700 rounded-lg text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-red-200">
                                <span class="font-bold">-10</span>
                            </button>
                            <button onclick="ajusteRapido({{ $vacina->id }}, 'definir', 0)" 
                                    class="px-3 py-1.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-lg text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200">
                                <span class="font-bold">Zero</span>
                            </button>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('vacinas.edit', $vacina) }}" 
                           class="px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 rounded-lg text-sm font-medium text-center transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </a>
                        <a href="{{ route('vacinas.show', $vacina) }}" 
                           class="px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-200 hover:from-blue-200 hover:to-blue-300 text-blue-700 rounded-lg text-sm font-medium text-center transition-all duration-200 shadow-sm hover:shadow-md border border-blue-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($vacinas->isEmpty())
<div class="text-center py-12">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma vacina encontrada</h3>
    <p class="text-gray-600">Comece cadastrando suas vacinas.</p>
    <a href="{{ route('vacinas.create') }}" 
       class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Cadastrar Vacina
    </a>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros
    function aplicarFiltros() {
        const filtroStatus = document.getElementById('filtro_status').value;
        const buscaVacina = document.getElementById('busca_vacina').value.toLowerCase();
        
        document.querySelectorAll('.vacina-card').forEach(card => {
            let mostrar = true;
            
            const status = card.dataset.status;
            const nome = card.dataset.nome;
            
            // Filtro por status
            if (filtroStatus && status !== filtroStatus) {
                mostrar = false;
            }
            
            // Busca por nome
            if (buscaVacina && !nome.includes(buscaVacina)) {
                mostrar = false;
            }
            
            card.style.display = mostrar ? 'block' : 'none';
        });
    }

    // Event listeners
    document.getElementById('filtro_status').addEventListener('change', aplicarFiltros);
    document.getElementById('busca_vacina').addEventListener('input', aplicarFiltros);

    // Formulários de ajuste
    document.querySelectorAll('.estoque-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            button.textContent = '...';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro: ' + (data.message || 'Erro desconhecido'));
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro na comunicação com o servidor');
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        });
    });

    // Funções globais
    window.ajusteRapido = function(vacinaId, operacao, quantidade) {
        let url = '';
        let data = { quantidade: quantidade };
        
        if (operacao === 'adicionar') {
            url = `{{ url('/estoque/adicionar') }}/${vacinaId}`;
            data.motivo = 'Ajuste rápido - adição';
        } else if (operacao === 'remover') {
            url = `{{ url('/estoque/remover') }}/${vacinaId}`;
            data.motivo = 'Ajuste rápido - remoção';
        } else if (operacao === 'definir' || operacao === 'ajustar') {
            url = `{{ url('/estoque/ajustar') }}/${vacinaId}`;
            data.motivo = 'Ajuste rápido - definição';
        }
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro: ' + (data.message || 'Erro desconhecido'));
            }
        });
    };

    window.atualizarTodos = function() {
        location.reload();
    };

    window.exportarRelatorio = function() {
        // Implementar exportação futuramente
        alert('Funcionalidade de exportação será implementada em breve');
    };
});
</script>
@endpush
@endsection