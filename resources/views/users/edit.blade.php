@extends('layouts.tenant-app')

@section('title', 'Editar Usuário')
@section('page-title', 'Editar Usuário')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome Completo *
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        E-mail *
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telefone
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="(00) 00000-0000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Nível de Acesso *
                    </label>
                    <select name="role" 
                            id="role" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            👑 Administrador - Acesso total
                        </option>
                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>
                            📊 Gerente - Gerencia operações e relatórios
                        </option>
                        <option value="operator" {{ old('role', $user->role) === 'operator' ? 'selected' : '' }}>
                            👤 Operador - Gerencia pacientes e agendamentos
                        </option>
                        <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>
                            👁️ Visualizador - Apenas visualização
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status *
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">✓ Ativo</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="is_active" 
                                   value="0" 
                                   {{ !old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">✗ Inativo</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Usuários inativos não podem fazer login</p>
                </div>

                <!-- Senha (opcional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nova Senha
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Deixe em branco para manter a senha atual</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info sobre último acesso -->
                @if($user->last_login_at)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="text-sm text-gray-700">
                            <p><strong>Último acesso:</strong> {{ $user->last_login_at->format('d/m/Y H:i') }}</p>
                            @if($user->last_login_ip)
                                <p class="mt-1"><strong>IP:</strong> {{ $user->last_login_ip }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Botões -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-[#3ebddb] to-[#77ca73] text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('users.index') }}" 
                       class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all text-center">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
