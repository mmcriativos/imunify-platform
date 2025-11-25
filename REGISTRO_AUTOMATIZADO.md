# 🚀 Fluxo de Registro Automatizado - Produção

## Overview do Processo

Quando uma clínica se registra no Imunify, o sistema:
1. ✅ Valida dados e disponibilidade do subdomínio
2. ✅ Cria tenant no banco central
3. ✅ Cria banco de dados isolado para a clínica
4. ✅ Executa todas as migrations automaticamente
5. ✅ Cria usuário admin da clínica
6. ✅ Configura período de trial (7-14 dias)
7. ✅ Redireciona automaticamente para o dashboard da clínica
8. ✅ Envia email de boas-vindas

**Tempo total: 3-5 segundos** ⚡

---

## Implementação Técnica

### 1. Controller de Registro

```php
// app/Http/Controllers/Auth/RegisterTenantController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterTenantController extends Controller
{
    /**
     * Mostrar formulário de registro
     */
    public function showForm()
    {
        $plans = Plan::active()->get();
        
        return view('auth.register-clinic', compact('plans'));
    }

    /**
     * Processar registro da clínica
     */
    public function register(Request $request)
    {
        // 1. Validar dados
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // 2. Criar Tenant
            $tenant = $this->createTenant($request);

            // 3. Criar Domínio (subdomínio)
            $this->createDomain($tenant, $request->subdomain);

            // 4. Inicializar contexto do tenant
            tenancy()->initialize($tenant);

            // 5. Criar usuário admin
            $user = $this->createAdminUser($request);

            // 6. Popular dados iniciais (opcional)
            $this->seedInitialData($tenant);

            DB::commit();

            // 7. Fazer login automático
            auth()->login($user);

            // 8. Enviar email de boas-vindas (em background)
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->queue(new \App\Mail\WelcomeClinic($tenant, $user));

            // 9. Redirecionar para dashboard da clínica
            $domain = $request->subdomain . '.' . config('app.domain'); // ex: clinica.imunify.com.br
            
            return redirect()
                ->to('https://' . $domain . '/dashboard')
                ->with('success', 'Bem-vindo ao Imunify! Sua clínica foi criada com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Erro ao criar tenant: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Erro ao criar sua clínica. Por favor, tente novamente.')
                ->withInput();
        }
    }

    /**
     * Validar dados do formulário
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // Dados da clínica
            'clinic_name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required', 
                'string', 
                'max:50', 
                'alpha_dash',
                'unique:domains,domain', // Verificar se subdomínio está disponível
                function ($attribute, $value, $fail) {
                    // Bloquear subdomínios reservados
                    $reserved = ['www', 'admin', 'api', 'app', 'mail', 'ftp', 'localhost'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Este subdomínio está reservado.');
                    }
                },
            ],
            
            // Dados de contato
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'cnpj' => ['nullable', 'string', 'size:14'],
            
            // Endereço
            'cep' => ['nullable', 'string', 'size:8'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'size:2'],
            
            // Usuário admin
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            // Plano
            'plan_id' => ['required', 'exists:plans,id'],
            
            // Termos
            'accept_terms' => ['accepted'],
        ], [
            'subdomain.unique' => 'Este subdomínio já está em uso. Escolha outro.',
            'subdomain.alpha_dash' => 'O subdomínio deve conter apenas letras, números e hífens.',
            'accept_terms.accepted' => 'Você deve aceitar os termos de uso.',
        ]);
    }

    /**
     * Criar tenant no banco central
     */
    protected function createTenant(Request $request)
    {
        $tenant = Tenant::create([
            'id' => Str::slug($request->subdomain), // ID = subdomínio
        ]);

        // Configurar dados do tenant
        $tenant->plan_id = $request->plan_id;
        $tenant->clinic_name = $request->clinic_name;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->cnpj = $request->cnpj;
        $tenant->address = $request->address;
        $tenant->city = $request->city;
        $tenant->state = $request->state;
        $tenant->zip_code = $request->cep;
        $tenant->status = 'active';
        $tenant->timezone = 'America/Sao_Paulo';
        
        // Trial de 14 dias
        $tenant->trial_ends_at = now()->addDays(14);
        
        // Primeira cobrança em 14 dias
        $tenant->subscription_ends_at = now()->addDays(14);
        
        $tenant->save();

        return $tenant;
    }

    /**
     * Criar domínio (subdomínio) do tenant
     */
    protected function createDomain(Tenant $tenant, string $subdomain)
    {
        $domain = env('APP_ENV') === 'local' 
            ? $subdomain . '.localhost'  // Local: clinica.localhost
            : $subdomain . '.' . config('app.domain'); // Prod: clinica.imunify.com.br

        $tenant->domains()->create([
            'domain' => $domain,
        ]);
    }

    /**
     * Criar usuário admin no banco do tenant
     */
    protected function createAdminUser(Request $request)
    {
        return User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verificado
        ]);
    }

    /**
     * Popular dados iniciais (opcional)
     */
    protected function seedInitialData(Tenant $tenant)
    {
        // Criar algumas cidades padrão de SP
        DB::table('cidades')->insert([
            ['nome' => 'São Paulo', 'estado' => 'SP', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Campinas', 'estado' => 'SP', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Santos', 'estado' => 'SP', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Criar algumas vacinas padrão
        DB::table('vacinas')->insert([
            [
                'nome' => 'Influenza (Gripe)',
                'fabricante' => 'Diversos',
                'doses_necessarias' => 1,
                'intervalo_doses' => null,
                'idade_minima' => '6 meses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'COVID-19',
                'fabricante' => 'Diversos',
                'doses_necessarias' => 2,
                'intervalo_doses' => 28,
                'idade_minima' => '6 meses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Hepatite B',
                'fabricante' => 'Diversos',
                'doses_necessarias' => 3,
                'intervalo_doses' => 30,
                'idade_minima' => 'Ao nascer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Verificar disponibilidade de subdomínio (AJAX)
     */
    public function checkSubdomain(Request $request)
    {
        $subdomain = $request->input('subdomain');
        
        // Verificar se é reservado
        $reserved = ['www', 'admin', 'api', 'app', 'mail', 'ftp', 'localhost'];
        if (in_array(strtolower($subdomain), $reserved)) {
            return response()->json([
                'available' => false,
                'message' => 'Este subdomínio está reservado.'
            ]);
        }
        
        // Verificar se já existe
        $domain = env('APP_ENV') === 'local' 
            ? $subdomain . '.localhost'
            : $subdomain . '.' . config('app.domain');
            
        $exists = DB::table('domains')
            ->where('domain', $domain)
            ->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists 
                ? 'Este subdomínio já está em uso.' 
                : 'Subdomínio disponível!',
            'full_domain' => $domain,
        ]);
    }
}
```

---

### 2. Routes (Central)

```php
// routes/web.php

use App\Http\Controllers\Auth\RegisterTenantController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Registro de clínicas
Route::get('/registrar', [RegisterTenantController::class, 'showForm'])
    ->name('register.form');

Route::post('/registrar', [RegisterTenantController::class, 'register'])
    ->name('register.submit');

// Verificar disponibilidade de subdomínio (AJAX)
Route::post('/check-subdomain', [RegisterTenantController::class, 'checkSubdomain'])
    ->name('check.subdomain');
```

---

### 3. View do Formulário

```blade
{{-- resources/views/auth/register-clinic.blade.php --}}

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre sua Clínica - Imunify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Cadastre sua Clínica</h1>
                <p class="text-gray-600">Comece seu período de teste gratuito de 14 dias</p>
            </div>

            {{-- Formulário --}}
            <form method="POST" action="{{ route('register.submit') }}" class="bg-white rounded-2xl shadow-xl p-8">
                @csrf

                {{-- Erros --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Escolher Plano --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">1. Escolha seu plano</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($plans as $plan)
                            <label class="cursor-pointer">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" 
                                       class="peer sr-only" {{ old('plan_id') == $plan->id ? 'checked' : '' }} required>
                                <div class="border-2 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 rounded-xl p-4 transition">
                                    <h3 class="font-bold text-lg">{{ $plan->name }}</h3>
                                    <p class="text-2xl font-bold text-indigo-600 my-2">
                                        {{ $plan->formatted_monthly_price }}<span class="text-sm">/mês</span>
                                    </p>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        <li>✓ {{ $plan->max_users }} usuários</li>
                                        <li>✓ {{ $plan->max_patients }} pacientes</li>
                                        @if($plan->whatsapp_enabled)
                                            <li>✓ WhatsApp integrado</li>
                                        @endif
                                    </ul>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Dados da Clínica --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">2. Dados da clínica</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Nome da Clínica</label>
                            <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Escolha seu subdomínio</label>
                            <div class="flex items-center">
                                <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain') }}" 
                                       class="flex-1 px-4 py-2 border rounded-l-lg" 
                                       placeholder="minhaclínica" required>
                                <span class="px-4 py-2 bg-gray-100 border border-l-0 rounded-r-lg">
                                    .imunify.com.br
                                </span>
                            </div>
                            <p id="subdomain-status" class="text-sm mt-1"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">CNPJ (opcional)</label>
                            <input type="text" name="cnpj" value="{{ old('cnpj') }}" 
                                   class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>
                </div>

                {{-- Usuário Admin --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">3. Crie sua conta de administrador</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Nome Completo</label>
                            <input type="text" name="admin_name" value="{{ old('admin_name') }}" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Email de Login</label>
                            <input type="email" name="admin_email" value="{{ old('admin_email') }}" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Senha</label>
                            <input type="password" name="password" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                    </div>
                </div>

                {{-- Termos --}}
                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" name="accept_terms" class="mt-1 mr-2" required>
                        <span class="text-sm text-gray-600">
                            Aceito os <a href="#" class="text-indigo-600">Termos de Uso</a> e 
                            <a href="#" class="text-indigo-600">Política de Privacidade</a>
                        </span>
                    </label>
                </div>

                {{-- Botão de Envio --}}
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition">
                    Começar Período de Teste Gratuito
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Não é necessário cartão de crédito para o período de teste
                </p>
            </form>

        </div>
    </div>

    {{-- Script para verificar subdomínio --}}
    <script>
        const subdomainInput = document.getElementById('subdomain');
        const statusDiv = document.getElementById('subdomain-status');
        let timeout = null;

        subdomainInput.addEventListener('input', function() {
            clearTimeout(timeout);
            
            const subdomain = this.value.trim();
            
            if (subdomain.length < 3) {
                statusDiv.textContent = '';
                return;
            }

            statusDiv.textContent = 'Verificando...';
            statusDiv.className = 'text-sm mt-1 text-gray-500';

            timeout = setTimeout(() => {
                fetch('{{ route("check.subdomain") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ subdomain: subdomain })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        statusDiv.textContent = '✓ ' + data.message + ' Seu endereço: ' + data.full_domain;
                        statusDiv.className = 'text-sm mt-1 text-green-600';
                    } else {
                        statusDiv.textContent = '✗ ' + data.message;
                        statusDiv.className = 'text-sm mt-1 text-red-600';
                    }
                });
            }, 500);
        });
    </script>

</body>
</html>
```

---

### 4. Email de Boas-vindas

```php
// app/Mail/WelcomeClinic.php

namespace App\Mail;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeClinic extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;
    public $user;

    public function __construct(Tenant $tenant, User $user)
    {
        $this->tenant = $tenant;
        $this->user = $user;
    }

    public function build()
    {
        $domain = $this->tenant->domains->first()->domain;
        
        return $this->subject('Bem-vindo ao Imunify!')
                    ->markdown('emails.welcome-clinic', [
                        'clinic_name' => $this->tenant->clinic_name,
                        'admin_name' => $this->user->name,
                        'dashboard_url' => 'https://' . $domain . '/dashboard',
                        'trial_days' => $this->tenant->trial_ends_at->diffInDays(now()),
                    ]);
    }
}
```

---

## ⚙️ Configurações de Produção

### DNS Wildcard (*.imunify.com.br)

```
# No painel do seu provedor de DNS (Cloudflare, etc):

Tipo    Nome    Destino
A       @       [IP do servidor]
CNAME   *       imunify.com.br
```

### Nginx Configuration

```nginx
# /etc/nginx/sites-available/imunify

server {
    listen 80;
    server_name imunify.com.br *.imunify.com.br;
    
    # Redirecionar para HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name imunify.com.br *.imunify.com.br;
    
    ssl_certificate /etc/letsencrypt/live/imunify.com.br/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/imunify.com.br/privkey.pem;
    
    root /var/www/imunify/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### SSL Certificate (Wildcard)

```bash
# Instalar certbot
sudo apt install certbot python3-certbot-nginx

# Gerar certificado wildcard
sudo certbot certonly --manual --preferred-challenges=dns \
  -d imunify.com.br -d *.imunify.com.br

# Seguir instruções para adicionar registro TXT no DNS
```

---

## 🔄 Fluxo Completo (Timeline)

```
T=0s    → Usuário preenche formulário
T=0.5s  → Validação de dados
T=1s    → Criar tenant no DB central
T=1.5s  → Criar banco tenantXXX
T=2s    → Executar migrations (19 tabelas)
T=2.5s  → Criar usuário admin
T=3s    → Popular dados iniciais
T=3.5s  → Login automático
T=4s    → Enviar email (background)
T=4.5s  → Redirecionar para https://clinica.imunify.com.br/dashboard

✅ PRONTO! Usuário já está logado e usando o sistema
```

---

## 📊 Monitoramento

### Metrics a acompanhar:

```php
// Dashboard Admin
- Total de registros/dia
- Taxa de conversão (trial → pagante)
- Tempo médio de onboarding
- Erros de criação de tenant
- Uso de recursos por tenant
```

---

## 🎯 Próximos Passos

Quer que eu implemente o controller e as views agora?

1. ✅ **RegisterTenantController** - Lógico de criação automatizada
2. ✅ **View do formulário** - Interface de cadastro
3. ✅ **Email de boas-vindas** - Confirmação automática
4. ⏳ **Middleware de verificação de trial** - Bloquear após expirar
5. ⏳ **Sistema de pagamento** - Integração com Stripe/Mercado Pago

