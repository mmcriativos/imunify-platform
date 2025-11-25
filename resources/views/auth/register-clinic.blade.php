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
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(62, 189, 219, 0.3); }
            50% { box-shadow: 0 0 40px rgba(62, 189, 219, 0.6); }
        }
        .animate-fade-up { animation: fadeInUp 0.6s ease-out; }
        .animate-fade-left { animation: fadeInLeft 0.6s ease-out; }
        .pulse-glow { animation: pulse-glow 3s infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 min-h-screen">
    
    {{-- Header --}}
    <nav class="bg-white/90 backdrop-blur-md shadow-sm py-4 sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4 flex items-center justify-between max-w-7xl">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo.png') }}" alt="Imunify" class="h-10 transition-transform group-hover:scale-105">
            </a>
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition flex items-center gap-2 text-sm font-medium">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Voltar</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-7xl">
        <div class="grid lg:grid-cols-5 gap-8 lg:gap-12 items-start">
            
            {{-- Coluna Esquerda: Informações --}}
            <div class="lg:col-span-2 animate-fade-left">
                <div class="sticky top-24">
                    <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 text-white mb-4 shadow-lg">
                                <i class="fas fa-rocket text-2xl"></i>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-3">
                                Teste Grátis por 7 Dias
                            </h1>
                            <p class="text-gray-600 text-lg leading-relaxed">
                                Comece agora mesmo a transformar a gestão da sua clínica de vacinação.
                            </p>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Sem Cartão de Crédito</h3>
                                    <p class="text-sm text-gray-600">Teste todas as funcionalidades sem compromisso</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-bolt text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Ativação Imediata</h3>
                                    <p class="text-sm text-gray-600">Comece a usar em menos de 2 minutos</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-headset text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Suporte Incluído</h3>
                                    <p class="text-sm text-gray-600">Nossa equipe está pronta para ajudar</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-orange-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Dados Seguros</h3>
                                    <p class="text-sm text-gray-600">Criptografia e backup automático</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-2xl p-6 border border-primary-100">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="fas fa-quote-left text-primary-500 text-xl"></i>
                                <p class="text-sm text-gray-700 italic leading-relaxed">
                                    "O Imunify transformou nossa clínica. Automatizamos lembretes, reduzimos faltas e aumentamos nossa produtividade."
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-secondary-400"></div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Dra. Maria Silva</p>
                                    <p class="text-xs text-gray-600">Clínica Saúde & Vida - SP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Coluna Direita: Formulário --}}
            <div class="lg:col-span-3 animate-fade-up">
                <form method="POST" action="{{ route('register.submit') }}" class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    @csrf

                    {{-- Erros Globais --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-circle text-xl mt-0.5"></i>
                                <div>
                                    <p class="font-bold mb-2">Corrija os seguintes erros:</p>
                                    <ul class="list-disc list-inside space-y-1 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                            <i class="fas fa-times-circle text-xl"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Seção 1: Escolha seu Plano --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Escolha seu plano</h2>
                        <p class="text-gray-600 mb-6">Selecione o plano ideal para sua clínica</p>
                        
                        <div class="grid md:grid-cols-3 gap-4">
                            @foreach($plans as $plan)
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="plan_id" value="{{ $plan->id }}" 
                                           class="peer sr-only" 
                                           {{ old('plan_id') == $plan->id ? 'checked' : ($plan->id == 2 && !old('plan_id') ? 'checked' : '') }} 
                                           required>
                                           
                                    <div class="relative border-2 border-gray-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 rounded-2xl p-5 transition-all duration-200 bg-white hover:border-primary-300 hover:shadow-lg {{ $plan->id == 2 ? 'border-primary-300' : '' }}">
                                        
                                        @if($plan->id == 2)
                                            <div class="absolute -top-2.5 -right-2.5">
                                                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                                    <i class="fas fa-star"></i> POPULAR
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute top-4 right-4">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center transition">
                                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                            </div>
                                        </div>
                                        
                                        <h3 class="font-bold text-xl text-gray-900 mb-3">{{ $plan->name }}</h3>
                                        
                                        <div class="mb-4">
                                            <span class="text-3xl font-bold text-gray-900">{{ $plan->formatted_monthly_price }}</span>
                                            <span class="text-gray-600 text-sm">/mês</span>
                                        </div>
                                        
                                        <ul class="space-y-2 text-sm">
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-check text-secondary-500 text-xs"></i>
                                                <span class="text-gray-700">{{ $plan->max_users }} usuários</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-check text-secondary-500 text-xs"></i>
                                                <span class="text-gray-700">{{ number_format($plan->max_patients, 0, ',', '.') }} pacientes</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-check text-secondary-500 text-xs"></i>
                                                <span class="text-gray-700">{{ number_format($plan->max_monthly_appointments, 0, ',', '.') }} agend./mês</span>
                                            </li>
                                            @if($plan->whatsapp_enabled)
                                                <li class="flex items-center gap-2">
                                                    <i class="fab fa-whatsapp text-secondary-500 text-xs"></i>
                                                    <span class="text-gray-700 font-medium">WhatsApp</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('plan_id')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-200 my-8"></div>

                    {{-- Seção 2: Dados da Clínica --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Dados da clínica</h2>
                        <p class="text-gray-600 mb-6">Informações básicas sobre sua clínica</p>
                        
                        <div class="grid md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nome da Clínica <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-hospital text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('clinic_name') border-red-500 @enderror" 
                                           placeholder="Ex: Clínica Saúde & Vida"
                                           required>
                                </div>
                                @error('clinic_name')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Subdomínio <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-link text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition lowercase @error('subdomain') border-red-500 @enderror" 
                                           placeholder="suaclinica"
                                           pattern="[a-z0-9-]+"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                        <div id="subdomain-status" class="hidden"></div>
                                    </div>
                                </div>
                                <div id="subdomain-message" class="text-xs mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-info-circle text-gray-500"></i>
                                    <span class="text-gray-500">Seu endereço será: <strong id="subdomain-preview" class="text-primary-600">suaclinica.imunify.com.br</strong></span>
                                </div>
                                @error('subdomain')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email da Clínica <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('email') border-red-500 @enderror" 
                                           placeholder="contato@clinica.com"
                                           autocomplete="email"
                                           required>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Telefone <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('phone') border-red-500 @enderror" 
                                           placeholder="(11) 99999-9999"
                                           autocomplete="tel"
                                           required>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    CNPJ <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('cnpj') border-red-500 @enderror" 
                                           placeholder="00.000.000/0000-00"
                                           required>
                                </div>
                                @error('cnpj')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 my-8"></div>

                    {{-- Seção 3: Dados do Administrador --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Seus dados de acesso</h2>
                        <p class="text-gray-600 mb-6">Crie sua conta de administrador</p>
                        
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Seu Nome <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="text" name="admin_name" value="{{ old('admin_name') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('admin_name') border-red-500 @enderror" 
                                           placeholder="João Silva"
                                           required>
                                </div>
                                @error('admin_name')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email de Login <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="email" name="admin_email" value="{{ old('admin_email') }}" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('admin_email') border-red-500 @enderror" 
                                           placeholder="joao@email.com"
                                           autocomplete="username"
                                           required>
                                </div>
                                @error('admin_email')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Senha <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="password" name="password" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition @error('password') border-red-500 @enderror" 
                                           placeholder="Mínimo 8 caracteres"
                                           autocomplete="new-password"
                                           required>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirmar Senha <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition" 
                                           placeholder="Digite a senha novamente"
                                           autocomplete="new-password"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 my-8"></div>

                    {{-- Termos e Condições --}}
                    <div class="mb-6">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <div class="flex items-center h-6">
                                <input type="checkbox" name="accept_terms" value="1" 
                                       class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 focus:ring-2 @error('accept_terms') border-red-500 @enderror"
                                       {{ old('accept_terms') ? 'checked' : '' }}
                                       required>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-700">
                                    Li e aceito os 
                                    <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold hover:underline">Termos de Uso</a> 
                                    e a 
                                    <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold hover:underline">Política de Privacidade</a>
                                    <span class="text-red-500">*</span>
                                </span>
                            </div>
                        </label>
                        @error('accept_terms')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1 ml-8">
                                <i class="fas fa-exclamation-circle text-xs"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Botão Submit --}}
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 hover:from-primary-600 hover:to-secondary-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-3 text-lg pulse-glow">
                            <i class="fas fa-gift"></i>
                            <span>Começar Teste Grátis de 7 Dias</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="container mx-auto px-4 text-center text-sm text-gray-600 max-w-7xl">
            <p>&copy; {{ date('Y') }} Imunify. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Máscaras
        const phoneInput = document.getElementById('phone');
        const cnpjInput = document.getElementById('cnpj');
        
        if (phoneInput) {
            IMask(phoneInput, {
                mask: '(00) 00000-0000'
            });
        }
        
        if (cnpjInput) {
            IMask(cnpjInput, {
                mask: '00.000.000/0000-00'
            });
        }

        // Verificação de disponibilidade de subdomínio
        const subdomainInput = document.getElementById('subdomain');
        const subdomainMessage = document.getElementById('subdomain-message');
        const subdomainPreview = document.getElementById('subdomain-preview');
        const subdomainStatus = document.getElementById('subdomain-status');
        let checkTimeout;

        subdomainInput?.addEventListener('input', function(e) {
            // Limpar e formatar
            let value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
            this.value = value;
            
            // Atualizar preview
            if (value) {
                subdomainPreview.textContent = value + '.imunify.com.br';
            } else {
                subdomainPreview.textContent = 'suaclinica.imunify.com.br';
            }

            // Limpar timeout anterior
            clearTimeout(checkTimeout);
            
            // Resetar visual
            this.classList.remove('border-green-500', 'border-red-500', 'pr-12');
            subdomainStatus.innerHTML = '';
            subdomainStatus.classList.add('hidden');

            // Se tiver pelo menos 3 caracteres, verificar
            if (value.length >= 3) {
                // Mostrar loading
                subdomainStatus.innerHTML = '<i class="fas fa-spinner fa-spin text-gray-400"></i>';
                subdomainStatus.classList.remove('hidden');
                this.classList.add('pr-12');

                // Aguardar 500ms antes de verificar (debounce)
                checkTimeout = setTimeout(() => {
                    checkSubdomainAvailability(value);
                }, 500);
            } else if (value.length > 0) {
                showSubdomainMessage('info', 'Digite pelo menos 3 caracteres');
            } else {
                showSubdomainMessage('default', 'Seu endereço será: <strong id="subdomain-preview" class="text-primary-600">suaclinica.imunify.com.br</strong>');
            }
        });

        function checkSubdomainAvailability(subdomain) {
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
                    // Disponível
                    subdomainInput.classList.remove('border-red-500');
                    subdomainInput.classList.add('border-green-500');
                    subdomainStatus.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
                    showSubdomainMessage('success', '✓ Disponível! Seu endereço será: <strong class="text-green-600">' + subdomain + '.imunify.com.br</strong>');
                } else {
                    // Não disponível
                    subdomainInput.classList.remove('border-green-500');
                    subdomainInput.classList.add('border-red-500');
                    subdomainStatus.innerHTML = '<i class="fas fa-times-circle text-red-500"></i>';
                    showSubdomainMessage('error', '✗ Este subdomínio já está em uso. Tente outro.');
                }
            })
            .catch(error => {
                console.error('Erro ao verificar subdomínio:', error);
                subdomainStatus.innerHTML = '<i class="fas fa-exclamation-triangle text-yellow-500"></i>';
                showSubdomainMessage('warning', 'Não foi possível verificar. Tente novamente.');
            });
        }

        function showSubdomainMessage(type, message) {
            const icons = {
                'default': '<i class="fas fa-info-circle text-gray-500"></i>',
                'info': '<i class="fas fa-info-circle text-blue-500"></i>',
                'success': '<i class="fas fa-check-circle text-green-500"></i>',
                'error': '<i class="fas fa-times-circle text-red-500"></i>',
                'warning': '<i class="fas fa-exclamation-triangle text-yellow-500"></i>'
            };

            const colors = {
                'default': 'text-gray-500',
                'info': 'text-blue-600',
                'success': 'text-green-600',
                'error': 'text-red-600',
                'warning': 'text-yellow-600'
            };

            subdomainMessage.innerHTML = icons[type] + '<span class="' + colors[type] + '">' + message + '</span>';
        }
    </script>
</body>
</html>
