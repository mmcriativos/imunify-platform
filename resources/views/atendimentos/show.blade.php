@extends('layouts.tenant-app')

@section('title', 'Detalhes do Atendimento - MultiImune')
@section('page-title', 'Detalhes do Atendimento')

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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card-header-emerald {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.card-header-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.card-header-pink {
    background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
}

.card-header-gray {
    background: linear-gradient(135deg, #6b7280 0%, #374151 100%);
}

.info-card {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.price-highlight {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header Moderno -->
    <div class="bg-white border-b border-gray-200 shadow-sm mb-8">
        <div class="container mx-auto px-6 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="card-header p-4 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold gradient-text">
                            Atendimento #{{ $atendimento->id }}
                        </h1>
                        <p class="text-gray-600 text-lg mt-1">{{ $atendimento->data->format('d/m/Y') }} • Detalhes completos do atendimento</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <a href="{{ route('atendimentos.edit', $atendimento) }}" 
                       class="group bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Atendimento
                    </a>
                    <a href="{{ route('atendimentos.index') }}" 
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
                <!-- Card de Informações do Atendimento -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-emerald p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Informações do Atendimento
                        </h2>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Data -->
                            <div class="info-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Data do Atendimento</label>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $atendimento->data->format('d/m/Y') }}</p>
                                        <p class="text-sm text-blue-600 font-medium">{{ \Carbon\Carbon::parse($atendimento->data)->locale('pt_BR')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo -->
                            <div class="info-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-lg">
                                        @if($atendimento->tipo == 'clinica')
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Tipo de Atendimento</label>
                                        @if($atendimento->tipo == 'clinica')
                                            <p class="text-2xl font-bold text-purple-700 mt-1">🏥 Clínica</p>
                                            <p class="text-sm text-purple-600 font-medium">Atendimento presencial</p>
                                        @else
                                            <p class="text-2xl font-bold text-emerald-700 mt-1">🏠 Domiciliar</p>
                                            <p class="text-sm text-emerald-600 font-medium">Atendimento em casa</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Local para Domiciliar -->
                            @if($atendimento->tipo == 'domiciliar')
                                @if($atendimento->cidade)
                                    <div class="info-card p-6 rounded-2xl lg:col-span-2">
                                        <div class="flex items-center gap-4">
                                            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Local do Atendimento</label>
                                                <p class="text-xl font-bold text-gray-800 mt-1">📍 {{ $atendimento->cidade->nome }} - {{ $atendimento->cidade->uf }}</p>
                                                @if($atendimento->endereco_atendimento)
                                                    <p class="text-gray-600 font-medium mt-2">{{ $atendimento->endereco_atendimento }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Observações -->
                        @if($atendimento->observacoes)
                            <div class="mt-8 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-2xl p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="bg-amber-500 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-amber-800">Observações Importantes</h3>
                                </div>
                                <p class="text-gray-700 text-lg leading-relaxed">{{ $atendimento->observacoes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card de Vacinas Aplicadas -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-purple p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div>
                                <span>Vacinas Aplicadas</span>
                                <span class="bg-white bg-opacity-30 px-3 py-1 rounded-full text-sm font-bold ml-2">{{ $atendimento->vacinas->count() }}</span>
                            </div>
                        </h2>
                    </div>

                    <div class="p-8">
                        <div class="space-y-6">
                            @foreach($atendimento->vacinas as $index => $vacina)
                                <div class="group bg-gradient-to-r from-slate-50 to-gray-50 hover:from-purple-50 hover:to-purple-100 p-6 rounded-2xl border-2 border-gray-200 hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white font-bold w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-800 group-hover:text-purple-800 transition-colors">{{ $vacina->nome }}</h3>
                                            @if($vacina->fabricante)
                                                <p class="text-gray-600 font-medium">{{ $vacina->fabricante }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-2 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
                                            <div class="text-2xl font-bold text-blue-600 mb-1">{{ $vacina->pivot->quantidade }}x</div>
                                            <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Quantidade</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
                                            <div class="text-lg font-bold text-emerald-600 mb-1">R$ {{ number_format($vacina->pivot->valor_unitario, 2, ',', '.') }}</div>
                                            <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Valor Unit.</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
                                            <div class="text-sm font-bold text-gray-800 mb-1">{{ $vacina->pivot->lote ?? 'Não informado' }}</div>
                                            <div class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Lote</div>
                                        </div>
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-xl text-center shadow-lg">
                                            <div class="text-xl font-bold mb-1">R$ {{ number_format($vacina->pivot->valor_total, 2, ',', '.') }}</div>
                                            <div class="text-sm font-semibold uppercase tracking-wide opacity-90">Subtotal</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total Geral -->
                        <div class="mt-8 bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 p-8 rounded-2xl shadow-2xl">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div class="bg-yellow-500 p-3 rounded-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">Valor Total do Atendimento</h3>
                                        <p class="text-gray-300">Soma de todas as vacinas aplicadas</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="price-highlight text-5xl font-black">R$ {{ number_format($atendimento->valor_total, 2, ',', '.') }}</div>
                                    <p class="text-gray-300 text-sm mt-1">Valor final</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral -->
            <div class="xl:col-span-1 space-y-8">
                <!-- Card de Dados do Paciente -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-pink p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            Dados do Paciente
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Nome -->
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-2xl border-2 border-pink-200">
                            <div class="text-center">
                                <div class="bg-gradient-to-r from-pink-500 to-rose-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800">{{ $atendimento->paciente->nome }}</h4>
                                <p class="text-pink-600 font-medium mt-1">Paciente Principal</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if($atendimento->paciente->cpf)
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                    <div class="bg-blue-500 p-2 rounded-lg shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">CPF</label>
                                        <p class="font-bold text-gray-800">{{ $atendimento->paciente->cpf }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($atendimento->paciente->telefone)
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200">
                                    <div class="bg-emerald-500 p-2 rounded-lg shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Telefone</label>
                                        <p class="font-bold text-gray-800">{{ $atendimento->paciente->telefone }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($atendimento->paciente->email)
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                    <div class="bg-purple-500 p-2 rounded-lg shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">E-mail</label>
                                        <p class="font-bold text-gray-800 break-all">{{ $atendimento->paciente->email }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($atendimento->paciente->endereco)
                            <div class="bg-gradient-to-r from-teal-50 to-teal-100 p-6 rounded-2xl border-2 border-teal-200">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-teal-500 p-2 rounded-lg shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-teal-800">Endereço Residencial</h4>
                                </div>
                                <div class="space-y-2 text-gray-700">
                                    <p class="font-semibold">{{ $atendimento->paciente->endereco }}@if($atendimento->paciente->numero), {{ $atendimento->paciente->numero }}@endif</p>
                                    @if($atendimento->paciente->complemento)
                                        <p class="text-gray-600">{{ $atendimento->paciente->complemento }}</p>
                                    @endif
                                    @if($atendimento->paciente->bairro)
                                        <p class="text-gray-800 font-medium">{{ $atendimento->paciente->bairro }}</p>
                                    @endif
                                    @if($atendimento->paciente->cidade)
                                        <p class="text-teal-700 font-bold">{{ $atendimento->paciente->cidade }}</p>
                                    @endif
                                    @if($atendimento->paciente->cep)
                                        <p class="text-gray-600"><span class="font-medium">CEP:</span> {{ $atendimento->paciente->cep }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl shadow-lg overflow-hidden">
                            <a href="{{ route('pacientes.show', $atendimento->paciente) }}" 
                               class="flex items-center justify-center gap-3 text-white font-bold py-4 px-6 transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver Ficha Completa do Paciente
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card de Informações do Registro -->
                <div class="bg-white hover-card rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="card-header-gray p-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Informações do Registro
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                            <div class="bg-blue-500 p-2 rounded-lg shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Registrado em</label>
                                <p class="text-gray-800 font-bold">{{ $atendimento->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-blue-600 text-sm">{{ $atendimento->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        @if($atendimento->usuario)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                <div class="bg-purple-500 p-2 rounded-lg shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Registrado por</label>
                                    <p class="text-gray-800 font-bold">{{ $atendimento->usuario->name }}</p>
                                </div>
                            </div>
                        @endif

                        @if($atendimento->updated_at != $atendimento->created_at)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl border border-amber-200">
                                <div class="bg-amber-500 p-2 rounded-lg shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Última atualização</label>
                                    <p class="text-gray-800 font-bold">{{ $atendimento->updated_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-amber-600 text-sm">{{ $atendimento->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ilustração Moderna -->
                <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-8 rounded-3xl border-2 border-indigo-200 shadow-lg">
                    <div class="text-center mb-6">
                        <h4 class="text-xl font-bold gradient-text">Atendimento Concluído</h4>
                        <p class="text-gray-600 mt-2">Registro completo e detalhado</p>
                    </div>
                    
                    <div class="relative">
                        <svg viewBox="0 0 300 200" class="w-full h-auto">
                            <defs>
                                <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#764ba2;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#f093fb;stop-opacity:1" />
                                </linearGradient>
                                <linearGradient id="checkGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            
                            <!-- Clipboard Background -->
                            <rect x="75" y="30" width="150" height="140" rx="15" fill="url(#mainGradient)" opacity="0.1"/>
                            <rect x="85" y="40" width="130" height="120" rx="10" fill="white" stroke="url(#mainGradient)" stroke-width="3"/>
                            
                            <!-- Header -->
                            <rect x="85" y="40" width="130" height="30" rx="10" fill="url(#mainGradient)" opacity="0.8"/>
                            
                            <!-- Checkmarks -->
                            <circle cx="110" cy="80" r="12" fill="url(#checkGradient)"/>
                            <path d="M 105 80 L 108 83 L 115 75" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                            
                            <circle cx="110" cy="105" r="12" fill="url(#checkGradient)"/>
                            <path d="M 105 105 L 108 108 L 115 100" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                            
                            <circle cx="110" cy="130" r="12" fill="url(#checkGradient)"/>
                            <path d="M 105 130 L 108 133 L 115 125" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                            
                            <!-- Text Lines -->
                            <rect x="130" y="75" width="70" height="8" rx="4" fill="url(#mainGradient)" opacity="0.3"/>
                            <rect x="130" y="100" width="60" height="8" rx="4" fill="url(#mainGradient)" opacity="0.3"/>
                            <rect x="130" y="125" width="75" height="8" rx="4" fill="url(#mainGradient)" opacity="0.3"/>
                            
                            <!-- Floating Icons -->
                            <circle cx="250" cy="60" r="15" fill="url(#checkGradient)" opacity="0.8">
                                <animate attributeName="cy" values="60;55;60" dur="2s" repeatCount="indefinite"/>
                            </circle>
                            <path d="M 245 60 L 248 63 L 255 55" stroke="white" stroke-width="2" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M 245 60 L 248 63 L 255 55;M 245 55 L 248 58 L 255 50;M 245 60 L 248 63 L 255 55" dur="2s" repeatCount="indefinite"/>
                            </path>
                            
                            <circle cx="50" cy="100" r="12" fill="#f59e0b" opacity="0.8">
                                <animate attributeName="cy" values="100;95;100" dur="2.5s" repeatCount="indefinite"/>
                            </circle>
                            <path d="M 45 95 L 50 105 L 55 95" stroke="white" stroke-width="2" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M 45 95 L 50 105 L 55 95;M 45 90 L 50 100 L 55 90;M 45 95 L 50 105 L 55 95" dur="2.5s" repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 font-bold py-2 px-4 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Atendimento Finalizado
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

