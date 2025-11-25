@extends('layouts.app')

@section('title', 'Editar Cidade - MultiImune')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                Editar Cidade
            </h1>
            <p class="text-gray-600 mt-2">Atualize as informações de {{ $cidade->nome }}</p>
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
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Atualizar Dados
                </h2>
            </div>

            <!-- Formulário -->
            <form action="{{ route('cidades.update', $cidade) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Nome da Cidade -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Nome da Cidade *
                            </span>
                        </label>
                        <input type="text" name="nome" id="nome" required 
                               value="{{ old('nome', $cidade->nome) }}"
                               placeholder="Ex: São Paulo, Rio de Janeiro, Belo Horizonte"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200 @error('nome') border-red-500 @enderror">
                        @error('nome')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- UF -->
                    <div>
                        <label for="uf" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Estado (UF) *
                            </span>
                        </label>
                        <select name="uf" id="uf" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200 @error('uf') border-red-500 @enderror">
                            <option value="">Selecione o estado...</option>
                            <option value="AC" {{ old('uf', $cidade->uf) == 'AC' ? 'selected' : '' }}>Acre (AC)</option>
                            <option value="AL" {{ old('uf', $cidade->uf) == 'AL' ? 'selected' : '' }}>Alagoas (AL)</option>
                            <option value="AP" {{ old('uf', $cidade->uf) == 'AP' ? 'selected' : '' }}>Amapá (AP)</option>
                            <option value="AM" {{ old('uf', $cidade->uf) == 'AM' ? 'selected' : '' }}>Amazonas (AM)</option>
                            <option value="BA" {{ old('uf', $cidade->uf) == 'BA' ? 'selected' : '' }}>Bahia (BA)</option>
                            <option value="CE" {{ old('uf', $cidade->uf) == 'CE' ? 'selected' : '' }}>Ceará (CE)</option>
                            <option value="DF" {{ old('uf', $cidade->uf) == 'DF' ? 'selected' : '' }}>Distrito Federal (DF)</option>
                            <option value="ES" {{ old('uf', $cidade->uf) == 'ES' ? 'selected' : '' }}>Espírito Santo (ES)</option>
                            <option value="GO" {{ old('uf', $cidade->uf) == 'GO' ? 'selected' : '' }}>Goiás (GO)</option>
                            <option value="MA" {{ old('uf', $cidade->uf) == 'MA' ? 'selected' : '' }}>Maranhão (MA)</option>
                            <option value="MT" {{ old('uf', $cidade->uf) == 'MT' ? 'selected' : '' }}>Mato Grosso (MT)</option>
                            <option value="MS" {{ old('uf', $cidade->uf) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul (MS)</option>
                            <option value="MG" {{ old('uf', $cidade->uf) == 'MG' ? 'selected' : '' }}>Minas Gerais (MG)</option>
                            <option value="PA" {{ old('uf', $cidade->uf) == 'PA' ? 'selected' : '' }}>Pará (PA)</option>
                            <option value="PB" {{ old('uf', $cidade->uf) == 'PB' ? 'selected' : '' }}>Paraíba (PB)</option>
                            <option value="PR" {{ old('uf', $cidade->uf) == 'PR' ? 'selected' : '' }}>Paraná (PR)</option>
                            <option value="PE" {{ old('uf', $cidade->uf) == 'PE' ? 'selected' : '' }}>Pernambuco (PE)</option>
                            <option value="PI" {{ old('uf', $cidade->uf) == 'PI' ? 'selected' : '' }}>Piauí (PI)</option>
                            <option value="RJ" {{ old('uf', $cidade->uf) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro (RJ)</option>
                            <option value="RN" {{ old('uf', $cidade->uf) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte (RN)</option>
                            <option value="RS" {{ old('uf', $cidade->uf) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul (RS)</option>
                            <option value="RO" {{ old('uf', $cidade->uf) == 'RO' ? 'selected' : '' }}>Rondônia (RO)</option>
                            <option value="RR" {{ old('uf', $cidade->uf) == 'RR' ? 'selected' : '' }}>Roraima (RR)</option>
                            <option value="SC" {{ old('uf', $cidade->uf) == 'SC' ? 'selected' : '' }}>Santa Catarina (SC)</option>
                            <option value="SP" {{ old('uf', $cidade->uf) == 'SP' ? 'selected' : '' }}>São Paulo (SP)</option>
                            <option value="SE" {{ old('uf', $cidade->uf) == 'SE' ? 'selected' : '' }}>Sergipe (SE)</option>
                            <option value="TO" {{ old('uf', $cidade->uf) == 'TO' ? 'selected' : '' }}>Tocantins (TO)</option>
                        </select>
                        @error('uf')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Ativo/Inativo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status de Atendimento
                            </span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="ativo" id="ativo" value="1"
                                   {{ old('ativo', $cidade->ativo) ? 'checked' : '' }}
                                   class="w-6 h-6 text-teal-600 border-2 border-gray-300 rounded focus:ring-4 focus:ring-teal-100">
                            <label for="ativo" class="text-gray-700 font-medium cursor-pointer">
                                Cidade ativa para atendimento
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 ml-9">
                            Desmarque para desativar temporariamente o atendimento nesta cidade
                        </p>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex gap-4 mt-8 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                        💾 Atualizar Cidade
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
        <!-- Card de Status Atual -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Dados Atuais
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-xl border border-teal-200">
                        <p class="text-xs text-gray-600 mb-1">Cidade</p>
                        <p class="text-lg font-bold text-gray-800">{{ $cidade->nome }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                        <p class="text-xs text-gray-600 mb-1">Estado</p>
                        <p class="text-lg font-bold text-gray-800">{{ $cidade->uf }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <p class="text-lg font-bold {{ $cidade->ativo ? 'text-green-700' : 'text-red-700' }}">
                            {{ $cidade->ativo ? '✓ Ativa' : '✗ Inativa' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Dicas -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl border border-amber-200">
            <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Atenção
            </h4>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="flex items-start gap-2">
                    <span class="text-amber-600 mt-0.5">•</span>
                    <span>Ao desativar uma cidade, ela não aparecerá mais nos cadastros de pacientes</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-600 mt-0.5">•</span>
                    <span>Pacientes já cadastrados não serão afetados</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-600 mt-0.5">•</span>
                    <span>Você pode reativar a cidade a qualquer momento</span>
                </li>
            </ul>
        </div>

        <!-- Ilustração -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <defs>
                    <linearGradient id="editCity" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#f59e0b;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Prédios -->
                <rect x="40" y="100" width="30" height="80" rx="2" fill="url(#editCity)" opacity="0.3"/>
                <rect x="75" y="85" width="35" height="95" rx="2" fill="url(#editCity)" opacity="0.5"/>
                <rect x="115" y="95" width="30" height="85" rx="2" fill="url(#editCity)" opacity="0.4"/>
                
                <!-- Lápis de Edição -->
                <rect x="130" y="30" width="15" height="60" rx="2" fill="#fbbf24" transform="rotate(-45 137.5 60)"/>
                <polygon points="120,50 128,58 122,64 114,56" fill="#f59e0b"/>
                <rect x="128" y="25" width="15" height="10" rx="1" fill="#78716c" transform="rotate(-45 135.5 30)"/>
                
                <!-- Linhas de Edição -->
                <line x1="60" y1="120" x2="90" y2="120" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
                <line x1="60" y1="130" x2="85" y2="130" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</div>
@endsection
