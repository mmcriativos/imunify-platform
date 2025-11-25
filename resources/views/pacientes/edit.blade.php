@extends('layouts.tenant-app')

@section('title', 'Editar Paciente')
@section('page-title', 'Editar Paciente')

@section('content')
<!-- Header com Avatar e Gradiente -->
<div class="relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 rounded-3xl mb-8 shadow-2xl">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-full h-full bg-repeat" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"8\"/><circle cx=\"10\" cy=\"10\" r=\"4\"/><circle cx=\"50\" cy=\"10\" r=\"4\"/><circle cx=\"10\" cy=\"50\" r=\"4\"/><circle cx=\"50\" cy=\"50\" r=\"4\"/></g></g></svg>');"></div>
    </div>
    
    <div class="relative p-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <!-- Avatar do Paciente -->
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-white/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                        ✏️ Editar Paciente
                    </h1>
                    <p class="text-white/80 text-lg">
                        Atualizando dados de <span class="font-semibold">{{ $paciente->nome }}</span>
                    </p>
                    
                    <!-- Badge de Status -->
                    <div class="mt-3 flex items-center gap-3">
                        <span class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium border border-white/30">
                            {{ $paciente->ativo ? '✅ Ativo' : '🚫 Inativo' }}
                        </span>
                        @if($paciente->data_nascimento)
                        <span class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium border border-white/30">
                            🎂 {{ \Carbon\Carbon::parse($paciente->data_nascimento)->age }} anos
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('pacientes.show', $paciente) }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl border border-white/30 transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Visualizar
                </a>
                <a href="{{ route('pacientes.index') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl border border-white/30 transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative Element -->
    <div class="absolute bottom-0 right-0 w-32 h-32 transform translate-x-8 translate-y-8">
        <div class="w-full h-full bg-white/10 rounded-full animate-pulse"></div>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Coluna do Formulário (2/3) -->
    <div class="lg:col-span-2">
        <form action="{{ route('pacientes.update', $paciente) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Card: Dados Pessoais -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Dados Pessoais
                    </h2>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Nome Completo -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nome Completo *
                            </span>
                        </label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome', $paciente->nome) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200 @error('nome') border-red-500 @enderror">
                        @error('nome')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    CPF
                                </span>
                            </label>
                            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $paciente->cpf) }}"
                                   placeholder="000.000.000-00"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200 @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    RG
                                </span>
                            </label>
                            <input type="text" name="rg" id="rg" value="{{ old('rg', $paciente->rg) }}"
                                   placeholder="00.000.000-0"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200">
                        </div>

                        <!-- Data de Nascimento -->
                        <div>
                            <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Nascimento
                                </span>
                            </label>
                            <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento', $paciente->data_nascimento) }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    Telefone
                                </span>
                            </label>
                            <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $paciente->telefone) }}"
                                   placeholder="(00) 00000-0000"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200">
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    E-mail
                                </span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $paciente->email) }}"
                                   placeholder="exemplo@email.com"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100 transition duration-200">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Paciente Menor de Idade / Responsável -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Dados do Responsável
                    </h2>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Toggle: É menor de idade? -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-xl p-6">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="bg-amber-500 p-3 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-lg font-bold text-gray-800">Paciente é menor de idade?</span>
                                    <p class="text-sm text-gray-600">Ative para cadastrar os dados do responsável</p>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="checkbox" name="e_menor" id="e_menor" value="1" {{ old('e_menor', $paciente->e_menor) ? 'checked' : '' }}
                                       class="sr-only peer"
                                       onchange="toggleResponsavel()">
                                <div class="w-16 h-8 bg-gray-300 rounded-full peer peer-checked:bg-amber-500 transition-colors duration-300"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition-transform duration-300 peer-checked:translate-x-8 shadow-md"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Campos do Responsável -->
                    <div id="responsavel-fields" class="space-y-6 {{ old('e_menor', $paciente->e_menor) ? '' : 'hidden' }}">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-blue-800 font-semibold text-sm">Informações do Responsável Legal</h3>
                                    <p class="text-blue-700 text-xs mt-1">Preencha os dados do responsável pelo paciente menor de idade</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nome do Responsável -->
                        <div>
                            <label for="responsavel_nome" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Nome Completo do Responsável
                                </span>
                            </label>
                            <input type="text" name="responsavel_nome" id="responsavel_nome" value="{{ old('responsavel_nome', $paciente->responsavel_nome) }}"
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
                                <input type="text" name="responsavel_cpf" id="responsavel_cpf" value="{{ old('responsavel_cpf', $paciente->responsavel_cpf) }}"
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
                                <input type="text" name="responsavel_telefone" id="responsavel_telefone" value="{{ old('responsavel_telefone', $paciente->responsavel_telefone) }}"
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
                                    <option value="Pai" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Pai' ? 'selected' : '' }}>Pai</option>
                                    <option value="Mãe" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Mãe' ? 'selected' : '' }}>Mãe</option>
                                    <option value="Avô" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Avô' ? 'selected' : '' }}>Avô</option>
                                    <option value="Avó" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Avó' ? 'selected' : '' }}>Avó</option>
                                    <option value="Tio" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Tio' ? 'selected' : '' }}>Tio</option>
                                    <option value="Tia" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Tia' ? 'selected' : '' }}>Tia</option>
                                    <option value="Tutor Legal" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Tutor Legal' ? 'selected' : '' }}>Tutor Legal</option>
                                    <option value="Outro" {{ old('responsavel_parentesco', $paciente->responsavel_parentesco) == 'Outro' ? 'selected' : '' }}>Outro</option>
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
                    <!-- Dica: CEP primeiro para preenchimento automático -->
                    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 border-l-4 border-teal-500 p-4 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-teal-900">💡 Dica Rápida</p>
                                <p class="text-sm text-teal-700 mt-1">Digite o CEP primeiro e o endereço será preenchido automaticamente!</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- CEP (primeiro campo) -->
                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    CEP
                                </span>
                            </label>
                            <input type="text" name="cep" id="cep" value="{{ old('cep', $paciente->cep) }}"
                                   placeholder="00000-000"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Logradouro -->
                        <div class="md:col-span-2">
                            <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">Logradouro</label>
                            <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $paciente->endereco) }}"
                                   placeholder="Rua, Avenida, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Número -->
                        <div>
                            <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">Número</label>
                            <input type="text" name="numero" id="numero" value="{{ old('numero', $paciente->numero) }}"
                                   placeholder="123"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Bairro -->
                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-2">Bairro</label>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $paciente->bairro) }}"
                                   placeholder="Centro, Jardim, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>

                        <!-- Complemento -->
                        <div>
                            <label for="complemento" class="block text-sm font-medium text-gray-700 mb-2">Complemento</label>
                            <input type="text" name="complemento" id="complemento" value="{{ old('complemento', $paciente->complemento) }}"
                                   placeholder="Apto, Bloco, etc."
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                        </div>
                    </div>

                    <!-- Cidade (campo livre) -->
                    <div>
                        <label for="cidade" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Cidade
                            </span>
                        </label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $paciente->cidade) }}"
                               placeholder="Ex: Poços de Caldas - MG"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Card: Observações e Status -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Observações e Status
                    </h2>
                </div>

                <div class="p-8 space-y-6">
                    <div>
                        <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">Observações Adicionais</label>
                        <textarea name="observacoes" id="observacoes" rows="4"
                                  placeholder="Informações relevantes sobre o paciente..."
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition duration-200">{{ old('observacoes', $paciente->observacoes) }}</textarea>
                    </div>

                    <!-- Status Ativo/Inativo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status do Cadastro
                            </span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="ativo" id="ativo" value="1"
                                   {{ old('ativo', $paciente->ativo) ? 'checked' : '' }}
                                   class="w-6 h-6 text-pink-600 border-2 border-gray-300 rounded focus:ring-4 focus:ring-pink-100">
                            <label for="ativo" class="text-gray-700 font-medium cursor-pointer">
                                Paciente ativo no sistema
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 ml-9">
                            Desmarque para desativar temporariamente o cadastro deste paciente
                        </p>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    💾 Atualizar Paciente
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
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 p-4 rounded-xl border border-pink-200">
                        <p class="text-xs text-gray-600 mb-1">Nome</p>
                        <p class="text-lg font-bold text-gray-800">{{ $paciente->nome }}</p>
                    </div>
                    @if($paciente->cpf)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                        <p class="text-xs text-gray-600 mb-1">CPF</p>
                        <p class="text-lg font-bold text-gray-800">{{ $paciente->cpf }}</p>
                    </div>
                    @endif
                    @if($paciente->data_nascimento)
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200">
                        <p class="text-xs text-gray-600 mb-1">Idade</p>
                        <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($paciente->data_nascimento)->age }} anos</p>
                    </div>
                    @endif
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <p class="text-lg font-bold {{ $paciente->ativo ? 'text-green-700' : 'text-red-700' }}">
                            {{ $paciente->ativo ? '✓ Ativo' : '✗ Inativo' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Avisos -->
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
                    <span>Ao desativar um paciente, ele não aparecerá mais nas listagens</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-600 mt-0.5">•</span>
                    <span>Os atendimentos já realizados não serão afetados</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-600 mt-0.5">•</span>
                    <span>Você pode reativar o paciente a qualquer momento</span>
                </li>
            </ul>
        </div>

        <!-- Ilustração Animada -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <div class="text-center mb-4">
                <h4 class="text-gray-800 font-semibold text-lg">✨ Edição de Paciente</h4>
                <p class="text-gray-600 text-sm mt-1">Mantenha os dados sempre atualizados</p>
            </div>
            
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <defs>
                    <linearGradient id="editPatient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#f59e0b;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="paperGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#ffffff;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f3f4f6;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Fundo decorativo -->
                <circle cx="100" cy="100" r="90" fill="url(#editPatient)" opacity="0.1" class="animate-pulse"/>
                
                <!-- Documento/Formulário -->
                <rect x="50" y="40" width="100" height="120" rx="8" fill="url(#paperGradient)" stroke="#e5e7eb" stroke-width="2"/>
                
                <!-- Linhas do formulário -->
                <line x1="60" y1="60" x2="140" y2="60" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                <line x1="60" y1="75" x2="120" y2="75" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                <line x1="60" y1="90" x2="130" y2="90" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                <line x1="60" y1="105" x2="110" y2="105" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                <line x1="60" y1="120" x2="125" y2="120" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                <line x1="60" y1="135" x2="115" y2="135" stroke="#d1d5db" stroke-width="2" opacity="0.5"/>
                
                <!-- Pessoa -->
                <circle cx="100" cy="30" r="12" fill="url(#editPatient)" opacity="0.8"/>
                <path d="M 85 50 Q 85 38 100 38 Q 115 38 115 50 L 115 65 L 85 65 Z" fill="url(#editPatient)" opacity="0.8"/>
                
                <!-- Lápis animado -->
                <g class="animate-bounce">
                    <rect x="140" y="40" width="8" height="35" rx="2" fill="#fbbf24" transform="rotate(-45 144 57.5)"/>
                    <polygon points="130,60 135,65 129,71 124,66" fill="#f59e0b"/>
                    <rect x="138" y="35" width="8" height="6" rx="1" fill="#78716c" transform="rotate(-45 142 38)"/>
                </g>
                
                <!-- Efeito de "escrita" -->
                <circle cx="125" cy="75" r="2" fill="#f59e0b" opacity="0.6">
                    <animate attributeName="opacity" values="0.2;0.8;0.2" dur="2s" repeatCount="indefinite"/>
                </circle>
                
                <!-- Check mark de sucesso -->
                <circle cx="60" cy="180" r="12" fill="#10b981" opacity="0.9">
                    <animate attributeName="r" values="8;12;8" dur="2s" repeatCount="indefinite"/>
                </circle>
                <path d="M 55 180 L 58 183 L 65 175" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
                
                <!-- Estrelas decorativas -->
                <g opacity="0.4">
                    <polygon points="30,20 32,26 38,26 33,30 35,36 30,32 25,36 27,30 22,26 28,26" fill="#fbbf24">
                        <animateTransform attributeName="transform" type="rotate" values="0 30 28;360 30 28" dur="8s" repeatCount="indefinite"/>
                    </polygon>
                    <polygon points="170,170 171,174 175,174 172,177 173,181 170,179 167,181 168,177 165,174 169,174" fill="#f97316">
                        <animateTransform attributeName="transform" type="rotate" values="360 170 175;0 170 175" dur="6s" repeatCount="indefinite"/>
                    </polygon>
                </g>
            </svg>
            
            <div class="mt-4 text-center">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-3 rounded-lg border border-amber-200">
                    <p class="text-amber-800 text-xs font-medium">
                        💡 Dica: Use Tab para navegar rapidamente entre os campos
                    </p>
                </div>
            </div>
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
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            
                            // Preenche a cidade automaticamente
                            if (data.localidade && data.uf) {
                                document.getElementById('cidade').value = data.localidade + ' - ' + data.uf;
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
</script>
@endsection
