@extends('layouts.tenant-app')

@section('title', 'Editar Membro')
@section('page-title', 'Editar Membro da Equipe')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                    <span class="text-2xl font-black bg-gradient-to-br from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                </div>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">Editar {{ $user->name }}</h1>
                <p class="text-blue-100">Atualize as informações do membro</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-8">
                <!-- Informações Pessoais -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informações Pessoais
                    </h2>
                    <p class="text-sm text-gray-600">Dados básicos do membro</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nome completo *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                required autofocus>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Telefone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="(00) 00000-0000">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">E-mail *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            required>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status e Último Acesso -->
                @if($user->last_login_at)
                <div class="mb-8 bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-700">Último acesso</p>
                            <p>{{ $user->last_login_at->format('d/m/Y H:i') }} ({{ $user->last_login_at->diffForHumans() }})</p>
                            @if($user->last_login_ip)
                                <p class="text-xs text-gray-500">IP: {{ $user->last_login_ip }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Permissões -->
                <div class="border-t-2 border-gray-100 pt-8 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Nível de Acesso
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Defina as permissões do usuário</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="admin" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-purple-300 hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">👑</span>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Administrador</h3>
                                        <p class="text-sm text-gray-600">Acesso total ao sistema</p>
                                    </div>
                                    <div class="peer-checked:block hidden">
                                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="manager" {{ old('role', $user->role) == 'manager' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-300 hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">📊</span>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Gerente</h3>
                                        <p class="text-sm text-gray-600">Gerencia e visualiza relatórios</p>
                                    </div>
                                    <div class="peer-checked:block hidden">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="operator" {{ old('role', $user->role) == 'operator' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-green-300 hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">👤</span>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Operador</h3>
                                        <p class="text-sm text-gray-600">Gerencia pacientes e agendamentos</p>
                                    </div>
                                    <div class="peer-checked:block hidden">
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="viewer" {{ old('role', $user->role) == 'viewer' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-gray-500 peer-checked:bg-gray-50 transition-all hover:border-gray-400 hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">👁️</span>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Visualizador</h3>
                                        <p class="text-sm text-gray-600">Apenas visualização</p>
                                    </div>
                                    <div class="peer-checked:block hidden">
                                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Status do Usuário -->
                <div class="border-t-2 border-gray-100 pt-8 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status da Conta
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Ative ou desative o acesso do usuário</p>

                    <div class="flex gap-4">
                        <label class="relative cursor-pointer flex-1">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-green-300">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full peer-checked:animate-pulse"></div>
                                    <span class="font-bold text-gray-900">Ativo</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer flex-1">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', $user->is_active) === 0 || old('is_active', $user->is_active) === '0' ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-gray-500 peer-checked:bg-gray-50 transition-all hover:border-gray-400">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                    <span class="font-bold text-gray-900">Inativo</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Alterar Senha (Opcional) -->
                <div class="border-t-2 border-gray-100 pt-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Alterar Senha
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Deixe em branco para manter a senha atual</p>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Nova Senha (opcional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                minlength="8"
                                placeholder="Mínimo 8 caracteres">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">💡 Use uma combinação de letras, números e símbolos</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Footer com Ações -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between gap-4">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
