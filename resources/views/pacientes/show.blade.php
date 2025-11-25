@extends('layouts.tenant-app')

@section('title', 'Detalhes do Paciente - MultiImune')
@section('page-title', 'Detalhes do Paciente')

@push('styles')
<style>
.hover-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.gradient-text {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-header {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
}

.card-header-emerald {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.card-header-teal {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
}

.card-header-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.card-header-gray {
    background: linear-gradient(135deg, #6b7280 0%, #374151 100%);
}

.info-card {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-active {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.status-inactive {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    border: 2px solid rgba(239, 68, 68, 0.3);
}

.pulse-animation {
    animation: pulse-slow 3s ease-in-out infinite;
}

@keyframes pulse-slow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header Moderno -->
    <div class="bg-white border-b border-gray-200 shadow-sm mb-8">
        <div class="container mx-auto px-6 py-6">
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
                <div class="flex items-center gap-6">
                    <!-- Avatar do Paciente -->
                    <div class="relative">
                        <div class="card-header w-20 h-20 rounded-3xl shadow-xl flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        @if($paciente->ativo)
                            <div class="absolute -bottom-1 -right-1 bg-emerald-500 w-6 h-6 rounded-full border-4 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            <div class="absolute -bottom-1 -right-1 bg-red-500 w-6 h-6 rounded-full border-4 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <h1 class="text-4xl font-bold gradient-text">
                            {{ $paciente->nome }}
                        </h1>
                        <div class="flex items-center gap-4 mt-2">
                            <p class="text-gray-600 text-lg">Ficha Completa do Paciente</p>
                            @if($paciente->data_nascimento)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ \Carbon\Carbon::parse($paciente->data_nascimento)->age }} anos
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <a href="{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}" 
                       class="group bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Novo Atendimento
                    </a>
                    <a href="{{ route('pacientes.edit', $paciente) }}" 
                       class="group bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Paciente
                    </a>
                    <a href="{{ route('pacientes.index') }}" 
                       class="group bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 pb-8">
        <!-- Layout Responsivo -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Coluna Principal -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Card de Dados Pessoais -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            Dados Pessoais
                        </h2>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nome Completo -->
                            <div class="lg:col-span-2 info-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 w-16 h-16 rounded-2xl shadow-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Nome Completo</label>
                                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $paciente->nome }}</p>
                                        <p class="text-blue-600 font-medium mt-1">Paciente Principal</p>
                                    </div>
                                </div>
                            </div>

                            <!-- CPF -->
                            @if($paciente->cpf)
                                <div class="info-card p-6 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-3 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">CPF</label>
                                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $paciente->cpf }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- RG -->
                            @if($paciente->rg)
                                <div class="info-card p-6 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">RG</label>
                                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $paciente->rg }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Data de Nascimento -->
                            @if($paciente->data_nascimento)
                                <div class="info-card p-6 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-3 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Data de Nascimento</label>
                                            <p class="text-2xl font-bold text-gray-800 mt-1">
                                                {{ \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') }}
                                            </p>
                                            <p class="text-pink-600 font-bold">{{ \Carbon\Carbon::parse($paciente->data_nascimento)->age }} anos</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Telefone -->
                            @if($paciente->telefone)
                                <div class="info-card p-6 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-3 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Telefone</label>
                                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $paciente->telefone }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- E-mail -->
                            @if($paciente->email)
                                <div class="lg:col-span-2 info-card p-6 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-3 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">E-mail</label>
                                            <p class="text-2xl font-bold text-gray-800 mt-1 break-all">{{ $paciente->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Observações -->
                        @if($paciente->observacoes)
                            <div class="mt-8 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-2xl p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="bg-amber-500 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-amber-800">Observações Importantes</h3>
                                </div>
                                <p class="text-gray-700 text-lg leading-relaxed">{{ $paciente->observacoes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card de Histórico de Atendimentos -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-emerald p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span>Histórico de Atendimentos</span>
                            </div>
                            @if($paciente->atendimentos->count() > 0)
                                <span class="bg-white bg-opacity-30 px-3 py-1 rounded-full text-sm font-bold">{{ $paciente->atendimentos->count() }}</span>
                            @endif
                        </h2>
                    </div>

                    <div class="p-8">
                        @if($paciente->atendimentos->count() > 0)
                            <div class="space-y-6">
                                @foreach($paciente->atendimentos as $index => $atendimento)
                                    <div class="group bg-gradient-to-r from-slate-50 to-gray-50 hover:from-emerald-50 hover:to-teal-50 p-6 rounded-2xl border-2 border-gray-200 hover:border-emerald-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-bold w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div>
                                                    <p class="text-2xl font-bold text-gray-800 group-hover:text-emerald-800 transition-colors">
                                                        📅 {{ \Carbon\Carbon::parse($atendimento->data)->format('d/m/Y') }}
                                                    </p>
                                                    <p class="text-gray-600 font-medium">
                                                        {{ \Carbon\Carbon::parse($atendimento->data)->diffForHumans() }}
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-2">
                                                        <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-bold">
                                                            💉 {{ $atendimento->vacinas->count() }} vacina(s)
                                                        </span>
                                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">
                                                            {{ $atendimento->tipo == 'clinica' ? '🏥 Clínica' : '🏠 Domiciliar' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-600 mb-1">Valor Total</p>
                                                <p class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                                    R$ {{ number_format($atendimento->valor_total, 2, ',', '.') }}
                                                </p>
                                                <a href="{{ route('atendimentos.show', $atendimento) }}" 
                                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 mt-2">
                                                    Ver Detalhes
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Lista de Vacinas -->
                                        <div class="mt-6 pt-4 border-t border-gray-200">
                                            <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Vacinas Aplicadas</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($atendimento->vacinas as $vacina)
                                                    <span class="inline-flex items-center gap-1 bg-white border-2 border-emerald-200 text-emerald-700 text-sm font-medium px-3 py-1 rounded-lg shadow-sm">
                                                        💉 {{ $vacina->nome }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Resumo Estatístico -->
                            <div class="mt-8 bg-gradient-to-r from-emerald-500 to-teal-600 p-6 rounded-2xl text-white shadow-2xl">
                                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Resumo do Histórico
                                </h3>
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="text-center">
                                        <div class="text-3xl font-black">{{ $paciente->atendimentos->count() }}</div>
                                        <div class="text-emerald-100 text-sm font-medium">Atendimentos</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-black">{{ $paciente->atendimentos->sum(function($a) { return $a->vacinas->count(); }) }}</div>
                                        <div class="text-emerald-100 text-sm font-medium">Vacinas Total</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-black">R$ {{ number_format($paciente->atendimentos->sum('valor_total'), 2, ',', '.') }}</div>
                                        <div class="text-emerald-100 text-sm font-medium">Valor Total</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="relative mb-6">
                                    <svg viewBox="0 0 200 200" class="w-32 h-32 mx-auto opacity-50">
                                        <defs>
                                            <linearGradient id="noAttendance" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#10b981;stop-opacity:0.3" />
                                                <stop offset="100%" style="stop-color:#14b8a6;stop-opacity:0.3" />
                                            </linearGradient>
                                        </defs>
                                        <rect x="50" y="50" width="100" height="120" rx="15" fill="url(#noAttendance)"/>
                                        <circle cx="100" cy="100" r="20" fill="#e5e7eb"/>
                                        <line x1="100" y1="85" x2="100" y2="105" stroke="#6b7280" stroke-width="4" stroke-linecap="round"/>
                                        <line x1="100" y1="115" x2="100" y2="117" stroke="#6b7280" stroke-width="4" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-700 mb-3">Nenhum Atendimento Registrado</h3>
                                <p class="text-gray-500 text-lg mb-6">Este paciente ainda não possui histórico de atendimentos no sistema</p>
                                <a href="{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}" 
                                   class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-4 px-8 rounded-xl shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Criar Primeiro Atendimento
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral -->
            <div class="xl:col-span-1 space-y-8">
                <!-- Card de Status -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-gray p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Status do Paciente
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($paciente->ativo)
                            <div class="status-active p-6 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-emerald-500 rounded-2xl p-3 pulse-animation shadow-lg">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-black text-emerald-700">✅ ATIVO</p>
                                            <p class="text-emerald-600 font-medium">Paciente ativo no sistema</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="status-inactive p-6 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-red-500 rounded-2xl p-3 shadow-lg">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-black text-red-700">❌ INATIVO</p>
                                            <p class="text-red-600 font-medium">Cadastro desativado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card de Endereço -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-teal p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            Endereço Residencial
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($paciente->endereco)
                            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-6 rounded-2xl border-2 border-teal-200">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-teal-500 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-lg font-bold text-gray-800">
                                                {{ $paciente->endereco }}{{ $paciente->numero ? ", {$paciente->numero}" : '' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if($paciente->complemento)
                                        <p class="text-gray-600 font-medium pl-10">{{ $paciente->complemento }}</p>
                                    @endif
                                    
                                    @if($paciente->bairro)
                                        <p class="text-gray-700 font-semibold pl-10">📍 {{ $paciente->bairro }}</p>
                                    @endif
                                    
                                    @if($paciente->cidade)
                                        <p class="text-teal-700 font-bold pl-10 text-lg">
                                            🏙️ {{ $paciente->cidade }}
                                        </p>
                                    @endif
                                    
                                    @if($paciente->cep)
                                        <p class="text-gray-600 font-medium pl-10">📮 CEP: {{ $paciente->cep }}</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Endereço não cadastrado</p>
                                <p class="text-gray-400 text-sm mt-1">Edite o paciente para adicionar</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card de Ações Rápidas -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-purple p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            Ações Rápidas
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <a href="{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}" 
                           class="group flex items-center gap-4 p-5 bg-gradient-to-r from-emerald-50 to-teal-50 hover:from-emerald-100 hover:to-teal-100 rounded-2xl border-2 border-emerald-200 hover:border-emerald-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-2xl group-hover:scale-110 transition shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-lg">Novo Atendimento</p>
                                <p class="text-emerald-600 text-sm font-medium">Criar atendimento para este paciente</p>
                            </div>
                        </a>

                        <a href="{{ route('pacientes.edit', $paciente) }}" 
                           class="group flex items-center gap-4 p-5 bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 rounded-2xl border-2 border-amber-200 hover:border-amber-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-2xl group-hover:scale-110 transition shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-lg">Editar Dados</p>
                                <p class="text-amber-600 text-sm font-medium">Alterar informações do cadastro</p>
                            </div>
                        </a>

                        <a href="{{ route('pacientes.index') }}" 
                           class="group flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-slate-50 hover:from-gray-100 hover:to-slate-100 rounded-2xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="bg-gradient-to-r from-gray-600 to-gray-700 p-3 rounded-2xl group-hover:scale-110 transition shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-lg">Ver Todos</p>
                                <p class="text-gray-600 text-sm font-medium">Voltar à listagem de pacientes</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Ilustração Moderna -->
                <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-8 rounded-3xl border-2 border-indigo-200 shadow-lg">
                    <div class="text-center mb-6">
                        <h4 class="text-xl font-bold gradient-text">Paciente Cadastrado</h4>
                        <p class="text-gray-600 mt-2">Ficha completa e atualizada</p>
                    </div>
                    
                    <div class="relative">
                        <svg viewBox="0 0 300 250" class="w-full h-auto">
                            <defs>
                                <linearGradient id="patientGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#8b5cf6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#ec4899;stop-opacity:1" />
                                </linearGradient>
                                <linearGradient id="heartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ef4444;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#dc2626;stop-opacity:1" />
                                </linearGradient>
                                <linearGradient id="shieldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            
                            <!-- Pessoa Principal -->
                            <circle cx="150" cy="90" r="35" fill="url(#patientGradient)" opacity="0.8">
                                <animate attributeName="r" values="35;37;35" dur="4s" repeatCount="indefinite"/>
                            </circle>
                            <path d="M 105 140 Q 105 110 150 110 Q 195 110 195 140 L 195 190 L 105 190 Z" fill="url(#patientGradient)" opacity="0.8"/>
                            
                            <!-- Prontuário Médico -->
                            <rect x="40" y="40" width="60" height="80" rx="8" fill="white" stroke="url(#patientGradient)" stroke-width="3"/>
                            <rect x="40" y="40" width="60" height="25" rx="8" fill="url(#patientGradient)" opacity="0.8"/>
                            
                            <!-- Texto do Prontuário -->
                            <line x1="50" y1="70" x2="90" y2="70" stroke="url(#patientGradient)" stroke-width="3" stroke-linecap="round"/>
                            <line x1="50" y1="80" x2="80" y2="80" stroke="url(#patientGradient)" stroke-width="3" stroke-linecap="round"/>
                            <line x1="50" y1="90" x2="85" y2="90" stroke="url(#patientGradient)" stroke-width="3" stroke-linecap="round"/>
                            <line x1="50" y1="100" x2="75" y2="100" stroke="url(#patientGradient)" stroke-width="3" stroke-linecap="round"/>
                            
                            <!-- Coração com Pulso -->
                            <g transform="translate(220, 80)">
                                <path d="M 20 15 C 20 8 15 2 8 2 C 1 2 -5 8 -5 15 C -5 25 5 35 20 50 C 35 35 45 25 45 15 C 45 8 40 2 33 2 C 26 2 20 8 20 15" 
                                      fill="url(#heartGradient)" opacity="0.9">
                                    <animate attributeName="opacity" values="0.7;1;0.7" dur="1.5s" repeatCount="indefinite"/>
                                    <animateTransform attributeName="transform" type="scale" values="1;1.1;1" dur="1.5s" repeatCount="indefinite"/>
                                </path>
                            </g>
                            
                            <!-- Escudo de Proteção -->
                            <g transform="translate(50, 150)">
                                <path d="M 15 5 C 15 5 5 2 0 5 C 0 5 0 15 0 25 C 0 40 15 50 15 50 C 15 50 30 40 30 25 C 30 15 30 5 30 5 C 25 2 15 5 15 5 Z" 
                                      fill="url(#shieldGradient)" opacity="0.8">
                                    <animate attributeName="opacity" values="0.6;1;0.6" dur="3s" repeatCount="indefinite"/>
                                </path>
                                <path d="M 8 20 L 12 24 L 22 14" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                            </g>
                            
                            <!-- Partículas Flutuantes -->
                            <circle cx="250" cy="50" r="4" fill="url(#patientGradient)" opacity="0.6">
                                <animate attributeName="cy" values="50;40;50" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="80" cy="200" r="3" fill="url(#shieldGradient)" opacity="0.5">
                                <animate attributeName="cy" values="200;190;200" dur="2.5s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.2;0.7;0.2" dur="2.5s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="270" cy="180" r="5" fill="url(#heartGradient)" opacity="0.4">
                                <animate attributeName="cy" values="180;170;180" dur="1.8s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.2;0.6;0.2" dur="1.8s" repeatCount="indefinite"/>
                            </circle>
                            
                            <!-- Conectores -->
                            <path d="M 150 125 Q 180 140 220 95" stroke="url(#patientGradient)" stroke-width="2" fill="none" opacity="0.4" stroke-dasharray="5,5">
                                <animate attributeName="stroke-dashoffset" values="0;10" dur="2s" repeatCount="indefinite"/>
                            </path>
                            <path d="M 150 125 Q 120 140 80 170" stroke="url(#shieldGradient)" stroke-width="2" fill="none" opacity="0.4" stroke-dasharray="5,5">
                                <animate attributeName="stroke-dashoffset" values="0;10" dur="2.2s" repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 font-bold py-2 px-4 rounded-full border-2 border-blue-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Ficha Protegida e Atualizada
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

