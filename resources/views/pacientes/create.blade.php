@extends('layouts.tenant-app')

@section('title', 'Novo Paciente')
@section('page-title', 'Novo Paciente')

@section('content')
<!-- Header -->
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-3 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Novo Paciente</h1>
                <p class="text-sm text-gray-600 mt-0.5">Cadastre um novo paciente no sistema</p>
            </div>
        </div>
        <a href="{{ route('pacientes.index') }}" 
           class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-200 border border-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna do Formulário (2/3) -->
    <div class="lg:col-span-2">
        <form action="{{ route('pacientes.store') }}" method="POST">
            @csrf
            
            <!-- Card: Dados Pessoais -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200 mb-6">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Dados Pessoais
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Nome Completo -->
                    <div>
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome Completo *
                        </label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome') }}"
                               placeholder="Ex: João da Silva Santos"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition @error('nome') border-red-500 @enderror">
                        @error('nome')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">
                                CPF
                            </label>
                            <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}"
                                   placeholder="000.000.000-00"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-semibold text-gray-700 mb-2">
                                RG
                            </label>
                            <input type="text" name="rg" id="rg" value="{{ old('rg') }}"
                                   placeholder="00.000.000-0"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition">
                        </div>

                        <!-- Data de Nascimento -->
                        <div>
                            <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-2">
                                Data de Nascimento
                            </label>
                            <input type="text" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}"
                                   placeholder="dd/mm/aaaa"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Telefone
                            </label>
                            <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}"
                                   placeholder="(00) 00000-0000"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition">
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   placeholder="exemplo@email.com"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Paciente Menor de Idade / Responsável -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200 mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Dados do Responsável
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Toggle: É menor de idade? -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="bg-amber-500 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-800">Paciente é menor de idade?</span>
                                    <p class="text-xs text-gray-600">Ative para cadastrar os dados do responsável</p>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="checkbox" name="e_menor" id="e_menor" value="1" {{ old('e_menor') ? 'checked' : '' }}
                                       class="sr-only peer"
                                       onchange="toggleResponsavel()">
                                <div class="w-14 h-7 bg-gray-300 rounded-full peer peer-checked:bg-amber-500 transition-colors duration-300"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform duration-300 peer-checked:translate-x-7 shadow-md"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Campos do Responsável (ocultos por padrão) -->
                    <div id="responsavel-fields" class="space-y-5 {{ old('e_menor') ? '' : 'hidden' }}">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-blue-800 font-semibold text-xs">Informações do Responsável Legal</h3>
                                    <p class="text-blue-700 text-xs mt-0.5">Preencha os dados do responsável pelo paciente menor de idade</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nome do Responsável -->
                        <div>
                            <label for="responsavel_nome" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nome Completo do Responsável
                            </label>
                            <input type="text" name="responsavel_nome" id="responsavel_nome" value="{{ old('responsavel_nome') }}"
                                   placeholder="Ex: Maria da Silva Santos"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- CPF do Responsável -->
                            <div>
                                <label for="responsavel_cpf" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        CPF
                                    </span>
                                </label>
                                <input type="text" name="responsavel_cpf" id="responsavel_cpf" value="{{ old('responsavel_cpf') }}"
                                       placeholder="000.000.000-00"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">
                            </div>

                            <!-- Telefone do Responsável -->
                            <div>
                                <label for="responsavel_telefone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Telefone
                                    </span>
                                </label>
                                <input type="text" name="responsavel_telefone" id="responsavel_telefone" value="{{ old('responsavel_telefone') }}"
                                       placeholder="(00) 00000-0000"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">
                            </div>

                            <!-- Parentesco -->
                            <div>
                                <label for="responsavel_parentesco" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        Parentesco
                                    </span>
                                </label>
                                <select name="responsavel_parentesco" id="responsavel_parentesco"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">
                                    <option value="">Selecione...</option>
                                    <option value="Pai" {{ old('responsavel_parentesco') == 'Pai' ? 'selected' : '' }}>Pai</option>
                                    <option value="Mãe" {{ old('responsavel_parentesco') == 'Mãe' ? 'selected' : '' }}>Mãe</option>
                                    <option value="Avô" {{ old('responsavel_parentesco') == 'Avô' ? 'selected' : '' }}>Avô</option>
                                    <option value="Avó" {{ old('responsavel_parentesco') == 'Avó' ? 'selected' : '' }}>Avó</option>
                                    <option value="Tio" {{ old('responsavel_parentesco') == 'Tio' ? 'selected' : '' }}>Tio</option>
                                    <option value="Tia" {{ old('responsavel_parentesco') == 'Tia' ? 'selected' : '' }}>Tia</option>
                                    <option value="Tutor Legal" {{ old('responsavel_parentesco') == 'Tutor Legal' ? 'selected' : '' }}>Tutor Legal</option>
                                    <option value="Outro" {{ old('responsavel_parentesco') == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Endereço -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Endereço
                    </h2>
                </div>

                <div class="p-8 space-y-6">
                    <!-- CEP com busca automática -->
                    <div>
                        <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                CEP
                                <span id="cep-loading" class="hidden ml-2 text-xs text-blue-600 animate-pulse">
                                    Buscando endereço...
                                </span>
                            </span>
                        </label>
                        <input type="text" name="cep" id="cep" value="{{ old('cep') }}"
                               placeholder="00000-000"
                               maxlength="9"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        <p class="text-xs text-gray-500 mt-1">Digite o CEP para preencher automaticamente o endereço</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Logradouro -->
                        <div class="md:col-span-2">
                            <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Logradouro
                                </span>
                            </label>
                            <input type="text" name="endereco" id="endereco" value="{{ old('endereco') }}"
                                   placeholder="Rua, Avenida, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Número -->
                        <div>
                            <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    Número
                                </span>
                            </label>
                            <input type="text" name="numero" id="numero" value="{{ old('numero') }}"
                                   placeholder="123"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Complemento -->
                        <div>
                            <label for="complemento" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Complemento
                                </span>
                            </label>
                            <input type="text" name="complemento" id="complemento" value="{{ old('complemento') }}"
                                   placeholder="Apto, Bloco, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Bairro -->
                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                    </svg>
                                    Bairro
                                </span>
                            </label>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}"
                                   placeholder="Centro, Jardim, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Cidade -->
                        <div>
                            <label for="cidade_nome" class="block text-sm font-semibold text-gray-700 mb-2">
                                Cidade
                            </label>
                            <input type="text" name="cidade_nome" id="cidade_nome" value="{{ old('cidade_nome') }}"
                                   placeholder="Preenchido automaticamente pelo CEP"
                                   readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                            <input type="hidden" name="cidade_id" id="cidade_id" value="{{ old('cidade_id') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Observações -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Observações Adicionais
                    </h2>
                </div>

                <div class="p-8">
                    <textarea name="observacoes" id="observacoes" rows="4"
                              placeholder="Informações relevantes sobre o paciente, alergias, condições especiais, etc."
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">{{ old('observacoes') }}</textarea>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    💾 Cadastrar Paciente
                </button>
                <a href="{{ route('pacientes.index') }}" 
                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-xl transition duration-300 text-center">
                    ❌ Cancelar
                </a>
            </div>
        </form>
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
                    Guia Rápido
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="bg-pink-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Campo Obrigatório</h4>
                        <p class="text-sm text-gray-600">Apenas o nome é obrigatório para cadastro inicial</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">CPF Único</h4>
                        <p class="text-sm text-gray-600">Cada CPF só pode ser cadastrado uma vez</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-teal-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Dados Completos</h4>
                        <p class="text-sm text-gray-600">Quanto mais informações, melhor o atendimento</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ilustração -->
        <div class="bg-gradient-to-br from-pink-50 to-rose-50 p-6 rounded-2xl border border-pink-200">
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <defs>
                    <linearGradient id="patientCreate" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#ec4899;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f43f5e;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Pessoa -->
                <circle cx="100" cy="70" r="30" fill="url(#patientCreate)" opacity="0.6"/>
                <path d="M 60 110 Q 60 85 100 85 Q 140 85 140 110 L 140 150 L 60 150 Z" fill="url(#patientCreate)" opacity="0.6"/>
                
                <!-- Prancheta -->
                <rect x="30" y="40" width="60" height="80" rx="4" fill="white" stroke="#ec4899" stroke-width="3"/>
                <rect x="50" y="35" width="20" height="8" rx="2" fill="#ec4899"/>
                
                <!-- Linhas da Prancheta -->
                <line x1="40" y1="55" x2="80" y2="55" stroke="#f43f5e" stroke-width="2" stroke-linecap="round"/>
                <line x1="40" y1="65" x2="75" y2="65" stroke="#f43f5e" stroke-width="2" stroke-linecap="round"/>
                <line x1="40" y1="75" x2="80" y2="75" stroke="#f43f5e" stroke-width="2" stroke-linecap="round"/>
                <line x1="40" y1="85" x2="70" y2="85" stroke="#f43f5e" stroke-width="2" stroke-linecap="round"/>
                
                <!-- Check -->
                <circle cx="160" cy="60" r="20" fill="#10b981" opacity="0.8"/>
                <path d="M 152 60 L 158 66 L 170 52" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                
                <!-- Coração -->
                <path d="M 100 170 C 100 165 95 160 90 160 C 85 160 82 163 82 168 C 82 173 85 178 100 190 C 115 178 118 173 118 168 C 118 163 115 160 110 160 C 105 160 100 165 100 170" 
                      fill="#f43f5e" opacity="0.4"/>
            </svg>
        </div>

        <!-- Card de Dica -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl border border-amber-200">
            <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Dica Importante
            </h4>
            <p class="text-sm text-gray-700 leading-relaxed">
                <strong>Observações:</strong> Use este campo para registrar alergias, condições médicas especiais, 
                medicamentos em uso ou qualquer informação relevante para o atendimento.
            </p>
        </div>
    </div>
</div>

<script>
// Função para toggle do responsável
function toggleResponsavel() {
    const checkbox = document.getElementById('e_menor');
    const fields = document.getElementById('responsavel-fields');
    
    if (checkbox.checked) {
        fields.classList.remove('hidden');
        fields.classList.add('animate-fade-in');
    } else {
        fields.classList.add('hidden');
        fields.classList.remove('animate-fade-in');
    }
}

// Validador de CPF
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }
    
    let soma = 0;
    let resto;
    
    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;
    
    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;
    
    return true;
}

// Máscaras de Input
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de CPF com validação
    const cpfInputs = document.querySelectorAll('#cpf, #responsavel_cpf');
    cpfInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
        
        input.addEventListener('blur', function(e) {
            const cpf = e.target.value.replace(/\D/g, '');
            if (cpf.length > 0 && cpf.length === 11) {
                if (!validarCPF(cpf)) {
                    e.target.classList.add('border-red-500');
                    e.target.classList.remove('border-gray-200');
                    showToast('CPF inválido', 'error');
                } else {
                    e.target.classList.remove('border-red-500');
                    e.target.classList.add('border-green-500');
                    setTimeout(() => {
                        e.target.classList.remove('border-green-500');
                        e.target.classList.add('border-gray-200');
                    }, 2000);
                }
            }
        });
    });

    // Máscara de RG
    const rgInput = document.getElementById('rg');
    if (rgInput) {
        rgInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1})$/, '$1-$2');
            e.target.value = value;
        });
    }

    // Máscara de Telefone
    const telefoneInputs = document.querySelectorAll('#telefone, #responsavel_telefone');
    telefoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    });

    // Máscara de CEP com busca automática
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Busca automática de CEP
        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            
            if (cep.length === 8) {
                const loading = document.getElementById('cep-loading');
                loading.classList.remove('hidden');
                
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            
                            // Preencher cidade automaticamente
                            if (data.localidade && data.uf) {
                                const cidadeNome = `${data.localidade} - ${data.uf}`;
                                document.getElementById('cidade_nome').value = cidadeNome;
                                
                                // Buscar o ID da cidade para salvar no hidden
                                const cidadeIdHidden = document.getElementById('cidade_id');
                                
                                // Fazer uma busca no backend para pegar o ID da cidade
                                // Por enquanto, vamos só preencher o nome
                                // TODO: Adicionar endpoint para buscar cidade_id por nome+UF
                            }
                            
                            // Foca no campo número após preencher
                            document.getElementById('numero').focus();
                            
                            // Mensagem de sucesso
                            showToast('Endereço preenchido automaticamente!', 'success');
                        } else {
                            showToast('CEP não encontrado', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar CEP:', error);
                        showToast('Erro ao buscar CEP', 'error');
                    })
                    .finally(() => {
                        loading.classList.add('hidden');
                    });
            }
        });
    }
});

// Função para mostrar notificações toast
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 ${
        type === 'success' 
            ? 'bg-gradient-to-r from-green-500 to-emerald-500' 
            : 'bg-gradient-to-r from-red-500 to-rose-500'
    } text-white font-semibold flex items-center gap-3`;
    
    toast.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
            }
        </svg>
        ${message}
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Inicializar Flatpickr para campos de data
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se Flatpickr está disponível
    if (typeof flatpickr !== 'undefined') {
        // Data de Nascimento
        const dataNascimento = document.getElementById('data_nascimento');
        if (dataNascimento) {
            flatpickr(dataNascimento, {
                dateFormat: 'Y-m-d',
                locale: 'pt',
                maxDate: 'today', // Não permite datas futuras
                defaultDate: null,
                altInput: true,
                altFormat: 'd/m/Y',
                placeholder: 'dd/mm/aaaa',
                allowInput: true,
                disableMobile: true, // Usa sempre o date picker customizado
                yearDropdown: true,
                monthDropdown: true
            });
        }
        
        // Data de Nascimento do Responsável (se existir)
        const responsavelNascimento = document.getElementById('responsavel_data_nascimento');
        if (responsavelNascimento) {
            flatpickr(responsavelNascimento, {
                dateFormat: 'Y-m-d',
                locale: 'pt',
                maxDate: 'today',
                defaultDate: null,
                altInput: true,
                altFormat: 'd/m/Y',
                placeholder: 'dd/mm/aaaa',
                allowInput: true,
                disableMobile: true,
                yearDropdown: true,
                monthDropdown: true
            });
        }
    }
});
</script>

<!-- TomSelect CSS e JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<!-- Flatpickr CSS e JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
@endsection

