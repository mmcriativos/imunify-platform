@extends('layouts.tenant-app')
@section('page-title', 'Novo Atendimento')
@section('title', 'Novo Atendimento - MultiImune')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* Melhorias no Tom Select */
.ts-wrapper.js-paciente-select .ts-control {
    border-radius: 0.75rem;
    min-height: 3.5rem;
    border: 2px solid #E5E7EB;
    box-shadow: none;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 100%);
}

.ts-wrapper.js-paciente-select.focus .ts-control,
.ts-wrapper.js-paciente-select.dropdown-active .ts-control {
    border-color: #8B5CF6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    background: #FFFFFF;
}

.ts-wrapper.js-paciente-select .ts-control input {
    font-size: 1rem;
    font-weight: 500;
    color: #374151;
}

.ts-dropdown.js-paciente-select {
    border-radius: 0.75rem;
    border: 2px solid rgba(139, 92, 246, 0.15);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    padding: 0.5rem 0;
    background: #FFFFFF;
    backdrop-filter: blur(20px);
}

.ts-dropdown.js-paciente-select .option {
    display: flex;
    flex-direction: column;
    padding: 0.75rem 1rem;
    gap: 0.25rem;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.ts-dropdown.js-paciente-select .option.active,
.ts-dropdown.js-paciente-select .option:hover {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(168, 85, 247, 0.05) 100%);
    border-left-color: #8B5CF6;
    transform: translateX(2px);
}

.ts-dropdown.js-paciente-select .option .option-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.95rem;
}

.ts-dropdown.js-paciente-select .option .option-meta {
    font-size: 0.8rem;
    color: #6B7280;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.ts-wrapper.js-paciente-select .ts-item-content {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.ts-wrapper.js-paciente-select .ts-item-content .option-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.95rem;
}

.ts-wrapper.js-paciente-select .ts-item-content .option-meta {
    font-size: 0.75rem;
    color: #6B7280;
}

/* Melhorias no Flatpickr */
.flatpickr-calendar {
    background: #FFFFFF;
    border-radius: 0.75rem;
    border: 2px solid rgba(139, 92, 246, 0.15);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.flatpickr-months {
    background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 100%);
    padding: 1rem;
}

.flatpickr-month {
    color: #FFFFFF;
}

.flatpickr-prev-month,
.flatpickr-next-month {
    fill: #FFFFFF;
    transition: all 0.2s ease;
}

.flatpickr-prev-month:hover,
.flatpickr-next-month:hover {
    fill: #E879F9;
}

.flatpickr-current-month {
    font-weight: 600;
}

.flatpickr-weekdays {
    background: #F8FAFC;
    padding: 0.5rem 0;
}

.flatpickr-weekday {
    font-weight: 600;
    color: #6B7280;
    font-size: 0.75rem;
}

.flatpickr-day {
    border-radius: 0.5rem;
    margin: 1px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.flatpickr-day:hover {
    background: #F3F4F6;
    border-color: #8B5CF6;
}

.flatpickr-day.selected {
    background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 100%);
    border-color: #8B5CF6;
    color: #FFFFFF;
    font-weight: 600;
}

.flatpickr-day.today {
    border-color: #10B981;
    color: #10B981;
    font-weight: 600;
}

.flatpickr-day.today.selected {
    background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 100%);
    border-color: #8B5CF6;
    color: #FFFFFF;
}

/* Input de data personalizado */
.date-input-container {
    position: relative;
}

.date-input-custom {
    background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 100%);
    border: 2px solid #E5E7EB;
    border-radius: 0.75rem;
    padding: 0.75rem 3rem 0.75rem 1rem;
    width: 100%;
    font-size: 1rem;
    font-weight: 500;
    color: #374151;
    transition: all 0.3s ease;
    cursor: pointer;
}

.date-input-custom:focus {
    outline: none;
    border-color: #8B5CF6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    background: #FFFFFF;
}

.date-input-icon {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #8B5CF6;
    pointer-events: none;
}

/* Tom Select para cidade */
.ts-wrapper.js-cidade-select .ts-control {
    border-radius: 0.75rem;
    min-height: 3.5rem;
    border: 2px solid #D1FAE5;
    box-shadow: none;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #ECFDF5 0%, #FFFFFF 100%);
}

.ts-wrapper.js-cidade-select.focus .ts-control,
.ts-wrapper.js-cidade-select.dropdown-active .ts-control {
    border-color: #10B981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    background: #FFFFFF;
}

.ts-wrapper.js-cidade-select .ts-control input {
    font-size: 1rem;
    font-weight: 500;
    color: #374151;
}

.ts-dropdown.js-cidade-select {
    border-radius: 0.75rem;
    border: 2px solid rgba(16, 185, 129, 0.15);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    padding: 0.5rem 0;
    background: #FFFFFF;
    backdrop-filter: blur(20px);
}

.ts-dropdown.js-cidade-select .option {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    gap: 0.75rem;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.ts-dropdown.js-cidade-select .option.active,
.ts-dropdown.js-cidade-select .option:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.05) 100%);
    border-left-color: #10B981;
    transform: translateX(2px);
}

.ts-wrapper.js-cidade-select .ts-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
</style>
@endpush

@section('content')
<!-- Header Premium com Gradiente -->
<div class="mb-6 sm:mb-8">
    <!-- Breadcrumb -->
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
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Novo Atendimento
        </span>
    </nav>

    <!-- Header Principal -->
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
                        Novo Atendimento
                    </h1>
                    <p class="text-emerald-50 text-sm sm:text-base lg:text-lg flex items-center gap-2 hidden sm:flex">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Registre um novo atendimento de vacinação no sistema
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-2 sm:mt-3">
                        <span class="bg-white/20 backdrop-blur-sm px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm font-semibold flex items-center gap-1 sm:gap-1.5">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Paciente
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm font-semibold flex items-center gap-1 sm:gap-1.5">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Vacinas
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-2 sm:px-3 py-1 rounded-full text-white text-xs sm:text-sm font-semibold flex items-center gap-1 sm:gap-1.5">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Local
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full lg:w-auto">
                <a href="{{ route('atendimentos.index') }}" 
                   class="flex items-center justify-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 transform hover:scale-105 ring-2 ring-white/30 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
                <button type="button" onclick="window.location.href='{{ route('pacientes.create') }}'" 
                        class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-emerald-600 font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 transform hover:scale-105 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span class="hidden sm:inline">Novo Paciente</span>
                    <span class="sm:hidden">Novo</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Dicas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 sm:p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-blue-800 font-semibold text-sm">Dados Obrigatórios</h3>
                    <p class="text-blue-700 text-xs mt-1">Paciente, data, tipo e pelo menos uma vacina</p>
                </div>
            </div>
        </div>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-emerald-800 font-semibold text-sm">Cálculo Automático</h3>
                    <p class="text-emerald-700 text-xs mt-1">O valor total é calculado automaticamente</p>
                </div>
            </div>
        </div>
        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-purple-800 font-semibold text-sm">Múltiplas Vacinas</h3>
                    <p class="text-purple-700 text-xs mt-1">Adicione quantas vacinas forem necessárias</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <!-- Coluna do Formulário (2/3) -->
    <div class="lg:col-span-2 space-y-4 sm:space-y-6">
        
        <!-- Mensagens de Erro/Sucesso -->
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-bold text-sm mb-1">❌ Erro ao Registrar Atendimento</h3>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-bold text-sm mb-2">❌ Erros de Validação:</h3>
                        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{ route('atendimentos.store') }}" method="POST" id="formAtendimento">
            @csrf
            
            <!-- Botão submit oculto para requestSubmit() funcionar -->
            <button type="submit" id="hiddenSubmitBtn" style="display: none;" aria-hidden="true"></button>
            
            <!-- Card de Dados Básicos -->
            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Dados Básicos do Atendimento
                    </h2>
                    <p class="text-purple-100 mt-2 text-sm">Data e paciente para o registro da vacinação</p>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Data -->
                        <div>
                            <label for="data" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Data do Atendimento *
                            </label>
                            <div class="date-input-container">
                                <input type="text" id="data_visual" required
                                       value="{{ old('data', date('d/m/Y')) }}"
                                       placeholder="Selecione a data..."
                                       class="date-input-custom"
                                       readonly>
                                <input type="hidden" name="data" id="data" value="{{ old('data', date('Y-m-d')) }}">
                                <svg class="w-5 h-5 date-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
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

                        <!-- Paciente -->
                        <div>
                            <label for="paciente_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Paciente *
                            </label>
                            <select name="paciente_id" id="paciente_id" required
                                    data-placeholder="🔍 Digite o nome, CPF ou telefone do paciente..."
                                    class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm js-paciente-select">
                                <option value="">Selecione um paciente</option>
                                @foreach($pacientes as $paciente)
                                    @php
                                        $cpf = $paciente->cpf ? 'CPF: ' . $paciente->cpf : 'CPF não informado';
                                        $telefone = $paciente->telefone ? '📱 ' . $paciente->telefone : null;
                                        $cidade = $paciente->cidade ? '📍 ' . $paciente->cidade : null;
                                        $metaInfo = collect([$cpf, $telefone, $cidade])->filter()->implode(' • ');
                                    @endphp
                                    <option value="{{ $paciente->id }}"
                                            data-document="{{ $cpf }}"
                                            data-meta="{{ $metaInfo }}"
                                            {{ old('paciente_id', request('paciente_id')) == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Local do Atendimento -->
            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        Local do Atendimento
                    </h2>
                    <p class="text-emerald-100 mt-2 text-sm">Defina onde será realizada a vacinação</p>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Tipo de Atendimento -->
                    <div class="mb-4 sm:mb-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2 sm:mb-3">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tipo de Atendimento *
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tipo" value="clinica" 
                                       {{ old('tipo', 'clinica') == 'clinica' ? 'checked' : '' }}
                                       onchange="toggleDomiciliar()"
                                       class="peer sr-only">
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
                                <input type="radio" name="tipo" value="domiciliar" 
                                       {{ old('tipo') == 'domiciliar' ? 'checked' : '' }}
                                       onchange="toggleDomiciliar()"
                                       class="peer sr-only">
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

                    <!-- Campos Domiciliar -->
                    <div id="camposDomiciliar" class="hidden">
                        <div class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 border-2 border-emerald-200 rounded-xl sm:rounded-2xl p-6 sm:p-8 shadow-lg backdrop-blur-sm">
                            <!-- Cabeçalho da seção -->
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Informações do Atendimento Domiciliar</h3>
                                    <p class="text-sm text-gray-600">Dados necessários para o atendimento na casa do paciente</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Campo Cidade -->
                                <div class="space-y-3 lg:col-span-2">
                                    <label for="cidade_id" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Cidade *
                                    </label>
                                    
                                    <div class="flex gap-3 items-start">
                                        <div class="flex-1">
                                            <select name="cidade_id" id="cidade_id"
                                                    data-placeholder="🏙️ Digite o nome da cidade..."
                                                    class="w-full rounded-xl border-2 border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm js-cidade-select">
                                                <option value="">Selecione a cidade do atendimento</option>
                                                @foreach($cidades as $cidade)
                                                    <option value="{{ $cidade->id }}" {{ old('cidade_id') == $cidade->id ? 'selected' : '' }}>
                                                        {{ $cidade->nome }} - {{ $cidade->uf }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <button type="button" 
                                                id="btnAdicionarCidade"
                                                class="group relative bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 border-0 font-medium flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <span class="hidden sm:inline">Adicionar Cidade</span>
                                            
                                            <!-- Tooltip para mobile -->
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none sm:hidden">
                                                Adicionar Cidade
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </button>
                                    </div>
                                    
                                    @error('cidade_id')
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-red-700 text-sm font-medium">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

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
                                               value="{{ old('cep') }}"
                                               placeholder="📮 00000-000"
                                               maxlength="9"
                                               class="w-full rounded-xl border-2 border-blue-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                        <div id="cep-loading" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none hidden">
                                            <svg class="w-5 h-5 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </div>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs text-blue-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Preenchimento automático do endereço
                                    </p>
                                </div>

                                <!-- Campo Logradouro -->
                                <div class="space-y-3">
                                    <label for="logradouro" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                        </svg>
                                        Rua/Avenida *
                                    </label>
                                    <input type="text" name="logradouro" id="logradouro"
                                           value="{{ old('logradouro') }}"
                                           placeholder="🛣️ Nome da rua, avenida, etc..."
                                           class="w-full rounded-xl border-2 border-teal-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                </div>

                                <!-- Campo Número -->
                                <div class="space-y-3">
                                    <label for="numero" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        Número *
                                    </label>
                                    <input type="text" name="numero" id="numero"
                                           value="{{ old('numero') }}"
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
                                           value="{{ old('bairro') }}"
                                           placeholder="🏘️ Nome do bairro..."
                                           class="w-full rounded-xl border-2 border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                </div>

                                <!-- Campo Complemento -->
                                <div class="space-y-3">
                                    <label for="complemento" class="flex items-center gap-2 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Complemento
                                    </label>
                                    <input type="text" name="complemento" id="complemento"
                                           value="{{ old('complemento') }}"
                                           placeholder="🏢 Apt, bloco, casa, etc..."
                                           class="w-full rounded-xl border-2 border-orange-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm py-3 px-4 font-medium text-gray-700 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-white placeholder-gray-500">
                                </div>
                            </div>

                            <!-- Informações adicionais -->
                            <div class="mt-6 bg-white/60 backdrop-blur-sm border border-emerald-200 rounded-lg p-4">
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
                                            <li>• <strong>Campos Obrigatórios:</strong> Cidade, rua e número são essenciais</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Vacinas -->
            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-4 sm:p-5 lg:p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <div>
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-3">
                                <div class="bg-white/20 p-2 rounded-lg">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                Vacinas Aplicadas
                            </h2>
                            <p class="text-blue-100 mt-1 text-sm">Adicione todas as vacinas administradas</p>
                        </div>
                        <button type="button" onclick="adicionarVacina()" 
                                class="w-full sm:w-auto bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-3 px-6 rounded-xl transition duration-300 transform hover:scale-105 flex items-center justify-center gap-2 text-sm sm:text-base shadow-lg ring-2 ring-white/30">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Adicionar Vacina
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <div id="vacinasContainer" class="space-y-3 sm:space-y-4">
                        <!-- As vacinas serão adicionadas aqui dinamicamente -->
                    </div>
                    @error('vacinas')
                        <p class="text-red-500 text-sm mt-4 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Card de Observações -->
            <div class="bg-white shadow-xl rounded-xl sm:rounded-2xl overflow-hidden border border-gray-100 mb-4 sm:mb-6">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-4 sm:p-5 lg:p-6">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        Observações
                    </h2>
                    <p class="text-amber-100 mt-2 text-sm">Informações adicionais sobre o atendimento (opcional)</p>
                </div>

                <div class="p-8">
                    <textarea name="observacoes" id="observacoes" rows="4"
                              placeholder="Informações adicionais sobre o atendimento..."
                              class="w-full rounded-xl border-gray-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm">{{ old('observacoes') }}</textarea>
                </div>
            </div>

            <!-- Card de Total e Botões -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">Valor Total do Atendimento</span>
                        </div>
                        <span id="valorTotal" class="text-3xl font-bold text-white drop-shadow-lg">R$ 0,00</span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex flex-col sm:flex-row justify-end gap-4">
                        <a href="{{ route('atendimentos.index') }}" 
                           class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-8 rounded-xl border-2 border-gray-300 transition duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Cancelar
                        </a>
                        <button type="button"
                                id="btnSubmitAtendimento"
                                onclick="submitarFormulario()"
                                class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Registrar Atendimento
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="lg:col-span-1 space-y-6">
        <!-- Card de Ajuda -->
        <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 rounded-2xl p-6 shadow-xl border border-indigo-200">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full p-3 mr-3 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Como Funciona?</h3>
            </div>
            
            <div class="space-y-4 text-sm text-gray-700">
                <div class="flex items-start">
                    <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-xs font-bold">1</span>
                    <p><strong>Selecione o paciente</strong> que receberá a vacina</p>
                </div>
                
                <div class="flex items-start">
                    <span class="bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-xs font-bold">2</span>
                    <p><strong>Escolha o tipo:</strong> Clínica ou Domiciliar</p>
                </div>
                
                <div class="flex items-start">
                    <span class="bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-xs font-bold">3</span>
                    <p><strong>Adicione as vacinas</strong> aplicadas no atendimento</p>
                </div>
                
                <div class="flex items-start">
                    <span class="bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-xs font-bold">4</span>
                    <p><strong>Valores automáticos:</strong> Os valores são preenchidos automaticamente</p>
                </div>
            </div>
        </div>

        <!-- Card de Dicas -->
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 shadow-xl border border-emerald-200">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-full p-3 mr-3 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Dicas Importantes</h3>
            </div>
            
            <div class="space-y-3 text-sm text-gray-700">
                <div class="bg-white/50 rounded-lg p-3 border border-emerald-200">
                    <p><strong>✓ Multiplas Doses:</strong> Você pode adicionar várias vacinas no mesmo atendimento</p>
                </div>
                <div class="bg-white/50 rounded-lg p-3 border border-emerald-200">
                    <p><strong>✓ Cálculo Automático:</strong> O valor total é calculado automaticamente com base nos preços das vacinas</p>
                </div>
                <div class="bg-white/50 rounded-lg p-3 border border-emerald-200">
                    <p><strong>✓ Histórico Completo:</strong> Todas as informações são salvas na carteira do paciente</p>
                </div>
            </div>
        </div>

        <!-- Ilustração SVG -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <svg class="w-full h-auto" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Fundo -->
                <circle cx="100" cy="100" r="90" fill="#EFF6FF"/>
                
                <!-- Seringa -->
                <g transform="translate(60, 60)">
                    <!-- Corpo da seringa -->
                    <rect x="20" y="30" width="40" height="60" rx="5" fill="#3B82F6" opacity="0.3"/>
                    <rect x="25" y="35" width="30" height="50" rx="3" fill="#60A5FA"/>
                    
                    <!-- Êmbolo -->
                    <rect x="35" y="20" width="10" height="20" rx="2" fill="#1E40AF"/>
                    <circle cx="40" cy="18" r="5" fill="#1E40AF"/>
                    
                    <!-- Agulha -->
                    <rect x="37" y="85" width="6" height="30" fill="#9CA3AF"/>
                    <polygon points="37,115 43,115 40,125" fill="#6B7280"/>
                    
                    <!-- Gotas -->
                    <circle cx="40" cy="130" r="2" fill="#60A5FA" opacity="0.6"/>
                    <circle cx="35" cy="135" r="1.5" fill="#60A5FA" opacity="0.4"/>
                    <circle cx="45" cy="133" r="1.5" fill="#60A5FA" opacity="0.4"/>
                </g>
                
                <!-- Ícone de Check -->
                <circle cx="150" cy="150" r="20" fill="#10B981"/>
                <path d="M 142 150 L 148 156 L 158 144" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
            </svg>
            
            <p class="text-center text-sm text-gray-600 mt-4">
                Sistema de registro rápido e eficiente
            </p>
        </div>

        <!-- Dicas Rápidas -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 shadow-lg border border-purple-100">
            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Dicas Importantes
            </h4>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="text-purple-600 mr-2">•</span>
                    <span>Você pode adicionar múltiplas vacinas por atendimento</span>
                </li>
                <li class="flex items-start">
                    <span class="text-purple-600 mr-2">•</span>
                    <span>Registre o lote para rastreabilidade</span>
                </li>
                <li class="flex items-start">
                    <span class="text-purple-600 mr-2">•</span>
                    <span>Para atendimento domiciliar, informe a cidade e endereço</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
<script>
// Configurar datepicker
document.addEventListener('DOMContentLoaded', function() {
    const dataVisual = document.getElementById('data_visual');
    const dataHidden = document.getElementById('data');
    
    if (dataVisual && dataHidden) {
        flatpickr(dataVisual, {
            locale: 'pt',
            dateFormat: 'd/m/Y',
            defaultDate: new Date(),
            minDate: new Date(new Date().setDate(new Date().getDate() - 30)),
            maxDate: new Date(new Date().setDate(new Date().getDate() + 365)),
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    dataHidden.value = `${year}-${month}-${day}`;
                }
            },
            onReady: function(selectedDates, dateStr, instance) {
                // Configurar valor inicial
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    dataHidden.value = `${year}-${month}-${day}`;
                }
            }
        });
    }
});

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
                    ${metaInfo ? `<span class="option-meta">${escape(metaInfo)}</span>` : ''}
                </div>`;
            },
            item: (data, escape) => {
                const metaInfo = data.meta ?? data.dataset?.meta ?? '';
                const displayMeta = metaInfo ? `<span class="option-meta">${escape(metaInfo.split('•')[0].trim())}</span>` : '';

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

    const placeholder = select.dataset.placeholder || 'Digite o nome da cidade...';

    new TomSelect(select, {
        create: false,
        allowEmptyOption: true,
        placeholder,
        maxOptions: 1000,
        searchField: ['text'],
        plugins: ['clear_button'],
        dropdownParent: 'body',
        closeAfterSelect: true,
        render: {
            option: (data, escape) => {
                return `<div class="flex items-center gap-2">
                    <span class="text-emerald-600">🏙️</span>
                    <span class="font-medium">${escape(data.text)}</span>
                </div>`;
            },
            item: (data, escape) => {
                return `<div class="flex items-center gap-2">
                    <span class="text-emerald-600">🏙️</span>
                    <span class="font-medium">${escape(data.text)}</span>
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
</script>
<script>
let vacinaIndex = 0;
const vacinasDisponiveis = @json($vacinas);
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

const vacinasAntigasRaw = @json(old('vacinas', []));
const vacinasAntigas = Array.isArray(vacinasAntigasRaw)
    ? vacinasAntigasRaw
    : Object.keys(vacinasAntigasRaw || {}).map((key) => vacinasAntigasRaw[key]).filter(Boolean);

const currencyFormatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
});

document.addEventListener('DOMContentLoaded', () => {
    setupPacienteSelect();
    setupCidadeSelect();
    setupCepSearch();
    toggleDomiciliar();

    if (vacinasAntigas.length) {
        vacinasAntigas.forEach((vacinaData) => adicionarVacina(vacinaData));
    } else {
        adicionarVacina();
    }
});

// Função para submeter o formulário manualmente (evita conflitos com TomSelect)
function submitarFormulario() {
    console.log('🔥 submitarFormulario() chamada!');
    
    const form = document.getElementById('formAtendimento');
    if (!form) {
        console.error('❌ Formulário não encontrado!');
        return;
    }
    
    console.log('📋 Form encontrado:', form);
    console.log('📋 Action:', form.action);
    console.log('📋 Method:', form.method);
    
    // Validar se há pelo menos uma vacina
    const vacinas = document.querySelectorAll('.vacina-item');
    console.log('💉 Total de vacinas:', vacinas.length);
    
    if (vacinas.length === 0) {
        showNotification('❌ Adicione pelo menos uma vacina ao atendimento!', 'error');
        console.error('❌ Nenhuma vacina adicionada');
        return;
    }
    
    // Validar campos obrigatórios
    const dataHidden = document.getElementById('data');
    const pacienteSelect = document.getElementById('paciente_id');
    const tipoInput = document.querySelector('input[name="tipo"]:checked');
    
    console.log('📅 Data:', dataHidden?.value);
    console.log('👤 Paciente:', pacienteSelect?.value);
    console.log('🏥 Tipo:', tipoInput?.value);
    
    if (!dataHidden?.value) {
        showNotification('❌ Selecione uma data!', 'error');
        return;
    }
    
    if (!pacienteSelect?.value) {
        showNotification('❌ Selecione um paciente!', 'error');
        return;
    }
    
    if (!tipoInput?.value) {
        showNotification('❌ Selecione o tipo de atendimento!', 'error');
        return;
    }
    
    // Validar vacinas
    let todasValidas = true;
    vacinas.forEach((item, index) => {
        const vacinaSelect = item.querySelector('.vacina-select');
        const quantidadeInput = item.querySelector('.quantidade-input');
        const valorInput = item.querySelector('.valor-input');
        
        if (!vacinaSelect?.value || !quantidadeInput?.value || !valorInput?.value) {
            todasValidas = false;
            console.error(`❌ Vacina ${index + 1}: Dados incompletos`);
        }
        
        console.log(`✅ Vacina ${index + 1}:`, {
            vacina_id: vacinaSelect?.value,
            quantidade: quantidadeInput?.value,
            valor: valorInput?.value
        });
    });
    
    if (!todasValidas) {
        showNotification('❌ Preencha todos os campos das vacinas corretamente!', 'error');
        return;
    }
    
    // Verificar CSRF token
    const csrfToken = form.querySelector('input[name="_token"]');
    if (!csrfToken) {
        console.error('❌ CSRF Token não encontrado!');
        showNotification('❌ Erro de segurança: Token CSRF ausente!', 'error');
        return;
    }
    
    console.log('🔐 CSRF Token:', csrfToken.value.substring(0, 10) + '...');
    
    // Mostrar todos os dados que serão enviados
    const formData = new FormData(form);
    console.log('📦 Dados a serem enviados:');
    for (let [key, value] of formData.entries()) {
        console.log(`   ${key}: ${value}`);
    }
    
    console.log('✅ Todas as validações passaram! Enviando formulário...');
    
    // SOLUÇÃO: Usar Fetch API ao invés de form.submit()
    // Isso contorna problemas com TomSelect e outros listeners
    try {
        console.log('🚀 Enviando via Fetch API...');
        
        const formData = new FormData(form);
        
        // Mostrar loading no botão
        const btn = document.getElementById('btnSubmitAtendimento');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
            `;
        }
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json, text/html'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            console.log('📨 Resposta recebida:', response.status, response.statusText);
            console.log('📨 URL da resposta:', response.url);
            
            const contentType = response.headers.get('content-type');
            console.log('📨 Content-Type:', contentType);
            
            // Tentar ler a resposta
            const responseText = await response.text();
            console.log('📨 Resposta (primeiros 500 chars):', responseText.substring(0, 500));
            
            if (response.redirected) {
                console.log('🔄 Redirecionando para:', response.url);
                
                // Se redirecionou para create, houve erro de validação
                if (response.url.includes('/create')) {
                    console.error('❌ Redirecionou para create - ERRO DE VALIDAÇÃO!');
                    
                    // Tentar encontrar erros na resposta
                    try {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(responseText, 'text/html');
                        const errors = doc.querySelectorAll('.text-red-500, .alert-danger, .error');
                        
                        if (errors.length > 0) {
                            console.error('❌ Erros encontrados na página:');
                            errors.forEach(error => {
                                console.error('  -', error.textContent.trim());
                                showNotification(error.textContent.trim(), 'error');
                            });
                        } else {
                            showNotification('❌ Erro de validação. Verifique os campos.', 'error');
                        }
                    } catch (e) {
                        console.error('Erro ao parsear resposta:', e);
                    }
                    
                    // Reabilitar botão
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Registrar Atendimento
                        `;
                    }
                    return;
                }
                
                window.location.href = response.url;
                return;
            }
            
            // Tentar parsear como JSON
            try {
                const data = JSON.parse(responseText);
                console.log('📦 JSON recebido:', data);
                
                if (data.success === false || data.error) {
                    console.error('❌ Erro retornado:', data);
                    showNotification('❌ ' + (data.message || data.error), 'error');
                    
                    // Reabilitar botão
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Registrar Atendimento
                        `;
                    }
                    return;
                }
                
                if (data.errors) {
                    console.error('❌ Erros de validação:', data.errors);
                    Object.keys(data.errors).forEach(field => {
                        data.errors[field].forEach(error => {
                            console.error(`  ${field}: ${error}`);
                            showNotification(`❌ ${field}: ${error}`, 'error');
                        });
                    });
                    
                    // Reabilitar botão
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Registrar Atendimento
                        `;
                    }
                    return;
                }
                
                if (data.message) {
                    console.error('❌ Mensagem de erro:', data.message);
                    showNotification('❌ ' + data.message, 'error');
                    
                    // Reabilitar botão
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Registrar Atendimento
                        `;
                    }
                    return;
                }
            } catch (e) {
                // Não é JSON, provavelmente HTML
                console.log('Não é JSON, é HTML');
            }
            
            if (response.ok) {
                console.log('✅ Sucesso! Redirecionando...');
                window.location.href = form.action.replace('/atendimentos', '/atendimentos');
            } else {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
        })
        .catch(error => {
            console.error('❌ Erro na requisição:', error);
            showNotification('❌ Erro ao enviar: ' + error.message, 'error');
            
            // Reabilitar botão
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Registrar Atendimento
                `;
            }
        });
        
    } catch (error) {
        console.error('❌ Erro ao enviar formulário:', error);
        showNotification('❌ Erro ao enviar formulário: ' + error.message, 'error');
    }
}

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
            
            // Mostrar notificação de sucesso
            showNotification('✅ Endereço encontrado! Verifique os dados preenchidos.', 'success');
        } else {
            showNotification('❌ CEP não encontrado. Verifique o número informado.', 'error');
        }
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        showNotification('⚠️ Erro ao buscar CEP. Tente novamente.', 'error');
    } finally {
        // Esconder loading
        loadingIcon?.classList.add('hidden');
    }
}

function showNotification(message, type = 'info') {
    // Remover notificação anterior se existir
    const existingNotification = document.querySelector('.cep-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `cep-notification fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    notification.className += ` ${bgColor} text-white`;
    
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="font-medium text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remover após 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

function toNumber(value) {
    if (value === null || value === undefined || value === '') {
        return null;
    }

    const sanitized = String(value).trim().replace(/\s/g, '').replace(',', '.');
    const numeric = Number(sanitized);

    return Number.isFinite(numeric) ? numeric : null;
}

function formatDecimalInput(value) {
    const numeric = toNumber(value);
    return numeric !== null ? numeric.toFixed(2) : '';
}

function formatCurrency(value) {
    const numeric = toNumber(value);
    return currencyFormatter.format(numeric !== null ? numeric : 0);
}

function getVacinaById(id) {
    return vacinasMap[String(id)] || null;
}

function getPriceOptionsForVacina(vacina) {
    if (!vacina) {
        return [];
    }

    return tabelaPrecoOrdenacao
        .map((chave) => {
            const valor = toNumber(vacina[chave]);
            if (valor === null) {
                return null;
            }

            return {
                key: chave,
                label: tabelaPrecoLabels[chave] || chave,
                value: valor,
            };
        })
        .filter(Boolean);
}

function buildVacinaOptionLabel(vacina) {
    // Apenas mostra o nome da vacina, sem os preços confusos
    return vacina.nome;
}

function createVacinaOptionsHtml(selectedId = '') {
    const options = ['<option value="">Selecione uma vacina...</option>'];

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
    const enderecoInput = document.getElementById('endereco_atendimento');
    
    if (tipo === 'domiciliar') {
        camposDomiciliar.classList.remove('hidden');
        cidadeSelect.setAttribute('required', 'required');
    } else {
        camposDomiciliar.classList.add('hidden');
        cidadeSelect.removeAttribute('required');

        if (cidadeSelect) {
            cidadeSelect.value = '';
        }

        if (enderecoInput) {
            enderecoInput.value = '';
        }
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
        <div class="vacina-item relative p-6 border-2 border-gray-200 rounded-2xl bg-gradient-to-br from-white to-gray-50 shadow-sm hover:shadow-xl hover:border-purple-300 transition-all duration-300" data-index="${index}">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                    <div class="lg:flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Vacina *
                        </label>
                        <select name="vacinas[${index}][vacina_id]" required data-field="vacina"
                                class="w-full rounded-xl border-2 border-gray-300 text-sm vacina-select focus:border-purple-500 focus:ring-purple-500 bg-white shadow-sm py-3 px-4 font-medium"
                                onchange="handleVacinaChange(${index})">
                            ${createVacinaOptionsHtml(selectedVacinaId)}
                        </select>
                    </div>
                    <div class="lg:w-80">
                        <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Tabela de Preço *
                        </label>
                        <select name="vacinas[${index}][tabela_preco]" required data-field="tabela"
                                class="w-full rounded-xl border-2 border-gray-300 text-sm tabela-preco-select focus:border-purple-500 focus:ring-purple-500 bg-white shadow-sm py-3 px-4 font-medium"
                                onchange="aplicarTabelaPreco(${index})">
                            <option value="">Selecione a tabela de preços...</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                    <div class="flex flex-col sm:flex-row sm:items-end gap-4 lg:flex-1">
                        <div class="sm:w-32 lg:w-32">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11H3m0 0l3 3m-3-3l3-3m8 6h4m0 0l-3 3m3-3l-3-3"/>
                                </svg>
                                Quantidade *
                            </label>
                            <input type="number" name="vacinas[${index}][quantidade]" value="${quantidade}" min="1" required data-field="quantidade"
                                   class="w-full rounded-xl border-2 border-gray-300 text-sm quantidade-input focus:border-purple-500 focus:ring-purple-500 py-3 px-4 font-semibold text-center bg-white shadow-sm"
                                   oninput="calcularTotal()">
                        </div>
                        <div class="sm:w-40 lg:w-40">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                Valor Unit. *
                            </label>
                            <input type="number" name="vacinas[${index}][valor_unitario]" step="0.01" min="0" required data-field="valor"
                                   class="w-full rounded-xl border-2 border-gray-300 text-sm valor-input focus:border-purple-500 focus:ring-purple-500 py-3 px-4 font-bold text-green-600 bg-white shadow-sm"
                                   oninput="calcularTotal()">
                        </div>
                        <div class="sm:flex-1">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Lote (Opcional)
                            </label>
                            <input type="text" name="vacinas[${index}][lote]" value="${lote}" data-field="lote" placeholder="Ex: L2024001"
                                   class="w-full rounded-xl border-2 border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 font-medium bg-white shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 lg:pl-2">
                        <button type="button" onclick="adicionarVacina(clonarVacina(${index}))"
                                class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-purple-50 to-indigo-50 text-purple-600 text-sm font-bold hover:from-purple-100 hover:to-indigo-100 border-2 border-purple-200 hover:border-purple-300 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Duplicar</span>
                        </button>
                        <button type="button" onclick="removerVacina(${index})" 
                                class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 text-red-600 text-sm font-bold hover:from-red-100 hover:to-rose-100 border-2 border-red-200 hover:border-red-300 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Remover</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', vacinaHtml);

    const item = container.querySelector(`.vacina-item[data-index="${index}"]`);
    if (!item) {
        return;
    }

    if (tabelaPrecoInicial) {
        item.dataset.initialTabela = tabelaPrecoInicial;
    }

    if (valorUnitario) {
        item.dataset.initialValor = valorUnitario;
    }

    handleVacinaChange(index, vacinaData);
    calcularTotal();
}

function removerVacina(index) {
    const item = document.querySelector(`.vacina-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        calcularTotal();
    }
    if (!document.querySelectorAll('.vacina-item').length) {
        adicionarVacina();
    } else {
        calcularTotal();
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

    priceSelect.innerHTML = '<option value="">Selecione a tabela...</option>';

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

    opcoesPreco.forEach((option) => {
        const optionElement = document.createElement('option');
        optionElement.value = option.key;
        optionElement.dataset.amount = option.value;
        optionElement.textContent = `${option.label} • ${formatCurrency(option.value)}`;
        priceSelect.appendChild(optionElement);
    });

    const customOption = document.createElement('option');
    customOption.value = 'personalizado';
    customOption.textContent = 'Personalizado';
    priceSelect.appendChild(customOption);

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

    priceSelect.value = tabelaSelecionada;

    const valorInicial = payload?.valor_unitario ?? item.dataset.initialValor ?? null;
    aplicarTabelaPreco(index, valorInicial);

    delete item.dataset.initialTabela;
    delete item.dataset.initialValor;
}

function clonarVacina(index) {
    const item = document.querySelector(`.vacina-item[data-index="${index}"]`);
    if (!item) {
        return null;
    }

    const vacinaId = item.querySelector('[data-field="vacina"]')?.value || '';
    const tabelaPreco = item.querySelector('[data-field="tabela"]')?.value || '';
    const quantidade = item.querySelector('[data-field="quantidade"]')?.value || '1';
    const valorUnitario = item.querySelector('[data-field="valor"]')?.value || '';
    const lote = item.querySelector('[data-field="lote"]')?.value || '';

    return {
        vacina_id: vacinaId,
        tabela_preco: tabelaPreco,
        quantidade,
        valor_unitario: valorUnitario,
        lote,
    };
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

// === MODAL ADICIONAR CIDADE ===
document.addEventListener('DOMContentLoaded', function() {
    const btnAdicionarCidade = document.getElementById('btnAdicionarCidade');
    const modal = document.getElementById('modalAdicionarCidade');
    const modalContent = document.getElementById('modalContent');
    const btnFecharModal = document.getElementById('btnFecharModal');
    const btnCancelarModal = document.getElementById('btnCancelarModal');
    const formNovaCidade = document.getElementById('formNovaCidade');
    const modalLoading = document.getElementById('modalLoading');

    // Abrir modal
    if (btnAdicionarCidade) {
        btnAdicionarCidade.addEventListener('click', function() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.style.transform = 'scale(1)';
                modalContent.style.opacity = '1';
            }, 10);
        });
    }

    // Fechar modal
    function fecharModal() {
        modalContent.style.transform = 'scale(0.95)';
        modalContent.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            formNovaCidade.reset();
        }, 300);
    }

    // Event listeners para fechar modal
    [btnFecharModal, btnCancelarModal].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', fecharModal);
        }
    });

    // Fechar modal ao clicar no fundo
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            fecharModal();
        }
    });

    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            fecharModal();
        }
    });

    // Submissão do formulário
    if (formNovaCidade) {
        formNovaCidade.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const nome = document.getElementById('novo_cidade_nome').value.trim();
            const uf = document.getElementById('novo_cidade_uf').value;
            
            if (!nome || !uf) {
                showNotification('Por favor, preencha todos os campos obrigatórios.', 'error');
                return;
            }

            // Mostrar loading
            modalLoading.classList.remove('hidden');
            
            try {
                const response = await fetch('/cidades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nome: nome,
                        uf: uf
                    })
                });

                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Adicionar a nova cidade ao select
                    const cidadeSelect = document.getElementById('cidade_id');
                    const tomSelectInstance = cidadeSelect.tomselect;
                    
                    if (tomSelectInstance) {
                        // Adicionar opção ao Tom Select
                        tomSelectInstance.addOption({
                            value: result.cidade.id,
                            text: `${result.cidade.nome} - ${result.cidade.uf}`
                        });
                        
                        // Selecionar a nova cidade
                        tomSelectInstance.setValue(result.cidade.id);
                    } else {
                        // Fallback para select nativo
                        const option = new Option(`${result.cidade.nome} - ${result.cidade.uf}`, result.cidade.id, true, true);
                        cidadeSelect.add(option);
                    }

                    showNotification(`Cidade "${result.cidade.nome} - ${result.cidade.uf}" adicionada com sucesso!`, 'success');
                    fecharModal();
                    
                } else {
                    const errorMessage = result.message || 'Erro ao adicionar cidade. Tente novamente.';
                    showNotification(errorMessage, 'error');
                }
                
            } catch (error) {
                console.error('Erro ao adicionar cidade:', error);
                showNotification('Erro de conexão. Verifique sua internet e tente novamente.', 'error');
            } finally {
                modalLoading.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush

<!-- Modal para Adicionar Cidade -->
<div id="modalAdicionarCidade" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
        <!-- Cabeçalho do Modal -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-6 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Nova Cidade</h3>
                        <p class="text-emerald-100 text-sm">Adicione uma nova cidade ao sistema</p>
                    </div>
                </div>
                <button type="button" id="btnFecharModal" class="text-emerald-100 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Conteúdo do Modal -->
        <form id="formNovaCidade" class="p-6">
            <div class="space-y-4">
                <!-- Nome da Cidade -->
                <div>
                    <label for="novo_cidade_nome" class="block text-sm font-bold text-gray-700 mb-2">
                        Nome da Cidade *
                    </label>
                    <input type="text" 
                           id="novo_cidade_nome" 
                           name="nome"
                           placeholder="Digite o nome da cidade"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-colors"
                           required>
                </div>

                <!-- Estado (UF) -->
                <div>
                    <label for="novo_cidade_uf" class="block text-sm font-bold text-gray-700 mb-2">
                        Estado (UF) *
                    </label>
                    <select id="novo_cidade_uf" 
                            name="uf"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 transition-colors"
                            required>
                        <option value="">Selecione o estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" 
                        id="btnCancelarModal"
                        class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        id="btnSalvarCidade"
                        class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium px-4 py-3 rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Cidade
                </button>
            </div>
        </form>

        <!-- Loading State -->
        <div id="modalLoading" class="absolute inset-0 bg-white bg-opacity-90 rounded-2xl hidden flex items-center justify-center">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-emerald-500 border-t-transparent mx-auto mb-4"></div>
                <p class="text-gray-600 font-medium">Salvando cidade...</p>
            </div>
        </div>
    </div>
</div>

@endsection

