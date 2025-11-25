@extends('layouts.app')

@section('title', 'Nova Cidade - MultiImune')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                Nova Cidade
            </h1>
            <p class="text-gray-600 mt-2">Adicione uma nova localidade de atendimento</p>
        </div>
        <a href="{{ route('cidades.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
            ← Voltar
        </a>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Coluna do Formulário (2/3) -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <!-- Header do Card -->
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Dados da Cidade
                </h2>
            </div>

            <!-- Formulário -->
            <form action="{{ route('cidades.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Nome da Cidade -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Nome da Cidade *
                            </span>
                        </label>
                        <input type="text" name="nome" id="nome" required 
                               value="{{ old('nome') }}"
                               placeholder="Ex: São Paulo, Rio de Janeiro, Belo Horizonte"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200 @error('nome') border-red-500 @enderror">
                        @error('nome')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- UF -->
                    <div>
                        <label for="uf" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Estado (UF) *
                            </span>
                        </label>
                        <select name="uf" id="uf" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200 @error('uf') border-red-500 @enderror">
                            <option value="">Selecione o estado...</option>
                            <option value="AC" {{ old('uf') == 'AC' ? 'selected' : '' }}>Acre (AC)</option>
                            <option value="AL" {{ old('uf') == 'AL' ? 'selected' : '' }}>Alagoas (AL)</option>
                            <option value="AP" {{ old('uf') == 'AP' ? 'selected' : '' }}>Amapá (AP)</option>
                            <option value="AM" {{ old('uf') == 'AM' ? 'selected' : '' }}>Amazonas (AM)</option>
                            <option value="BA" {{ old('uf') == 'BA' ? 'selected' : '' }}>Bahia (BA)</option>
                            <option value="CE" {{ old('uf') == 'CE' ? 'selected' : '' }}>Ceará (CE)</option>
                            <option value="DF" {{ old('uf') == 'DF' ? 'selected' : '' }}>Distrito Federal (DF)</option>
                            <option value="ES" {{ old('uf') == 'ES' ? 'selected' : '' }}>Espírito Santo (ES)</option>
                            <option value="GO" {{ old('uf') == 'GO' ? 'selected' : '' }}>Goiás (GO)</option>
                            <option value="MA" {{ old('uf') == 'MA' ? 'selected' : '' }}>Maranhão (MA)</option>
                            <option value="MT" {{ old('uf') == 'MT' ? 'selected' : '' }}>Mato Grosso (MT)</option>
                            <option value="MS" {{ old('uf') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul (MS)</option>
                            <option value="MG" {{ old('uf') == 'MG' ? 'selected' : '' }}>Minas Gerais (MG)</option>
                            <option value="PA" {{ old('uf') == 'PA' ? 'selected' : '' }}>Pará (PA)</option>
                            <option value="PB" {{ old('uf') == 'PB' ? 'selected' : '' }}>Paraíba (PB)</option>
                            <option value="PR" {{ old('uf') == 'PR' ? 'selected' : '' }}>Paraná (PR)</option>
                            <option value="PE" {{ old('uf') == 'PE' ? 'selected' : '' }}>Pernambuco (PE)</option>
                            <option value="PI" {{ old('uf') == 'PI' ? 'selected' : '' }}>Piauí (PI)</option>
                            <option value="RJ" {{ old('uf') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro (RJ)</option>
                            <option value="RN" {{ old('uf') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte (RN)</option>
                            <option value="RS" {{ old('uf') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul (RS)</option>
                            <option value="RO" {{ old('uf') == 'RO' ? 'selected' : '' }}>Rondônia (RO)</option>
                            <option value="RR" {{ old('uf') == 'RR' ? 'selected' : '' }}>Roraima (RR)</option>
                            <option value="SC" {{ old('uf') == 'SC' ? 'selected' : '' }}>Santa Catarina (SC)</option>
                            <option value="SP" {{ old('uf') == 'SP' ? 'selected' : '' }}>São Paulo (SP)</option>
                            <option value="SE" {{ old('uf') == 'SE' ? 'selected' : '' }}>Sergipe (SE)</option>
                            <option value="TO" {{ old('uf') == 'TO' ? 'selected' : '' }}>Tocantins (TO)</option>
                        </select>
                        @error('uf')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex gap-4 mt-8 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                        💾 Salvar Cidade
                    </button>
                    <a href="{{ route('cidades.index') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-xl transition duration-300 text-center">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Coluna Lateral (1/3) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Card de Ajuda -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Dicas
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="bg-teal-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Nome Completo</h4>
                        <p class="text-sm text-gray-600">Digite o nome completo da cidade sem abreviações</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-cyan-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Estado Correto</h4>
                        <p class="text-sm text-gray-600">Selecione o estado (UF) correspondente à cidade</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Ativação Automática</h4>
                        <p class="text-sm text-gray-600">A cidade será cadastrada como ativa automaticamente</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ilustração SVG -->
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-6 rounded-2xl border border-teal-200">
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <defs>
                    <linearGradient id="cityCreate" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#14b8a6;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Prédios da Cidade -->
                <rect x="30" y="110" width="25" height="70" rx="2" fill="url(#cityCreate)" opacity="0.7"/>
                <rect x="60" y="90" width="30" height="90" rx="2" fill="url(#cityCreate)" opacity="0.8"/>
                <rect x="95" y="100" width="25" height="80" rx="2" fill="url(#cityCreate)" opacity="0.6"/>
                <rect x="125" y="80" width="30" height="100" rx="2" fill="url(#cityCreate)" opacity="0.9"/>
                <rect x="160" y="95" width="20" height="85" rx="2" fill="url(#cityCreate)" opacity="0.7"/>
                
                <!-- Janelas -->
                <rect x="35" y="120" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="42" y="120" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="35" y="130" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="42" y="130" width="4" height="4" fill="white" opacity="0.8"/>
                
                <rect x="65" y="100" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="72" y="100" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="80" y="100" width="4" height="4" fill="white" opacity="0.8"/>
                
                <!-- Nuvens -->
                <circle cx="50" cy="30" r="12" fill="#e0f2fe" opacity="0.6"/>
                <circle cx="65" cy="28" r="15" fill="#e0f2fe" opacity="0.6"/>
                <circle cx="80" cy="30" r="10" fill="#e0f2fe" opacity="0.6"/>
                
                <circle cx="130" cy="40" r="10" fill="#e0f2fe" opacity="0.6"/>
                <circle cx="142" cy="38" r="13" fill="#e0f2fe" opacity="0.6"/>
                <circle cx="155" cy="40" r="9" fill="#e0f2fe" opacity="0.6"/>
                
                <!-- Pin de Localização -->
                <path d="M100 45 L100 25 Q100 15 110 15 Q120 15 120 25 L120 45 Q115 55 110 65 Q105 55 100 45" 
                      fill="#ef4444" stroke="#dc2626" stroke-width="2"/>
                <circle cx="110" cy="27" r="5" fill="white"/>
            </svg>
        </div>

        <!-- Card de Exemplo -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl border border-amber-200">
            <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Exemplos
            </h4>
            <div class="space-y-2 text-sm">
                <p class="text-gray-700">
                    <strong>Nome:</strong> Campinas<br>
                    <strong>UF:</strong> SP
                </p>
                <div class="border-t border-amber-200 my-2"></div>
                <p class="text-gray-700">
                    <strong>Nome:</strong> Porto Alegre<br>
                    <strong>UF:</strong> RS
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
