@extends('layouts.tenant-app')

@section('title', 'Configurações da Clínica')
@section('page-title', 'Configurações da Clínica')

@section('content')
<!-- Header -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl mb-8 shadow-2xl">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-repeat" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"8\"/></g></g></svg>');"></div>
    </div>
    
    <div class="relative p-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-white/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                        ⚙️ Configurações da Clínica
                    </h1>
                    <p class="text-white/80 text-lg">
                        Configure as informações institucionais da sua clínica
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
    <div class="flex items-center gap-3">
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<form action="{{ route('clinic.config.update') }}" method="POST" class="space-y-6">
    @csrf
    
    <!-- Card: Informações Básicas -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Informações Básicas
            </h2>
        </div>

        <div class="p-8 space-y-6">
            <!-- Nome da Clínica -->
            <div>
                <label for="clinic_name" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Nome da Clínica *
                    </span>
                </label>
                <input type="text" name="clinic_name" id="clinic_name" required value="{{ old('clinic_name', $tenant->clinic_name) }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition duration-200 @error('clinic_name') border-red-500 @enderror">
                @error('clinic_name')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CNES -->
                <div>
                    <label for="cnes" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            CNES (Cadastro Nacional de Estabelecimentos de Saúde)
                        </span>
                    </label>
                    <input type="text" name="cnes" id="cnes" value="{{ old('cnes', $tenant->cnes) }}"
                           placeholder="Ex: 1234567"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition duration-200">
                    <p class="text-xs text-gray-500 mt-1">⚠️ Obrigatório para certificados de vacinação</p>
                </div>

                <!-- CRM -->
                <div>
                    <label for="crm" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            CRM (Conselho Regional de Medicina)
                        </span>
                    </label>
                    <input type="text" name="crm" id="crm" value="{{ old('crm', $tenant->crm) }}"
                           placeholder="Ex: CRM/SP 123456"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition duration-200">
                    <p class="text-xs text-gray-500 mt-1">⚠️ Obrigatório para certificados de vacinação</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Contato -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Informações de Contato
            </h2>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Telefone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Telefone
                        </span>
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $tenant->phone) }}"
                           placeholder="(00) 00000-0000"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                </div>

                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            E-mail
                        </span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}"
                           placeholder="contato@clinica.com.br"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition duration-200">
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Endereço -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Endereço
            </h2>
        </div>

        <div class="p-8 space-y-6">
            <!-- Endereço completo -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Endereço Completo</label>
                <input type="text" name="address" id="address" value="{{ old('address', $tenant->address) }}"
                       placeholder="Rua, número, complemento"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition duration-200">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cidade -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $tenant->city) }}"
                           placeholder="São Paulo"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition duration-200">
                </div>

                <!-- Estado -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">Estado (UF)</label>
                    <input type="text" name="state" id="state" value="{{ old('state', $tenant->state) }}"
                           placeholder="SP"
                           maxlength="2"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition duration-200">
                </div>

                <!-- CEP -->
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                    <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $tenant->zip_code) }}"
                           placeholder="00000-000"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition duration-200">
                </div>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex gap-4">
        <button type="submit" 
                class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
            💾 Salvar Configurações
        </button>
    </div>
</form>

<!-- Alerta Informativo -->
<div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg mt-8">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <h3 class="text-amber-800 font-bold text-lg mb-2">⚠️ Informação Importante</h3>
            <p class="text-amber-700">
                <strong>CNES e CRM são obrigatórios</strong> para a emissão de certificados de vacinação válidos no território nacional.
                Estes dados aparecerão nos certificados gerados e devem estar atualizados conforme o registro do estabelecimento.
            </p>
        </div>
    </div>
</div>

@endsection
