@extends('layouts.tenant-app')

@section('title', 'Formas de Pagamento')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Formas de Pagamento
            </h1>
            <p class="text-gray-600 mt-1">Gerencie as formas de pagamento aceitas</p>
        </div>
        <a href="{{ route('financeiro.formas-pagamento.create') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Forma de Pagamento
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tipos de Pagamento -->
    <div class="space-y-6">
        @php
            $tipoLabels = [
                'dinheiro' => ['label' => '💵 Dinheiro', 'bg' => 'bg-green-50', 'border' => 'border-green-200'],
                'pix' => ['label' => '📱 PIX', 'bg' => 'bg-blue-50', 'border' => 'border-blue-200'],
                'debito' => ['label' => '💳 Débito', 'bg' => 'bg-purple-50', 'border' => 'border-purple-200'],
                'credito' => ['label' => '💎 Crédito', 'bg' => 'bg-indigo-50', 'border' => 'border-indigo-200'],
                'boleto' => ['label' => '📄 Boleto', 'bg' => 'bg-orange-50', 'border' => 'border-orange-200'],
                'transferencia' => ['label' => '🏦 Transferência', 'bg' => 'bg-cyan-50', 'border' => 'border-cyan-200'],
                'outro' => ['label' => '📌 Outros', 'bg' => 'bg-gray-50', 'border' => 'border-gray-200'],
            ];
        @endphp

        @forelse($formasPorTipo as $tipo => $formas)
            <div class="bg-white rounded-lg shadow-sm border {{ $tipoLabels[$tipo]['border'] ?? 'border-gray-200' }} overflow-hidden">
                <div class="px-6 py-4 {{ $tipoLabels[$tipo]['bg'] ?? 'bg-gray-50' }} border-b {{ $tipoLabels[$tipo]['border'] ?? 'border-gray-200' }}">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $tipoLabels[$tipo]['label'] ?? ucfirst($tipo) }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($formas as $forma)
                            <div class="group relative bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg p-4 transition">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 truncate">{{ $forma->nome }}</h4>
                                        
                                        <div class="mt-2 space-y-1">
                                            @if($forma->taxa_percentual > 0)
                                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Taxa: {{ number_format($forma->taxa_percentual, 2, ',', '.') }}%
                                                </p>
                                            @endif
                                            
                                            @if($forma->prazo_recebimento > 0)
                                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    Prazo: {{ $forma->prazo_recebimento }} dias
                                                </p>
                                            @endif
                                            
                                            @if($forma->adquirente)
                                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                    {{ $forma->adquirente }}
                                                </p>
                                            @endif
                                            
                                            @if($forma->requer_conciliacao)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Requer Conciliação
                                                </span>
                                            @endif
                                            
                                            @if(!$forma->ativo)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-800 text-xs rounded-full">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    Inativo
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition flex gap-1">
                                        <a href="{{ route('financeiro.formas-pagamento.edit', $forma) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition" 
                                           title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('financeiro.formas-pagamento.destroy', $forma) }}" method="POST" 
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta forma de pagamento?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-md transition" title="Excluir">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma forma de pagamento cadastrada</h3>
                <p class="text-gray-600 mb-4">Comece criando sua primeira forma de pagamento</p>
                <a href="{{ route('financeiro.formas-pagamento.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Forma de Pagamento
                </a>
            </div>
        @endforelse
    </div>

    <!-- Voltar -->
    <div class="mt-6">
        <a href="{{ route('financeiro.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection
