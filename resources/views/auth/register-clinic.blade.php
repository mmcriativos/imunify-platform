<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre sua Clínica - Imunify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/imask"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f7fb',
                            100: '#cceff7',
                            200: '#99dfef',
                            300: '#66cfe7',
                            400: '#3ebddb',
                            500: '#3ebddb',
                            600: '#329ab0',
                            700: '#267585',
                            800: '#1a505a',
                            900: '#0d282d'
                        },
                        secondary: {
                            50: '#eef9ed',
                            100: '#ddf3db',
                            200: '#bbe7b7',
                            300: '#99db93',
                            400: '#77ca73',
                            500: '#77ca73',
                            600: '#60a25c',
                            700: '#487a45',
                            800: '#30512e',
                            900: '#182917'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-subtle {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-slide-left { animation: slideInLeft 0.6s ease-out; }
        .animate-slide-right { animation: slideInRight 0.6s ease-out; }
        .animate-fade { animation: fadeIn 0.6s ease-out; }
        .animate-pulse-subtle { animation: pulse-subtle 2s infinite; }
        .step-indicator { transition: all 0.3s ease; }
        .step-indicator.active { transform: scale(1.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-primary-50 to-secondary-50 min-h-screen">
    
    {{-- Header --}}
    <nav class="bg-white/80 backdrop-blur-sm shadow-sm py-3 sticky top-0 z-50">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo.png') }}" alt="Imunify" class="h-9 transition-transform group-hover:scale-105">
            </a>
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Voltar para home</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="max-w-6xl mx-auto">
            
            {{-- Header com ilustração --}}
            <div class="text-center mb-8 animate-fade">
                <div class="inline-block mb-4">
                    <div class="relative">
                        <div class="absolute -inset-2 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur opacity-30 animate-pulse-subtle"></div>
                        <div class="relative bg-white rounded-full p-6 shadow-xl">
                            <i class="fas fa-rocket text-5xl text-primary-600"></i>
                        </div>
                    </div>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-800 mb-3">
                    Cadastre sua Clínica
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-2">
                    <i class="fas fa-gift text-primary-600 mr-2"></i>
                    Comece seu período de teste <strong class="text-primary-600">GRÁTIS</strong> de 7 dias
                </p>
                <div class="flex items-center justify-center gap-6 text-sm text-gray-500 flex-wrap">
                    <span><i class="fas fa-check text-secondary-500 mr-1"></i>Sem cartão de crédito</span>
                    <span><i class="fas fa-check text-secondary-500 mr-1"></i>Cancele quando quiser</span>
                    <span><i class="fas fa-check text-secondary-500 mr-1"></i>Suporte incluído</span>
                </div>
            </div>

            {{-- Progress Steps --}}
            <div class="mb-8 animate-slide-right">
                <div class="flex items-center justify-center gap-4 max-w-2xl mx-auto">
                    <div class="flex items-center gap-2 step-indicator active">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white flex items-center justify-center font-bold shadow-lg">
                            1
                        </div>
                        <span class="text-sm font-semibold text-gray-700 hidden md:inline">Plano</span>
                    </div>
                    <div class="h-1 flex-1 bg-gradient-to-r from-primary-200 to-secondary-200 rounded"></div>
                    <div class="flex items-center gap-2 step-indicator">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">
                            2
                        </div>
                        <span class="text-sm font-semibold text-gray-500 hidden md:inline">Dados</span>
                    </div>
                    <div class="h-1 flex-1 bg-gray-200 rounded"></div>
                    <div class="flex items-center gap-2 step-indicator">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">
                            3
                        </div>
                        <span class="text-sm font-semibold text-gray-500 hidden md:inline">Admin</span>
                    </div>
                </div>
            </div>

            {{-- Formulário --}}
            <form method="POST" action="{{ route('register.submit') }}" class="bg-white rounded-3xl shadow-2xl p-6 md:p-10 animate-slide-left">
                @csrf

                {{-- Erros Globais --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-8 animate-fade">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-bold mb-2">Por favor, corrija os seguintes erros:</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-8 flex items-center animate-fade">
                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-8 flex items-center animate-fade">
                        <i class="fas fa-times-circle text-2xl mr-3"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- PASSO 1: Escolher Plano --}}
                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg">
                            1
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Escolha seu plano</h2>
                            <p class="text-gray-600 text-sm">Selecione o plano ideal para sua clínica</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach($plans as $index => $plan)
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" 
                                       class="peer sr-only" 
                                       {{ old('plan_id') == $plan->id ? 'checked' : ($plan->id == 2 && !old('plan_id') ? 'checked' : '') }} 
                                       required>
                                       
                                {{-- Glow effect quando selecionado --}}
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-2xl opacity-0 peer-checked:opacity-100 blur transition duration-300"></div>
                                
                                <div class="relative border-2 border-gray-200 peer-checked:border-primary-500 peer-checked:shadow-2xl rounded-2xl p-6 transition-all duration-300 bg-white group-hover:shadow-xl group-hover:-translate-y-1 {{ $plan->id == 2 ? 'border-primary-300 shadow-lg' : '' }}">
                                    
                                    {{-- Badge Popular --}}
                                    @if($plan->id == 2)
                                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                            <div class="bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-4 py-1 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                                <i class="fas fa-star"></i>
                                                MAIS POPULAR
                                            </div>
                                        </div>
                                    @endif
                                    
                                    {{-- Check icon quando selecionado --}}
                                    <div class="absolute top-4 right-4">
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center transition">
                                            <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </div>
                                    
                                    <h3 class="font-bold text-2xl text-gray-800 mb-2 mt-2">{{ $plan->name }}</h3>
                                    
                                    <div class="mb-4">
                                        <span class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">
                                            {{ $plan->formatted_monthly_price }}
                                        </span>
                                        <span class="text-gray-600">/mês</span>
                                    </div>
                                    
                                    <ul class="space-y-3 text-sm">
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-check text-secondary-500 mt-0.5"></i>
                                            <span class="text-gray-700"><strong>{{ $plan->max_users }}</strong> usuários</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-check text-secondary-500 mt-0.5"></i>
                                            <span class="text-gray-700"><strong>{{ number_format($plan->max_patients, 0, ',', '.') }}</strong> pacientes</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-check text-secondary-500 mt-0.5"></i>
                                            <span class="text-gray-700">{{ number_format($plan->max_monthly_appointments, 0, ',', '.') }} agendamentos/mês</span>
                                        </li>
                                        @if($plan->whatsapp_enabled)
                                            <li class="flex items-start gap-2">
                                                <i class="fab fa-whatsapp text-secondary-500 mt-0.5"></i>
                                                <span class="text-gray-700 font-semibold">WhatsApp integrado</span>
                                            </li>
                                        @else
                                            <li class="flex items-start gap-2 opacity-40">
                                                <i class="fas fa-times text-gray-400 mt-0.5"></i>
                                                <span class="text-gray-500">WhatsApp integrado</span>
                                            </li>
                                        @endif
                                        @if($plan->analytics_enabled)
                                            <li class="flex items-start gap-2">
                                                <i class="fas fa-chart-line text-secondary-500 mt-0.5"></i>
                                                <span class="text-gray-700 font-semibold">Analytics avançado</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    @error('plan_id')
                        <p class="text-red-500 text-sm mt-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="relative my-10">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="bg-white px-4 text-gray-500 text-sm font-medium">
                            <i class="fas fa-arrow-down"></i>
                        </span>
                    </div>
                </div>

                {{-- PASSO 2: Dados da Clínica --}}
                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg">
                            2
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Dados da sua clínica</h2>
                            <p class="text-gray-600 text-sm">Informações sobre sua instituição</p>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nome da Clínica <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hospital text-gray-400"></i>
                                </div>
                                <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('clinic_name') border-red-500 @enderror" 
                                       placeholder="Ex: Clínica VacinaSP"
                                       required>
                            </div>
                            @error('clinic_name')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Escolha seu subdomínio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-link text-gray-400"></i>
                                </div>
                                <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain') }}" 
                                       class="w-full pl-12 pr-48 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('subdomain') border-red-500 @enderror" 
                                       placeholder="minhaclínica"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm font-medium">.imunify.com.br</span>
                                </div>
                            </div>
                            <p id="subdomain-status" class="text-sm mt-2"></p>
                            @error('subdomain')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Este será o endereço da sua clínica (ex: clinica.imunify.com.br)
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email da Clínica <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('email') border-red-500 @enderror" 
                                       placeholder="contato@clinica.com"
                                       autocomplete="email"
                                       required>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Telefone <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('phone') border-red-500 @enderror" 
                                       placeholder="(11) 99999-9999"
                                       autocomplete="tel"
                                       required>
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                CNPJ <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                                <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('cnpj') border-red-500 @enderror" 
                                       placeholder="00.000.000/0000-00"
                                       required>
                            </div>
                            @error('cnpj')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="relative my-10">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="bg-white px-4 text-gray-500 text-sm font-medium">
                            <i class="fas fa-arrow-down"></i>
                        </span>
                    </div>
                </div>

                {{-- PASSO 3: Usuário Admin --}}
                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg">
                            3
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Crie sua conta de administrador</h2>
                            <p class="text-gray-600 text-sm">Credenciais de acesso ao sistema</p>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nome Completo <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="admin_name" value="{{ old('admin_name') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('admin_name') border-red-500 @enderror" 
                                       placeholder="Dr. João Silva"
                                       required>
                            </div>
                            @error('admin_name')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email de Login <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="admin_email" value="{{ old('admin_email') }}" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('admin_email') border-red-500 @enderror" 
                                       placeholder="joao@email.com"
                                       autocomplete="username"
                                       required>
                            </div>
                            @error('admin_email')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Senha <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 @error('password') border-red-500 @enderror" 
                                       placeholder="Mínimo 8 caracteres"
                                       autocomplete="new-password"
                                       required>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmar Senha <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password_confirmation" 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200" 
                                       placeholder="Digite a senha novamente"
                                       autocomplete="new-password"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative my-10">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                </div>

                {{-- Termos --}}
                <div class="mb-8 bg-gradient-to-r from-primary-50 to-secondary-50 p-6 rounded-xl border-2 border-primary-100">
                    <label class="flex items-start cursor-pointer group">
                        <input type="checkbox" name="accept_terms" class="mt-1 mr-3 w-5 h-5 text-primary-600 rounded focus:ring-4 focus:ring-primary-100 @error('accept_terms') border-red-500 @enderror" required>
                        <span class="text-sm text-gray-700">
                            Eu li e aceito os 
                            <a href="{{ route('legal.terms') }}" target="_blank" class="text-primary-600 hover:text-primary-700 font-semibold underline">Termos de Uso</a> e 
                            <a href="{{ route('legal.privacy') }}" target="_blank" class="text-primary-600 hover:text-primary-700 font-semibold underline">Política de Privacidade</a>
                            <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('accept_terms')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botão de Envio --}}
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white py-4 px-8 rounded-xl font-bold text-lg hover:from-primary-600 hover:to-secondary-600 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-[1.02] active:scale-95 relative overflow-hidden group">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-white to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <span class="relative flex items-center justify-center gap-3">
                        <i class="fas fa-gift text-xl animate-bounce"></i>
                        <span>Começar Teste Grátis de 7 Dias</span>
                        <i class="fas fa-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>

                <p class="text-center text-sm text-gray-600 mt-6 flex items-center justify-center gap-2">
                    <i class="fas fa-shield-alt text-secondary-500"></i>
                    <span><strong>Seus dados estão seguros.</strong> Não é necessário cartão de crédito.</span>
                </p>
            </form>

            {{-- Benefícios Resumidos --}}
            <div class="mt-16 grid md:grid-cols-3 gap-6 text-center">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-100 group hover:-translate-y-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-gift text-3xl text-primary-600"></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">7 Dias Grátis</h3>
                    <p class="text-gray-600">Teste todas as funcionalidades sem compromisso</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-100 group hover:-translate-y-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-secondary-100 rounded-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-credit-card text-3xl text-secondary-600"></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Sem Cartão</h3>
                    <p class="text-gray-600">Não pedimos dados de pagamento no cadastro</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-100 group hover:-translate-y-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-headset text-3xl bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent"></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Suporte Incluído</h3>
                    <p class="text-gray-600">Equipe pronta para ajudar você a começar</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Script para verificar subdomínio em tempo real --}}
    <script>
        // Máscaras de input
        const phoneMask = IMask(document.getElementById('phone'), {
            mask: '(00) 00000-0000'
        });

        const cnpjMask = IMask(document.getElementById('cnpj'), {
            mask: '00.000.000/0000-00'
        });

        const subdomainInput = document.getElementById('subdomain');
        const statusDiv = document.getElementById('subdomain-status');
        const registerForm = document.querySelector('form');
        const submitButton = registerForm.querySelector('button[type="submit"]');
        const buttonContent = submitButton.querySelector('span:last-child');
        let timeout = null;

        // Verificação de subdomínio em tempo real
        subdomainInput.addEventListener('input', function() {
            clearTimeout(timeout);
            
            const subdomain = this.value.trim().toLowerCase().replace(/[^a-z0-9-]/g, '');
            this.value = subdomain;
            
            if (subdomain.length < 3) {
                statusDiv.textContent = '';
                statusDiv.className = 'text-sm mt-2';
                return;
            }

            statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verificando disponibilidade...';
            statusDiv.className = 'text-sm mt-2 text-gray-500';

            timeout = setTimeout(() => {
                fetch('{{ route("check.subdomain") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ subdomain: subdomain })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        statusDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message + ' <br><strong>Seu endereço:</strong> ' + data.full_domain;
                        statusDiv.className = 'text-sm mt-2 text-green-600 font-medium animate-fade';
                    } else {
                        statusDiv.innerHTML = '<i class="fas fa-times-circle"></i> ' + data.message;
                        statusDiv.className = 'text-sm mt-2 text-red-600 font-medium animate-fade';
                    }
                })
                .catch(error => {
                    statusDiv.textContent = 'Erro ao verificar. Tente novamente.';
                    statusDiv.className = 'text-sm mt-2 text-red-600';
                });
            }, 600);
        });

        // Loading no botão ao enviar
        registerForm.addEventListener('submit', function(e) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
            buttonContent.innerHTML = `
                <i class="fas fa-spinner fa-spin text-xl"></i>
                <span>Criando sua clínica...</span>
                <i class="fas fa-spinner fa-spin text-lg"></i>
            `;
        });
    </script>

</body>
</html>
