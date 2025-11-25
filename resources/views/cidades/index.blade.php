@extends('layouts.tenant-app')

@section('title', 'Cidades - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Cidades')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Cidades Atendidas
                    </h1>
                    <p class="text-gray-600 mt-1">Gerencie as localidades onde a MultiImune atua</p>
                </div>
            </div>
        </div>
        <a href="{{ route('cidades.create') }}" 
           class="flex items-center gap-2 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Cidade
        </a>
    </div>
</div>

<!-- Grid de Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($cidades as $cidade)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
            <!-- Header do Card -->
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-white">{{ $cidade->nome }}</h3>
                    </div>
                    <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $cidade->uf }}
                    </span>
                </div>
            </div>
            
            <!-- Corpo do Card -->
            <div class="p-6">
                <!-- Status -->
                <div class="mb-4">
                    @if($cidade->ativo)
                        <div class="flex items-center gap-2 text-sm">
                            <div class="bg-green-500 rounded-full w-2 h-2 animate-pulse"></div>
                            <span class="text-green-700 font-semibold">Atendimento Ativo</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-sm">
                            <div class="bg-gray-400 rounded-full w-2 h-2"></div>
                            <span class="text-gray-600 font-semibold">Inativa</span>
                        </div>
                    @endif
                </div>

                <!-- Informações -->
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-xl mb-4 border border-teal-100">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <span class="font-medium">{{ $cidade->nome }} / {{ $cidade->uf }}</span>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex gap-2">
                    <a href="{{ route('cidades.show', $cidade) }}" 
                       class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('cidades.edit', $cidade) }}" 
                       class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white shadow-xl rounded-2xl p-12 text-center border border-gray-100">
                <!-- Ilustração SVG -->
                <svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto mb-6 opacity-50">
                    <defs>
                        <linearGradient id="cityGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#14b8a6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Prédios -->
                    <rect x="30" y="100" width="30" height="80" fill="url(#cityGrad)" opacity="0.3"/>
                    <rect x="70" y="80" width="35" height="100" fill="url(#cityGrad)" opacity="0.5"/>
                    <rect x="115" y="90" width="30" height="90" fill="url(#cityGrad)" opacity="0.4"/>
                    <rect x="155" y="70" width="25" height="110" fill="url(#cityGrad)" opacity="0.6"/>
                    <!-- Janelas -->
                    <rect x="35" y="110" width="5" height="5" fill="white"/>
                    <rect x="45" y="110" width="5" height="5" fill="white"/>
                    <rect x="75" y="90" width="5" height="5" fill="white"/>
                    <rect x="85" y="90" width="5" height="5" fill="white"/>
                    <rect x="95" y="90" width="5" height="5" fill="white"/>
                </svg>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Nenhuma Cidade Cadastrada</h3>
                <p class="text-gray-600 mb-6">Comece adicionando as cidades onde sua clínica atende pacientes</p>
                
                <a href="{{ route('cidades.create') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Cadastrar Primeira Cidade
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginação -->
@if($cidades->hasPages())
    <div class="mt-8">
        {{ $cidades->links() }}
    </div>
@endif
@endsection

