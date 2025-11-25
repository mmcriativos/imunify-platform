<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Caixa #{{ $caixa->id }} - {{ $caixa->isAberto() ? 'Aberto' : 'Fechado' }}
            </h2>
            <div class="flex gap-2">
                @if($caixa->isAberto())
                    <a href="{{ route('financeiro.lancamentos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                        + Novo Lançamento
                    </a>
                    <button onclick="document.getElementById('modalFecharCaixa').classList.remove('hidden')" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm">
                        🔒 Fechar Caixa
                    </button>
                @else
                    <form action="{{ route('financeiro.caixa.reabrir', $caixa) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm">
                            🔓 Reabrir Caixa
                        </button>
                    </form>
                @endif
                <a href="{{ route('financeiro.caixa.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                    ← Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informações do Caixa -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Informações</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Abertura:</strong> {{ $caixa->data_abertura->format('d/m/Y H:i') }}</p>
                        <p><strong>Usuário:</strong> {{ $caixa->usuarioAbertura->name }}</p>
                        @if($caixa->isFechado())
                            <p><strong>Fechamento:</strong> {{ $caixa->data_fechamento->format('d/m/Y H:i') }}</p>
                            <p><strong>Fechado por:</strong> {{ $caixa->usuarioFechamento->name }}</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Valores</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm">Valor Inicial:</span>
                            <span class="text-sm font-semibold">R$ {{ number_format($caixa->valor_inicial, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm">Valor Esperado:</span>
                            <span class="text-sm font-semibold text-blue-600">R$ {{ number_format($caixa->valor_esperado, 2, ',', '.') }}</span>
                        </div>
                        @if($caixa->valor_real !== null)
                            <div class="flex justify-between">
                                <span class="text-sm">Valor Real:</span>
                                <span class="text-sm font-semibold">R$ {{ number_format($caixa->valor_real, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t">
                                <span class="text-sm font-medium">Diferença:</span>
                                <span class="text-sm font-bold {{ $caixa->diferenca >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ number_format($caixa->diferenca, 2, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Totalizadores</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>💵 Dinheiro:</span>
                            <span class="font-semibold">R$ {{ number_format($caixa->total_dinheiro ?? 0, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>📱 PIX:</span>
                            <span class="font-semibold">R$ {{ number_format($caixa->total_pix ?? 0, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>💳 Débito:</span>
                            <span class="font-semibold">R$ {{ number_format($caixa->total_debito ?? 0, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>💳 Crédito:</span>
                            <span class="font-semibold">R$ {{ number_format($caixa->total_credito ?? 0, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>🔹 Outros:</span>
                            <span class="font-semibold">R$ {{ number_format($caixa->total_outros ?? 0, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($caixa->observacoes)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-yellow-800 mb-2">📝 Observações do Fechamento</h3>
                    <p class="text-sm text-yellow-700">{{ $caixa->observacoes }}</p>
                </div>
            @endif

            <!-- Lançamentos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Lançamentos deste Caixa</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descrição</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Forma Pgto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($caixa->lancamentos as $lanc)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lanc->created_at->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $lanc->descricao }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $lanc->categoria->cor }}20; color: {{ $lanc->categoria->cor }}">
                                                {{ $lanc->categoria->nome }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $lanc->formaPagamento->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $lanc->paciente ? $lanc->paciente->nome : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold {{ $lanc->tipo == 'receita' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $lanc->tipo == 'receita' ? '+' : '-' }} R$ {{ number_format($lanc->valor, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Nenhum lançamento neste caixa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Fechar Caixa -->
    @if($caixa->isAberto())
        <div id="modalFecharCaixa" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🔒 Fechar Caixa</h3>
                    <form action="{{ route('financeiro.caixa.fechar', $caixa) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4 p-4 bg-blue-50 rounded-md">
                            <p class="text-sm"><strong>Valor Esperado:</strong> R$ {{ number_format($caixa->valor_esperado, 2, ',', '.') }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor Real Contado</label>
                            <input type="number" name="valor_real" step="0.01" min="0" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="0,00">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observações (opcional)</label>
                            <textarea name="observacoes" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Ex: Diferença devido a..."></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('modalFecharCaixa').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Fechar Caixa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
