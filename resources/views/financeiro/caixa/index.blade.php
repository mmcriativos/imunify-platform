@extends('layouts.tenant-app')

@section('title', 'Gerenciar Caixas')
@section('page-title', 'Gerenciar Caixas')

@section('content')
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Gerenciar Caixas
            </h1>
            <p class="text-gray-600 mt-1">Controle de abertura e fechamento de caixa</p>
        </div>
        <div>
            @if(!$caixaAberto)
                <button onclick="document.getElementById('modalAbrirCaixa').classList.remove('hidden')" 
                        class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow-md transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    Abrir Novo Caixa
                </button>
            @else
                <div class="bg-green-50 border-2 border-green-500 text-green-700 px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Caixa Aberto desde {{ $caixaAberto->hora_abertura }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Abertura</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fechamento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuário</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Valor Inicial</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Esperado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Real</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Diferença</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($caixas as $caixa)
                                    <tr class="{{ $caixa->isAberto() ? 'bg-green-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $caixa->data_abertura->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $caixa->data_fechamento ? $caixa->data_fechamento->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $caixa->usuarioAbertura->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                            R$ {{ number_format($caixa->valor_inicial, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-blue-600 font-semibold">
                                            R$ {{ number_format($caixa->valor_esperado ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $caixa->valor_real ? 'text-gray-900 font-semibold' : 'text-gray-400' }}">
                                            {{ $caixa->valor_real ? 'R$ ' . number_format($caixa->valor_real, 2, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold {{ $caixa->diferenca > 0 ? 'text-green-600' : ($caixa->diferenca < 0 ? 'text-red-600' : 'text-gray-900') }}">
                                            {{ $caixa->diferenca ? 'R$ ' . number_format($caixa->diferenca, 2, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($caixa->isAberto())
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aberto</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Fechado</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('financeiro.caixa.show', $caixa) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">Nenhum caixa encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $caixas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Abrir Caixa -->
<div id="modalAbrirCaixa" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                </svg>
                Abrir Novo Caixa
            </h3>
            <form action="{{ route('financeiro.caixa.abrir') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Valor Inicial</label>
                    <input type="number" name="valor_inicial" step="0.01" min="0" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="0,00">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalAbrirCaixa').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Abrir Caixa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
