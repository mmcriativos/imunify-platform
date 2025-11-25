@extends('layouts.tenant-app')

@section('page-title', 'Configurações WhatsApp')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header com Navegação -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    Configuração WhatsApp
                </h1>
                <p class="text-gray-600 mt-1">Gerencie notificações e integração do WhatsApp Business</p>
            </div>
            <a href="{{ route('lembretes.index') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar para Lembretes
            </a>
        </div>
    </div>

    <!-- Informações do Plano Atual -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg p-6 mb-8 border border-blue-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white p-2 rounded-lg shadow-sm">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Plano {{ $plan->name }}</h3>
                        <p class="text-sm text-gray-600">
                            @if($plan->whatsapp_mode === 'none')
                                WhatsApp não incluído
                            @elseif($plan->whatsapp_mode === 'shared')
                                Número compartilhado oficial do Imunify
                            @else
                                Número próprio exclusivo do WhatsApp Business
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($plan->whatsapp_mode !== 'none')
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500">Quota Mensal</p>
                        <p class="text-lg font-bold text-gray-900">
                            @if($plan->whatsapp_unlimited)
                                <span class="text-green-600">✨ Ilimitada</span>
                            @else
                                {{ number_format($plan->whatsapp_quota ?? 0) }} mensagens
                            @endif
                        </p>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500">Modo</p>
                        <p class="text-lg font-bold text-gray-900">
                            @if($plan->whatsapp_mode === 'shared')
                                📱 Compartilhado
                            @else
                                ✨ Próprio
                            @endif
                        </p>
                    </div>
                </div>
                @endif
            </div>
            
            @if($plan->whatsapp_mode === 'none' || ($plan->whatsapp_mode === 'shared' && ($plan->whatsapp_quota ?? 0) < 500))
            <div class="lg:text-right">
                <a href="#upgrade-section" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Fazer Upgrade
                </a>
                <p class="text-xs text-gray-600 mt-2">Desbloqueie mais recursos</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Funcionalidades que usam WhatsApp -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Funcionalidades com Notificação WhatsApp
        </h3>
        <p class="text-gray-600 mb-6">O sistema envia mensagens automáticas do WhatsApp para as seguintes situações:</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Lembretes de Vacinação -->
            <div class="flex gap-4 p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1">🔔 Lembretes de Vacinação</h4>
                    <p class="text-sm text-gray-700">Notifica pacientes sobre doses pendentes automaticamente</p>
                </div>
            </div>

            <!-- Confirmações de Presença -->
            <div class="flex gap-4 p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg border border-green-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1">✅ Confirmações de Presença</h4>
                    <p class="text-sm text-gray-700">Envia confirmação de agendamentos e coleta respostas</p>
                </div>
            </div>

            <!-- Campanhas de Vacinação -->
            <div class="flex gap-4 p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1">📢 Campanhas de Vacinação</h4>
                    <p class="text-sm text-gray-700">Divulga campanhas sazonais em massa para pacientes</p>
                </div>
            </div>

            <!-- Resultado de Exames -->
            <div class="flex gap-4 p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg border border-orange-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 mb-1">📋 Notificações de Atendimento</h4>
                    <p class="text-sm text-gray-700">Avisa sobre conclusão de atendimentos e resultados</p>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-900">Automação Inteligente</p>
                    <p class="text-sm text-gray-600 mt-1">Todas as mensagens são enviadas automaticamente pelo sistema, economizando tempo da sua equipe e melhorando o relacionamento com os pacientes.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modelos de Mensagem -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Modelos de Mensagem
                </h3>
                <p class="text-sm text-gray-600 mt-1">Veja como os pacientes recebem as notificações automáticas</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Modelo: Lembrete de Vacinação -->
            <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-blue-400 transition">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-lg">🔔</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Lembrete de Vacinação</h4>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border-l-4 border-green-500">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">🏥 <strong>{{ tenant()->name ?? 'Clínica MultiImune' }}</strong>

Olá <strong>Maria Silva</strong>! 👋

💉 Você tem uma dose pendente de vacinação:

📋 <strong>Vacina:</strong> Hepatite B - 2ª dose
📅 <strong>Previsão:</strong> 15/12/2025
⏰ <strong>Horário sugerido:</strong> 14:00h

📞 Para agendar, entre em contato:
Telefone: (11) 9999-9999

✅ Mantenha sua carteira em dia!</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Enviado automaticamente quando detectada dose pendente
                </div>
            </div>

            <!-- Modelo: Confirmação de Presença -->
            <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-green-400 transition">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-lg">✅</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Confirmação de Presença</h4>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border-l-4 border-green-500">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">🏥 <strong>{{ tenant()->name ?? 'Clínica MultiImune' }}</strong>

Olá <strong>João Santos</strong>! 👋

📅 Você tem um agendamento confirmado:

💉 <strong>Vacina:</strong> Gripe (Influenza)
📆 <strong>Data:</strong> 20/11/2025
⏰ <strong>Horário:</strong> 10:30h

❓ Você confirma sua presença?

✅ Digite <strong>SIM</strong> para confirmar
❌ Digite <strong>NÃO</strong> para reagendar

Aguardamos você! 😊</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Enviado 24h antes do agendamento
                </div>
            </div>

            <!-- Modelo: Campanha de Vacinação -->
            <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-purple-400 transition">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-lg">📢</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Campanha de Vacinação</h4>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">🏥 <strong>{{ tenant()->name ?? 'Clínica MultiImune' }}</strong>

📢 <strong>CAMPANHA DE VACINAÇÃO 2025</strong>

💉 Proteção contra a Gripe disponível!

🎯 <strong>Público-alvo:</strong>
• Idosos (60+)
• Crianças (6 meses a 5 anos)
• Gestantes
• Profissionais da saúde

📅 <strong>Período:</strong> 18/11 a 20/12/2025
💰 <strong>Valor especial:</strong> R$ 50,00

📞 Agende já: (11) 9999-9999

🛡️ Proteja-se e proteja quem você ama!</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Enviado em campanhas sazonais configuradas
                </div>
            </div>

            <!-- Modelo: Notificação de Atendimento -->
            <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-orange-400 transition">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-lg">📋</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">Conclusão de Atendimento</h4>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border-l-4 border-orange-500">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">🏥 <strong>{{ tenant()->name ?? 'Clínica MultiImune' }}</strong>

Olá <strong>Ana Costa</strong>! 👋

✅ Seu atendimento foi concluído com sucesso!

💉 <strong>Vacina aplicada:</strong> Tríplice Viral
📅 <strong>Data:</strong> 18/11/2025
👨‍⚕️ <strong>Profissional:</strong> Dr. Carlos Silva

📋 <strong>Próxima dose:</strong>
• Vacina: Tríplice Viral - 2ª dose
• Previsão: 18/01/2026

📄 Sua carteira foi atualizada no sistema.

Obrigado pela confiança! 💙</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Enviado imediatamente após conclusão do atendimento
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">Personalização Automática</p>
                    <p class="text-sm text-blue-700 mt-1">Todas as mensagens são personalizadas automaticamente com os dados do paciente, vacinas e horários corretos. O nome da sua clínica sempre aparece identificado.</p>
                </div>
            </div>
        </div>
    </div>

    @if($plan->whatsapp_mode === 'none')
        <!-- Sem WhatsApp -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <div class="text-4xl mb-4">🔒</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">WhatsApp não disponível</h3>
            <p class="text-gray-600 mb-4">Seu plano atual não inclui envio de mensagens via WhatsApp</p>
            <a href="#" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition">
                Ver Planos Disponíveis
            </a>
        </div>
    @else
        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Status</span>
                    <div class="w-2 h-2 rounded-full {{ $isAvailable ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                <p class="text-2xl font-bold {{ $isAvailable ? 'text-green-600' : 'text-red-600' }}">
                    {{ $isAvailable ? 'Ativo' : 'Inativo' }}
                </p>
            </div>

            <!-- Uso -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="mb-2">
                    <span class="text-sm font-medium text-gray-600">Uso Mensal</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-2">
                    {{ $usageInfo['sent'] ?? 0 }}
                    @if(!$plan->whatsapp_unlimited)
                        <span class="text-base text-gray-500">/ {{ $usageInfo['quota'] ?? 0 }}</span>
                    @endif
                </p>
                @if(!$plan->whatsapp_unlimited)
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all" 
                         style="width: {{ min(100, (($usageInfo['sent'] ?? 0) / max(1, $usageInfo['quota'] ?? 1)) * 100) }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $usageInfo['remaining'] ?? 0 }} restantes</p>
                @else
                <p class="text-sm text-green-600 font-medium">✨ Ilimitado</p>
                @endif
            </div>

            <!-- Modo -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="mb-2">
                    <span class="text-sm font-medium text-gray-600">Modo</span>
                </div>
                <p class="text-xl font-bold text-gray-900">
                    @if($plan->whatsapp_mode === 'shared')
                        📱 Compartilhado
                    @else
                        ✨ Próprio
                    @endif
                </p>
                @if($connection->status === 'connected' && $connection->phone_number)
                <p class="text-sm text-gray-600 mt-1">{{ $connection->phone_number }}</p>
                @endif
            </div>
        </div>

        @if($plan->whatsapp_mode === 'shared')
            <!-- Info Compartilhado -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">📱 Número Compartilhado</h3>
                <p class="text-sm text-gray-700 mb-3">
                    Suas mensagens são enviadas através do número oficial do Imunify. 
                    Cada mensagem inclui o nome da sua clínica para identificação.
                </p>
                <div class="bg-white border border-gray-300 rounded p-3">
                    <p class="text-xs text-gray-600 mb-1">Exemplo de mensagem:</p>
                    <div class="bg-gray-50 p-2 rounded text-sm">
                        <p class="font-semibold">🏥 {{ tenant()->name ?? 'Sua Clínica' }}</p>
                        <p class="mt-1 text-gray-700">Olá! Este é um lembrete de vacinação...</p>
                    </div>
                </div>
            </div>
        @elseif($plan->whatsapp_mode === 'own')
            <!-- Configuração Número Próprio -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">✨ Seu Número WhatsApp</h3>
                
                @if($connection->status === 'disconnected' || !$connection->zapi_instance_id)
                    <!-- Form Credenciais -->
                    <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                        <p class="text-sm font-medium text-gray-900 mb-1">💡 Credenciais Z-API necessárias</p>
                        <p class="text-sm text-gray-600">
                            Acesse <a href="https://www.z-api.io" target="_blank" class="text-blue-600 hover:underline">z-api.io</a>, 
                            crie uma instância e cole as credenciais abaixo.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instance ID</label>
                            <input type="text" id="zapi_instance_id" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Seu instance ID">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Token</label>
                            <input type="text" id="zapi_token" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Seu token">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Client Token</label>
                            <input type="text" id="zapi_client_token" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Seu client token">
                        </div>
                        <button onclick="connectWhatsApp()" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-3 rounded-lg transition">
                            🔗 Conectar WhatsApp
                        </button>
                    </div>
                @elseif($connection->status === 'qrcode')
                    <!-- QR Code -->
                    <div class="text-center">
                        <p class="text-gray-700 mb-4">Escaneie o QR Code com seu WhatsApp:</p>
                        <div class="inline-block bg-white border-2 border-gray-300 rounded-lg p-4">
                            @if($connection->qrcode_base64)
                                <img src="{{ $connection->qrcode_base64 }}" alt="QR Code" class="w-64 h-64">
                            @else
                                <div class="w-64 h-64 flex items-center justify-center bg-gray-100 rounded">
                                    <p class="text-gray-500">Carregando...</p>
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-3">Aguardando leitura do QR Code...</p>
                        <button onclick="checkStatus()" 
                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition">
                            🔄 Verificar Status
                        </button>
                    </div>
                @else
                    <!-- Conectado -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center mb-4">
                        <div class="text-4xl mb-3">✅</div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">WhatsApp Conectado!</h4>
                        <p class="text-gray-700">Seu número está ativo e pronto para enviar mensagens.</p>
                        @if($connection->phone_number)
                        <p class="text-sm text-gray-600 mt-2">Número: {{ $connection->phone_number }}</p>
                        @endif
                    </div>
                    <button onclick="disconnectWhatsApp()" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                        ❌ Desconectar
                    </button>
                @endif
            </div>
        @endif

        <!-- Teste de Mensagem -->
        @if($isAvailable && $usageInfo['has_quota'])
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📱 Enviar Teste</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número (apenas números com DDI)</label>
                    <input type="text" id="test_phone" 
                           placeholder="5511999999999" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Ex: 5511999999999 (DDI + DDD + número)</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
                    <textarea id="test_message" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                              placeholder="Digite sua mensagem...">🏥 *Teste de Integração*

Esta é uma mensagem de teste do sistema.

✅ Se você recebeu, está tudo funcionando!</textarea>
                </div>
                
                <button onclick="sendTestMessage()" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Enviar Teste
                </button>
            </div>
        </div>
        @elseif($isAvailable && !$usageInfo['has_quota'])
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <div class="text-4xl mb-3">⚠️</div>
            <h3 class="text-lg font-bold text-red-600 mb-2">Quota Esgotada</h3>
            <p class="text-gray-700 mb-4">Você atingiu o limite de mensagens do seu plano este mês.</p>
            <a href="#" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-2 rounded-lg transition">
                🚀 Fazer Upgrade
            </a>
        </div>
        @endif
    @endif

    <!-- Seção de Upgrade de Planos -->
    <div id="upgrade-section" class="mt-12 scroll-mt-20">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Expanda suas Possibilidades</h2>
            <p class="text-gray-600">Escolha o plano ideal para a sua clínica e envie mais mensagens automáticas</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Plano Starter -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:border-blue-400 transition">
                <div class="text-center mb-6">
                    <div class="inline-block bg-blue-100 p-3 rounded-full mb-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Starter</h3>
                    <p class="text-gray-600 text-sm mt-1">Para clínicas pequenas</p>
                </div>

                <div class="mb-6">
                    <div class="text-center">
                        <span class="text-4xl font-bold text-gray-900">50</span>
                        <span class="text-gray-600">/mês</span>
                    </div>
                    <p class="text-center text-sm text-gray-500 mt-1">mensagens WhatsApp</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Número compartilhado</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Lembretes automáticos</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Confirmações de presença</span>
                    </li>
                </ul>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    Selecionar Plano
                </button>
            </div>

            <!-- Plano Pro (Destaque) -->
            <div class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl shadow-2xl border-2 border-purple-400 p-6 transform scale-105 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-full shadow">MAIS POPULAR</span>
                </div>

                <div class="text-center mb-6">
                    <div class="inline-block bg-white/20 p-3 rounded-full mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Pro</h3>
                    <p class="text-purple-100 text-sm mt-1">Para clínicas médias</p>
                </div>

                <div class="mb-6">
                    <div class="text-center">
                        <span class="text-4xl font-bold text-white">250</span>
                        <span class="text-purple-100">/mês</span>
                    </div>
                    <p class="text-center text-sm text-purple-100 mt-1">mensagens WhatsApp</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-white font-medium">Tudo do Starter, mais:</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-white">5x mais mensagens</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-white">Campanhas de vacinação</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-white">Relatórios avançados</span>
                    </li>
                </ul>

                <button class="w-full bg-white hover:bg-gray-100 text-purple-700 font-semibold py-3 rounded-lg transition shadow-lg">
                    Selecionar Plano
                </button>
            </div>

            <!-- Plano Enterprise -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:border-purple-400 transition">
                <div class="text-center mb-6">
                    <div class="inline-block bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-full mb-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Enterprise</h3>
                    <p class="text-gray-600 text-sm mt-1">Para grandes clínicas</p>
                </div>

                <div class="mb-6">
                    <div class="text-center">
                        <span class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">∞</span>
                    </div>
                    <p class="text-center text-sm text-gray-500 mt-1">mensagens ilimitadas</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700 font-medium">Tudo do Pro, mais:</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Mensagens ilimitadas</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700"><strong>Número próprio</strong> WhatsApp</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Suporte prioritário</span>
                    </li>
                </ul>

                <button class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                    Selecionar Plano
                </button>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-gray-600 text-sm">Dúvidas sobre os planos? <a href="#" class="text-blue-600 hover:underline font-medium">Entre em contato conosco</a></p>
        </div>
    </div>
</div>
<!-- Fim do container -->

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}

.toast {
    animation: slideIn 0.3s ease-out;
}

.toast.removing {
    animation: slideOut 0.3s ease-in;
}
</style>

<script>
// Sistema de Toast Notifications
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    const icons = {
        success: '✅',
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️'
    };
    
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    toast.className = `toast flex items-start gap-3 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl max-w-md`;
    toast.innerHTML = `
        <div class="text-2xl flex-shrink-0">${icons[type]}</div>
        <div class="flex-1">
            <p class="font-medium leading-relaxed">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition ml-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    
    container.appendChild(toast);
    
    // Auto-remover após duração
    setTimeout(() => {
        toast.classList.add('removing');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// Modal de confirmação customizado
function showConfirm(message, onConfirm) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 p-6 transform transition-all">
            <div class="text-center mb-6">
                <div class="text-5xl mb-4">⚠️</div>
                <p class="text-lg text-gray-800">${message}</p>
            </div>
            <div class="flex gap-3">
                <button onclick="this.closest('.fixed').remove()" 
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Cancelar
                </button>
                <button id="confirm-btn" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Confirmar
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.querySelector('#confirm-btn').addEventListener('click', () => {
        modal.remove();
        onConfirm();
    });
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });
}

function connectWhatsApp() {
    const instanceId = document.getElementById('zapi_instance_id').value;
    const token = document.getElementById('zapi_token').value;
    const clientToken = document.getElementById('zapi_client_token').value;

    if (!instanceId || !token || !clientToken) {
        showToast('Por favor, preencha todos os campos.', 'warning');
        return;
    }

    showToast('Conectando ao WhatsApp...', 'info', 2000);

    fetch('{{ route("whatsapp.connect") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            zapi_instance_id: instanceId,
            zapi_token: token,
            zapi_client_token: clientToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showToast('Erro: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao conectar. Verifique o console.', 'error');
    });
}

function checkStatus() {
    fetch('{{ route("whatsapp.status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.is_connected) {
                showToast('WhatsApp conectado com sucesso!', 'success');
                setTimeout(() => location.reload(), 2000);
            } else {
                showToast('Ainda aguardando conexão. Status: ' + data.status, 'info', 3000);
            }
        });
}

function sendTestMessage() {
    const phone = document.getElementById('test_phone').value;
    const message = document.getElementById('test_message').value;

    if (!phone || !message) {
        showToast('Por favor, preencha todos os campos.', 'warning');
        return;
    }

    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Enviando...</span>';

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
            showToast('Mensagem de teste enviada com sucesso!', 'success');
            if (data.usage) {
                showToast(`Uso atualizado: ${data.usage.sent} / ${data.usage.quota} mensagens`, 'info', 5000);
            }
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao enviar. Verifique o console.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> Enviar Teste';
    });
}

function disconnectWhatsApp() {
    showConfirm('Tem certeza que deseja desconectar o WhatsApp?', () => {
        showToast('Desconectando...', 'info', 2000);
        
        fetch('{{ route("whatsapp.disconnect") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            showToast(data.message, data.success ? 'success' : 'error');
            if (data.success) {
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Erro ao desconectar.', 'error');
        });
    });
}

// Auto-refresh para QR Code
@if(isset($connection) && $connection->status === 'qrcode')
setInterval(() => {
    checkStatus();
}, 5000); // Verifica a cada 5 segundos
@endif
</script>
@endsection
