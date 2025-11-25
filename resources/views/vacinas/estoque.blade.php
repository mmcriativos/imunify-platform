@extends('layouts.tenant-app')

@section('title', 'Gestão de Estoque - MultiImune')
@section('page-title', 'Gestão de Estoque')

@section('content')
<!-- Header da Gestão de Estoque -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="text-white">
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                    </svg>
                    Gestão de Estoque
                </h1>
                <p class="text-indigo-100 mt-1">Visualização e atualização em massa dos estoques</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="toggleModoEdicaoMassa()" 
                        class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm">
                    ✏️ Modo Edição
                </button>
                <a href="{{ route('vacinas.index') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtros e Controles -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-4">
            <!-- Filtro por Status de Estoque -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status do Estoque</label>
                <select id="filtro_estoque" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="todos">Todos</option>
                    <option value="baixo">Estoque Baixo</option>
                    <option value="zerado">Estoque Zerado</option>
                    <option value="normal">Estoque Normal</option>
                </select>
            </div>

            <!-- Filtro por Fabricante -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fabricante</label>
                <select id="filtro_fabricante" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="todos">Todos</option>
                    @foreach($fabricantes as $fabricante)
                    <option value="{{ $fabricante }}">{{ $fabricante }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Busca -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Vacina</label>
                <input type="text" id="busca_vacina" placeholder="Nome da vacina..." 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Ações em Massa -->
        <div class="flex gap-2">
            <button onclick="exportarEstoque()" 
                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm">
                📊 Exportar
            </button>
            <button onclick="importarEstoque()" 
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm">
                📥 Importar
            </button>
        </div>
    </div>
</div>

<!-- Tabela de Estoque -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header da Tabela -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Estoque das Vacinas</h3>
            <div class="text-sm text-gray-600">
                Total: {{ $vacinas->count() }} vacinas
            </div>
        </div>
    </div>

    <!-- Formulário para Atualização em Massa -->
    <form id="form_estoque_massa" action="{{ route('vacinas.update-estoque-massa') }}" method="POST">
        @csrf
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selecionar_todos" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vacina
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estoque Atual
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estoque Mínimo
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Lote/Validade
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider modo-edicao hidden">
                            Ações Rápidas
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vacinas as $vacina)
                    <tr class="hover:bg-gray-50 vacina-row" 
                        data-estoque="{{ $vacina->estoque_atual ?? 0 }}" 
                        data-fabricante="{{ $vacina->fabricante }}"
                        data-nome="{{ strtolower($vacina->nome) }}">
                        
                        <!-- Checkbox -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="vacinas_selecionadas[]" value="{{ $vacina->id }}" 
                                   class="rounded border-gray-300 checkbox-vacina">
                        </td>

                        <!-- Info da Vacina -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $vacina->nome }}</div>
                                    <div class="text-sm text-gray-500">{{ $vacina->fabricante ?? 'Sem fabricante' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Estoque Atual -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="modo-visualizacao">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ ($vacina->estoque_atual ?? 0) == 0 ? 'bg-red-100 text-red-800' : 
                                       (($vacina->estoque_atual ?? 0) <= ($vacina->estoque_minimo ?? 0) ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $vacina->estoque_atual ?? 0 }}
                                </span>
                            </div>
                            <div class="modo-edicao hidden">
                                <input type="number" name="estoques[{{ $vacina->id }}][atual]" 
                                       value="{{ $vacina->estoque_atual ?? 0 }}" min="0"
                                       class="w-20 px-2 py-1 border border-gray-300 rounded text-center text-sm">
                            </div>
                        </td>

                        <!-- Estoque Mínimo -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="modo-visualizacao">
                                <span class="text-sm text-gray-900">{{ $vacina->estoque_minimo ?? '-' }}</span>
                            </div>
                            <div class="modo-edicao hidden">
                                <input type="number" name="estoques[{{ $vacina->id }}][minimo]" 
                                       value="{{ $vacina->estoque_minimo ?? 0 }}" min="0"
                                       class="w-20 px-2 py-1 border border-gray-300 rounded text-center text-sm">
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $status = ($vacina->estoque_atual ?? 0) == 0 ? 'zerado' : 
                                         (($vacina->estoque_atual ?? 0) <= ($vacina->estoque_minimo ?? 0) ? 'baixo' : 'normal');
                                $statusTexto = $status == 'zerado' ? 'Zerado' : ($status == 'baixo' ? 'Baixo' : 'Normal');
                                $statusCor = $status == 'zerado' ? 'text-red-600' : ($status == 'baixo' ? 'text-yellow-600' : 'text-green-600');
                            @endphp
                            <span class="text-sm font-medium {{ $statusCor }}">{{ $statusTexto }}</span>
                        </td>

                        <!-- Lote/Validade -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm text-gray-900">{{ $vacina->lote_atual ?? '-' }}</div>
                            @if($vacina->validade_lote)
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($vacina->validade_lote)->format('d/m/Y') }}
                            </div>
                            @endif
                        </td>

                        <!-- Ações Rápidas -->
                        <td class="px-6 py-4 whitespace-nowrap text-center modo-edicao hidden">
                            <div class="flex justify-center space-x-1">
                                <button type="button" onclick="ajusteRapido({{ $vacina->id }}, 'add', 10)" 
                                        class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                    +10
                                </button>
                                <button type="button" onclick="ajusteRapido({{ $vacina->id }}, 'sub', 10)" 
                                        class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                    -10
                                </button>
                                <button type="button" onclick="ajusteRapido({{ $vacina->id }}, 'zero', 0)" 
                                        class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs hover:bg-gray-200">
                                    0
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer com Ações -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 modo-edicao hidden">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <span id="contador_selecionadas">0</span> vacinas selecionadas
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="cancelarEdicao()" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                        💾 Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modo de edição
    let modoEdicao = false;

    function toggleModoEdicaoMassa() {
        modoEdicao = !modoEdicao;
        
        document.querySelectorAll('.modo-edicao').forEach(el => {
            el.classList.toggle('hidden', !modoEdicao);
        });
        
        document.querySelectorAll('.modo-visualizacao').forEach(el => {
            el.classList.toggle('hidden', modoEdicao);
        });
    }

    // Filtros
    function aplicarFiltros() {
        const filtroEstoque = document.getElementById('filtro_estoque').value;
        const filtroFabricante = document.getElementById('filtro_fabricante').value;
        const buscaVacina = document.getElementById('busca_vacina').value.toLowerCase();
        
        document.querySelectorAll('.vacina-row').forEach(row => {
            let mostrar = true;
            
            const estoque = parseInt(row.dataset.estoque);
            const fabricante = row.dataset.fabricante;
            const nome = row.dataset.nome;
            
            // Filtro por estoque
            if (filtroEstoque !== 'todos') {
                if (filtroEstoque === 'zerado' && estoque !== 0) mostrar = false;
                if (filtroEstoque === 'baixo' && estoque > 10) mostrar = false;
                if (filtroEstoque === 'normal' && estoque <= 10) mostrar = false;
            }
            
            // Filtro por fabricante
            if (filtroFabricante !== 'todos' && fabricante !== filtroFabricante) {
                mostrar = false;
            }
            
            // Busca por nome
            if (buscaVacina && !nome.includes(buscaVacina)) {
                mostrar = false;
            }
            
            row.style.display = mostrar ? 'table-row' : 'none';
        });
    }

    // Ajuste rápido
    function ajusteRapido(vacinaId, operacao, valor) {
        const input = document.querySelector(`input[name="estoques[${vacinaId}][atual]"]`);
        const atual = parseInt(input.value) || 0;
        
        let novoValor;
        switch(operacao) {
            case 'add': novoValor = atual + valor; break;
            case 'sub': novoValor = Math.max(0, atual - valor); break;
            case 'zero': novoValor = 0; break;
        }
        
        input.value = novoValor;
    }

    // Seleção em massa
    document.getElementById('selecionar_todos').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.checkbox-vacina');
        checkboxes.forEach(cb => cb.checked = this.checked);
        atualizarContador();
    });

    function atualizarContador() {
        const selecionadas = document.querySelectorAll('.checkbox-vacina:checked').length;
        document.getElementById('contador_selecionadas').textContent = selecionadas;
    }

    // Event listeners
    document.getElementById('filtro_estoque').addEventListener('change', aplicarFiltros);
    document.getElementById('filtro_fabricante').addEventListener('change', aplicarFiltros);
    document.getElementById('busca_vacina').addEventListener('input', aplicarFiltros);
    
    document.querySelectorAll('.checkbox-vacina').forEach(cb => {
        cb.addEventListener('change', atualizarContador);
    });

    // Tornar funções globais
    window.toggleModoEdicaoMassa = toggleModoEdicaoMassa;
    window.ajusteRapido = ajusteRapido;
    window.cancelarEdicao = function() {
        window.location.reload();
    };
    
    window.exportarEstoque = function() {
        window.location.href = '{{ route("vacinas.export-estoque") }}';
    };
    
    window.importarEstoque = function() {
        // Implementar modal de importação
        alert('Funcionalidade de importação será implementada');
    };
});
</script>
@endpush
@endsection