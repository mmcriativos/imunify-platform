@extends('layouts.tenant-app')

@section('title', 'Nova Categoria Financeira')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🏷️ Nova Categoria</h1>
                <p class="text-sm text-gray-600 mt-1">Crie uma nova categoria financeira</p>
            </div>
            <a href="{{ route('financeiro.categorias.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                ← Voltar
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-8">
            <form 
                action="{{ route('financeiro.categorias.store') }}" 
                method="POST" 
                x-data="{
                    nome: @js(old('nome', '')),
                    tipo: @js(old('tipo', 'receita')),
                    icone: @js(old('icone', '')),
                    cor: @js(old('cor', '#3B82F6')),
                    showEmojiPicker: false,
                    emojis: ['💉', '💊', '🏥', '🩺', '🔬', '🧪', '🩹', '🧬', '⚕️', '🚑', '💰', '💵', '💳', '💸', '📊', '📈', '📉', '🧾', '🏦', '💼', '👔', '🔧', '🔨', '⚡', '💡', '🏠', '🚗', '✈️', '🍔', '☕', '📱', '💻', '🖨️', '📞', '📧', '📦', '🎁', '🛒', '🏪', '🏢'],
                    selectEmoji(emoji) {
                        this.icone = emoji;
                        this.showEmojiPicker = false;
                    }
                }"
            >
                @csrf

                <!-- Nome -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nome da Categoria *</label>
                    <input type="text" name="nome" required x-model="nome"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('nome') border-red-500 @enderror"
                           placeholder="Ex: Venda de Vacinas, Materiais de Limpeza...">
                    @error('nome')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Tipo *</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo" value="receita" x-model="tipo" required class="peer sr-only">
                            <div class="peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:ring-2 peer-checked:ring-green-200 border-2 border-gray-300 rounded-xl p-4 transition hover:border-green-300">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-2xl">📈</span>
                                    <span class="text-green-600 font-semibold">Receita</span>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo" value="despesa" x-model="tipo" required class="peer sr-only">
                            <div class="peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-200 border-2 border-gray-300 rounded-xl p-4 transition hover:border-red-300">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-2xl">📉</span>
                                    <span class="text-red-600 font-semibold">Despesa</span>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('tipo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ícone (Emoji) -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ícone (Emoji)</label>
                    
                    <div class="relative">
                        <!-- Campo de Exibição -->
                        <div 
                            @click="showEmojiPicker = !showEmojiPicker"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 transition flex items-center justify-between bg-white"
                        >
                            <div class="flex items-center gap-3">
                                <span class="text-3xl" x-text="icone || '😊'"></span>
                                <span class="text-gray-600" x-text="icone ? 'Clique para trocar' : 'Clique para escolher um emoji'"></span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        
                        <input type="hidden" name="icone" x-model="icone">
                        
                        <!-- Emoji Picker Dropdown -->
                        <div 
                            x-show="showEmojiPicker"
                            @click.away="showEmojiPicker = false"
                            x-transition
                            class="absolute z-10 mt-2 w-full bg-white rounded-lg shadow-xl border-2 border-blue-300 p-4"
                        >
                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-700">Escolha um emoji</span>
                                <button 
                                    type="button"
                                    @click="icone = ''; showEmojiPicker = false"
                                    class="text-xs text-red-600 hover:text-red-700 font-medium"
                                >
                                    Limpar
                                </button>
                            </div>
                            <div class="grid grid-cols-8 gap-2 max-h-64 overflow-y-auto">
                                <template x-for="emoji in emojis" :key="emoji">
                                    <button
                                        type="button"
                                        @click="selectEmoji(emoji)"
                                        class="text-2xl hover:bg-blue-50 rounded-lg p-2 transition"
                                        :class="{ 'bg-blue-100 ring-2 ring-blue-500': icone === emoji }"
                                        x-text="emoji"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <p class="mt-2 text-xs text-gray-600">
                        💡 Exemplos: 💉 vacinas | 💊 medicamentos | 🏥 consultas | 💰 receitas | 💸 despesas
                    </p>
                </div>

                <!-- Cor -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Cor</label>
                    <div class="flex gap-3 items-center">
                        <input type="color" name="cor" x-model="cor"
                               class="h-12 w-20 border-2 border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" x-model="cor"
                               @input="$el.value = $el.value.toUpperCase()"
                               class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono"
                               placeholder="#3B82F6"
                               pattern="^#[0-9A-Fa-f]{6}$"
                               maxlength="7">
                    </div>
                    <p class="text-xs text-gray-600 mt-2">Escolha uma cor para identificar visualmente esta categoria nos relatórios</p>
                </div>

                <!-- Preview em Tempo Real -->
                <div class="mb-6 p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border-2 border-gray-200">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <p class="text-sm font-bold text-gray-700">Prévia em Tempo Real</p>
                    </div>
                    
                    <div 
                        class="rounded-xl p-5 border-2 shadow-sm transition-all"
                        :style="`
                            background-color: ${tipo === 'receita' ? '#f0fdf4' : '#fef2f2'};
                            border-color: ${cor || '#CBD5E0'};
                        `"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div 
                                class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl shadow-sm"
                                :style="`background-color: ${cor || '#3B82F6'}20`"
                            >
                                <span x-text="icone || '📦'"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 
                                    class="font-bold text-xl truncate leading-tight"
                                    :style="`color: ${cor || '#1A202C'}`"
                                    x-text="nome || 'Nome da Categoria'"
                                ></h4>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span 
                                class="px-3 py-1.5 rounded-full text-xs font-bold"
                                :class="tipo === 'receita' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            >
                                <span x-text="tipo === 'receita' ? '📈 Receita' : '📉 Despesa'"></span>
                            </span>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t" :style="`border-color: ${cor || '#CBD5E0'}40`">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 font-medium">Cor:</span>
                                <div class="flex items-center gap-2">
                                    <div 
                                        class="w-7 h-7 rounded-lg border-2 border-white shadow-sm"
                                        :style="`background-color: ${cor || '#3B82F6'}`"
                                    ></div>
                                    <code class="text-xs font-mono text-gray-700 font-semibold" x-text="cor || '#3B82F6'"></code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('financeiro.categorias.index') }}"
                       class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-semibold transition shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Criar Categoria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
