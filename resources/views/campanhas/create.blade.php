@extends('layouts.tenant-app')

@section('page-title', 'Nova Campanha')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('campanhas.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para Campanhas
        </a>
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <span class="text-4xl">🎯</span>
            Nova Campanha de Vacinação
        </h1>
        <p class="text-gray-600 mt-2">
            Configure uma nova campanha sazonal com público-alvo e período específicos
        </p>
    </div>

    {{-- Mensagens de Erro --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-red-800 font-semibold mb-2">Corrija os seguintes erros:</h3>
                <ul class="list-disc list-inside text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Aviso Explicativo --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="bg-blue-500 p-3 rounded-xl flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-900 mb-2">
                    ℹ️ Como Funcionam as Campanhas
                </h3>
                <p class="text-blue-800 mb-3 leading-relaxed">
                    Campanhas <strong>não enviam mensagens em massa</strong>. Elas apenas <strong>personalizam os lembretes automáticos</strong> que são enviados quando os pacientes <strong>já têm agendamentos confirmados</strong>.
                </p>
                <div class="bg-white/60 rounded-lg p-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-blue-900">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <strong>Respeita a quota do seu plano</strong> - envios graduais ao longo do período
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-900">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <strong>Sem risco de ban do WhatsApp</strong> - apenas notificações transacionais
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-900">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <strong>Mensagens relevantes</strong> - só envia para quem agendou consulta
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulário --}}
    <form action="{{ route('campanhas.store') }}" method="POST" class="bg-white rounded-2xl border-2 border-gray-200 shadow-lg p-8">
        @csrf

        <div class="space-y-6">
            {{-- Nome da Campanha --}}
            <div>
                <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nome da Campanha <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nome" 
                       name="nome" 
                       value="{{ old('nome') }}" 
                       required
                       placeholder="Ex: Campanha Influenza 2025"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                @error('nome')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Vacina --}}
            <div>
                <label for="vacina" class="block text-sm font-semibold text-gray-700 mb-2">
                    Vacina <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="vacina" 
                       name="vacina" 
                       value="{{ old('vacina') }}" 
                       required
                       placeholder="Ex: Influenza, COVID-19, Hepatite B"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                @error('vacina')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descrição --}}
            <div>
                <label for="descricao" class="block text-sm font-semibold text-gray-700 mb-2">
                    Descrição
                </label>
                <textarea id="descricao" 
                          name="descricao" 
                          rows="3"
                          placeholder="Descreva os objetivos e detalhes da campanha..."
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">{{ old('descricao') }}</textarea>
                @error('descricao')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Período da Campanha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="data_inicio" class="block text-sm font-semibold text-gray-700 mb-2">
                        Data de Início <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="data_inicio" 
                           name="data_inicio" 
                           value="{{ old('data_inicio') }}" 
                           required
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                    @error('data_inicio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_fim" class="block text-sm font-semibold text-gray-700 mb-2">
                        Data de Término <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="data_fim" 
                           name="data_fim" 
                           value="{{ old('data_fim') }}" 
                           required
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                    @error('data_fim')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Público-Alvo --}}
            <div>
                <label for="publico_alvo" class="block text-sm font-semibold text-gray-700 mb-2">
                    Público-Alvo
                </label>
                <input type="text" 
                       id="publico_alvo" 
                       name="publico_alvo" 
                       value="{{ old('publico_alvo') }}" 
                       placeholder="Ex: Idosos acima de 60 anos, Gestantes, Profissionais da saúde"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                @error('publico_alvo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Faixa Etária --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Faixa Etária (Opcional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="idade_minima" class="block text-sm font-semibold text-gray-700 mb-2">
                            Idade Mínima
                        </label>
                        <input type="number" 
                               id="idade_minima" 
                               name="idade_minima" 
                               value="{{ old('idade_minima') }}" 
                               min="0"
                               max="120"
                               placeholder="Ex: 60"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                        @error('idade_minima')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="idade_maxima" class="block text-sm font-semibold text-gray-700 mb-2">
                            Idade Máxima
                        </label>
                        <input type="number" 
                               id="idade_maxima" 
                               name="idade_maxima" 
                               value="{{ old('idade_maxima') }}" 
                               min="0"
                               max="120"
                               placeholder="Ex: 120"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                        @error('idade_maxima')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="mt-3 text-sm text-gray-600">
                    💡 Defina a faixa etária para filtrar automaticamente os pacientes elegíveis
                </p>
            </div>

            {{-- Prioridade --}}
            <div>
                <label for="prioridade" class="block text-sm font-semibold text-gray-700 mb-2">
                    Prioridade <span class="text-red-500">*</span>
                </label>
                <select id="prioridade" 
                        name="prioridade" 
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                    <option value="">Selecione a prioridade</option>
                    <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>🟢 Baixa</option>
                    <option value="média" {{ old('prioridade') == 'média' ? 'selected' : '' }}>🟡 Média</option>
                    <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                </select>
                @error('prioridade')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Ativo --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" 
                           name="ativa" 
                           value="1" 
                           {{ old('ativa', true) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-900">Ativar campanha imediatamente</span>
                        <p class="text-sm text-gray-600 mt-1">
                            Se marcado, a campanha começará a enviar lembretes automáticos assim que salvar
                        </p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Botões --}}
        <div class="flex items-center gap-4 mt-8 pt-6 border-t-2 border-gray-200">
            <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl">
                💾 Criar Campanha
            </button>
            <a href="{{ route('campanhas.index') }}" class="px-6 py-4 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection
