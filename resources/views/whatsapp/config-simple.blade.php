@extends('layouts.app')

@section('title', 'Configuração WhatsApp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">⚙️ Configuração WhatsApp</h1>
            <a href="{{ route('lembretes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                ← Voltar para Lembretes
            </a>
        </div>

        <!-- Debug Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-bold text-blue-900 mb-2">🔍 Debug</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li><strong>Plano:</strong> {{ $plan->name ?? 'N/A' }}</li>
                <li><strong>Modo WhatsApp:</strong> {{ $plan->whatsapp_mode ?? 'N/A' }}</li>
                <li><strong>Quota:</strong> {{ $plan->whatsapp_quota ?? 0 }}</li>
                <li><strong>Ilimitado:</strong> {{ $plan->whatsapp_unlimited ? 'Sim' : 'Não' }}</li>
                <li><strong>Disponível:</strong> {{ $isAvailable ? 'Sim' : 'Não' }}</li>
                <li><strong>Connection Status:</strong> {{ $connection->status ?? 'N/A' }}</li>
            </ul>
        </div>

        <!-- Card do Plano -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📋 Seu Plano: {{ $plan->name }}</h2>
            
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-600">Modo WhatsApp:</span>
                    <span class="ml-2">
                        @if($plan->whatsapp_mode === 'none')
                            ❌ Não disponível
                        @elseif($plan->whatsapp_mode === 'shared')
                            📱 Número compartilhado
                        @else
                            ✨ Número próprio
                        @endif
                    </span>
                </div>
                
                @if($plan->whatsapp_mode !== 'none')
                <div>
                    <span class="text-sm font-medium text-gray-600">Quota:</span>
                    <span class="ml-2">
                        @if($plan->whatsapp_unlimited)
                            <strong class="text-green-600">Ilimitada</strong>
                        @else
                            <strong>{{ $plan->whatsapp_quota ?? 0 }}</strong> mensagens/mês
                        @endif
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Status Cards -->
        @if($plan->whatsapp_mode !== 'none')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border rounded-lg p-4">
                <div class="text-sm text-gray-600 mb-1">Status</div>
                <div class="text-2xl font-bold {{ $isAvailable ? 'text-green-600' : 'text-red-600' }}">
                    {{ $isAvailable ? 'Ativo ✓' : 'Inativo ✗' }}
                </div>
            </div>
            
            <div class="bg-white border rounded-lg p-4">
                <div class="text-sm text-gray-600 mb-1">Uso Mensal</div>
                <div class="text-2xl font-bold text-gray-900">
                    {{ $usageInfo['sent'] ?? 0 }}
                    @if(!$plan->whatsapp_unlimited)
                        <span class="text-base text-gray-500">/ {{ $usageInfo['quota'] ?? 0 }}</span>
                    @endif
                </div>
            </div>
            
            <div class="bg-white border rounded-lg p-4">
                <div class="text-sm text-gray-600 mb-1">Modo</div>
                <div class="text-xl font-bold text-gray-900">
                    {{ $plan->whatsapp_mode === 'shared' ? '📱 Compartilhado' : '✨ Próprio' }}
                </div>
            </div>
        </div>
        @endif

        <!-- Mensagem para plano sem WhatsApp -->
        @if($plan->whatsapp_mode === 'none')
        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-6 text-center">
            <div class="text-5xl mb-4">🔒</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">WhatsApp não disponível</h3>
            <p class="text-gray-700 mb-4">Seu plano atual não inclui envio de mensagens via WhatsApp</p>
            <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">
                Ver Planos Disponíveis
            </a>
        </div>
        @endif

        <!-- Info Modo Compartilhado -->
        @if($plan->whatsapp_mode === 'shared')
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-2">📱 Número Compartilhado</h3>
            <p class="text-sm text-gray-700 mb-3">
                Suas mensagens são enviadas através do número oficial do Imunify. 
                Cada mensagem inclui o nome da sua clínica para identificação.
            </p>
            <div class="bg-white border border-gray-300 rounded p-3">
                <p class="text-xs text-gray-600 mb-2">Exemplo de mensagem:</p>
                <div class="bg-gray-50 border border-gray-200 rounded p-3">
                    <p class="font-bold text-gray-900">🏥 {{ tenant()->name ?? 'Sua Clínica' }}</p>
                    <p class="mt-2 text-gray-700">Olá! Este é um lembrete de vacinação...</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Teste de Mensagem -->
        @if($isAvailable && $usageInfo['has_quota'])
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📱 Enviar Mensagem de Teste</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Número (com DDI)
                    </label>
                    <input 
                        type="text" 
                        id="test_phone" 
                        placeholder="5511999999999"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">Ex: 5511999999999 (DDI + DDD + número)</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mensagem
                    </label>
                    <textarea 
                        id="test_message" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Digite sua mensagem..."
                    >🏥 *Teste de Integração*

Esta é uma mensagem de teste do sistema.

✅ Se você recebeu, está tudo funcionando!</textarea>
                </div>
                
                <button 
                    onclick="sendTestMessage()" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg transition"
                >
                    📤 Enviar Teste
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function sendTestMessage() {
    const phone = document.getElementById('test_phone').value;
    const message = document.getElementById('test_message').value;

    if (!phone || !message) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    fetch('{{ route("whatsapp.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone, message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao enviar. Verifique o console.');
    });
}
</script>
@endsection
