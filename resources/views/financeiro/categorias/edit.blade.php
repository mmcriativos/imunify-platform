@extends('layouts.tenant-app')

@section('title', 'Editar Categoria')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{
    nome: @js(old('nome', $categoria->nome)),
    tipo: @js(old('tipo', $categoria->tipo)),
    icone: @js(old('icone', $categoria->icone ?? '')),
    cor: @js(old('cor', $categoria->cor ?? '#3B82F6')),
    ativo: {{ old('ativo', $categoria->ativo) ? 'true' : 'false' }},
    showEmojiPicker: false,
    emojis: ['💉', '💊', '🏥', '🩺', '🔬', '🧪', '🩹', '🧬', '⚕️', '🚑', '💰', '💵', '💳', '💸', '📊', '📈', '📉', '🧾', '🏦', '💼', '👔', '🔧', '🔨', '⚡', '💡', '🏠', '🚗', '✈️', '🍔', '☕', '📱', '💻', '🖨️', '📞', '📧', '📦', '🎁', '🛒', '🏪', '🏢'],
    selectEmoji(emoji) {
        this.icone = emoji;
        this.showEmojiPicker = false;
    }
}">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar Categoria
        </h1>
        <p class="text-gray-600 mt-1">Atualize as informações da categoria</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form action="{{ route('financeiro.categorias.update', $categoria) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div class="mb-6">
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome da Categoria
                        </label>
                        <input 
                            type="text" 
                            name="nome" 
                            id="nome"
                            x-model="nome"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nome') border-red-500 @enderror"
                            placeholder="Ex: Consultas, Salários, etc."
                            required
                        >
                        @error('nome')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tipo
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="tipo" value="receita" x-model="tipo" class="peer sr-only" required>
                                <div class="border-2 border-gray-300 rounded-lg p-4 text-center transition peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:ring-2 peer-checked:ring-green-200">
                                    <div class="text-3xl mb-2">📈</div>
                                    <div class="font-semibold text-gray-900">Receita</div>
                                    <div class="text-xs text-gray-600">Entrada de dinheiro</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="tipo" value="despesa" x-model="tipo" class="peer sr-only" required>
                                <div class="border-2 border-gray-300 rounded-lg p-4 text-center transition peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-2 peer-checked:ring-red-200">
                                    <div class="text-3xl mb-2">📉</div>
                                    <div class="font-semibold text-gray-900">Despesa</div>
                                    <div class="text-xs text-gray-600">Saída de dinheiro</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Ícone (Emoji) -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ícone (Emoji) <span class="text-gray-500 font-normal text-xs">opcional</span>
                        </label>
                        
                        <div class="relative">
                            <div 
                                @click="showEmojiPicker = !showEmojiPicker"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 transition flex items-center justify-between bg-white"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl" x-text="icone || '😊'"></span>
                                    <span class="text-gray-600" x-text="icone ? 'Clique para trocar' : 'Clique para escolher um emoji'"></span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            
                            <input type="hidden" name="icone" :value="icone">
                            
                            <div 
                                x-show="showEmojiPicker"
                                @click.away="showEmojiPicker = false"
                                x-transition
                                class="absolute z-10 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 p-4"
                                style="display: none;"
                            >
                                <div class="mb-3 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-700">Escolha um emoji</span>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Cor <span class="text-gray-500 font-normal text-xs">opcional</span>
                        </label>
                        <div class="flex gap-3 items-center">
                            <input 
                                type="color" 
                                name="cor" 
                                x-model="cor"
                                class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer"
                            >
                            <input 
                                type="text" 
                                x-model="cor"
                                @input="cor = $el.value.toUpperCase()"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono"
                                placeholder="#3B82F6"
                                pattern="^#[0-9A-Fa-f]{6}$"
                                maxlength="7"
                            >
                        </div>
                        <p class="text-xs text-gray-600 mt-2">Escolha uma cor para identificar visualmente esta categoria</p>
                    </div>

                    <!-- Status Ativo -->
                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="ativo" 
                                value="1"
                                x-model="ativo"
                                {{ old('ativo', $categoria->ativo) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                            >
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Categoria Ativa</span>
                                <p class="text-xs text-gray-600">Desmarque para desativar temporariamente</p>
                            </div>
                        </label>
                    </div>

                    <!-- Botões -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button 
                            type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Atualizar Categoria
                        </button>
                        <a 
                            href="{{ route('financeiro.categorias.index') }}" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition"
                        >
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Prévia em Tempo Real
                </h3>
                
                <div 
                    class="rounded-lg p-5 border-2 transition-all shadow-sm"
                    :style="`
                        background-color: ${tipo === 'receita' ? '#f0fdf4' : '#fef2f2'};
                        border-color: ${cor || '#CBD5E0'};
                    `"
                >
                    <div class="flex items-center gap-3 mb-4">
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
                    
                    <div class="flex items-center gap-2 flex-wrap">
                        <span 
                            class="px-3 py-1.5 rounded-full text-xs font-bold"
                            :class="tipo === 'receita' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                        >
                            <span x-text="tipo === 'receita' ? '📈 Receita' : '📉 Despesa'"></span>
                        </span>
                        <template x-if="!ativo">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-200 text-gray-700">
                                Inativa
                            </span>
                        </template>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t" :style="`border-color: ${cor || '#CBD5E0'}40`">
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

                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-2">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-blue-800 leading-relaxed">
                            <strong>💡 Dica:</strong> A prévia atualiza automaticamente conforme você preenche o formulário!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Voltar -->
    <div class="mt-6">
        <a href="{{ route('financeiro.categorias.index') }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para Categorias
        </a>
    </div>
</div>
@endsection
