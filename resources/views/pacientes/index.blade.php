@extends('layouts.tenant-app')

@section('title', 'Pacientes - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Pacientes')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                        Pacientes
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $pacientes->total() }} paciente(s) cadastrado(s)</p>
                </div>
            </div>
        </div>
        <a href="{{ route('pacientes.create') }}" 
           class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Paciente
        </a>
    </div>
</div>

<!-- Filtros de Busca -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
    <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filtros e Busca
        </h2>
    </div>
    
    <form method="GET" action="{{ route('pacientes.index') }}" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Campo de Busca -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar Paciente
                    </span>
                </label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Nome, CPF, telefone, e-mail ou código..."
                       class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition duration-200">
            </div>

            <!-- Filtro por Cidade -->
            <div>
                <label for="cidade_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Cidade
                    </span>
                </label>
                <select name="cidade_id" id="cidade_id"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition duration-200">
                    <option value="">Todas</option>
                    @foreach($cidades as $cidade)
                        <option value="{{ $cidade->id }}" {{ request('cidade_id') == $cidade->id ? 'selected' : '' }}>
                            {{ $cidade->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Tipo -->
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Tipo
                    </span>
                </label>
                <select name="tipo" id="tipo"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition duration-200">
                    <option value="">Todos</option>
                    <option value="adulto" {{ request('tipo') == 'adulto' ? 'selected' : '' }}>Adultos</option>
                    <option value="menor" {{ request('tipo') == 'menor' ? 'selected' : '' }}>Menores de Idade</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="submit" 
                    class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Buscar
            </button>
            <a href="{{ route('pacientes.index') }}" 
               class="flex items-center gap-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Limpar Filtros
            </a>
        </div>
    </form>
</div>

<!-- Card da Tabela -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <!-- Header da Tabela -->
    <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Lista de Pacientes Cadastrados
        </h2>
    </div>

    <!-- Tabela -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <a href="{{ route('pacientes.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2 hover:text-pink-600 transition group">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Código
                            @if(request('sort') == 'id')
                                <svg class="w-4 h-4 {{ request('direction') == 'asc' ? 'rotate-0' : 'rotate-180' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <a href="{{ route('pacientes.index', array_merge(request()->all(), ['sort' => 'nome', 'direction' => request('sort') == 'nome' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2 hover:text-pink-600 transition group">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nome
                            @if(request('sort') == 'nome' || !request('sort'))
                                <svg class="w-4 h-4 {{ request('direction') == 'desc' ? 'rotate-180' : 'rotate-0' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <a href="{{ route('pacientes.index', array_merge(request()->all(), ['sort' => 'cpf', 'direction' => request('sort') == 'cpf' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2 hover:text-pink-600 transition group">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            CPF
                            @if(request('sort') == 'cpf')
                                <svg class="w-4 h-4 {{ request('direction') == 'asc' ? 'rotate-0' : 'rotate-180' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <a href="{{ route('pacientes.index', array_merge(request()->all(), ['sort' => 'telefone', 'direction' => request('sort') == 'telefone' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2 hover:text-pink-600 transition group">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Telefone
                            @if(request('sort') == 'telefone')
                                <svg class="w-4 h-4 {{ request('direction') == 'asc' ? 'rotate-0' : 'rotate-180' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Cidade
                        </div>
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Ações
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($pacientes as $paciente)
                    <tr class="hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    #{{ str_pad($paciente->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-gradient-to-br from-pink-100 to-rose-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $paciente->nome }}</p>
                                    @if($paciente->data_nascimento)
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($paciente->data_nascimento)->age }} anos
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($paciente->cpf)
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-medium">
                                    {{ $paciente->cpf }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">Não informado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($paciente->telefone)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-gray-700 font-medium">{{ $paciente->telefone }}</span>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Não informado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($paciente->cidade)
                                <div class="flex items-center gap-2">
                                    <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-lg text-sm font-medium">
                                        {{ $paciente->cidade }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Não informado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pacientes.show', $paciente) }}" 
                                   class="flex items-center gap-1 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-3 py-2 rounded-lg transition duration-300 transform hover:scale-105 text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver
                                </a>
                                <a href="{{ route('pacientes.edit', $paciente) }}" 
                                   class="flex items-center gap-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white px-3 py-2 rounded-lg transition duration-300 transform hover:scale-105 text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16">
                            <div class="text-center">
                                <!-- Ilustração SVG -->
                                <svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto mb-6 opacity-50">
                                    <defs>
                                        <linearGradient id="patientEmpty" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#ec4899;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#f43f5e;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <!-- Pessoas -->
                                    <circle cx="70" cy="60" r="20" fill="url(#patientEmpty)" opacity="0.3"/>
                                    <path d="M 50 90 Q 50 75 70 75 Q 90 75 90 90 L 90 110 L 50 110 Z" fill="url(#patientEmpty)" opacity="0.3"/>
                                    
                                    <circle cx="130" cy="70" r="25" fill="url(#patientEmpty)" opacity="0.5"/>
                                    <path d="M 100 105 Q 100 85 130 85 Q 160 85 160 105 L 160 130 L 100 130 Z" fill="url(#patientEmpty)" opacity="0.5"/>
                                    
                                    <!-- Plus -->
                                    <circle cx="100" cy="140" r="25" fill="#10b981" opacity="0.3"/>
                                    <line x1="100" y1="130" x2="100" y2="150" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                    <line x1="90" y1="140" x2="110" y2="140" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                                
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Nenhum Paciente Cadastrado</h3>
                                <p class="text-gray-600 mb-6">Comece adicionando o primeiro paciente ao sistema</p>
                                
                                <a href="{{ route('pacientes.create') }}" 
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Cadastrar Primeiro Paciente
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($pacientes->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $pacientes->links() }}
        </div>
    @endif
</div>
@endsection

