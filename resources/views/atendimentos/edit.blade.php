@extends('layouts.tenant-app')

@section('title', 'Editar Atendimento - MultiImune')
@section('page-title', 'Editar Atendimento')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css">
<style>
/* Estilos para Select de Paciente */
.ts-wrapper.js-paciente-select .ts-control {
    border-radius: 0.75rem;
    min-height: 3rem;
    border: 2px solid #D1D5DB;
    box-shadow: none;
    padding: 0.35rem 0.75rem;
    transition: border 0.2s ease, box-shadow 0.2s ease;
}

.ts-wrapper.js-paciente-select.focus .ts-control,
.ts-wrapper.js-paciente-select.dropdown-active .ts-control {
    border-color: #10B981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
}

.ts-wrapper.js-paciente-select .ts-control input {
    font-size: 0.95rem;
}

.ts-dropdown.js-paciente-select {
    border-radius: 0.75rem;
    border: 2px solid rgba(16, 185, 129, 0.15);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
    padding: 0.5rem 0;
}

.ts-dropdown.js-paciente-select .option {
    display: flex;
    flex-direction: column;
    padding: 0.5rem 1rem;
    gap: 0.25rem;
    border-left: 3px solid transparent;
}

.ts-dropdown.js-paciente-select .option.active,
.ts-dropdown.js-paciente-select .option:hover {
    background-color: rgba(16, 185, 129, 0.08);
    border-left-color: #10B981;
}

.ts-dropdown.js-paciente-select .option .option-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.95rem;
}

.ts-dropdown.js-paciente-select .option .option-meta {
    font-size: 0.8rem;
    color: #6B7280;
}

.ts-wrapper.js-paciente-select .ts-item-content {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
}

.ts-wrapper.js-paciente-select .ts-item-content .option-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
}

.ts-wrapper.js-paciente-select .ts-item-content .option-meta {
    font-size: 0.75rem;
    color: #6B7280;
}

/* Estilos para Select de Cidade */
.ts-wrapper.js-cidade-select .ts-control {
    border-radius: 0.75rem;
    min-height: 3rem;
    border: 2px solid #D1D5DB;
    box-shadow: none;
    padding: 0.35rem 0.75rem;
    transition: border 0.2s ease, box-shadow 0.2s ease;
}

.ts-wrapper.js-cidade-select.focus .ts-control,
.ts-wrapper.js-cidade-select.dropdown-active .ts-control {
    border-color: #10B981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
}

.ts-dropdown.js-cidade-select {
    border-radius: 0.75rem;
    border: 2px solid rgba(16, 185, 129, 0.15);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
}

/* Estilos para Selects de Vacina e Tabela de Preço */
.ts-wrapper.js-vacina-select .ts-control,
.ts-wrapper.js-tabela-select .ts-control {
    border-radius: 0.75rem;
    min-height: 2.5rem;
    border: 2px solid #D1D5DB;
    box-shadow: none;
    padding: 0.35rem 0.75rem;
    transition: border 0.2s ease, box-shadow 0.2s ease;
    font-size: 0.875rem;
}

.ts-wrapper.js-vacina-select.focus .ts-control,
.ts-wrapper.js-vacina-select.dropdown-active .ts-control {
    border-color: #A855F7;
    box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.15);
}

.ts-wrapper.js-tabela-select.focus .ts-control,
.ts-wrapper.js-tabela-select.dropdown-active .ts-control {
    border-color: #A855F7;
    box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.15);
}

.ts-dropdown.js-vacina-select,
.ts-dropdown.js-tabela-select {
    border-radius: 0.75rem;
    border: 2px solid rgba(168, 85, 247, 0.15);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
    font-size: 0.875rem;
}

/* Estilos modernos para inputs de texto, número e textarea */
input[type="text"],
input[type="number"],
input[type="date"],
textarea {
    transition: all 0.2s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
textarea:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

input[type="text"].rounded-xl,
input[type="number"].rounded-xl,
input[type="date"].rounded-xl,
textarea.rounded-xl {
    border-width: 2px;
}

/* Input readonly/disabled */
input[readonly],
input[disabled] {
    cursor: not-allowed;
    opacity: 0.7;
}

/* Labels com animação */
label {
    transition: color 0.2s ease;
}

label:hover {
    color: #059669;
}
</style>
@endpush

@section('content')
<!-- Header -->
<div class="mb-6 sm:mb-8">
    <nav class="flex items-center gap-2 text-xs sm:text-sm mb-3 sm:mb-4 overflow-x-auto pb-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition whitespace-nowrap">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>
        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('atendimentos.index') }}" class="flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition whitespace-nowrap">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Atendimentos
        </a>
        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="flex items-center gap-1 text-emerald-600 font-semibold whitespace-nowrap">
            Editar Atendimento
        </span>
    </nav>

    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-xl sm:rounded-2xl shadow-2xl p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 sm:gap-6">
            <div class="flex items-start gap-3 sm:gap-4 w-full lg:w-auto">
                <div class="bg-white/20 backdrop-blur-sm p-2.5 sm:p-3 lg:p-4 rounded-xl sm:rounded-2xl shadow-lg ring-2 ring-white/30 flex-shrink-0">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white mb-1 sm:mb-2 drop-shadow-lg break-words">
                        Editar Atendimento #{{ $atendimento->id }}
                    </h1>
                    <p class="text-emerald-50 text-sm sm:text-base lg:text-lg mt-1">Atualize as informações registradas para este atendimento.</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full lg:w-auto">
                <a href="{{ route('atendimentos.show', $atendimento) }}" class="flex items-center justify-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 transform hover:scale-105 ring-2 ring-white/30 text-sm sm:text-base">
                    ← Visualizar
                </a>
                <a href="{{ route('atendimentos.index') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-emerald-600 font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 text-sm sm:text-base">
                    Voltar à lista
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <div class="lg:col-span-2 space-y-4 sm:space-y-6">
        <form action="{{ route('atendimentos.update', $atendimento) }}" method="POST" id="formAtendimento">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Dados Básicos do Atendimento
                    </h2>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="data" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Data do Atendimento *
                            </label>
                            <div class="relative">
                                <input type="date" name="data" id="data" required value="{{ old('data', optional($atendimento->data)->format('Y-m-d')) }}" class="w-full rounded-xl border-2 border-gray-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 shadow-sm transition-all duration-200 pl-4 pr-4 py-2.5">
                            </div>
                            @error('data')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="paciente_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Paciente *
                            </label>
                            <select name="paciente_id" id="paciente_id" required data-placeholder="Digite para buscar um paciente..." class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm js-paciente-select">
                                <option value="">Selecione um paciente</option>
                                @foreach($pacientes as $paciente)
                                    @php
                                        $cpf = $paciente->cpf ? 'CPF: ' . $paciente->cpf : 'CPF não informado';
                                        $telefone = $paciente->telefone ? 'Telefone: ' . $paciente->telefone : null;
                                        $metaInfo = $telefone ? $cpf . ' · ' . $telefone : $cpf;
                                        $selected = old('paciente_id', $atendimento->paciente_id) == $paciente->id;
                                    @endphp
                                    <option value="{{ $paciente->id }}" data-document="{{ $cpf }}" data-meta="{{ $metaInfo }}" {{ $selected ? 'selected' : '' }}>{{ $paciente->nome }}</option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        Local do Atendimento
                    </h2>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="mb-4 sm:mb-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2 sm:mb-3">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tipo de Atendimento *
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @php $tipoSelecionado = old('tipo', $atendimento->tipo); @endphp
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tipo" value="clinica" {{ $tipoSelecionado === 'clinica' ? 'checked' : '' }} onchange="toggleDomiciliar()" class="peer sr-only">
                                <div class="p-3 sm:p-4 lg:p-5 border-2 border-gray-200 rounded-lg sm:rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <div class="bg-blue-100 peer-checked:bg-blue-500 p-1.5 sm:p-2 rounded-lg transition flex-shrink-0">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-800 text-sm sm:text-base">Clínica</p>
                                            <p class="text-xs text-gray-600">Artur Nogueira</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tipo" value="domiciliar" {{ $tipoSelecionado === 'domiciliar' ? 'checked' : '' }} onchange="toggleDomiciliar()" class="peer sr-only">
                                <div class="p-3 sm:p-4 lg:p-5 border-2 border-gray-200 rounded-lg sm:rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <div class="bg-green-100 peer-checked:bg-green-500 p-1.5 sm:p-2 rounded-lg transition flex-shrink-0">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-800 text-sm sm:text-base">Domiciliar</p>
                                            <p class="text-xs text-gray-600">Casa do paciente</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="camposDomiciliar" class="{{ $tipoSelecionado === 'domiciliar' ? '' : 'hidden' }}">
                        <div class="bg-green-50 border border-green-200 rounded-lg sm:rounded-xl p-4 sm:p-5 lg:p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="cidade_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        Cidade
                                    </label>
                                    <select name="cidade_id" id="cidade_id" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm js-cidade-select" {{ $tipoSelecionado === 'domiciliar' ? 'required' : '' }}>
                                        <option value="">Selecione uma cidade</option>
                                        @foreach($cidades as $cidade)
                                            <option value="{{ $cidade->id }}" {{ old('cidade_id', $atendimento->cidade_id) == $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }} - {{ $cidade->uf }}</option>
                                        @endforeach
                                    </select>
                                    @error('cidade_id')
                                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">
                                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        Endereço do Atendimento
                                    </label>
                                    
                                    <!-- Grid de Campos de Endereço -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Campo CEP -->
                                        <div class="space-y-3">
                                            <label for="cep" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                                </svg>
                                                CEP
                                            </label>
                                            <div class="relative">
                                                <input type="text" name="cep" id="cep"
                                                       value="{{ old('cep', '') }}"
                                                       maxlength="9"
                                                       placeholder="🔖 00000-000"
                                                       class="w-full rounded-xl border-2 border-blue-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                                <div id="cep-loading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent"></div>
                                                </div>
                                            </div>
                                            <p class="text-xs text-blue-600 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                Preenchimento automático do endereço
                                            </p>
                                        </div>

                                        <!-- Campo Logradouro -->
                                        <div class="space-y-3">
                                            <label for="logradouro" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                                Rua/Avenida
                                            </label>
                                            <input type="text" name="logradouro" id="logradouro"
                                                   value="{{ old('logradouro', '') }}"
                                                   placeholder="🛣️ Nome da rua, avenida, etc..."
                                                   class="w-full rounded-xl border-2 border-teal-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                        </div>

                                        <!-- Campo Número -->
                                        <div class="space-y-3">
                                            <label for="numero" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                Número
                                            </label>
                                            <input type="text" name="numero" id="numero"
                                                   value="{{ old('numero', '') }}"
                                                   placeholder="🔢 123, 456-A, S/N..."
                                                   class="w-full rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                        </div>

                                        <!-- Campo Bairro -->
                                        <div class="space-y-3">
                                            <label for="bairro" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                Bairro
                                            </label>
                                            <input type="text" name="bairro" id="bairro"
                                                   value="{{ old('bairro', '') }}"
                                                   placeholder="🏘️ Nome do bairro..."
                                                   class="w-full rounded-xl border-2 border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                        </div>

                                        <!-- Campo Complemento -->
                                        <div class="space-y-3 md:col-span-2">
                                            <label for="complemento" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Complemento
                                            </label>
                                            <input type="text" name="complemento" id="complemento"
                                                   value="{{ old('complemento', '') }}"
                                                   placeholder="🏢 Apt, bloco, casa, etc..."
                                                   class="w-full rounded-xl border-2 border-orange-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                        </div>
                                    </div>

                                    <!-- Informações adicionais -->
                                    <div class="mt-4 bg-white/60 backdrop-blur-sm border border-emerald-200 rounded-lg p-4">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-800">Informações Importantes</h4>
                                                <ul class="text-xs text-gray-600 mt-2 space-y-1">
                                                    <li>• <strong>CEP:</strong> Preenchimento automático dos campos de endereço</li>
                                                    <li>• <strong>Cidade:</strong> Usada para cálculo de taxa de deslocamento</li>
                                                    <li>• <strong>Endereço Completo:</strong> Facilita localização e entrega</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4 sm:p-5 lg:p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Vacinas Aplicadas
                        </h2>
                        <button type="button" onclick="adicionarVacina()" class="w-full sm:w-auto bg-white hover:bg-gray-100 text-purple-600 font-semibold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Adicionar Vacina
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <div id="vacinasContainer" class="space-y-3 sm:space-y-4"></div>
                    @error('vacinas')
                        <p class="text-red-500 text-sm mt-4 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Observações
                    </h2>
                </div>
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <textarea name="observacoes" id="observacoes" rows="4" placeholder="Registre observações ou informações adicionais sobre este atendimento..." class="w-full rounded-xl border-2 border-gray-300 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 shadow-sm pl-10 pr-4 py-3 transition-all duration-200 resize-none">{{ old('observacoes', $atendimento->observacoes) }}</textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            <span id="charCount">{{ strlen(old('observacoes', $atendimento->observacoes)) }}</span> caracteres
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    💾 Salvar alterações
                </button>
                <a href="{{ route('atendimentos.show', $atendimento) }}" class="inline-flex items-center justify-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Dicas rápidas
            </h4>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start gap-2"><span class="text-purple-600">•</span><span>Revise os dados antes de salvar para manter o histórico consistente.</span></li>
                <li class="flex items-start gap-2"><span class="text-purple-600">•</span><span>Você pode ajustar valores unitários conforme necessário.</span></li>
                <li class="flex items-start gap-2"><span class="text-purple-600">•</span><span>Eventos domiciliares devem ter cidade e endereço informados.</span></li>
            </ul>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 shadow-lg border border-emerald-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold text-gray-800">Resumo financeiro</h4>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 uppercase tracking-wide">
                    Valor total
                </span>
            </div>
            <div class="text-3xl font-extrabold text-emerald-600" id="valorTotal">
                R$ {{ number_format(old('valor_total', $atendimento->valor_total), 2, ',', '.') }}
            </div>
            <p class="text-sm text-gray-600 mt-2">Atualizado automaticamente conforme os ajustes de vacinas.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
@php
    $vacinasExistentesFormatadas = $atendimento->vacinas->map(function ($vacina) {
        return [
            'vacina_id' => $vacina->id,
            'quantidade' => $vacina->pivot->quantidade,
            'valor_unitario' => number_format($vacina->pivot->valor_unitario, 2, '.', ''),
            'lote' => $vacina->pivot->lote,
            'tabela_preco' => null,
            'tipo_preco' => null,
        ];
    })->values();
@endphp
<script>
function setupPacienteSelect() {
    const select = document.getElementById('paciente_id');

    if (!select || typeof TomSelect === 'undefined') {
        return;
    }

    if (select.tomselect) {
        return;
    }

    const placeholder = select.dataset.placeholder || 'Digite para buscar um paciente...';

    new TomSelect(select, {
        create: false,
        allowEmptyOption: true,
        placeholder,
        maxOptions: 1000,
        searchField: ['text', 'document', 'meta'],
        plugins: ['clear_button'],
        dropdownParent: 'body',
        closeAfterSelect: true,
        render: {
            option: (data, escape) => {
                const documentInfo = data.document ?? data.dataset?.document ?? '';
                const metaInfo = data.meta ?? data.dataset?.meta ?? documentInfo;

                return `<div class="option-content">
                    <span class="option-title">${escape(data.text)}</span>
                    <span class="option-meta">${escape(metaInfo || documentInfo)}</span>
                </div>`;
            },
            item: (data, escape) => {
                const metaInfo = data.meta ?? data.dataset?.meta ?? '';
                const displayMeta = metaInfo ? `<span class="option-meta">${escape(metaInfo)}</span>` : '';

                return `<div class="ts-item-content">
                    <span class="option-title">${escape(data.text)}</span>
                    ${displayMeta}
                </div>`;
            },
        },
        onInitialize: function() {
            const control = this.control_input?.closest('.ts-control');
            if (control) {
                control.setAttribute('aria-label', placeholder);
            }
        }
    });
}

function setupCidadeSelect() {
    const select = document.getElementById('cidade_id');

    if (!select || typeof TomSelect === 'undefined') {
        return;
    }

    if (select.tomselect) {
        return;
    }

    new TomSelect(select, {
        create: false,
        allowEmptyOption: true,
        placeholder: 'Digite para buscar uma cidade...',
        plugins: ['clear_button'],
        dropdownParent: 'body',
        closeAfterSelect: true,
    });
}

let vacinaSelectInstances = {};
let tabelaSelectInstances = {};

function setupVacinaSelect(index) {
    const select = document.querySelector(`.vacina-item[data-index="${index}"] .vacina-select`);
    
    if (!select || typeof TomSelect === 'undefined') {
        return;
    }

    if (select.tomselect) {
        select.tomselect.destroy();
    }

    const instance = new TomSelect(select, {
        create: false,
        allowEmptyOption: true,
        placeholder: 'Selecione uma vacina...',
        dropdownParent: 'body',
        closeAfterSelect: true,
        onChange: function(value) {
            handleVacinaChange(index);
        }
    });

    vacinaSelectInstances[index] = instance;
}

function setupTabelaSelect(index) {
    const select = document.querySelector(`.vacina-item[data-index="${index}"] .tabela-preco-select`);
    
    if (!select || typeof TomSelect === 'undefined') {
        return;
    }

    if (select.tomselect) {
        select.tomselect.destroy();
    }

    const instance = new TomSelect(select, {
        create: false,
        allowEmptyOption: true,
        placeholder: 'Selecione a tabela...',
        dropdownParent: 'body',
        closeAfterSelect: true,
        onChange: function(value) {
            aplicarTabelaPreco(index);
        }
    });

    tabelaSelectInstances[index] = instance;
}
</script>
<script>
let vacinaIndex = 0;
const vacinasDisponiveis = <?php echo $vacinas->toJson(); ?>;
const vacinasMap = {};

vacinasDisponiveis.forEach((vacina) => {
    vacinasMap[String(vacina.id)] = vacina;
});

const tabelaPrecoLabels = {
    preco_promocional: 'Preço Promocional',
    preco_venda_pix: 'PIX / Dinheiro',
    preco_venda_cartao: 'Cartão',
    preco_custo: 'Preço de Custo',
};

const tabelaPrecoOrdenacao = ['preco_promocional', 'preco_venda_pix', 'preco_venda_cartao', 'preco_custo'];

const vacinasAntigasRaw = <?php echo json_encode(old('vacinas', [])); ?>;
const vacinasAntigas = Array.isArray(vacinasAntigasRaw)
    ? vacinasAntigasRaw
    : Object.keys(vacinasAntigasRaw || {}).map((key) => vacinasAntigasRaw[key]).filter(Boolean);

const vacinasExistentes = <?php echo $vacinasExistentesFormatadas->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

const vacinasIniciais = vacinasAntigas.length ? vacinasAntigas : (vacinasExistentes || []);

const currencyFormatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
});

document.addEventListener('DOMContentLoaded', () => {
    setupPacienteSelect();
    setupCidadeSelect();
    setupCepSearch();
    toggleDomiciliar();

    if (vacinasIniciais.length) {
        vacinasIniciais.forEach((vacinaData) => adicionarVacina(vacinaData));
    } else {
        adicionarVacina();
    }

    // Contador de caracteres no textarea
    const observacoesTextarea = document.getElementById('observacoes');
    const charCount = document.getElementById('charCount');
    
    if (observacoesTextarea && charCount) {
        observacoesTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
});

// Função para buscar CEP
function setupCepSearch() {
    const cepInput = document.getElementById('cep');
    if (!cepInput) return;

    // Formatação automática do CEP
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length >= 5) {
            value = value.substring(0, 8);
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        }
        
        e.target.value = value;
        
        // Buscar endereço se CEP estiver completo
        if (value.length === 9) {
            buscarEnderecoPorCep(value.replace(/\D/g, ''));
        }
    });
}

async function buscarEnderecoPorCep(cep) {
    if (cep.length !== 8) return;

    const loadingIcon = document.getElementById('cep-loading');
    const logradouroInput = document.getElementById('logradouro');
    const bairroInput = document.getElementById('bairro');
    
    // Mostrar loading
    loadingIcon?.classList.remove('hidden');
    
    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
        
        if (!data.erro) {
            // Preencher campos automaticamente
            if (logradouroInput && data.logradouro) {
                logradouroInput.value = data.logradouro;
                logradouroInput.classList.add('bg-green-50', 'border-green-400');
                setTimeout(() => {
                    logradouroInput.classList.remove('bg-green-50', 'border-green-400');
                }, 2000);
            }
            
            if (bairroInput && data.bairro) {
                bairroInput.value = data.bairro;
                bairroInput.classList.add('bg-green-50', 'border-green-400');
                setTimeout(() => {
                    bairroInput.classList.remove('bg-green-50', 'border-green-400');
                }, 2000);
            }
            
            // Focar no campo número
            const numeroInput = document.getElementById('numero');
            if (numeroInput) {
                numeroInput.focus();
            }
            
            // Mostrar notificação de sucesso (se tiver função showNotification)
            if (typeof showNotification === 'function') {
                showNotification('✅ Endereço encontrado! Verifique os dados preenchidos.', 'success');
            }
        } else {
            if (typeof showNotification === 'function') {
                showNotification('❌ CEP não encontrado. Verifique o número informado.', 'error');
            }
        }
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        if (typeof showNotification === 'function') {
            showNotification('⚠️ Erro ao buscar CEP. Verifique sua conexão.', 'error');
        }
    } finally {
        // Ocultar loading
        loadingIcon?.classList.add('hidden');
    }
}

function toNumber(value) {
    if (value === null || value === undefined || value === '') {
        return null;
    }

    if (typeof value === 'number') {
        return Number.isFinite(value) ? value : null;
    }

    const strValue = String(value).trim();
    if (!strValue.length) {
        return null;
    }

    const hasComma = strValue.includes(',');
    const hasDot = strValue.includes('.');

    let normalized = strValue.replace(/\s/g, '');

    if (hasComma && hasDot) {
        normalized = normalized.replace(/\./g, '').replace(',', '.');
    } else if (hasComma) {
        normalized = normalized.replace(',', '.');
    }

    const parsed = Number(normalized);
    return Number.isFinite(parsed) ? parsed : null;
}

function formatCurrency(value) {
    const numberValue = toNumber(value);
    return currencyFormatter.format(numberValue !== null ? numberValue : 0);
}

function buildVacinaOptionLabel(vacina) {
    const prices = getPriceOptionsForVacina(vacina)
        .map((option) => `${option.label}: ${formatCurrency(option.value)}`);

    return prices.length
        ? `${vacina.nome} — ${prices.join(' • ')}`
        : vacina.nome;
}

function createVacinaOptionsHtml(selectedId = '') {
    const options = ['<option value="">Selecione...</option>'];

    vacinasDisponiveis.forEach((vacina) => {
        const selected = String(selectedId) === String(vacina.id) ? 'selected' : '';
        options.push(`<option value="${vacina.id}" ${selected}>${buildVacinaOptionLabel(vacina)}</option>`);
    });

    return options.join('');
}

function toggleDomiciliar() {
    const tipoSelecionado = document.querySelector('input[name="tipo"]:checked');
    if (!tipoSelecionado) {
        return;
    }

    const tipo = tipoSelecionado.value;
    const camposDomiciliar = document.getElementById('camposDomiciliar');
    const cidadeSelect = document.getElementById('cidade_id');
    
    if (tipo === 'domiciliar') {
        camposDomiciliar.classList.remove('hidden');
        cidadeSelect.setAttribute('required', 'required');
    } else {
        camposDomiciliar.classList.add('hidden');
        cidadeSelect.removeAttribute('required');

        // Limpar todos os campos de endereço
        if (cidadeSelect) {
            cidadeSelect.value = '';
        }

        const cepInput = document.getElementById('cep');
        if (cepInput) cepInput.value = '';

        const logradouroInput = document.getElementById('logradouro');
        if (logradouroInput) logradouroInput.value = '';

        const numeroInput = document.getElementById('numero');
        if (numeroInput) numeroInput.value = '';

        const bairroInput = document.getElementById('bairro');
        if (bairroInput) bairroInput.value = '';

        const complementoInput = document.getElementById('complemento');
        if (complementoInput) complementoInput.value = '';
    }
}

function adicionarVacina(vacinaData = null) {
    const container = document.getElementById('vacinasContainer');
    const index = vacinaIndex++;

    const selectedVacinaId = vacinaData?.vacina_id ?? '';
    const quantidade = vacinaData?.quantidade ?? 1;
    const lote = vacinaData?.lote ?? '';
    const valorUnitario = vacinaData?.valor_unitario ?? '';
    const tabelaPrecoInicial = vacinaData?.tabela_preco ?? vacinaData?.tipo_preco ?? '';

    const vacinaHtml = `
        <div class="vacina-item relative p-6 border-2 border-gray-200 rounded-2xl bg-gradient-to-br from-white to-purple-50/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:border-purple-300 group" data-index="${index}">
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="bg-purple-100 text-purple-600 text-xs font-bold px-2 py-1 rounded-lg">
                    #${index + 1}
                </div>
            </div>
            <div class="flex flex-col gap-6">
                <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                    <div class="lg:flex-1">
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Vacina *
                        </label>
                        <select name="vacinas[${index}][vacina_id]" required data-field="vacina"
                                class="w-full rounded-xl border-gray-300 text-sm vacina-select js-vacina-select focus:border-purple-500 focus:ring-purple-500"
                                onchange="handleVacinaChange(${index})">
                            ${createVacinaOptionsHtml(selectedVacinaId)}
                        </select>
                    </div>
                    <div class="lg:w-72">
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Tabela de Preço *
                        </label>
                        <select name="vacinas[${index}][tabela_preco]" data-field="tabela" class="w-full rounded-xl border-gray-300 text-sm tabela-preco-select js-tabela-select focus:border-purple-500 focus:ring-purple-500" onchange="aplicarTabelaPreco(${index})">
                            <option value="">Selecione a tabela...</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Quantidade *
                        </label>
                        <div class="relative">
                            <input type="number" min="1" name="vacinas[${index}][quantidade]" value="${quantidade}" data-field="quantidade"
                                   class="quantidade-input w-full rounded-xl border-2 border-gray-300 text-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 pl-4 pr-4 py-2.5 font-semibold text-gray-900"
                                   onchange="calcularTotal()" onkeyup="calcularTotal()">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Valor Unitário *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold text-sm">R$</span>
                            </div>
                            <input type="text" name="vacinas[${index}][valor_unitario]" value="${valorUnitario}" data-field="valor"
                                   class="valor-input w-full rounded-xl border-2 border-gray-300 text-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 pl-10 pr-4 py-2.5 font-semibold text-gray-900"
                                   onblur="formatarValorMascara(this); calcularTotal()" onkeyup="mascararValor(this)">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Lote
                        </label>
                        <div class="relative">
                            <input type="text" name="vacinas[${index}][lote]" value="${lote}" data-field="lote"
                                   class="w-full rounded-xl border-2 border-gray-300 text-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-200 pl-4 pr-4 py-2.5 uppercase tracking-wider"
                                   placeholder="Ex: L123456">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 border-2 border-red-200 hover:border-red-300 transition-all duration-200 transform hover:scale-105" onclick="removerVacina(${index})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Remover
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

    const template = document.createElement('template');
    template.innerHTML = vacinaHtml.trim();
    const vacinaElement = template.content.firstChild;

    if (vacinaData && tabelaPrecoInicial) {
        vacinaElement.dataset.initialTabela = tabelaPrecoInicial;
    }

    if (vacinaData && valorUnitario) {
        vacinaElement.dataset.initialValor = valorUnitario;
    }

    container.appendChild(vacinaElement);
    
    // Inicializar Tom Select nos novos selects
    setTimeout(() => {
        setupVacinaSelect(index);
        setupTabelaSelect(index);
    }, 50);
    
    handleVacinaChange(index, vacinaData);
}

function removerVacina(index) {
    const item = document.querySelector(`.vacina-item[data-index="${index}"]`);
    if (!item) {
        return;
    }

    // Destruir instâncias do Tom Select
    if (vacinaSelectInstances[index]) {
        vacinaSelectInstances[index].destroy();
        delete vacinaSelectInstances[index];
    }
    
    if (tabelaSelectInstances[index]) {
        tabelaSelectInstances[index].destroy();
        delete tabelaSelectInstances[index];
    }

    item.remove();
    calcularTotal();
}

function getVacinaById(id) {
    return vacinasMap[String(id)] || null;
}

function formatDecimalInput(value) {
    const numeric = toNumber(value);
    return numeric !== null ? numeric.toFixed(2) : '';
}

function mascararValor(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (!value.length) {
        input.value = '';
        return;
    }

    while (value.length < 3) {
        value = '0' + value;
    }

    const inteiro = value.slice(0, -2);
    const decimal = value.slice(-2);
    input.value = `${parseInt(inteiro, 10).toLocaleString('pt-BR')},${decimal}`;
}

function formatarValorMascara(input) {
    const numero = toNumber(input.value);
    if (numero !== null) {
        input.value = numero.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
}

function handleVacinaChange(index, payload = null) {
    const item = document.querySelector(`.vacina-item[data-index="${index}"]`);
    if (!item) {
        return;
    }

    const select = item.querySelector('.vacina-select');
    const priceSelect = item.querySelector('.tabela-preco-select');
    const valorInput = item.querySelector('.valor-input');

    if (!select || !priceSelect || !valorInput) {
        return;
    }

    // Obter instância do Tom Select da tabela de preços
    const tabelaSelectInstance = tabelaSelectInstances[index];
    
    // Limpar opções da tabela de preços
    if (tabelaSelectInstance) {
        tabelaSelectInstance.clearOptions();
        tabelaSelectInstance.addOption({ value: '', text: 'Selecione a tabela...' });
    } else {
        priceSelect.innerHTML = '<option value="">Selecione a tabela...</option>';
    }

    const vacinaSelecionada = getVacinaById(select.value);

    if (!vacinaSelecionada) {
        valorInput.readOnly = false;
        valorInput.classList.remove('bg-gray-100');

        const valorInicial = payload?.valor_unitario ?? item.dataset.initialValor ?? '';
        valorInput.value = valorInicial ? formatDecimalInput(valorInicial) : '';
        calcularTotal();
        return;
    }

    const opcoesPreco = getPriceOptionsForVacina(vacinaSelecionada);

    // Adicionar opções à tabela de preços
    opcoesPreco.forEach((option) => {
        const optionData = {
            value: option.key,
            text: `${option.label} — ${formatCurrency(option.value)}`,
        };
        
        if (tabelaSelectInstance) {
            tabelaSelectInstance.addOption(optionData);
        } else {
            const optionElement = document.createElement('option');
            optionElement.value = option.key;
            optionElement.dataset.amount = option.value;
            optionElement.textContent = optionData.text;
            priceSelect.appendChild(optionElement);
        }
    });

    // Adicionar opção "Personalizado"
    const customOption = {
        value: 'personalizado',
        text: 'Personalizado'
    };
    
    if (tabelaSelectInstance) {
        tabelaSelectInstance.addOption(customOption);
    } else {
        const customOptionElement = document.createElement('option');
        customOptionElement.value = 'personalizado';
        customOptionElement.textContent = 'Personalizado';
        priceSelect.appendChild(customOptionElement);
    }

    let tabelaSelecionada = payload?.tabela_preco ?? item.dataset.initialTabela ?? '';

    if (!tabelaSelecionada && payload?.valor_unitario) {
        const valorAntigo = toNumber(payload.valor_unitario);
        const matched = opcoesPreco.find((option) => Math.abs(option.value - valorAntigo) < 0.005);
        if (matched) {
            tabelaSelecionada = matched.key;
        }
    }

    if (tabelaSelecionada && tabelaSelecionada !== 'personalizado' && !opcoesPreco.some((option) => option.key === tabelaSelecionada)) {
        tabelaSelecionada = '';
    }

    if (!tabelaSelecionada) {
        const preferida = tabelaPrecoOrdenacao.find((key) => opcoesPreco.some((option) => option.key === key));
        tabelaSelecionada = preferida || (opcoesPreco.length ? opcoesPreco[0].key : 'personalizado');
    }

    // Definir valor selecionado
    if (tabelaSelectInstance) {
        tabelaSelectInstance.setValue(tabelaSelecionada, true);
    } else {
        priceSelect.value = tabelaSelecionada;
    }

    const valorInicial = payload?.valor_unitario ?? item.dataset.initialValor ?? null;
    aplicarTabelaPreco(index, valorInicial);

    delete item.dataset.initialTabela;
    delete item.dataset.initialValor;
}

function getPriceOptionsForVacina(vacina) {
    if (!vacina) {
        return [];
    }

    return tabelaPrecoOrdenacao
        .map((key) => {
            const value = toNumber(vacina[key]);
            if (value === null) {
                return null;
            }

            return {
                key,
                label: tabelaPrecoLabels[key],
                value,
            };
        })
        .filter(Boolean);
}

function aplicarTabelaPreco(index, valorPersonalizado = null) {
    const item = document.querySelector(`.vacina-item[data-index="${index}"]`);
    if (!item) {
        return;
    }

    const select = item.querySelector('.vacina-select');
    const priceSelect = item.querySelector('.tabela-preco-select');
    const valorInput = item.querySelector('.valor-input');

    if (!select || !priceSelect || !valorInput) {
        return;
    }

    const tabelaSelecionada = priceSelect.value;
    const vacinaSelecionada = getVacinaById(select.value);

    if (tabelaSelecionada === 'personalizado') {
        valorInput.readOnly = false;
        valorInput.classList.remove('bg-gray-100');

        if (valorPersonalizado !== null && valorPersonalizado !== undefined && valorPersonalizado !== '') {
            valorInput.value = formatDecimalInput(valorPersonalizado);
        }

        calcularTotal();
        return;
    }

    if (!tabelaSelecionada || !vacinaSelecionada) {
        valorInput.readOnly = false;
        valorInput.classList.remove('bg-gray-100');

        if (valorPersonalizado !== null && valorPersonalizado !== undefined && valorPersonalizado !== '') {
            valorInput.value = formatDecimalInput(valorPersonalizado);
        }

        calcularTotal();
        return;
    }

    const valorBase = toNumber(vacinaSelecionada[tabelaSelecionada]);

    if (valorBase !== null) {
        valorInput.value = formatDecimalInput(valorBase);
        valorInput.readOnly = true;
        valorInput.classList.add('bg-gray-100');
    } else {
        valorInput.readOnly = false;
        valorInput.classList.remove('bg-gray-100');

        if (valorPersonalizado !== null && valorPersonalizado !== undefined && valorPersonalizado !== '') {
            valorInput.value = formatDecimalInput(valorPersonalizado);
        }
    }

    calcularTotal();
}

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.vacina-item').forEach(item => {
        const quantidadeInput = item.querySelector('.quantidade-input');
        const valorInput = item.querySelector('.valor-input');

        const quantidade = toNumber(quantidadeInput?.value);
        const valorUnitario = toNumber(valorInput?.value);

        if (quantidade !== null && valorUnitario !== null) {
            total += quantidade * valorUnitario;
        }
    });
    
    const valorTotalElemento = document.getElementById('valorTotal');
    if (valorTotalElemento) {
        valorTotalElemento.textContent = formatCurrency(total);
    }
}
</script>
@endpush
