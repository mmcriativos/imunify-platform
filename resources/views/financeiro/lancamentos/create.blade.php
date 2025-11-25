@extends('layouts.tenant-app')

@section('title', 'Novo Lançamento Financeiro')
@section('page-title', 'Novo Lançamento')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Compacto -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Novo Lançamento</h1>
            <p class="text-sm text-gray-500 mt-1">Registre uma nova movimentação financeira</p>
        </div>
        <a href="{{ route('financeiro.lancamentos.index') }}" 
           class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(!$caixaAberto)
                <div class="bg-amber-50 border-l-4 border-amber-400 text-amber-700 p-4 rounded-lg mb-6">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold">Sem caixa aberto</p>
                            <p class="text-xs mt-0.5">O lançamento será criado sem vínculo.
                                <a href="{{ route('financeiro.caixa.index') }}" class="underline font-semibold hover:text-amber-800">Abrir caixa</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6">
                    <form action="{{ route('financeiro.lancamentos.store') }}" method="POST" x-data="lancamentoForm()">
                        @csrf

                        <!-- Tipo -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Lançamento *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="tipo" value="receita" x-model="tipo" required class="peer sr-only">
                                    <div class="peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 bg-white border-2 border-gray-200 rounded-lg p-4 transition hover:border-emerald-300">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-emerald-100 peer-checked:bg-emerald-200 p-2 rounded-lg transition">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                            </div>
                                            <span class="font-semibold">Receita</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tipo" value="despesa" x-model="tipo" required class="peer sr-only">
                                    <div class="peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 bg-white border-2 border-gray-200 rounded-lg p-4 transition hover:border-red-300">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-red-100 peer-checked:bg-red-200 p-2 rounded-lg transition">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                                </svg>
                                            </div>
                                            <span class="font-semibold">Despesa</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Categoria -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-bold text-gray-700">Categoria *</label>
                                    <a href="{{ route('financeiro.categorias.index') }}" target="_blank" 
                                       class="text-xs text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Gerenciar
                                    </a>
                                </div>
                                <div class="relative">
                                    <select name="categoria_id" required x-model="categoriaId"
                                            class="w-full bg-white rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition appearance-none pl-4 pr-10 py-2.5 @error('categoria_id') border-red-500 @enderror">
                                        <option value="">Selecione uma categoria...</option>
                                        <template x-if="tipo === 'receita'">
                                            <optgroup label="📈 Receitas">
                                                @foreach($categorias->where('tipo', 'receita') as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->icone }} {{ $cat->nome }}</option>
                                                @endforeach
                                            </optgroup>
                                        </template>
                                        <template x-if="tipo === 'despesa'">
                                            <optgroup label="📉 Despesas">
                                                @foreach($categorias->where('tipo', 'despesa') as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->icone }} {{ $cat->nome }}</option>
                                                @endforeach
                                            </optgroup>
                                        </template>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('categoria_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1" x-show="!tipo">👆 Selecione o tipo primeiro</p>
                            </div>

                            <!-- Forma de Pagamento -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Forma de Pagamento *</label>
                                <div class="relative">
                                    <select name="forma_pagamento_id" x-model="formaPagamento" required
                                            class="w-full bg-white rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition appearance-none pl-4 pr-10 py-2.5 @error('forma_pagamento_id') border-red-500 @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach($formasPagamento as $forma)
                                            <option value="{{ $forma->id }}" data-requer-conciliacao="{{ $forma->requer_conciliacao ? 'true' : 'false' }}">
                                                {{ $forma->nome }}
                                                @if($forma->requer_conciliacao) 💳 @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('forma_pagamento_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Descrição e Valor -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Descrição *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="descricao" required value="{{ old('descricao') }}"
                                           class="w-full bg-white pl-10 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition @error('descricao') border-red-500 @enderror"
                                           placeholder="Ex: Aplicação vacina tríplice">
                                </div>
                                @error('descricao')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Valor *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 font-bold text-lg">R$</span>
                                    <input type="text" name="valor" id="valor" required value="{{ old('valor') }}"
                                           class="w-full bg-white pl-12 pr-4 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition text-lg font-semibold @error('valor') border-red-500 @enderror"
                                           placeholder="0,00">
                                </div>
                                @error('valor')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Data e Paciente -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Data do Lançamento *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="date" name="data" value="{{ old('data', date('Y-m-d')) }}" required
                                           class="w-full bg-white pl-10 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition @error('data') border-red-500 @enderror">
                                </div>
                                @error('data')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Data de Vencimento</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <input type="date" name="data_vencimento" value="{{ old('data_vencimento') }}"
                                           class="w-full bg-white pl-10 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition @error('data_vencimento') border-red-500 @enderror">
                                </div>
                                @error('data_vencimento')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Para contas a pagar/receber no futuro</p>
                            </div>
                        </div>

                        <!-- Documento e Paciente -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Número do Documento</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="numero_documento" value="{{ old('numero_documento') }}"
                                           class="w-full bg-white pl-10 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition"
                                           placeholder="Ex: NF-123, Boleto 456">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Nota fiscal, boleto, recibo, etc.</p>
                            </div>

                            <!-- Paciente -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Paciente (opcional)</label>
                                <select name="paciente_id" id="paciente-select">
                                    <option value="">Nenhum</option>
                                    @foreach($pacientes as $pac)
                                        <option value="{{ $pac->id }}" {{ old('paciente_id') == $pac->id ? 'selected' : '' }}>
                                            {{ $pac->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="confirmado" checked class="peer sr-only">
                                    <div class="peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 bg-white border-2 border-gray-200 rounded-lg p-3 transition hover:border-emerald-300">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-semibold text-sm">Confirmado</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="pendente" class="peer sr-only">
                                    <div class="peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 bg-white border-2 border-gray-200 rounded-lg p-3 transition hover:border-amber-300">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-semibold text-sm">Pendente</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Dados de Cartão (se necessário) -->
                        <div x-show="requerConciliacao" class="mt-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl" style="display: none;">
                            <h4 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Dados da Transação de Cartão
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">NSU</label>
                                    <input type="text" name="nsu"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                                           placeholder="Número NSU">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Código Autorização</label>
                                    <input type="text" name="codigo_autorizacao"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bandeira</label>
                                    <select name="bandeira"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                                        <option value="">Selecione...</option>
                                        <option value="visa">💳 Visa</option>
                                        <option value="mastercard">💳 Mastercard</option>
                                        <option value="elo">💳 Elo</option>
                                        <option value="american_express">💳 American Express</option>
                                        <option value="hipercard">💳 Hipercard</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Número de Parcelas</label>
                                    <input type="number" name="numero_parcelas" min="1" value="1"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Observações</label>
                            <textarea name="observacoes" rows="3"
                                      class="w-full bg-white rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition"
                                      placeholder="Informações adicionais..."></textarea>
                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('financeiro.lancamentos.index') }}"
                               class="px-5 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        function lancamentoForm() {
            return {
                tipo: '',
                categoriaId: '',
                formaPagamento: '',
                requerConciliacao: false,
                init() {
                    this.$watch('formaPagamento', value => {
                        const select = document.querySelector('select[name="forma_pagamento_id"]');
                        if (select && select.selectedIndex >= 0) {
                            const option = select.options[select.selectedIndex];
                            this.requerConciliacao = option.getAttribute('data-requer-conciliacao') === 'true';
                        }
                    });

                    // Máscara de valor monetário
                    const valorInput = document.getElementById('valor');
                    if (valorInput) {
                        valorInput.addEventListener('input', function(e) {
                            let value = e.target.value.replace(/\D/g, '');
                            if (value === '') {
                                e.target.value = '';
                                return;
                            }
                            value = (parseInt(value) / 100).toFixed(2);
                            e.target.value = value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        });
                    }

                    // Tom Select para pacientes
                    new TomSelect('#paciente-select', {
                        placeholder: 'Digite para buscar...',
                        allowEmptyOption: true,
                        create: false
                    });
                }
            }
        }
    </script>
    @endpush
@endsection
