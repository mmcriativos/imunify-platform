@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent">
                Convites de Usuário
            </h2>
            <p class="mt-2 text-gray-600">
                Gere links de convite para novos administradores e usuários
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('invitation_url'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-900 px-4 py-4 rounded-lg" x-data="{ copied: false }">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold mb-2">Link do convite gerado:</p>
                        <div class="flex items-center bg-white p-3 rounded border border-blue-300">
                            <input type="text" value="{{ session('invitation_url') }}" readonly 
                                class="flex-1 text-sm text-gray-700 border-none bg-transparent focus:outline-none" 
                                id="invitation-url">
                            <button @click="navigator.clipboard.writeText('{{ session('invitation_url') }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                class="ml-2 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                <span x-show="!copied">📋 Copiar</span>
                                <span x-show="copied" style="display: none;">✓ Copiado!</span>
                            </button>
                        </div>
                        <p class="text-sm mt-2 text-blue-700">
                            ⏱️ Este link expira em 72 horas. Envie-o para o convidado via e-mail ou WhatsApp.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Formulário de Novo Convite -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                    <div class="bg-gradient-to-r from-cyan-400 to-purple-500 p-6">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Novo Convite
                        </h3>
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('invitations.store') }}" class="space-y-6">
                            @csrf

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    E-mail do Convidado
                                </label>
                                <input type="email" name="email" id="email" 
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="usuario@exemplo.com"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    Função
                                </label>
                                <select name="role" id="role" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors @error('role') border-red-500 @enderror"
                                    required>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuário</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    <strong>Administrador:</strong> Pode gerenciar usuários e configurações<br>
                                    <strong>Usuário:</strong> Acesso básico ao sistema
                                </p>
                            </div>

                            <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                    </svg>
                                    Gerar Convite
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Convites -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Convites Enviados
                        </h3>
                    </div>

                    <div class="p-6">
                        @if($invitations->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum convite enviado</h3>
                                <p class="mt-1 text-sm text-gray-500">Crie um novo convite para começar.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($invitations as $invitation)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" x-data="{ copied: false }">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <span class="text-lg font-semibold text-gray-900">{{ $invitation->email }}</span>
                                                    
                                                    @if($invitation->role === 'admin')
                                                        <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            Administrador
                                                        </span>
                                                    @else
                                                        <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Usuário
                                                        </span>
                                                    @endif

                                                    @if($invitation->isUsed())
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            ✓ Aceito
                                                        </span>
                                                    @elseif($invitation->isExpired())
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            ⏱️ Expirado
                                                        </span>
                                                    @else
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            ⏳ Pendente
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="text-sm text-gray-600 space-y-1">
                                                    <p>
                                                        <span class="font-medium">Convidado por:</span> {{ $invitation->invitedBy->name }}
                                                    </p>
                                                    <p>
                                                        <span class="font-medium">Criado:</span> {{ $invitation->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                    @if($invitation->isUsed())
                                                        <p class="text-green-700">
                                                            <span class="font-medium">Aceito:</span> {{ $invitation->accepted_at->format('d/m/Y H:i') }} por {{ $invitation->user->name }}
                                                        </p>
                                                    @else
                                                        <p class="{{ $invitation->isExpired() ? 'text-red-600' : 'text-orange-600' }}">
                                                            <span class="font-medium">Expira:</span> {{ $invitation->expires_at->format('d/m/Y H:i') }}
                                                            ({{ $invitation->expires_at->diffForHumans() }})
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="ml-4 flex-shrink-0 space-y-2">
                                                @if($invitation->isValid())
                                                    <button @click="navigator.clipboard.writeText('{{ $invitation->getInvitationUrl() }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                        class="block w-full px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                                        <span x-show="!copied">📋 Copiar Link</span>
                                                        <span x-show="copied" style="display: none;">✓ Copiado!</span>
                                                    </button>
                                                @endif

                                                @if(!$invitation->isUsed())
                                                    <form method="POST" action="{{ route('invitations.destroy', $invitation) }}" 
                                                        onsubmit="return confirm('Deseja realmente revogar este convite?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="block w-full px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                                            🗑️ Revogar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
