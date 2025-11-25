@extends('layouts.tenant-app')

@section('title', 'Confirmações de Presença - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Confirmações de Presença')

@section('content')
<!-- Header Compacto -->
<div class="mb-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-3 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Confirmações de Presença
                </h1>
                <p class="text-sm text-gray-600">Respostas dos pacientes via WhatsApp</p>
            </div>
        </div>
        
        <!-- Filtros de Período -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-3">
            <div class="flex flex-wrap gap-2">
                <button onclick="mudarPeriodo('hoje')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $periodo == 'hoje' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Hoje
                </button>
                <button onclick="mudarPeriodo('7dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $periodo == '7dias' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    7 dias
                </button>
                <button onclick="mudarPeriodo('15dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $periodo == '15dias' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    15 dias
                </button>
                <button onclick="mudarPeriodo('30dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $periodo == '30dias' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    30 dias
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas Compactos -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card Total Enviados -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-xs font-semibold uppercase mb-1">Total Enviados</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($kpis['total']) }}</p>
                    <p class="text-blue-100 text-xs mt-1">solicitações</p>
                </div>
                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Confirmados -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-emerald-100 text-xs font-semibold uppercase mb-1">Confirmados</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($kpis['confirmados']) }}</p>
                    <p class="text-emerald-100 text-xs mt-1">Taxa: {{ $kpis['taxa_confirmacao'] }}%</p>
                </div>
                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Pendentes -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-amber-100 text-xs font-semibold uppercase mb-1">Pendentes</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($kpis['pendentes']) }}</p>
                    <p class="text-amber-100 text-xs mt-1">aguardando</p>
                </div>
                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Taxa de Resposta -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-xs font-semibold uppercase mb-1">Taxa de Resposta</p>
                    <p class="text-3xl font-bold text-white">{{ $kpis['taxa_resposta'] }}%</p>
                    <p class="text-purple-100 text-xs mt-1">Cancelados: {{ number_format($kpis['cancelados']) }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agendamentos Próximos (Hoje e Amanhã) -->
@if($agendamentosProximos->count() > 0)
<div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-5 py-3 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-white">Agendamentos Próximos (Hoje e Amanhã)</h3>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data/Hora</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Confirmação</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($agendamentosProximos as $agendamento)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900">{{ $agendamento->paciente->nome }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $agendamento->data_inicio->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $agendamento->data_inicio->format('H:i') }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $agendamento->paciente->telefone }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'agendado' => 'bg-blue-100 text-blue-800',
                                'confirmado' => 'bg-emerald-100 text-emerald-800',
                                'cancelado' => 'bg-red-100 text-red-800',
                                'concluido' => 'bg-gray-100 text-gray-800',
                            ];
                            $color = $statusColors[$agendamento->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($agendamento->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($agendamento->confirmacaoPresenca)
                            @php
                                $confirmacaoColors = [
                                    'pendente' => ['bg-amber-100 text-amber-800', '⏳ Pendente'],
                                    'confirmado' => ['bg-emerald-100 text-emerald-800', '✅ Confirmado'],
                                    'cancelado' => ['bg-red-100 text-red-800', '❌ Cancelado'],
                                ];
                                $conf = $confirmacaoColors[$agendamento->confirmacaoPresenca->status] ?? ['bg-gray-100 text-gray-800', $agendamento->confirmacaoPresenca->status];
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $conf[0] }}">
                                {{ $conf[1] }}
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                Não enviado
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        @if($agendamento->confirmacaoPresenca && $agendamento->confirmacaoPresenca->status === 'pendente')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('confirmacoes.confirmar', $agendamento->confirmacaoPresenca->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-semibold text-xs">
                                        ✓ Confirmar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('confirmacoes.cancelar', $agendamento->confirmacaoPresenca->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs">
                                        ✗ Cancelar
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Tabela de Últimas Confirmações -->
<div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800">Histórico de Confirmações</h3>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Envio</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agendamento</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Respondido</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ultimasConfirmacoes as $confirmacao)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $confirmacao->enviado_em->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $confirmacao->enviado_em->format('H:i:s') }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900">{{ $confirmacao->paciente->nome ?? 'N/A' }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $confirmacao->telefone }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($confirmacao->agendamento)
                            <div class="text-sm text-gray-900">{{ $confirmacao->agendamento->data_inicio->format('d/m/Y H:i') }}</div>
                        @else
                            <span class="text-sm text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @php
                            $statusBadges = [
                                'pendente' => ['bg-amber-100 text-amber-800', '⏳ Pendente'],
                                'confirmado' => ['bg-emerald-100 text-emerald-800', '✅ Confirmado'],
                                'cancelado' => ['bg-red-100 text-red-800', '❌ Cancelado'],
                            ];
                            $badge = $statusBadges[$confirmacao->status] ?? ['bg-gray-100 text-gray-800', $confirmacao->status];
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $badge[0] }}">
                            {{ $badge[1] }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($confirmacao->respondido_em)
                            <div class="text-sm text-gray-900">{{ $confirmacao->respondido_em->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $confirmacao->respondido_em->format('H:i:s') }}</div>
                        @else
                            <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <p class="text-gray-500 font-medium text-sm">Nenhuma confirmação registrada ainda</p>
                            <p class="text-xs text-gray-400">As confirmações aparecerão aqui automaticamente</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-xl animate-bounce">
    {{ session('success') }}
</div>
@endif

@endsection

@push('scripts')
<script>
    function mudarPeriodo(periodo) {
        window.location.href = `?periodo=${periodo}`;
    }
    
    // Auto-hide success message
    setTimeout(() => {
        const alert = document.querySelector('.animate-bounce');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000);
</script>
@endpush
