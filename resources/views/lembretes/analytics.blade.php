@extends('layouts.app')

@section('title', 'Analytics - Lembretes WhatsApp')

@section('content')
<!-- Header com Gradiente -->
<div class="mb-6 sm:mb-8">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-2.5 sm:p-3 rounded-xl shadow-lg flex-shrink-0">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                    Analytics - Lembretes WhatsApp
                </h1>
                <p class="text-sm sm:text-base text-gray-600 mt-0.5 sm:mt-1">Análise de envios e performance dos lembretes automáticos</p>
            </div>
        </div>
        
        <!-- Filtros de Período -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-3 sm:p-4">
            <div class="flex flex-wrap gap-2">
                <button onclick="mudarPeriodo('hoje')" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == 'hoje' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Hoje
                </button>
                <button onclick="mudarPeriodo('7dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == '7dias' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    7 dias
                </button>
                <button onclick="mudarPeriodo('15dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == '15dias' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    15 dias
                </button>
                <button onclick="mudarPeriodo('30dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == '30dias' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    30 dias
                </button>
                <button onclick="mudarPeriodo('90dias')" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == '90dias' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    90 dias
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas Premium -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Total Enviados -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105">
        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide mb-2">Total Enviados</p>
                    <p class="text-5xl font-bold text-white">{{ number_format($kpis['total']) }}</p>
                    <p class="text-blue-100 text-sm mt-2">mensagens no período</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Taxa de Sucesso -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wide mb-2">Taxa de Sucesso</p>
                    <p class="text-5xl font-bold text-white">{{ $kpis['taxa_sucesso'] }}%</p>
                    <p class="text-emerald-100 text-sm mt-2">{{ number_format($kpis['sucessos']) }} de {{ number_format($kpis['total']) }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Enviados Hoje -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105">
        <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide mb-2">Enviados Hoje</p>
                    <p class="text-5xl font-bold text-white">{{ number_format($kpis['hoje']) }}</p>
                    <p class="text-purple-100 text-sm mt-2">lembretes de hoje</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Esta Semana -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 transform transition duration-300 hover:scale-105">
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-amber-100 text-sm font-semibold uppercase tracking-wide mb-2">Esta Semana</p>
                    <p class="text-5xl font-bold text-white">{{ number_format($kpis['semana']) }}</p>
                    <p class="text-amber-100 text-sm mt-2">Mês: {{ number_format($kpis['mes']) }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Gráfico Temporal (2/3) -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Envios ao Longo do Tempo</h3>
            </div>
            <canvas id="graficoTemporal" height="80"></canvas>
        </div>
    </div>

    <!-- Gráfico Taxa de Sucesso (1/3) -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Taxa de Sucesso</h3>
            </div>
            <canvas id="graficoTaxaSucesso"></canvas>
        </div>
    </div>
</div>

<!-- Gráfico Por Tipo -->
<div class="mb-8">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Lembretes por Tipo</h3>
        </div>
        <canvas id="graficoPorTipo" height="60"></canvas>
    </div>
</div>

<!-- Tabela de Últimos Envios -->
<div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Últimos 20 Envios</h3>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paciente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ultimosEnvios as $envio)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $envio->enviado_em->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $envio->enviado_em->format('H:i:s') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $envio->paciente->nome ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $envio->telefone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $badges = [
                                '7dias' => ['bg-blue-100 text-blue-800', '7 dias antes'],
                                '1dia' => ['bg-amber-100 text-amber-800', '1 dia antes'],
                                'hoje' => ['bg-purple-100 text-purple-800', 'No dia'],
                                'atrasado' => ['bg-red-100 text-red-800', 'Atrasado'],
                            ];
                            $badge = $badges[$envio->tipo] ?? ['bg-gray-100 text-gray-800', $envio->tipo];
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge[0] }}">
                            {{ $badge[1] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($envio->sucesso)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                ✓ Sucesso
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="{{ $envio->erro }}">
                                ✗ Falha
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick='verMensagem(@json($envio->id))' 
                                class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Ver
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 font-medium">Nenhum lembrete enviado ainda</p>
                            <p class="text-sm text-gray-400">Os envios aparecerão aqui automaticamente</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ver Mensagem -->
<div id="modalMensagem" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-2xl bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-bold text-gray-900">Mensagem Enviada</h3>
            <button onclick="fecharModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="conteudoMensagem" class="mt-4">
            <div class="flex justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Dados dos gráficos
    const dadosTemporal = @json($graficoTemporal);
    const dadosPorTipo = @json($graficoPorTipo);
    const dadosTaxaSucesso = @json($graficoTaxaSucesso);
    const ultimosEnvios = @json($ultimosEnvios);

    // Gráfico Temporal (Linha)
    const ctxTemporal = document.getElementById('graficoTemporal').getContext('2d');
    new Chart(ctxTemporal, {
        type: 'line',
        data: {
            labels: dadosTemporal.labels,
            datasets: [
                {
                    label: 'Total',
                    data: dadosTemporal.total,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Sucessos',
                    data: dadosTemporal.sucessos,
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Falhas',
                    data: dadosTemporal.falhas,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico Taxa de Sucesso (Pizza)
    const ctxTaxa = document.getElementById('graficoTaxaSucesso').getContext('2d');
    new Chart(ctxTaxa, {
        type: 'doughnut',
        data: {
            labels: dadosTaxaSucesso.labels,
            datasets: [{
                data: dadosTaxaSucesso.valores,
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            }
        }
    });

    // Gráfico Por Tipo (Barras)
    const ctxTipo = document.getElementById('graficoPorTipo').getContext('2d');
    new Chart(ctxTipo, {
        type: 'bar',
        data: {
            labels: dadosPorTipo.labels,
            datasets: [{
                label: 'Quantidade',
                data: dadosPorTipo.valores,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 0,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Função para mudar período
    function mudarPeriodo(periodo) {
        window.location.href = `?periodo=${periodo}`;
    }

    // Função para ver mensagem
    function verMensagem(id) {
        const envio = ultimosEnvios.find(e => e.id === id);
        
        if (envio) {
            document.getElementById('conteudoMensagem').innerHTML = `
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Paciente</p>
                                <p class="font-semibold text-gray-900">${envio.paciente.nome}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Telefone</p>
                                <p class="font-semibold text-gray-900">${envio.telefone}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tipo</p>
                                <p class="font-semibold text-gray-900">${envio.tipo}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Enviado em</p>
                                <p class="font-semibold text-gray-900">${new Date(envio.enviado_em).toLocaleString('pt-BR')}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Mensagem:</p>
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg p-4 border border-blue-200">
                            <pre class="whitespace-pre-wrap text-sm text-gray-800 font-sans">${envio.mensagem}</pre>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('modalMensagem').classList.remove('hidden');
        }
    }

    // Função para fechar modal
    function fecharModal() {
        document.getElementById('modalMensagem').classList.add('hidden');
    }

    // Fechar modal ao clicar fora
    document.getElementById('modalMensagem').addEventListener('click', function(e) {
        if (e.target === this) {
            fecharModal();
        }
    });
</script>
@endpush
