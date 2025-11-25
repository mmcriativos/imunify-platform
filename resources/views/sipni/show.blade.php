@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Cabeçalho -->
    <div class="mb-8">
        <a href="{{ route('sipni.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Voltar para Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Detalhes da Exportação #{{ $export->id }}</h1>
    </div>

    <!-- Status -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Status</h2>
            @if($export->status == 'enviado')
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                    ✓ Enviado com Sucesso
                </span>
            @elseif($export->status == 'pendente')
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                    ⏳ Pendente
                </span>
            @else
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                    ✗ {{ ucfirst($export->status) }}
                </span>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-600">Data de Criação:</span>
                <p class="font-medium">{{ $export->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            @if($export->data_envio)
            <div>
                <span class="text-sm text-gray-600">Data de Envio:</span>
                <p class="font-medium">{{ $export->data_envio->format('d/m/Y H:i:s') }}</p>
            </div>
            @endif
            <div>
                <span class="text-sm text-gray-600">Tentativas:</span>
                <p class="font-medium">{{ $export->tentativas }}</p>
            </div>
            @if($export->protocolo_sipni)
            <div>
                <span class="text-sm text-gray-600">Protocolo SIPNI:</span>
                <p class="font-medium">{{ $export->protocolo_sipni }}</p>
            </div>
            @endif
        </div>

        @if($export->erro_mensagem)
        <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
            <p class="text-sm font-semibold text-red-800">Erro:</p>
            <p class="text-sm text-red-700">{{ $export->erro_mensagem }}</p>
        </div>
        @endif
    </div>

    <!-- Dados do Paciente -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Dados do Paciente</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-600">Nome:</span>
                <p class="font-medium">{{ $export->paciente->nome }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">CPF:</span>
                <p class="font-medium">{{ $export->paciente->cpf ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">CNS:</span>
                <p class="font-medium">{{ $export->paciente->cns ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Data de Nascimento:</span>
                <p class="font-medium">{{ $export->paciente->data_nascimento?->format('d/m/Y') ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Nome da Mãe:</span>
                <p class="font-medium">{{ $export->paciente->nome_mae ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Sexo:</span>
                <p class="font-medium">{{ $export->paciente->sexo ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Dados da Vacinação -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Dados da Vacinação</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-600">Vacina:</span>
                <p class="font-medium">{{ $export->vacina->nome }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Código SIPNI:</span>
                <p class="font-medium">{{ $export->vacina->codigo_sipni ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Lote:</span>
                <p class="font-medium">{{ $export->atendimentoVacina->lote ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Validade:</span>
                <p class="font-medium">{{ $export->atendimentoVacina->validade ?? '-' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Data de Aplicação:</span>
                <p class="font-medium">{{ $export->atendimento->data->format('d/m/Y') }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Profissional:</span>
                <p class="font-medium">{{ $export->usuario->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Payload Enviado -->
    @if($export->payload)
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Payload Enviado</h2>
        <pre class="bg-gray-50 p-4 rounded-lg overflow-x-auto text-sm"><code>{{ json_encode($export->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
    </div>
    @endif

    <!-- Ações -->
    @if($export->podeRetentar())
    <div class="mt-6">
        <form action="{{ route('sipni.retry', $export) }}" method="POST">
            @csrf
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                🔄 Reenviar para SIPNI
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
