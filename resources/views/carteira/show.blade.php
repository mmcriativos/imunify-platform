@extends('layouts.tenant-app')

@section('title', 'Carteira de Vacinação - ' . $paciente->nome)
@section('page-title', 'Carteira de Vacinação')

@push('styles')
<style>
    .writing-mode-vertical {
        writing-mode: vertical-rl;
        text-orientation: mixed;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="mb-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('carteira.index') }}" 
               class="bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 p-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Carteira de Vacinação
                </h1>
                <p class="text-gray-600 text-sm">Histórico completo de imunizações</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('carteira.certificado', $paciente->id) }}" 
               target="_blank"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Certificado PDF
            </a>
            
            <a href="{{ route('carteira.print', $paciente->id) }}" 
               target="_blank"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimir
            </a>
            
            <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Aplicação
            </button>
        </div>
    </div>
</div>

<!-- Informações do Paciente -->
<div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-6 shadow-lg">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Dados do Paciente -->
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide">Paciente com imunizações em dia</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Código</p>
            <p class="text-lg font-bold text-gray-900">#{{ str_pad($paciente->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nome</p>
            <p class="text-lg font-bold text-gray-900">{{ $paciente->nome }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nascimento</p>
            <p class="text-lg font-bold text-gray-900">
                {{ $paciente->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}
            </p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Idade</p>
            <p class="text-lg font-bold text-gray-900">
                @if($paciente->data_nascimento)
                    @php
                        $anos = \Carbon\Carbon::parse($paciente->data_nascimento)->age;
                        $meses = \Carbon\Carbon::parse($paciente->data_nascimento)->diffInMonths(now());
                    @endphp
                    @if($anos == 0)
                        {{ $meses }} {{ $meses == 1 ? 'mês e ' : 'meses e ' }}
                        {{ \Carbon\Carbon::parse($paciente->data_nascimento)->diffInDays(now()) % 30 }} 
                        {{ \Carbon\Carbon::parse($paciente->data_nascimento)->diffInDays(now()) % 30 == 1 ? 'dia' : 'dias' }}
                    @else
                        {{ $anos }} {{ $anos == 1 ? 'ano e ' : 'anos e ' }}{{ $meses % 12 }} {{ $meses % 12 == 1 ? 'mês' : 'meses' }}
                    @endif
                @else
                    Não informado
                @endif
            </p>
        </div>
    </div>
    
            @if($paciente->responsavel_nome)
                <div class="mt-4 pt-4 border-t border-green-200">
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Responsável</p>
                    <p class="text-base font-semibold text-gray-900">{{ $paciente->responsavel_nome }}</p>
                </div>
            @endif
            
            <div class="mt-6 flex items-center gap-2">
                <button onclick="toggleSugestoes()" 
                        class="text-sm text-green-700 font-medium hover:text-green-800 flex items-center gap-1 transition-colors">
                    <svg id="seta-sugestoes" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    Exibir sugestões automáticas
                </button>
            </div>
        </div>
        
        <!-- QR Code -->
        <div class="lg:border-l lg:border-green-200 lg:pl-6 flex items-center">
            <div class="bg-white rounded-xl p-6 shadow-lg text-center border border-gray-100">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm font-bold text-gray-700 uppercase">Carteira Digital</p>
                </div>
                <div id="qrcode" class="flex justify-center mb-4"></div>
                <p class="text-xs text-gray-600 mb-4">Escaneie para acessar online</p>
                <button onclick="compartilharCarteira()" 
                        class="text-sm bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-medium py-2.5 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 mx-auto w-full shadow-md hover:shadow-lg transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Compartilhar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Campanhas Ativas -->
@if(isset($campanhasAtivas) && $campanhasAtivas->count() > 0)
    <div class="mb-6">
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-300 rounded-xl overflow-hidden shadow-lg">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            Campanhas de Vacinação Ativas
                        </h3>
                        <p class="text-emerald-100 text-sm mt-1">
                            {{ $campanhasAtivas->count() }} {{ $campanhasAtivas->count() == 1 ? 'campanha disponível' : 'campanhas disponíveis' }} para este paciente
                        </p>
                    </div>
                    <div class="hidden lg:block">
                        <svg class="w-12 h-12 text-emerald-200 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($campanhasAtivas as $campanha)
                        @php
                            $urgente = $campanha['dias_restantes'] <= 7;
                            $corBorda = $urgente ? 'border-red-400' : 'border-emerald-400';
                            $corBg = $urgente ? 'bg-red-50' : 'bg-white';
                        @endphp
                        
                        <div class="{{ $corBg }} border-2 {{ $corBorda }} rounded-xl p-5 hover:shadow-lg transition-all relative overflow-hidden">
                            @if($urgente)
                                <div class="absolute top-0 left-0 right-0 bg-red-500 text-white text-xs font-bold py-1 px-3 text-center animate-pulse">
                                    ⏰ ÚLTIMOS {{ $campanha['dias_restantes'] }} {{ $campanha['dias_restantes'] == 1 ? 'DIA' : 'DIAS' }}!
                                </div>
                                <div class="mt-6"></div>
                            @endif
                            
                            <div class="flex items-start gap-4">
                                <!-- Ícone -->
                                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 p-3 rounded-xl flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                
                                <!-- Conteúdo -->
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $campanha['nome'] }}</h4>
                                    <p class="text-sm text-gray-700 mb-3">{{ $campanha['descricao'] }}</p>
                                    
                                    <div class="space-y-2 text-sm">
                                        <!-- Vacina -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-700">Vacina:</span>
                                            <span class="text-emerald-700 font-bold">{{ $campanha['vacina'] }}</span>
                                        </div>
                                        
                                        <!-- Público-alvo -->
                                        @if($campanha['publico_alvo'])
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <span class="text-gray-600">{{ $campanha['publico_alvo'] }}</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Período -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $campanha['data_inicio'] }} até {{ $campanha['data_fim'] }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Botão de ação -->
                                    <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"
                                            class="mt-4 w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Agendar Vacinação
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Vacinas Sugeridas (oculto inicialmente) -->
@if($vacinasSugeridas->count() > 0)
    <div id="sugestoes" class="hidden mb-6">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-indigo-200 rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Sugestões Inteligentes de Vacinação
                        </h3>
                        <p class="text-indigo-100 text-sm mt-1">
                            Baseadas no Calendário Nacional do Ministério da Saúde • {{ $vacinasSugeridas->count() }} recomendações
                        </p>
                    </div>
                    
                    <!-- Legenda de Prioridades -->
                    <div class="hidden lg:flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-white font-semibold">Alta prioridade</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <span class="text-white font-semibold">Média prioridade</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Separar por prioridade -->
                @php
                    $altaPrioridade = $vacinasSugeridas->filter(fn($s) => $s['prioridade'] === 'alta');
                    $mediaPrioridade = $vacinasSugeridas->filter(fn($s) => $s['prioridade'] === 'média');
                    $atrasadas = $vacinasSugeridas->filter(fn($s) => isset($s['atrasada']) && $s['atrasada']);
                @endphp
                
                <!-- Alertas de Doses Atrasadas -->
                @if($atrasadas->count() > 0)
                    <div class="mb-6 bg-red-50 border-2 border-red-300 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-500 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-red-900 text-lg mb-2">⚠️ Atenção: Vacinas Atrasadas!</h4>
                                <p class="text-red-700 text-sm mb-3">As seguintes vacinas estão com aplicação atrasada. Recomenda-se regularização urgente:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($atrasadas as $sugestao)
                                        <div class="bg-white border-2 border-red-400 rounded-lg p-3 flex items-start gap-3">
                                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="font-bold text-red-900">{{ $sugestao['nome'] }}</p>
                                                <p class="text-sm text-red-700">{{ $sugestao['dose'] }}</p>
                                                <p class="text-xs text-red-600 mt-1">Ideal: {{ $sugestao['idade_recomendada'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Alta Prioridade -->
                @if($altaPrioridade->count() > 0)
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <h4 class="font-bold text-gray-900 text-lg">Alta Prioridade</h4>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $altaPrioridade->count() }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($altaPrioridade as $sugestao)
                                <a href="{{ route('agenda.index') }}?paciente_id={{ $paciente->id }}" class="block bg-white border-2 border-red-300 rounded-xl p-4 hover:shadow-lg transition-shadow relative overflow-hidden hover:border-red-400">
                                    <!-- Faixa de prioridade -->
                                    <div class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                                        URGENTE
                                    </div>
                                    
                                    <div class="flex items-start gap-3 mt-2">
                                        <div class="bg-red-100 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 text-base">{{ $sugestao['nome'] }}</p>
                                            <p class="text-sm text-gray-700 font-semibold">{{ $sugestao['dose'] }}</p>
                                            <div class="mt-2 flex items-center gap-1 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            @if(isset($sugestao['observacao']))
                                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $sugestao['observacao'] }}</p>
                                            @endif
                                            <div class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Clique para agendar
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Média Prioridade -->
                @if($mediaPrioridade->count() > 0)
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <h4 class="font-bold text-gray-900 text-lg">Média Prioridade</h4>
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $mediaPrioridade->count() }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($mediaPrioridade as $sugestao)
                                <a href="{{ route('agenda.index') }}?paciente_id={{ $paciente->id }}" class="block bg-white border-2 border-yellow-300 rounded-xl p-4 hover:shadow-lg transition-shadow hover:border-yellow-400">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-yellow-100 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">{{ $sugestao['nome'] }}</p>
                                            <p class="text-sm text-gray-700">{{ $sugestao['dose'] }}</p>
                                            <div class="mt-2 flex items-center gap-1 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            @if(isset($sugestao['observacao']))
                                                <p class="mt-2 text-xs text-gray-600">{{ $sugestao['observacao'] }}</p>
                                            @endif
                                            <div class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-yellow-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Clique para agendar
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Histórico de Vacinações -->
<div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span>Histórico de Imunizações</span>
                </h2>
                <p class="text-emerald-100 mt-1 text-sm">
                    Registro completo de {{ $vacinasAplicadas->count() }} vacinação{{ $vacinasAplicadas->count() != 1 ? 'ões' : '' }} aplicada{{ $vacinasAplicadas->count() != 1 ? 's' : '' }}
                </p>
            </div>
            
            <!-- Estatísticas rápidas -->
            <div class="text-right">
                <div class="bg-white/20 rounded-lg p-3">
                    <div class="text-2xl font-bold text-white">{{ $vacinasAplicadas->count() }}</div>
                    <div class="text-xs text-emerald-100 font-medium">Total aplicadas</div>
                </div>
            </div>
        </div>
        
        <!-- Legenda de status com melhor design -->
        <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg"></div>
                    <span class="text-white font-medium text-sm">Aplicada</span>
                </div>
            </div>
            <div class="bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-400 rounded-full shadow-lg"></div>
                    <span class="text-white font-medium text-sm">Agendada</span>
                </div>
            </div>
            <div class="bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-purple-400 rounded-full shadow-lg"></div>
                    <span class="text-white font-medium text-sm">Sugestão</span>
                </div>
            </div>
            <div class="bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-400 rounded-full shadow-lg"></div>
                    <span class="text-white font-medium text-sm">Pendente</span>
                </div>
            </div>
        </div>
    </div>

    @if($vacinasAplicadas->count() > 0)
        <div class="p-6 bg-gray-50">
            <!-- Layout tipo carteira de vacinação física -->
            <div class="space-y-6">
                @php
                    // Agrupar por vacina e organizar em linhas
                    $vacinasPorCategoria = [
                        'BCG' => ['nome' => 'BCG', 'cor' => 'bg-green-50', 'borda' => 'border-green-200'],
                        'Hepatite' => ['nome' => 'Hepatite B', 'cor' => 'bg-green-50', 'borda' => 'border-green-200'],
                        'Pentavalente' => ['nome' => 'Pentavalente/13V', 'cor' => 'bg-blue-50', 'borda' => 'border-blue-200'],
                        'Pneumocócica' => ['nome' => 'Pneumocócica 13 Valente', 'cor' => 'bg-blue-50', 'borda' => 'border-blue-200'],
                        'Meningocócica' => ['nome' => 'Meningocócica/Rotavírus Pentavalente', 'cor' => 'bg-purple-50', 'borda' => 'border-purple-200'],
                        'Rotavírus' => ['nome' => 'Rotavírus', 'cor' => 'bg-purple-50', 'borda' => 'border-purple-200'],
                        'Influenza' => ['nome' => 'Influenza', 'cor' => 'bg-cyan-50', 'borda' => 'border-cyan-200'],
                    ];
                    
                    // Organizar vacinas aplicadas por nome
                    $vacinasAgrupadas = $vacinasAplicadas->groupBy('vacina');
                @endphp

                @foreach($vacinasAgrupadas as $nomeVacina => $doses)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <!-- Cabeçalho da Vacina com design mais moderno -->
                        <div class="flex">
                            <!-- Label lateral com gradiente -->
                            <div class="bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 text-white font-bold text-sm writing-mode-vertical px-4 py-6 flex items-center justify-center min-w-[70px] relative">
                                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                                <span class="transform -rotate-180 relative z-10 tracking-wider" style="writing-mode: vertical-rl; text-orientation: mixed;">
                                    {{ strtoupper(Str::limit($nomeVacina, 15, '')) }}
                                </span>
                                <!-- Decoração geométrica -->
                                <div class="absolute top-2 left-2 w-2 h-2 bg-white/30 rounded-full"></div>
                                <div class="absolute bottom-2 right-2 w-2 h-2 bg-white/30 rounded-full"></div>
                            </div>
                            
                            <!-- Grid de doses com melhor espaçamento -->
                            <div class="flex-1 p-6 bg-gradient-to-br from-gray-50 to-white">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                    @foreach($doses->sortBy('data') as $index => $dose)
                                        @php
                                            $isPaga = !isset($dose['pendente_pagamento']) || !$dose['pendente_pagamento'];
                                            $corCard = $isPaga ? 'bg-gradient-to-br from-emerald-50 to-green-50 border-emerald-300' : 'bg-gradient-to-br from-red-50 to-pink-50 border-red-300';
                                            $corBadge = $isPaga ? 'bg-gradient-to-r from-emerald-500 to-green-600' : 'bg-gradient-to-r from-red-500 to-pink-600';
                                            $corIcone = $isPaga ? 'text-emerald-600' : 'text-red-600';
                                        @endphp
                                        
                                        <div class="relative {{ $corCard }} border-2 rounded-xl p-4 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                            <!-- Badge de status com gradiente -->
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="{{ $corBadge }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                                    {{ is_numeric($dose['dose']) ? $dose['dose'] . 'ª' : $dose['dose'] }}
                                                </span>
                                                @if(!$isPaga)
                                                    <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">Pendente</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Data com melhor tipografia -->
                                            <div class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4 {{ $corIcone }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($dose['data'])->format('d/m/Y') }}
                                            </div>
                                            
                                            <!-- Detalhes com ícones */
                                            <div class="space-y-2 text-xs text-gray-600">
                                                @if(isset($dose['lote']) && $dose['lote'])
                                                    <div class="flex items-center gap-2 bg-white/50 rounded-lg p-2">
                                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                        </svg>
                                                        <span class="font-semibold">{{ Str::limit($dose['lote'], 12) }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if(isset($dose['tipo']))
                                                    <div class="flex items-center gap-2 bg-white/50 rounded-lg p-2">
                                                        @if($dose['tipo'] === 'clinica')
                                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                            </svg>
                                                        @endif
                                                        <span class="capitalize font-medium">{{ $dose['tipo'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Ícone de check com animação -->
                                            @if($isPaga)
                                                <div class="absolute -top-2 -right-2 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full p-1.5 shadow-lg">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @php
                                        // Buscar doses sugeridas desta vacina específica do ProximaDoseService
                                        $dosesSugeridasDessaVacina = $vacinasSugeridas->filter(function($sug) use ($nomeVacina) {
                                            return stripos($sug['nome'], explode(' ', $nomeVacina)[0]) !== false ||
                                                   stripos($nomeVacina, explode(' ', $sug['nome'])[0]) !== false;
                                        });
                                    @endphp
                                    
                                    @foreach($dosesSugeridasDessaVacina as $sugestao)
                                        <div class="relative bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-purple-300 border-dashed rounded-xl p-4 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                            <!-- Badge de sugestão com gradiente -->
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                                    {{ $sugestao['dose'] }}
                                                </span>
                                                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-1 rounded-full">Sugestão</span>
                                            </div>
                                            
                                            <!-- Data sugerida com ícone -->
                                            <div class="text-base font-bold text-purple-900 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            
                                            <!-- Detalhes com melhor design -->
                                            <div class="space-y-2 text-xs text-purple-600">
                                                <div class="bg-white/70 rounded-lg p-2 flex items-center gap-2">
                                                    <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-semibold">Dose recomendada</span>
                                                </div>
                                                <div class="bg-white/70 rounded-lg p-2 flex items-center gap-2">
                                                    <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    <a href="{{ route('agenda.index') }}?paciente_id={{ $paciente->id }}" class="font-semibold hover:text-purple-700">Clique para agendar</a>
                                                </div>
                                            </div>
                                            
                                            <!-- Ícone de sugestão -->
                                            <div class="absolute -top-2 -right-2 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full p-1.5 shadow-lg">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-16 px-6">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 max-w-md mx-auto">
                <!-- Ícone ilustrativo -->
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 w-24 h-24 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                
                <!-- Conteúdo -->
                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-gray-900">Carteira em branco</h3>
                    <p class="text-gray-600">Nenhuma vacina foi registrada ainda para este paciente</p>
                    <p class="text-sm text-gray-500">Comece registrando a primeira aplicação para iniciar o histórico de imunização</p>
                </div>
                
                <!-- Botão de ação -->
                <div class="mt-8">
                    <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="bg-white/20 p-1 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span>Registrar Primeira Vacina</span>
                    </button>
                </div>
                
                <!-- Dica adicional -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-left">
                            <p class="text-sm text-blue-800 font-medium">Dica</p>
                            <p class="text-xs text-blue-700 mt-1">Após registrar a primeira vacina, o sistema gerará automaticamente sugestões baseadas no calendário nacional de vacinação.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Gerar QR Code
document.addEventListener('DOMContentLoaded', function() {
    const urlCarteira = "{{ route('carteira.show', $paciente->id) }}";
    new QRCode(document.getElementById("qrcode"), {
        text: urlCarteira,
        width: 128,
        height: 128,
        colorDark: "#059669",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
});

// Função para copiar link público da carteira
function compartilharCarteira() {
    const urlPublica = "{{ route('carteira.publica', $paciente->token_carteira) }}";
    const nome = "{{ $paciente->nome }}";
    
    navigator.clipboard.writeText(urlPublica).then(() => {
        alert('✅ Link público copiado com sucesso!\n\nCompartilhe com o paciente: ' + nome + '\n\n' + urlPublica + '\n\n🔒 Este link permite visualização pública da carteira sem necessidade de login.');
    }).catch(() => {
        // Fallback para navegadores antigos
        const textarea = document.createElement('textarea');
        textarea.value = urlPublica;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('Link copiado para área de transferência!\n\n' + url);
    });
}

function toggleSugestoes() {
    const sugestoes = document.getElementById('sugestoes');
    const seta = document.getElementById('seta-sugestoes');
    
    if (sugestoes.classList.contains('hidden')) {
        sugestoes.classList.remove('hidden');
        seta.classList.add('rotate-180');
    } else {
        sugestoes.classList.add('hidden');
        seta.classList.remove('rotate-180');
    }
}
</script>
@endsection
