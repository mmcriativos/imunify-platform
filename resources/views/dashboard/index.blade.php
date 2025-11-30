@extends('layouts.tenant-app')

@section('title', 'Dashboard - Imunify')
@section('page-title', 'Dashboard')

@section('content')
@php
    $meses = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];
    
    // Verificar status do trial
    $tenant = tenant();
    $onTrial = $tenant && $tenant->onTrial();
    $trialEndsAt = $tenant?->trial_ends_at;
    $daysRemaining = $trialEndsAt ? now()->diffInDays($trialEndsAt, false) : 0;
    $daysRemaining = max(0, ceil($daysRemaining)); // Arredondar para cima e não deixar negativo
@endphp

<!-- Banner de Trial -->
@if($onTrial)
<div class="mb-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-8 py-6 border-b border-blue-100">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <!-- Conteúdo Principal -->
                <div class="flex items-start gap-5 flex-1">
                    <!-- Ícone -->
                    <div class="hidden sm:flex items-center justify-center w-14 h-14 bg-blue-100 rounded-2xl flex-shrink-0">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Texto -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                🎉 PERÍODO DE TESTE
                            </span>
                            <span class="text-gray-500 text-sm font-medium">
                                Válido até {{ $trialEndsAt->format('d/m/Y') }}
                            </span>
                        </div>
                        <h3 class="text-gray-900 font-bold text-xl sm:text-2xl mb-2">
                            @if($daysRemaining > 1)
                                Restam {{ $daysRemaining }} dias de teste grátis!
                            @elseif($daysRemaining == 1)
                                Último dia de teste grátis!
                            @else
                                Seu período de teste termina hoje!
                            @endif
                        </h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Aproveite todos os recursos premium e escolha o melhor plano para sua clínica.
                        </p>
                    </div>
                </div>
                
                <!-- Botões de Ação -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <a href="#" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[#3ebddb] to-[#77ca73] text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Ver Planos
                    </a>
                    <button type="button" 
                            onclick="this.closest('.mb-6').style.display='none'" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all whitespace-nowrap">
                        Lembrar depois
                    </button>
                </div>
            </div>
            
            <!-- Barra de Progresso -->
            @php
                $totalDays = 7; // Trial de 7 dias
                $progressPercent = min(100, max(0, (($totalDays - $daysRemaining) / $totalDays) * 100));
            @endphp
            <div class="mt-5 bg-gray-200 rounded-full h-2.5 overflow-hidden">
                <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] h-full rounded-full transition-all duration-1000" 
                     style="width: {{ $progressPercent }}%">
                </div>
            </div>
            <div class="flex justify-between items-center mt-2">
                <p class="text-gray-500 text-xs font-medium">
                    {{ number_format($progressPercent, 0) }}% do período utilizado
                </p>
                <p class="text-gray-700 text-xs font-semibold">
                    {{ $daysRemaining }} de {{ $totalDays }} dias restantes
                </p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Filtros e Resumo do Período -->
<div class="bg-white shadow-lg rounded-2xl border border-gray-100 mb-6">
    <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] px-6 py-4 rounded-t-2xl">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <!-- Título e Stats Rápidos -->
            <div class="flex-1">
                <h2 class="text-2xl font-black text-white flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $meses[$mesAtual] ?? 'Novembro' }} de {{ $anoAtual }}
                </h2>
                
                <!-- Stats Rápidos -->
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2 flex items-center gap-2">
                        <div class="bg-[#77ca73]/40 p-1.5 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Atendimentos</p>
                            <p class="text-white text-lg font-bold">{{ $atendimentosMes }}</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2 flex items-center gap-2">
                        <div class="bg-[#3ebddb]/40 p-1.5 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Pacientes</p>
                            <p class="text-white text-lg font-bold">{{ $pacientesAtendidos }}</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2 flex items-center gap-2">
                        <div class="bg-white/30 p-1.5 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Faturamento</p>
                            <p class="text-white text-lg font-bold">R$ {{ number_format($faturamentoMes, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="lg:text-right">
                <p class="text-white/90 text-xs font-semibold uppercase tracking-wider mb-3">Período de Análise</p>
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row gap-3">
                        <!-- Select Mês Moderno -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-[#3ebddb]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <select name="mes" id="mes" 
                                    class="bg-white/95 backdrop-blur-sm border-2 border-white/40 text-gray-900 rounded-xl pl-10 pr-10 py-3 font-semibold text-sm shadow-lg hover:bg-white hover:border-[#3ebddb] focus:border-[#3ebddb] focus:ring-4 focus:ring-[#3ebddb]/20 transition-all cursor-pointer appearance-none"
                                    onchange="this.form.submit()">
                                @php
                                    $meses = [
                                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 
                                        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 
                                        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                                    ];
                                @endphp
                                @foreach($meses as $num => $nome)
                                    <option value="{{ $num }}" {{ $mesAtual == $num ? 'selected' : '' }}>{{ $nome }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Select Ano Moderno -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-[#77ca73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <select name="ano" id="ano" 
                                    class="bg-white/95 backdrop-blur-sm border-2 border-white/40 text-gray-900 rounded-xl pl-10 pr-10 py-3 font-semibold text-sm shadow-lg hover:bg-white hover:border-[#77ca73] focus:border-[#77ca73] focus:ring-4 focus:ring-[#77ca73]/20 transition-all cursor-pointer appearance-none"
                                    onchange="this.form.submit()">
                                @for($ano = now()->year; $ano >= now()->year - 5; $ano--)
                                    <option value="{{ $ano }}" {{ $anoAtual == $ano ? 'selected' : '' }}>{{ $ano }}</option>
                                @endfor
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Botão Atualizar -->
                        <button type="submit" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm border-2 border-white/40 text-white rounded-xl px-6 py-3 font-bold text-sm shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Atualizar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $tenant = tenant();
    $hasCNES = !empty($tenant->cnes);
    $hasCRM = !empty($tenant->crm);
    $needsConfig = !$hasCNES || !$hasCRM;
@endphp

<!-- Alerta de Configuração Premium (apenas se necessário) -->
@if($needsConfig)
<div class="relative mb-8 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-[#3ebddb] to-[#77ca73] opacity-10"></div>
    <div class="relative bg-white border-2 border-[#3ebddb] rounded-2xl shadow-xl overflow-hidden">
        <!-- Barra Superior Colorida com cores Imunify -->
        <div class="h-2 bg-gradient-to-r from-[#3ebddb] via-[#5bc9d4] to-[#77ca73]"></div>
        
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-start gap-4 flex-1">
                    <!-- Ícone Animado -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#3ebddb] rounded-2xl animate-ping opacity-20"></div>
                        <div class="relative bg-gradient-to-br from-[#3ebddb] to-[#77ca73] p-4 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Conteúdo -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="text-xl font-bold text-gray-900">Configuração Pendente</h3>
                            <span class="bg-[#3ebddb]/10 text-[#3ebddb] text-xs font-bold px-2.5 py-1 rounded-full border-2 border-[#3ebddb]">
                                Ação Necessária
                            </span>
                        </div>
                        <p class="text-gray-700 font-medium mb-3">
                            Complete os dados da clínica para liberar todas as funcionalidades
                        </p>
                        
                        <!-- Itens Pendentes -->
                        <div class="flex flex-wrap gap-2">
                            @if(!$hasCNES)
                            <div class="flex items-center gap-1.5 bg-[#3ebddb]/10 border-2 border-[#3ebddb] rounded-lg px-3 py-1.5">
                                <svg class="w-4 h-4 text-[#3ebddb]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="text-sm font-semibold text-[#3ebddb]">CNES</span>
                            </div>
                            @endif
                            @if(!$hasCRM)
                            <div class="flex items-center gap-1.5 bg-[#77ca73]/10 border-2 border-[#77ca73] rounded-lg px-3 py-1.5">
                                <svg class="w-4 h-4 text-[#77ca73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="text-sm font-semibold text-[#77ca73]">CRM</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Botão de Ação -->
                <a href="{{ route('clinic.config') }}" class="group bg-gradient-to-r from-[#3ebddb] to-[#77ca73] hover:from-[#2da8c4] hover:to-[#63b55f] text-white font-bold px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center gap-3 whitespace-nowrap">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Configurar Agora</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Ações Rápidas -->
<div class="bg-white shadow-xl rounded-2xl border border-gray-100 mb-6">
    <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] px-6 py-4 rounded-t-2xl">
        <h2 class="text-xl font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Ações Rápidas
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
            <!-- Novo Atendimento -->
            <a href="{{ route('atendimentos.create') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-[#3ebddb]/10 to-[#5bc9d4]/10 hover:from-[#3ebddb]/20 hover:to-[#5bc9d4]/20 rounded-xl border-2 border-[#3ebddb]/30 hover:border-[#3ebddb] transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-[#3ebddb] to-[#5bc9d4] p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Atendimento</p>
            </a>

            <!-- Novo Paciente -->
            <a href="{{ route('pacientes.create') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-[#77ca73]/10 to-[#63b55f]/10 hover:from-[#77ca73]/20 hover:to-[#63b55f]/20 rounded-xl border-2 border-[#77ca73]/30 hover:border-[#77ca73] transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-[#77ca73] to-[#63b55f] p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Paciente</p>
            </a>

            <!-- Nova Vacina -->
            <a href="{{ route('vacinas.create') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 rounded-xl border-2 border-blue-200 hover:border-blue-400 transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Vacina</p>
            </a>

            <!-- Carteira Digital -->
            <a href="{{ route('carteira.index') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 rounded-xl border-2 border-purple-200 hover:border-purple-400 transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Carteira</p>
            </a>

            <!-- Relatórios -->
            <a href="{{ route('relatorios.mensal') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-violet-50 to-fuchsia-50 hover:from-violet-100 hover:to-fuchsia-100 rounded-xl border-2 border-violet-200 hover:border-violet-400 transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Relatórios</p>
            </a>

            <!-- Agenda -->
            <a href="{{ route('agenda.index') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-yellow-50 to-orange-50 hover:from-yellow-100 hover:to-orange-100 rounded-xl border-2 border-yellow-200 hover:border-yellow-400 transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Agenda</p>
            </a>

            <!-- Confirmações -->
            <a href="{{ route('confirmacoes.index') }}" 
               class="flex flex-col items-center gap-2 p-4 bg-gradient-to-br from-lime-50 to-green-50 hover:from-lime-100 hover:to-green-100 rounded-xl border-2 border-lime-200 hover:border-lime-400 transition-all transform hover:scale-105 group">
                <div class="bg-gradient-to-r from-lime-500 to-green-500 p-3 rounded-xl group-hover:scale-110 group-hover:shadow-lg transition-all shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="font-bold text-gray-800 text-xs text-center">Confirmações</p>
            </a>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas Premium -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Atendimentos -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
        <div class="bg-gradient-to-br from-[#3ebddb] to-[#5bc9d4] p-8">
            <div class="flex flex-col gap-4">
                <!-- Ícone e Título -->
                <div class="flex justify-between items-start">
                    <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Atendimentos</p>
                    <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                        <svg class="w-10 h-10 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Valor -->
                <div>
                    <p class="text-4xl lg:text-6xl font-black text-white drop-shadow-md mb-2">{{ $atendimentosMes }}</p>
                    <p class="text-white text-base font-semibold drop-shadow-sm">realizados este mês</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#3ebddb]/10 to-[#5bc9d4]/10 px-6 py-4">
            <a href="{{ route('atendimentos.index') }}" class="flex items-center justify-between text-[#3ebddb] hover:text-[#2a9fb8] font-bold transition group">
                <span>Ver todos os atendimentos</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Card Pacientes -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
        <div class="bg-gradient-to-br from-[#77ca73] to-[#63b55f] p-8">
            <div class="flex flex-col gap-4">
                <!-- Ícone e Título -->
                <div class="flex justify-between items-start">
                    <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Pacientes</p>
                    <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                        <svg class="w-10 h-10 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <!-- Valor -->
                <div>
                    <p class="text-4xl lg:text-6xl font-black text-white drop-shadow-md mb-2">{{ $pacientesAtendidos }}</p>
                    <p class="text-white text-base font-semibold drop-shadow-sm">atendidos este mês</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#77ca73]/10 to-[#63b55f]/10 px-6 py-4">
            <a href="{{ route('pacientes.index') }}" class="flex items-center justify-between text-[#77ca73] hover:text-[#63b55f] font-bold transition group">
                <span>Ver todos os pacientes</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Card Faturamento -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
        <div class="bg-gradient-to-br from-[#5bc9d4] via-[#3ebddb] to-[#77ca73] p-8">
            <div class="flex flex-col gap-4">
                <!-- Ícone e Título -->
                <div class="flex justify-between items-start">
                    <p class="text-white text-sm font-bold uppercase tracking-wider drop-shadow-sm">Faturamento</p>
                    <div class="bg-white/30 backdrop-blur-md p-3 rounded-2xl shadow-xl border-2 border-white/50">
                        <svg class="w-10 h-10 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Valor -->
                <div>
                    <p class="text-4xl lg:text-5xl font-black text-white drop-shadow-md mb-2 break-words">R$ {{ number_format($faturamentoMes, 2, ',', '.') }}</p>
                    <p class="text-white text-base font-semibold drop-shadow-sm">receita do mês</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#3ebddb]/10 to-[#77ca73]/10 px-6 py-4">
            <a href="{{ route('relatorios.mensal') }}" class="flex items-center justify-between text-[#3ebddb] hover:text-[#2a9fb8] font-bold transition group">
                <span>Ver relatório financeiro</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Atendimentos por Tipo - Largura Total -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-8">
    <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] p-6">
        <h3 class="text-2xl font-black text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Atendimentos por Tipo
        </h3>
    </div>

    <div class="p-6 lg:p-8">
        @if($atendimentosPorTipo->count() > 0)
            @php
                $total = $atendimentosPorTipo->sum('total');
                $cores = [
                    'clinica' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon' => 'text-blue-500'],
                    'domiciliar' => ['bg' => 'bg-green-500', 'text' => 'text-green-700', 'light' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => 'text-green-500']
                ];
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @foreach($atendimentosPorTipo as $tipo)
                    @php
                        $percentual = $total > 0 ? ($tipo->total / $total) * 100 : 0;
                        $cor = $cores[$tipo->tipo] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'light' => 'bg-gray-50', 'border' => 'border-gray-200', 'icon' => 'text-gray-500'];
                    @endphp
                    <div class="relative group">
                        <div class="absolute inset-0 {{ $cor['bg'] }} rounded-2xl opacity-5 group-hover:opacity-10 transition"></div>
                        <div class="relative border-2 {{ $cor['border'] }} rounded-2xl p-6 bg-white group-hover:shadow-xl transition transform group-hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="{{ $cor['light'] }} p-4 rounded-xl border-2 {{ $cor['border'] }}">
                                        <svg class="w-8 h-8 {{ $cor['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($tipo->tipo == 'clinica')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-800 capitalize">{{ $tipo->tipo }}</p>
                                        <p class="text-sm text-gray-500 font-medium">{{ number_format($percentual, 1) }}% do total</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-5xl font-bold {{ $cor['text'] }}">{{ $tipo->total }}</p>
                                </div>
                            </div>
                            <!-- Barra de Progresso -->
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $cor['bg'] }} h-full rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $percentual }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Total Geral -->
            <div class="bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-xl p-5 border-2 border-[#3ebddb]/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-r from-[#3ebddb] to-[#77ca73] p-3 rounded-xl shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 font-bold uppercase tracking-wide">Total de Atendimentos</p>
                            <p class="text-xs text-gray-500 font-medium">Este mês</p>
                        </div>
                    </div>
                    <p class="text-4xl font-black bg-gradient-to-r from-[#3ebddb] to-[#77ca73] bg-clip-text text-transparent">
                        {{ $total }}
                    </p>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-gray-500 font-medium text-lg">Nenhum atendimento este mês</p>
                <p class="text-gray-400 text-sm mt-2">Comece registrando seu primeiro atendimento</p>
            </div>
        @endif
    </div>
</div>



<!-- Últimos Atendimentos -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-[#2a9fb8] to-[#3ebddb] p-6">
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-black text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Atendimentos Recentes
            </h3>
            <a href="{{ route('atendimentos.index') }}" 
               class="flex items-center gap-2 text-white hover:text-gray-200 font-semibold transition group">
                <span>Ver todos</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-blue-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Data</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Paciente</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Local</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Valor</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ultimosAtendimentos as $atendimento)
                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-slate-50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-semibold text-gray-800">{{ $atendimento->data->format('d/m/Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $atendimento->paciente->nome }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($atendimento->tipo == 'clinica')
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-[#3ebddb]/20 to-[#5bc9d4]/20 text-[#3ebddb] border-2 border-[#3ebddb]/40">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Clínica
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-[#77ca73]/20 to-[#63b55f]/20 text-[#77ca73] border-2 border-[#77ca73]/40">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Domiciliar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($atendimento->cidade)
                                <span class="inline-flex items-center gap-1 text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $atendimento->cidade->nome }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">Artur Nogueira</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-lg font-black bg-gradient-to-r from-[#77ca73] to-[#63b55f] bg-clip-text text-transparent">
                                R$ {{ number_format($atendimento->valor_total, 2, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('atendimentos.show', $atendimento) }}" 
                               class="inline-flex items-center gap-1 bg-gradient-to-r from-[#3ebddb] to-[#5bc9d4] hover:from-[#2a9fb8] hover:to-[#3ebddb] text-white font-bold px-4 py-2 rounded-xl transition-all duration-300 transform hover:scale-105 text-sm shadow-md hover:shadow-lg">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16">
                            <div class="text-center">
                                <svg viewBox="0 0 200 200" class="w-32 h-32 mx-auto mb-4 opacity-30">
                                    <defs>
                                        <linearGradient id="emptyDash" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#6366f1;stop-opacity:0.3" />
                                            <stop offset="100%" style="stop-color:#a855f7;stop-opacity:0.3" />
                                        </linearGradient>
                                    </defs>
                                    <rect x="50" y="50" width="100" height="100" rx="10" fill="url(#emptyDash)"/>
                                    <circle cx="100" cy="100" r="30" fill="#e5e7eb"/>
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Nenhum Atendimento Registrado</h3>
                                <p class="text-gray-500 mb-6">Comece registrando o primeiro atendimento do mês</p>
                                <a href="{{ route('atendimentos.create') }}" 
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-[#3ebddb] to-[#77ca73] hover:from-[#2a9fb8] hover:to-[#63b55f] text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Novo Atendimento
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

