@extends('layouts.tenant-app')

@section('page-title', 'Campanhas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <span class="text-4xl">🎯</span>
                Campanhas de Vacinação
            </h1>
            <p class="text-gray-600 mt-2">
                Gerencie campanhas sazonais e envie lembretes automáticos para públicos específicos
            </p>
        </div>
        <a href="{{ route('campanhas.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Campanha
        </a>
    </div>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- Aviso Explicativo (apenas se não houver campanhas) --}}
    @if($campanhas->count() === 0)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 mb-8">
        <div class="flex items-start gap-4">
            <div class="bg-blue-500 p-3 rounded-xl flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-900 mb-2">
                    💡 O que são Campanhas de Vacinação?
                </h3>
                <p class="text-blue-800 mb-3 leading-relaxed">
                    Crie campanhas sazonais (como <strong>Influenza 2025</strong> ou <strong>COVID-19 Reforço</strong>) para organizar e personalizar seus agendamentos.
                </p>
                <p class="text-blue-800 text-sm leading-relaxed">
                    <strong>⚠️ Importante:</strong> Campanhas <strong>não disparam mensagens em massa</strong>. Elas apenas personalizam os lembretes automáticos enviados quando os pacientes agendam consultas. Isso mantém sua comunicação profissional, respeita quotas do plano e evita bloqueios do WhatsApp.
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="bg-green-500 p-3 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-700">{{ $ativas->count() }}</div>
                    <div class="text-sm text-green-600">Campanhas Ativas</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="bg-blue-500 p-3 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-700">{{ $futuras->count() }}</div>
                    <div class="text-sm text-blue-600">Agendadas</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="bg-gray-500 p-3 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-700">{{ $encerradas->count() }}</div>
                    <div class="text-sm text-gray-600">Encerradas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Campanhas --}}
    @if($campanhas->count() > 0)
    <div class="space-y-4">
        @foreach($campanhas as $campanha)
        <div class="bg-white rounded-xl border-2 {{ $campanha->estaAtiva() ? 'border-green-200' : 'border-gray-200' }} p-6 hover:shadow-lg transition">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <h3 class="text-xl font-bold text-gray-900">{{ $campanha->nome }}</h3>
                        
                        {{-- Status Badge --}}
                        @if($campanha->estaAtiva())
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold rounded-full shadow-md">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            ATIVA
                        </span>
                        @elseif(\Carbon\Carbon::parse($campanha->data_inicio)->isFuture())
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-bold rounded-full shadow-md">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            AGENDADA
                        </span>
                        @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">
                            ENCERRADA
                        </span>
                        @endif

                        {{-- Prioridade Badge --}}
                        @if($campanha->prioridade === 'alta')
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">
                            🔴 Alta Prioridade
                        </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            <strong>Vacina:</strong> {{ $campanha->vacina }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <strong>Período:</strong> {{ \Carbon\Carbon::parse($campanha->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($campanha->data_fim)->format('d/m/Y') }}
                        </div>
                        @if($campanha->publico_alvo)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <strong>Público:</strong> {{ $campanha->publico_alvo }}
                        </div>
                        @endif
                    </div>

                    @if($campanha->descricao)
                    <p class="text-sm text-gray-600 line-clamp-2">{{ $campanha->descricao }}</p>
                    @endif
                </div>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('campanhas.edit', $campanha) }}" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium text-center">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('campanhas.toggle', $campanha) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 {{ $campanha->ativa ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg transition text-sm font-medium">
                            {{ $campanha->ativa ? '⏸️ Pausar' : '▶️ Ativar' }}
                        </button>
                    </form>
                    <form action="{{ route('campanhas.destroy', $campanha) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta campanha?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                            🗑️ Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    {{-- Estado Vazio --}}
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full mb-6">
            <span class="text-5xl">🎯</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">
            Nenhuma Campanha Criada
        </h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Crie campanhas sazonais para enviar lembretes automáticos para públicos específicos, como Influenza para idosos ou COVID-19 para todos.
        </p>
        <a href="{{ route('campanhas.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Criar Primeira Campanha
        </a>
    </div>
    @endif

</div>
@endsection
