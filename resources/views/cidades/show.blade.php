@extends('layouts.app')

@section('title', 'Detalhes da Cidade - MultiImune')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ $cidade->nome }}
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $cidade->uf }} • Detalhes da Cidade</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cidades.edit', $cidade) }}" 
               class="flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <a href="{{ route('cidades.index') }}" 
               class="flex items-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                ← Voltar
            </a>
        </div>
    </div>
</div>

<!-- Layout 2 Colunas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Coluna Principal (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Card de Informações Principais -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <!-- Header do Card -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informações da Localidade
                </h2>
            </div>

            <!-- Corpo do Card -->
            <div class="p-8 space-y-6">
                <!-- Nome da Cidade -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-xl border border-blue-100">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Cidade</label>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $cidade->nome }}</p>
                </div>

                <!-- Estado (UF) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-cyan-50 to-teal-50 p-6 rounded-xl border border-cyan-200">
                        <div class="flex items-start gap-4">
                            <div class="bg-cyan-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Estado</label>
                                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $cidade->uf }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Localização Completa -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Localização</label>
                                <p class="text-lg font-semibold text-gray-800 mt-1">{{ $cidade->nome }}, {{ $cidade->uf }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Estatísticas (Placeholder) -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Informações de Atendimento
                </h2>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pacientes -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-xl border border-blue-200 text-center">
                        <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 mb-1">-</p>
                        <p class="text-sm text-gray-600">Pacientes</p>
                    </div>

                    <!-- Atendimentos -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200 text-center">
                        <div class="bg-purple-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-purple-600 mb-1">-</p>
                        <p class="text-sm text-gray-600">Atendimentos</p>
                    </div>

                    <!-- Vacinas Aplicadas -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200 text-center">
                        <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-green-600 mb-1">-</p>
                        <p class="text-sm text-gray-600">Vacinas</p>
                    </div>
                </div>

                <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <p class="text-sm text-amber-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Estatísticas detalhadas serão implementadas em breve
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Coluna Lateral (1/3) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Card de Status -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status
                </h3>
            </div>
            <div class="p-6">
                @if($cidade->ativo)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border-2 border-green-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-500 rounded-full p-2 animate-pulse">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-700 text-lg">ATIVA</p>
                                <p class="text-xs text-green-600">Disponível para atendimento</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-red-50 to-rose-50 p-5 rounded-xl border-2 border-red-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-500 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-red-700 text-lg">INATIVA</p>
                                <p class="text-xs text-red-600">Não disponível</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Card de Ações Rápidas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Ações Rápidas
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('cidades.edit', $cidade) }}" 
                   class="flex items-center gap-3 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 hover:from-yellow-100 hover:to-orange-100 rounded-xl border border-yellow-200 transition duration-300 group">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-2 rounded-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Editar Cidade</p>
                        <p class="text-xs text-gray-600">Alterar informações</p>
                    </div>
                </a>

                <a href="{{ route('cidades.index') }}" 
                   class="flex items-center gap-3 p-4 bg-gradient-to-r from-gray-50 to-slate-50 hover:from-gray-100 hover:to-slate-100 rounded-xl border border-gray-200 transition duration-300 group">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 p-2 rounded-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Ver Todas</p>
                        <p class="text-xs text-gray-600">Voltar à listagem</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Ilustração -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <svg viewBox="0 0 200 200" class="w-full h-auto">
                <defs>
                    <linearGradient id="showCity" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Skyline da Cidade -->
                <rect x="20" y="120" width="25" height="60" rx="2" fill="url(#showCity)" opacity="0.4"/>
                <rect x="50" y="100" width="30" height="80" rx="2" fill="url(#showCity)" opacity="0.6"/>
                <rect x="85" y="110" width="25" height="70" rx="2" fill="url(#showCity)" opacity="0.5"/>
                <rect x="115" y="90" width="35" height="90" rx="2" fill="url(#showCity)" opacity="0.7"/>
                <rect x="155" y="105" width="25" height="75" rx="2" fill="url(#showCity)" opacity="0.5"/>
                
                <!-- Janelas -->
                <rect x="25" y="130" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="33" y="130" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="25" y="140" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="33" y="140" width="4" height="4" fill="white" opacity="0.8"/>
                
                <rect x="55" y="110" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="63" y="110" width="4" height="4" fill="white" opacity="0.8"/>
                <rect x="71" y="110" width="4" height="4" fill="white" opacity="0.8"/>
                
                <!-- Pin de Localização Grande -->
                <path d="M85 30 L85 10 Q85 0 100 0 Q115 0 115 10 L115 30 Q110 45 100 65 Q90 45 85 30" 
                      fill="#ef4444" stroke="#dc2626" stroke-width="2.5"/>
                <circle cx="100" cy="15" r="8" fill="white"/>
                
                <!-- Estrelas/Pontos -->
                <circle cx="30" cy="30" r="2" fill="#fbbf24" opacity="0.6"/>
                <circle cx="170" cy="40" r="2" fill="#fbbf24" opacity="0.6"/>
                <circle cx="150" cy="20" r="2" fill="#fbbf24" opacity="0.6"/>
            </svg>
        </div>
    </div>
</div>
@endsection
