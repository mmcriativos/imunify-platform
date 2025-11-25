@extends('layouts.tenant-app')

@section('title', 'Nova Forma de Pagamento')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Forma de Pagamento
        </h1>
        <p class="text-gray-600 mt-1">Cadastre uma nova forma de pagamento</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('financeiro.formas-pagamento.store') }}" method="POST">
            @csrf

            <!-- Nome -->
            <div class="mb-6">
                <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nome da Forma de Pagamento *
                </label>
                <input 
                    type="text" 
                    name="nome" 
                    id="nome"
                    value="{{ old('nome') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nome') border-red-500 @enderror"
                    placeholder="Ex: Dinheiro, Cartão de Crédito, PIX..."
                    required
                >
                @error('nome')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Tipo *
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $tipos = [
                            'dinheiro' => ['label' => '💵 Dinheiro', 'icon' => '💵'],
                            'pix' => ['label' => '📱 PIX', 'icon' => '📱'],
                            'debito' => ['label' => '💳 Débito', 'icon' => '💳'],
                            'credito' => ['label' => '💎 Crédito', 'icon' => '💎'],
                            'boleto' => ['label' => '📄 Boleto', 'icon' => '📄'],
                            'transferencia' => ['label' => '🏦 Transferência', 'icon' => '🏦'],
                            'outro' => ['label' => '📌 Outro', 'icon' => '📌'],
                        ];
                    @endphp
                    
                    @foreach($tipos as $value => $info)
                        <label class="cursor-pointer">
                            <input 
                                type="radio" 
                                name="tipo" 
                                value="{{ $value }}" 
                                {{ old('tipo') == $value ? 'checked' : '' }}
                                class="peer sr-only" 
                                required
                            >
                            <div class="border-2 border-gray-300 rounded-lg p-3 text-center transition peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 hover:border-blue-300">
                                <div class="text-2xl mb-1">{{ $info['icon'] }}</div>
                                <div class="text-xs font-semibold text-gray-900">{{ str_replace(['💵 ', '📱 ', '💳 ', '💎 ', '📄 ', '🏦 ', '📌 '], '', $info['label']) }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('tipo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Taxa Percentual -->
                <div>
                    <label for="taxa_percentual" class="block text-sm font-semibold text-gray-700 mb-2">
                        Taxa (%)
                        <span class="text-gray-500 font-normal text-xs ml-1">opcional</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            name="taxa_percentual" 
                            id="taxa_percentual"
                            value="{{ old('taxa_percentual', '0') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('taxa_percentual') border-red-500 @enderror"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            max="100"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">%</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-600">Taxa cobrada pela operadora (ex: 2.5%)</p>
                    @error('taxa_percentual')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prazo de Recebimento -->
                <div>
                    <label for="prazo_recebimento" class="block text-sm font-semibold text-gray-700 mb-2">
                        Prazo de Recebimento
                        <span class="text-gray-500 font-normal text-xs ml-1">opcional</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            name="prazo_recebimento" 
                            id="prazo_recebimento"
                            value="{{ old('prazo_recebimento', '0') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prazo_recebimento') border-red-500 @enderror"
                            placeholder="0"
                            min="0"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">dias</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-600">Dias até receber (ex: 30 dias)</p>
                    @error('prazo_recebimento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Adquirente -->
            <div class="mb-6">
                <label for="adquirente" class="block text-sm font-semibold text-gray-700 mb-2">
                    Adquirente/Operadora
                    <span class="text-gray-500 font-normal text-xs ml-1">opcional</span>
                </label>
                <input 
                    type="text" 
                    name="adquirente" 
                    id="adquirente"
                    value="{{ old('adquirente') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('adquirente') border-red-500 @enderror"
                    placeholder="Ex: Stone, Cielo, PagSeguro, Mercado Pago..."
                >
                <p class="mt-1 text-xs text-gray-600">Nome da empresa processadora de pagamentos</p>
                @error('adquirente')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox -->
            <div class="mb-6">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="requer_conciliacao" 
                        value="1"
                        {{ old('requer_conciliacao') ? 'checked' : '' }}
                        class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                    >
                    <div>
                        <span class="text-sm font-semibold text-gray-700">Requer Conciliação</span>
                        <p class="text-xs text-gray-600">Marque se precisa conciliar com extrato da operadora (cartões, boletos)</p>
                    </div>
                </label>
            </div>

            <!-- Botões -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Criar Forma de Pagamento
                </button>
                <a 
                    href="{{ route('financeiro.formas-pagamento.index') }}" 
                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Voltar -->
    <div class="mt-6">
        <a href="{{ route('financeiro.formas-pagamento.index') }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para Formas de Pagamento
        </a>
    </div>
</div>
@endsection
