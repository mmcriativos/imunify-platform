@extends('layouts.tenant-app')

@section('title', 'Nova Vacina - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Nova Vacina')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
                Nova Vacina
            </h1>
            <p class="text-gray-600 mt-2">Cadastre uma nova vacina no sistema</p>
        </div>
        <a href="{{ route('vacinas.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
            ← Voltar
        </a>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Coluna do Formulário (2/3) -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <form action="{{ route('vacinas.store') }}" method="POST">
                @csrf
                
                <div class="space-y-8">
                    <!-- Nome da Vacina -->
                    <div class="relative">
                        <label for="nome" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            Nome da Vacina
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <input type="text" name="nome" id="nome" required value="{{ old('nome') }}"
                                   placeholder="Ex: Influenza (Gripe), COVID-19, Hepatite B"
                                   class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                        </div>
                        @error('nome')
                            <div class="flex items-center mt-2 text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Fabricante -->
                    <div class="relative">
                        <label for="fabricante" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            Fabricante
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                            </div>
                            <input type="text" name="fabricante" id="fabricante" value="{{ old('fabricante') }}"
                                   placeholder="Ex: Sanofi Pasteur, Pfizer, AstraZeneca"
                                   class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                        </div>
                        @error('fabricante')
                            <div class="flex items-center mt-2 text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Modo de Agir -->
                    <div class="relative">
                        <label for="modo_agir" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            Modo de Agir
                        </label>
                        <div class="relative">
                            <textarea name="modo_agir" id="modo_agir" rows="4"
                                      placeholder="Como a vacina age no organismo para proteger contra a doença"
                                      class="w-full px-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400 resize-none">{{ old('modo_agir') }}</textarea>
                        </div>
                        <div class="flex items-center mt-2 text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Ex: Vacina inativada que estimula o sistema imunológico a produzir anticorpos</span>
                        </div>
                        @error('modo_agir')
                            <div class="flex items-center mt-2 text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Indicações -->
                    <div class="relative">
                        <label for="indicacoes" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            Indicações
                        </label>
                        <div class="relative">
                            <textarea name="indicacoes" id="indicacoes" rows="4"
                                      placeholder="Para quem a vacina é indicada (faixa etária, grupos de risco, etc)"
                                      class="w-full px-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400 resize-none">{{ old('indicacoes') }}</textarea>
                        </div>
                        <div class="flex items-center mt-2 text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Ex: Pessoas a partir de 6 meses de idade, gestantes, idosos</span>
                        </div>
                        @error('indicacoes')
                            <div class="flex items-center mt-2 text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="relative">
                        <label for="descricao" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="bg-amber-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            Descrição e Observações
                        </label>
                        <div class="relative">
                            <textarea name="descricao" id="descricao" rows="4"
                                      placeholder="Informações adicionais: apresentação, armazenamento, via de administração, etc"
                                      class="w-full px-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400 resize-none">{{ old('descricao') }}</textarea>
                        </div>
                        <div class="flex items-center mt-2 text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Ex: Dose de 0,5 mL, administração intramuscular, armazenar entre 2°C e 8°C</span>
                        </div>
                        @error('descricao')
                            <div class="flex items-center mt-2 text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Esquema de Dosagem -->
                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Esquema de Dosagem</h3>
                                <p class="text-sm text-gray-600">Configure o protocolo vacinal</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="numero_doses" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Número de Doses
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <select name="numero_doses" id="numero_doses" required
                                            onchange="toggleIntervaloDoses()"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 bg-white hover:border-gray-400 appearance-none">
                                        <option value="1" {{ old('numero_doses', 1) == 1 ? 'selected' : '' }}>🎯 Dose Única</option>
                                        <option value="2" {{ old('numero_doses') == 2 ? 'selected' : '' }}>✌️ 2 Doses</option>
                                        <option value="3" {{ old('numero_doses') == 3 ? 'selected' : '' }}>🔢 3 Doses</option>
                                        <option value="4" {{ old('numero_doses') == 4 ? 'selected' : '' }}>📋 4 Doses</option>
                                        <option value="5" {{ old('numero_doses') == 5 ? 'selected' : '' }}>📊 5 ou mais Doses</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex items-center mt-2 text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Quantas doses são necessárias?</span>
                                </div>
                            </div>

                            <div id="intervaloContainer">
                                <label for="intervalo_doses_dias" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Intervalo entre Doses
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="number" name="intervalo_doses_dias" id="intervalo_doses_dias" min="0" 
                                           value="{{ old('intervalo_doses_dias') }}"
                                           placeholder="Ex: 30, 60, 180"
                                           class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-sm text-gray-500 font-medium">dias</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Dias entre cada dose</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Preços -->
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="bg-emerald-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Gestão de Preços</h3>
                                <p class="text-sm text-gray-600">Configure os valores comerciais da vacina</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Preço de Custo -->
                            <div>
                                <label for="preco_custo" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                    Preço de Custo
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">R$</span>
                                    </div>
                                    <input type="text" name="preco_custo" id="preco_custo" inputmode="decimal"
                                           value="{{ old('preco_custo') }}"
                                           placeholder="0,00"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                                <div class="flex items-center mt-2 text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Quanto custa por dose</span>
                                </div>
                                @error('preco_custo')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Preço Venda Cartão -->
                            <div>
                                <label for="preco_venda_cartao" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Preço Venda Cartão
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">R$</span>
                                    </div>
                                    <input type="text" name="preco_venda_cartao" id="preco_venda_cartao" inputmode="decimal"
                                           value="{{ old('preco_venda_cartao') }}"
                                           placeholder="0,00"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                                <div class="flex items-center mt-2 text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Preço no cartão de crédito/débito</span>
                                </div>
                                @error('preco_venda_cartao')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Preço Venda PIX/Dinheiro -->
                            <div>
                                <label for="preco_venda_pix" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    Preço PIX/Dinheiro
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">R$</span>
                                    </div>
                                    <input type="text" name="preco_venda_pix" id="preco_venda_pix" inputmode="decimal"
                                           value="{{ old('preco_venda_pix') }}"
                                           placeholder="0,00"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                                <div class="flex items-center mt-2 text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Preço em PIX ou dinheiro (geralmente menor)</span>
                                </div>
                                @error('preco_venda_pix')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Preço Promocional -->
                            <div>
                                <label for="preco_promocional" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Preço Promocional
                                    <span class="text-gray-400 ml-2 text-xs">(Opcional)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">R$</span>
                                    </div>
                                    <input type="text" name="preco_promocional" id="preco_promocional" inputmode="decimal"
                                           value="{{ old('preco_promocional') }}"
                                           placeholder="0,00"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                                <div class="flex items-center mt-2 text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Preço em promoção (quando aplicável)</span>
                                </div>
                                @error('preco_promocional')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Validade -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="validade_dias" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Validade da Imunização
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input type="number" name="validade_dias" id="validade_dias" min="0" max="7300"
                                       value="{{ old('validade_dias') }}"
                                       placeholder="Ex: 365, 730, 1095"
                                       class="w-full pl-12 pr-16 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 font-medium">dias</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-2 text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm">Período de proteção após conclusão do esquema vacinal</span>
                            </div>
                            <div class="mt-2 text-xs text-gray-400">
                                💡 <strong>Referências:</strong> 1 ano = 365 dias | 2 anos = 730 dias | 3 anos = 1095 dias
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estoque Inicial & Lote -->
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-6">
                        <div class="bg-orange-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Controle de Estoque Inicial</h3>
                            <p class="text-sm text-gray-600">Configure o estoque e registre o primeiro lote</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Estoque Mínimo -->
                        <div>
                            <label for="estoque_minimo" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Estoque Mínimo
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                </div>
                                <input type="number" name="estoque_minimo" id="estoque_minimo" min="0" 
                                       value="{{ old('estoque_minimo', 10) }}"
                                       placeholder="Ex: 10"
                                       class="w-full pl-12 pr-16 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 font-medium">unid.</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Alerta quando atingir este valor</p>
                        </div>

                        <!-- Estoque Ideal -->
                        <div>
                            <label for="estoque_ideal" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Estoque Ideal
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <input type="number" name="estoque_ideal" id="estoque_ideal" min="0" 
                                       value="{{ old('estoque_ideal', 50) }}"
                                       placeholder="Ex: 50"
                                       class="w-full pl-12 pr-16 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 font-medium">unid.</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Meta de estoque para operação ideal</p>
                        </div>

                        <!-- Estoque Inicial -->
                        <div>
                            <label for="estoque_atual" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                                Estoque Inicial
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <input type="number" name="estoque_atual" id="estoque_atual" min="0" 
                                       value="{{ old('estoque_atual', 0) }}"
                                       placeholder="Ex: 25"
                                       class="w-full pl-12 pr-16 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 font-medium">unid.</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Quantidade atual em estoque</p>
                        </div>
                    </div>

                    <!-- Informações do Primeiro Lote (Condicional) -->
                    <div id="lote-section" class="border-t border-orange-200 pt-6" style="display: none;">
                        <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Informações do Primeiro Lote
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Número do Lote -->
                            <div>
                                <label for="numero_lote" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Número do Lote
                                </label>
                                <div class="relative">
                                    <input type="text" name="numero_lote" id="numero_lote" 
                                           value="{{ old('numero_lote') }}"
                                           placeholder="Ex: LT2024-001"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                            </div>

                            <!-- Data de Validade do Lote -->
                            <div>
                                <label for="data_validade_lote" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Validade do Lote
                                </label>
                                <div class="relative">
                                    <input type="date" name="data_validade_lote" id="data_validade_lote" 
                                           value="{{ old('data_validade_lote') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 bg-white hover:border-gray-400">
                                </div>
                            </div>

                            <!-- Fornecedor -->
                            <div>
                                <label for="fornecedor_nome" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Fornecedor
                                </label>
                                <div class="relative">
                                    <input type="text" name="fornecedor_nome" id="fornecedor_nome" 
                                           value="{{ old('fornecedor_nome') }}"
                                           placeholder="Ex: Laboratório ABC"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-white hover:border-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dicas sobre Controle de Estoque -->
                    <div class="bg-orange-100 border border-orange-300 rounded-lg p-4 mt-6">
                        <h4 class="text-sm font-bold text-orange-800 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            💡 Dicas de Controle de Estoque
                        </h4>
                        <ul class="space-y-2 text-sm text-orange-700">
                            <li class="flex items-start">
                                <span class="text-orange-600 mr-2 mt-0.5">•</span>
                                <span><strong>Estoque Mínimo:</strong> Define quando você receberá alertas de reposição</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-orange-600 mr-2 mt-0.5">•</span>
                                <span><strong>Estoque Ideal:</strong> Meta de quantidade para operação sem interrupções</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-orange-600 mr-2 mt-0.5">•</span>
                                <span><strong>Informações do Lote:</strong> Aparecem apenas se você informar estoque inicial > 0</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-gray-50 rounded-xl p-6 mt-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Todos os campos marcados com * são obrigatórios</span>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('vacinas.index') }}" 
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-20 transition-all duration-200 font-semibold shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancelar
                            </a>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-30 transition-all duration-300 hover-lift relative overflow-hidden group">
                                <div class="relative z-10 flex items-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Cadastrar Vacina</span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Coluna de Ajuda/Ilustração (1/3) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Ilustração SVG -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <svg class="w-full h-auto" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Fundo -->
                <circle cx="100" cy="100" r="90" fill="#F0FDF4"/>
                
                <!-- Frasco de Vacina -->
                <g transform="translate(70, 40)">
                    <!-- Tampa -->
                    <rect x="20" y="10" width="20" height="8" rx="2" fill="#10B981"/>
                    <rect x="18" y="15" width="24" height="5" rx="1" fill="#059669"/>
                    
                    <!-- Corpo do frasco -->
                    <path d="M 18 20 L 18 80 Q 18 90 28 90 L 42 90 Q 52 90 52 80 L 52 20 Z" 
                          fill="#D1FAE5" stroke="#10B981" stroke-width="2"/>
                    
                    <!-- Líquido -->
                    <path d="M 22 40 L 22 78 Q 22 85 28 85 L 42 85 Q 48 85 48 78 L 48 40 Z" 
                          fill="#34D399" opacity="0.6"/>
                    
                    <!-- Rótulo -->
                    <rect x="24" y="50" width="22" height="15" rx="2" fill="white" opacity="0.9"/>
                    <line x1="26" y1="55" x2="44" y2="55" stroke="#10B981" stroke-width="1.5"/>
                    <line x1="26" y1="60" x2="40" y2="60" stroke="#10B981" stroke-width="1"/>
                    
                    <!-- Cruz médica -->
                    <g transform="translate(30, 25)">
                        <rect x="3" y="0" width="4" height="10" rx="1" fill="#10B981"/>
                        <rect x="0" y="3" width="10" height="4" rx="1" fill="#10B981"/>
                    </g>
                </g>
                
                <!-- Doses indicadas -->
                <g transform="translate(120, 60)">
                    <!-- Dose 1 -->
                    <circle cx="0" cy="0" r="8" fill="#3B82F6"/>
                    <text x="0" y="4" text-anchor="middle" fill="white" font-size="10" font-weight="bold">1</text>
                    
                    <!-- Dose 2 -->
                    <circle cx="0" cy="25" r="8" fill="#3B82F6"/>
                    <text x="0" y="29" text-anchor="middle" fill="white" font-size="10" font-weight="bold">2</text>
                    
                    <!-- Dose 3 -->
                    <circle cx="0" cy="50" r="8" fill="#3B82F6"/>
                    <text x="0" y="54" text-anchor="middle" fill="white" font-size="10" font-weight="bold">3</text>
                    
                    <!-- Linha conectando -->
                    <line x1="0" y1="8" x2="0" y2="17" stroke="#93C5FD" stroke-width="2" stroke-dasharray="2,2"/>
                    <line x1="0" y1="33" x2="0" y2="42" stroke="#93C5FD" stroke-width="2" stroke-dasharray="2,2"/>
                </g>
                
                <!-- Selo de qualidade -->
                <circle cx="150" cy="140" r="20" fill="#10B981"/>
                <path d="M 142 140 L 148 146 L 158 134" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
            </svg>
            
            <p class="text-center text-sm text-gray-600 mt-4 font-medium">
                Controle completo de dosagem
            </p>
        </div>

        <!-- Card de Exemplos -->
        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-2xl p-6 shadow-lg border border-green-100">
            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                Exemplos de Esquemas
            </h4>
            <div class="space-y-3 text-sm">
                <div class="bg-white rounded-lg p-3 border border-green-200">
                    <p class="font-semibold text-green-700">💉 COVID-19 (2 doses)</p>
                    <p class="text-gray-600 text-xs mt-1">Intervalo: 30 dias</p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-blue-200">
                    <p class="font-semibold text-blue-700">💉 Hepatite B (3 doses)</p>
                    <p class="text-gray-600 text-xs mt-1">Intervalo: 30-60 dias</p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-purple-200">
                    <p class="font-semibold text-purple-700">💉 Influenza (Dose única)</p>
                    <p class="text-gray-600 text-xs mt-1">Anual</p>
                </div>
            </div>
        </div>

        <!-- Dicas -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 shadow-lg border border-blue-100">
            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Dicas Importantes
            </h4>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    <span>Informe sempre o número correto de doses</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    <span>O intervalo ajuda no controle de revacinação</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    <span>Dose única = não precisa intervalo</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Animações customizadas */
    @keyframes slideInFromRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes pulse-soft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    /* Estilos para campos com erro */
    .field-error {
        animation: shake 0.3s ease-in-out;
    }
    
    /* Feedback visual melhorado */
    .input-success {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
    }
    
    .input-warning {
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1);
    }
    
    .input-error {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
        animation: shake 0.3s ease-in-out;
    }
    
    /* Botão com efeito de loading */
    .btn-loading {
        position: relative;
        overflow: hidden;
    }
    
    .btn-loading::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: loading-shine 1.5s infinite;
    }
    
    @keyframes loading-shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    /* Melhorias no toast */
    .toast-enter {
        animation: slideInFromRight 0.3s ease-out;
    }
    
    .toast-exit {
        animation: slideInFromRight 0.3s ease-out reverse;
    }
    
    /* Hover effects melhorados */
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Indicador de campo obrigatório */
    .required-field::after {
        content: ' *';
        color: #ef4444;
        font-weight: bold;
    }
    
    /* Transições suaves para todos os inputs */
    input, select, textarea {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Estilo para campos desabilitados */
    input:disabled, select:disabled, textarea:disabled {
        background-color: #f9fafb;
        color: #9ca3af;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    /* Gradientes suaves para seções */
    .gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-green { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .gradient-purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    
    /* Animação para seção de lote */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Estilo para indicadores de estoque */
    .estoque-baixo { border-color: #ef4444 !important; background-color: #fef2f2; }
    .estoque-ok { border-color: #10b981 !important; background-color: #f0fdf4; }
    .estoque-alto { border-color: #3b82f6 !important; background-color: #eff6ff; }
</style>
@endpush

@push('scripts')
<script>
// Controlar visibilidade do intervalo de doses
function toggleIntervaloDoses() {
    const numeroDoses = document.getElementById('numero_doses');
    const intervaloContainer = document.getElementById('intervaloContainer');
    const intervaloInput = document.getElementById('intervalo_doses_dias');

    if (!numeroDoses || !intervaloContainer || !intervaloInput) {
        return;
    }

    if (Number(numeroDoses.value) === 1) {
        intervaloContainer.classList.add('opacity-50');
        intervaloInput.disabled = true;
        intervaloInput.value = '';
    } else {
        intervaloContainer.classList.remove('opacity-50');
        intervaloInput.disabled = false;
    }
}

// Máscara de moeda brasileira
function mascaraMoeda(campo) {
    if (!campo) {
        return;
    }

    let valor = campo.value || '';
    valor = valor.replace(/\D/g, '');

    if (!valor) {
        campo.value = '';
        return;
    }

    const numero = parseInt(valor, 10);

    if (Number.isNaN(numero)) {
        campo.value = '';
        return;
    }

    const resultado = (numero / 100).toFixed(2);
    const [inteira, decimal] = resultado.split('.');
    const inteiraFormatada = inteira.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    campo.value = `${inteiraFormatada},${decimal}`;
}

document.addEventListener('DOMContentLoaded', function() {
    toggleIntervaloDoses();

    const campos = ['preco_custo', 'preco_venda_cartao', 'preco_venda_pix', 'preco_promocional'];

    // Configurar máscaras e validações
    campos.forEach(id => {
        const campo = document.getElementById(id);
        if (!campo) return;

        campo.addEventListener('input', function() {
            mascaraMoeda(this);
            
            // Feedback visual durante digitação
            this.classList.add('border-emerald-400', 'ring-2', 'ring-emerald-200');
            setTimeout(() => {
                this.classList.remove('border-emerald-400', 'ring-2', 'ring-emerald-200');
            }, 500);
        });

        if (campo.value) {
            mascaraMoeda(campo);
        }
    });

    // Validação em tempo real do nome da vacina
    const nomeField = document.getElementById('nome');
    if (nomeField) {
        nomeField.addEventListener('input', function() {
            const valor = this.value.trim();
            const container = this.parentElement;
            
            if (valor.length === 0) {
                this.classList.remove('border-green-500');
                this.classList.add('border-red-300');
                showValidationMessage(container, 'Nome da vacina é obrigatório', 'error');
            } else if (valor.length < 3) {
                this.classList.remove('border-green-500');
                this.classList.add('border-yellow-400');
                showValidationMessage(container, 'Nome muito curto (mínimo 3 caracteres)', 'warning');
            } else {
                this.classList.remove('border-red-300', 'border-yellow-400');
                this.classList.add('border-green-500');
                clearValidationMessage(container);
            }
        });
    }

    // Validação de fabricante
    const fabricanteField = document.getElementById('fabricante');
    if (fabricanteField) {
        fabricanteField.addEventListener('input', function() {
            const valor = this.value.trim();
            const container = this.parentElement;
            
            if (valor.length > 0 && valor.length < 2) {
                showValidationMessage(container, 'Nome do fabricante muito curto', 'warning');
            } else {
                clearValidationMessage(container);
            }
        });
    }

    // Validação de intervalo de doses
    const intervaloDoses = document.getElementById('intervalo_doses_dias');
    const numeroDoses = document.getElementById('numero_doses');
    
    if (intervaloDoses && numeroDoses) {
        intervaloDoses.addEventListener('input', function() {
            const valor = parseInt(this.value);
            const container = this.parentElement;
            
            if (numeroDoses.value > 1 && (isNaN(valor) || valor <= 0)) {
                this.classList.add('border-yellow-400');
                showValidationMessage(container, 'Intervalo necessário para múltiplas doses', 'warning');
            } else if (valor > 365) {
                this.classList.add('border-yellow-400');
                showValidationMessage(container, 'Intervalo muito longo (máximo 365 dias)', 'warning');
            } else {
                this.classList.remove('border-yellow-400');
                clearValidationMessage(container);
            }
        });
    }

    // Validação do campo de validade
    const validadeDias = document.getElementById('validade_dias');
    if (validadeDias) {
        validadeDias.addEventListener('input', function() {
            const valor = parseInt(this.value);
            const container = this.parentElement;
            
            if (isNaN(valor) || valor < 0) {
                this.classList.add('border-red-400');
                showValidationMessage(container, 'Valor deve ser um número positivo', 'error');
            } else if (valor === 0) {
                this.classList.add('border-yellow-400');
                this.classList.remove('border-red-400');
                showValidationMessage(container, 'Validade de 0 dias significa sem proteção duradoura', 'warning');
            } else if (valor > 7300) { // ~20 anos
                this.classList.add('border-yellow-400');
                this.classList.remove('border-red-400');
                showValidationMessage(container, 'Validade muito longa (máximo ~20 anos)', 'warning');
            } else if (valor >= 30) {
                this.classList.remove('border-red-400', 'border-yellow-400');
                this.classList.add('border-green-500');
                clearValidationMessage(container);
            } else {
                this.classList.add('border-yellow-400');
                this.classList.remove('border-red-400');
                showValidationMessage(container, 'Validade muito baixa (mínimo recomendado: 30 dias)', 'warning');
            }
        });

        // Adicionar sugestões de valores comuns
        validadeDias.addEventListener('focus', function() {
            const container = this.parentElement.parentElement;
            if (!container.querySelector('.validade-suggestions')) {
                const suggestions = document.createElement('div');
                suggestions.className = 'validade-suggestions mt-2 p-3 bg-purple-50 border border-purple-200 rounded-lg';
                suggestions.innerHTML = `
                    <div class="text-xs text-purple-700 font-medium mb-2">💡 Sugestões de validade:</div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <button type="button" onclick="document.getElementById('validade_dias').value = 365" class="text-left p-1 hover:bg-purple-100 rounded">
                            🗓️ 1 ano (365 dias)
                        </button>
                        <button type="button" onclick="document.getElementById('validade_dias').value = 1825" class="text-left p-1 hover:bg-purple-100 rounded">
                            🗓️ 5 anos (1825 dias)
                        </button>
                        <button type="button" onclick="document.getElementById('validade_dias').value = 3650" class="text-left p-1 hover:bg-purple-100 rounded">
                            🗓️ 10 anos (3650 dias)
                        </button>
                        <button type="button" onclick="document.getElementById('validade_dias').value = 0" class="text-left p-1 hover:bg-purple-100 rounded">
                            ♾️ Sem validade (0 dias)
                        </button>
                    </div>
                `;
                container.appendChild(suggestions);
            }
        });

        validadeDias.addEventListener('blur', function() {
            const container = this.parentElement.parentElement;
            const suggestions = container.querySelector('.validade-suggestions');
            if (suggestions) {
                setTimeout(() => {
                    if (suggestions) suggestions.remove();
                }, 200);
            }
        });
    }

    // Controle melhorado do formulário
    const formulario = document.querySelector('form');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Validações finais
            let formValido = true;
            const erros = [];

            // Validar nome
            if (!nomeField?.value.trim()) {
                erros.push('Nome da vacina é obrigatório');
                nomeField?.focus();
                formValido = false;
            }

            // Validar intervalo se necessário
            if (numeroDoses?.value > 1 && (!intervaloDoses?.value || intervaloDoses.value <= 0)) {
                erros.push('Intervalo entre doses é obrigatório para múltiplas doses');
                if (formValido) intervaloDoses?.focus();
                formValido = false;
            }

            if (!formValido) {
                e.preventDefault();
                showToast(erros.join('<br>'), 'error');
                return;
            }

            // Animação do botão
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Salvando vacina...</span>
                    </div>
                `;
                submitBtn.disabled = true;
                submitBtn.classList.add('cursor-not-allowed', 'opacity-75');
            }

            // Processar campos monetários
            campos.forEach(id => {
                const campo = document.getElementById(id);
                if (!campo || !campo.value) return;

                let valor = campo.value.trim();
                if (valor.includes(',')) {
                    valor = valor.replace(/\./g, '').replace(',', '.');
                }

                const numero = Number(valor);
                campo.value = Number.isFinite(numero) ? numero.toFixed(2) : '';
            });

            showToast('Salvando vacina...', 'info');
        });
    }

    // Função para mostrar mensagens de validação
    function showValidationMessage(container, message, type = 'error') {
        clearValidationMessage(container);
        
        const msgDiv = document.createElement('div');
        msgDiv.className = `validation-message mt-1 text-xs flex items-center ${
            type === 'error' ? 'text-red-500' : 
            type === 'warning' ? 'text-yellow-600' : 
            'text-blue-500'
        }`;
        
        msgDiv.innerHTML = `
            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>${message}</span>
        `;
        
        container.appendChild(msgDiv);
    }

    function clearValidationMessage(container) {
        const existing = container.querySelector('.validation-message');
        if (existing) {
            existing.remove();
        }
    }

    // Função para mostrar toast notifications
    function showToast(message, type = 'info') {
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-xl border transition-all duration-300 transform translate-x-full max-w-sm ${
            type === 'error' ? 'bg-red-50 border-red-200 text-red-800' : 
            type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 
            type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
            'bg-blue-50 border-blue-200 text-blue-800'
        }`;
        
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'error' ? 
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                            type === 'success' ?
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                        }
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button onclick="document.getElementById('${toastId}').remove()" class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animar entrada
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remover após 5 segundos
        setTimeout(() => {
            if (document.getElementById(toastId)) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.getElementById(toastId)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }
        }, 5000);
    }

    // Tornar função global
    window.showToast = showToast;

    // Indicador de progresso do formulário
    function updateFormProgress() {
        const totalFields = ['nome', 'fabricante', 'numero_doses', 'validade_dias'];
        const filledFields = totalFields.filter(id => {
            const field = document.getElementById(id);
            return field && field.value.trim() !== '';
        }).length;
        
        // Verificar campos opcionais preenchidos
        const optionalFields = ['modo_acao', 'indicacoes', 'preco_custo'];
        const filledOptional = optionalFields.filter(id => {
            const field = document.getElementById(id);
            return field && field.value.trim() !== '';
        }).length;
        
        const baseProgress = (filledFields / totalFields.length) * 80; // 80% para campos obrigatórios
        const optionalProgress = (filledOptional / optionalFields.length) * 20; // 20% para opcionais
        const progress = Math.min(100, baseProgress + optionalProgress);
        
        const progressBar = document.getElementById('form-progress');
        const progressText = document.getElementById('progress-text');
        
        if (progressBar && progressText) {
            progressBar.style.width = progress + '%';
            
            if (progress === 100) {
                progressText.textContent = '✅ Formulário completo!';
                progressBar.classList.add('bg-green-500');
                progressBar.classList.remove('bg-blue-500', 'bg-yellow-500');
                progressText.classList.add('text-green-600');
                progressText.classList.remove('text-blue-600', 'text-yellow-600');
            } else if (progress >= 80) {
                progressText.textContent = `${Math.round(progress)}% - Campos essenciais OK`;
                progressBar.classList.add('bg-yellow-500');
                progressBar.classList.remove('bg-blue-500', 'bg-green-500');
                progressText.classList.add('text-yellow-600');
                progressText.classList.remove('text-blue-600', 'text-green-600');
            } else {
                progressText.textContent = `${Math.round(progress)}% preenchido`;
                progressBar.classList.add('bg-blue-500');
                progressBar.classList.remove('bg-green-500', 'bg-yellow-500');
                progressText.classList.add('text-blue-600');
                progressText.classList.remove('text-green-600', 'text-yellow-600');
            }
        }
    }

    // Atualizar progresso quando os campos mudarem
    const progressFields = ['nome', 'fabricante', 'numero_doses', 'validade_dias', 'modo_acao', 'indicacoes', 'preco_custo'];
    progressFields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', updateFormProgress);
            field.addEventListener('change', updateFormProgress);
        }
    });

    // Controle da seção de lote baseado no estoque inicial
    const estoqueAtual = document.getElementById('estoque_atual');
    const loteSection = document.getElementById('lote-section');
    
    function toggleLoteSection() {
        if (estoqueAtual && loteSection) {
            const valor = parseInt(estoqueAtual.value) || 0;
            if (valor > 0) {
                loteSection.style.display = 'block';
                loteSection.classList.add('animate-fadeIn');
            } else {
                loteSection.style.display = 'none';
                loteSection.classList.remove('animate-fadeIn');
                // Limpar campos do lote
                ['numero_lote', 'data_validade_lote', 'fornecedor_nome'].forEach(id => {
                    const field = document.getElementById(id);
                    if (field) field.value = '';
                });
            }
        }
    }

    if (estoqueAtual) {
        estoqueAtual.addEventListener('input', toggleLoteSection);
        estoqueAtual.addEventListener('change', toggleLoteSection);
        // Inicializar
        toggleLoteSection();
    }

    // Validação de estoque mínimo vs ideal
    const estoqueMinimo = document.getElementById('estoque_minimo');
    const estoqueIdeal = document.getElementById('estoque_ideal');
    
    function validateEstoqueLogic() {
        if (estoqueMinimo && estoqueIdeal) {
            const minimo = parseInt(estoqueMinimo.value) || 0;
            const ideal = parseInt(estoqueIdeal.value) || 0;
            
            if (minimo > 0 && ideal > 0 && minimo >= ideal) {
                estoqueIdeal.classList.add('border-yellow-400');
                const container = estoqueIdeal.parentElement;
                showValidationMessage(container, 'Estoque ideal deve ser maior que o mínimo', 'warning');
            } else {
                estoqueIdeal.classList.remove('border-yellow-400');
                const container = estoqueIdeal.parentElement;
                clearValidationMessage(container);
            }
        }
    }

    if (estoqueMinimo && estoqueIdeal) {
        estoqueMinimo.addEventListener('input', validateEstoqueLogic);
        estoqueIdeal.addEventListener('input', validateEstoqueLogic);
    }

    // Inicializar progresso
    updateFormProgress();
});
</script>

<!-- Barra de Progresso Flutuante -->
<div id="progress-container" class="fixed bottom-4 left-4 right-4 bg-white rounded-lg shadow-xl border border-gray-200 p-4 z-40 md:left-auto md:right-4 md:w-80">
    <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm font-semibold text-gray-700">Progresso do Formulário</h4>
        <span id="progress-text" class="text-xs text-blue-600 font-medium">0% preenchido</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2">
        <div id="form-progress" class="bg-blue-500 h-2 rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
    </div>
    <p class="text-xs text-gray-500 mt-2">Complete os campos obrigatórios para continuar</p>
</div>
@endpush
@endsection

