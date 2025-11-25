# 🏢 MultiImune → Imunify (Multi-Tenant SaaS)

## 🎯 Visão Geral da Transformação

Transformar o MultiImune em **Imunify**, um sistema SaaS multi-tenant onde cada clínica/posto de saúde terá seu próprio ambiente isolado.

---

## ✅ O que já foi feito:

### 1. **Pacote Tenancy Instalado**
- ✅ `stancl/tenancy` v3.9.1 instalado
- ✅ Configurações publicadas
- ✅ TenancyServiceProvider registrado
- ✅ Migrations executadas:
  - `tenants` - Tabela de clínicas (tenants)
  - `domains` - Domínios/subdomínios por tenant
  - `tenant_user_impersonation_tokens` - Tokens para impersonation

### 2. **Arquivos Criados**
- ✅ `config/tenancy.php` - Configuração completa
- ✅ `routes/tenant.php` - Rotas específicas por tenant
- ✅ `app/Providers/TenancyServiceProvider.php` - Provider do tenancy

---

## 📋 Próximos Passos (Ordem de Implementação)

### **FASE 1: Configuração Base** ⏳

#### 1.1 Configurar Identificação de Tenants
Você tem 3 opções:

**Opção A: Subdomínios (Recomendado)**
```
clinicaA.imunify.com.br
clinicaB.imunify.com.br  
clinicaC.imunify.com.br
```

**Opção B: Domínios Próprios**
```
clinicaexemplo.com.br
outraclinia.com
```

**Opção C: Path-based**
```
imunify.com.br/clinica-a
imunify.com.br/clinica-b
```

**👉 Recomendação: Opção A (Subdomínios) - mais profissional e escalável**

#### 1.2 Definir Estrutura de Dados

**Banco de Dados Central** (database padrão):
- `users` - Usuários admin do sistema
- `tenants` - Clínicas cadastradas
- `domains` - Domínios/subdomínios
- `plans` - Planos de assinatura (Básico, Pro, Enterprise)
- `subscriptions` - Assinaturas ativas

**Banco de Dados por Tenant** (cada clínica tem seu próprio):
- `users` - Funcionários da clínica
- `pacientes`
- `atendimentos`
- `agendamentos`
- `vacinas`
- `lembretes_enviados`
- `confirmacoes_presenca`
- Todas as tabelas existentes do MultiImune

---

### **FASE 2: Reestruturação de Modelos** 📦

#### 2.1 Models que ficam CENTRAIS (sem tenant)
```php
// app/Models/Central/
- Tenant.php (já existe via package)
- User.php (admin central)
- Plan.php
- Subscription.php
```

#### 2.2 Models que são POR TENANT
```php
// app/Models/ (atual - permanece)
- User.php (usuários da clínica)
- Paciente.php
- Atendimento.php
- Agendamento.php
- Vacina.php
- LembreteEnviado.php
- ConfirmacaoPresenca.php
// Todos os models atuais
```

---

### **FASE 3: Migrations Separadas** 🗄️

#### 3.1 Migrations Centrais (ficam em database/migrations)
- `create_users_table` (admin)
- `create_tenants_table` ✅ (já existe)
- `create_domains_table` ✅ (já existe)
- `create_plans_table` (novo)
- `create_subscriptions_table` (novo)

#### 3.2 Migrations por Tenant (mover para database/migrations/tenant)
- **TODAS as migrations atuais** do MultiImune:
  - `create_users_table` (funcionários)
  - `create_pacientes_table`
  - `create_atendimentos_table`
  - `create_agendamentos_table`
  - `create_vacinas_table`
  - `create_lembretes_enviados_table`
  - `create_confirmacoes_presenca_table`
  - Todas as demais...

---

### **FASE 4: Rotas Separadas** 🛣️

#### 4.1 Rotas Centrais (routes/web.php)
```php
// Domínio principal: imunify.com.br
Route::get('/', 'LandingController@index'); // Landing page
Route::get('/pricing', 'PricingController@index'); // Planos
Route::post('/register', 'TenantController@register'); // Cadastro clínica

// Admin central
Route::prefix('central')->group(function () {
    Route::get('/login', 'Auth\CentralLoginController@showLoginForm');
    Route::post('/login', 'Auth\CentralLoginController@login');
    
    Route::middleware('auth:central')->group(function () {
        Route::get('/dashboard', 'Central\DashboardController@index');
        Route::resource('/tenants', 'Central\TenantController');
        Route::get('/analytics', 'Central\AnalyticsController@index');
    });
});
```

#### 4.2 Rotas por Tenant (routes/tenant.php) ✅
```php
// Subdomínio: clinica.imunify.com.br
// TODAS as rotas atuais do MultiImune vão aqui!
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('pacientes', PacienteController::class);
    Route::resource('atendimentos', AtendimentoController::class);
    // ... todas rotas existentes
});
```

---

### **FASE 5: Autenticação Separada** 🔐

#### 5.1 Guards Separados (config/auth.php)
```php
'guards' => [
    'web' => [  // Para tenants (clínicas)
        'driver' => 'session',
        'provider' => 'users',
    ],
    'central' => [  // Para admin central
        'driver' => 'session',
        'provider' => 'central_users',
    ],
],

'providers' => [
    'users' => [  // Usuários das clínicas
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'central_users' => [  // Admins do sistema
        'driver' => 'eloquent',
        'model' => App\Models\Central\User::class,
    ],
],
```

---

### **FASE 6: Criação de Tenants** 🏗️

#### 6.1 Criar Tenant Manualmente (Para testes)
```bash
php artisan tinker

$tenant = Tenant::create(['id' => 'clinica-exemplo']);
$tenant->domains()->create(['domain' => 'clinica-exemplo.localhost']);
```

#### 6.2 Sistema de Cadastro Automático
```php
// Controller para auto-cadastro
public function register(Request $request)
{
    $validated = $request->validate([
        'clinic_name' => 'required|string',
        'subdomain' => 'required|unique:domains,domain',
        'admin_name' => 'required|string',
        'admin_email' => 'required|email',
        'admin_password' => 'required|min:8',
        'plan' => 'required|exists:plans,id',
    ]);

    // Criar tenant
    $tenant = Tenant::create([
        'id' => Str::slug($validated['subdomain']),
        'plan_id' => $validated['plan'],
    ]);

    // Criar domínio
    $tenant->domains()->create([
        'domain' => $validated['subdomain'] . '.imunify.com.br'
    ]);

    // Criar usuário admin do tenant
    $tenant->run(function () use ($validated) {
        User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'is_admin' => true,
        ]);
    });

    return redirect()->to('https://' . $validated['subdomain'] . '.imunify.com.br/login');
}
```

---

### **FASE 7: Configuração WhatsApp por Tenant** 📱

#### 7.1 Cada Clínica Terá Suas Próprias Credenciais Z-API

```php
// Migration tenant: add_whatsapp_config_to_tenants
Schema::table('tenants', function (Blueprint $table) {
    $table->string('whatsapp_api_url')->nullable();
    $table->string('whatsapp_instance')->nullable();
    $table->string('whatsapp_token')->nullable();
    $table->string('whatsapp_client_token')->nullable();
});
```

```php
// Atualizar WhatsAppService
public function __construct()
{
    $tenant = tenancy()->tenant;
    
    $this->apiUrl = $tenant->whatsapp_api_url ?? config('services.evolution.url');
    $this->apiKey = $tenant->whatsapp_token ?? config('services.evolution.api_key');
    $this->instanceName = $tenant->whatsapp_instance ?? config('services.evolution.instance_name');
    $this->clientToken = $tenant->whatsapp_client_token ?? config('services.evolution.client_token');
}
```

---

### **FASE 8: Seeds e Dados Iniciais** 🌱

#### 8.1 Seeder para Novos Tenants
```php
// database/seeders/TenantSeeder.php
public function run()
{
    // Criar vacinas padrão
    Vacina::create(['nome' => 'Influenza (Gripe)', 'doses' => 1]);
    Vacina::create(['nome' => 'Covid-19', 'doses' => 2]);
    // ...

    // Criar usuário admin
    User::create([
        'name' => 'Administrador',
        'email' => tenant('id') . '@imunify.com.br',
        'password' => Hash::make('senha-temporaria-123'),
        'is_admin' => true,
    ]);
}
```

#### 8.2 Executar Seeder Automaticamente
```php
// TenancyServiceProvider
Event::listen(TenantCreated::class, function (TenantCreated $event) {
    $event->tenant->run(function () {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--class' => 'TenantSeeder']);
    });
});
```

---

### **FASE 9: Planos e Assinaturas** 💳

#### 9.1 Criar Tabela de Planos
```php
Schema::create('plans', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Básico, Pro, Enterprise
    $table->decimal('price', 10, 2);
    $table->integer('max_users')->nullable();
    $table->integer('max_patients')->nullable();
    $table->integer('max_monthly_appointments')->nullable();
    $table->boolean('whatsapp_enabled')->default(true);
    $table->boolean('analytics_enabled')->default(false);
    $table->boolean('multi_unit_enabled')->default(false);
    $table->timestamps();
});
```

#### 9.2 Limitar Recursos por Plano
```php
// Middleware: CheckPlanLimits
public function handle($request, Closure $next)
{
    $tenant = tenancy()->tenant;
    $plan = $tenant->plan;

    // Verificar limite de pacientes
    if ($plan && $plan->max_patients) {
        $count = Paciente::count();
        if ($count >= $plan->max_patients) {
            return redirect()->back()->with('error', 'Limite de pacientes atingido!');
        }
    }

    return $next($request);
}
```

---

### **FASE 10: Painel Admin Central** 👨‍💼

#### 10.1 Dashboard Central
- Total de clínicas ativas
- Receita mensal
- Novas assinaturas
- Clínicas por plano
- Gráficos de crescimento
- Lista de todos tenants
- Impersonation (entrar como clínica)

#### 10.2 Gerenciamento de Tenants
- Criar/editar/deletar clínicas
- Alterar plano
- Suspender/ativar clínica
- Ver estatísticas por clínica
- Logs de atividades

---

## 🔧 Comandos Úteis

```bash
# Criar tenant manualmente
php artisan tenants:create {id}

# Listar todos tenants
php artisan tenants:list

# Rodar migrations em todos tenants
php artisan tenants:migrate

# Rodar seeder em todos tenants
php artisan tenants:seed

# Rodar comando em tenant específico
php artisan tenants:run {tenant_id} {command}

# Deletar tenant
php artisan tenants:delete {id}
```

---

## 📊 Estrutura de Arquivos Final

```
app/
├── Models/
│   ├── Central/           # Models centrais
│   │   ├── User.php       # Admin central
│   │   ├── Plan.php
│   │   └── Subscription.php
│   └── ...                # Models por tenant (atuais)
├── Http/
│   └── Controllers/
│       ├── Central/       # Controllers admin central
│       └── ...            # Controllers tenants (atuais)
├── Providers/
│   └── TenancyServiceProvider.php ✅

config/
└── tenancy.php ✅

database/
├── migrations/            # Migrations centrais
│   ├── 2019_09_15_000010_create_tenants_table.php ✅
│   ├── 2019_09_15_000020_create_domains_table.php ✅
│   └── create_plans_table.php
└── migrations/tenant/     # Migrations por tenant (MOVER ATUAIS)

routes/
├── web.php                # Rotas centrais
├── tenant.php ✅          # Rotas por tenant
└── api.php

resources/views/
├── central/               # Views admin central
│   ├── dashboard.blade.php
│   └── tenants/
└── ...                    # Views tenants (atuais)
```

---

## 🚀 Plano de Migração

### **Etapa 1: Configurar Subdomínios (Localhost)**
```apache
# httpd-vhosts.conf ou similar
<VirtualHost *:80>
    ServerName imunify.test
    ServerAlias *.imunify.test
    DocumentRoot "M:/laragon/www/multiimune/public"
</VirtualHost>
```

### **Etapa 2: Mover Migrations para Tenant**
```bash
# Criar pasta
mkdir database/migrations/tenant

# Mover TODAS migrations atuais (exceto as 3 do tenancy)
Move-Item database/migrations/*.php database/migrations/tenant/
```

### **Etapa 3: Atualizar Models**
Adicionar trait `BelongsToTenant` onde necessário (opcional, o tenancy já isola automaticamente)

### **Etapa 4: Mover Rotas**
Copiar TODAS rotas de `web.php` para `tenant.php`

### **Etapa 5: Criar Tenant de Teste**
```bash
php artisan tinker
>>> $tenant = Tenant::create(['id' => 'clinic-test'])
>>> $tenant->domains()->create(['domain' => 'clinic-test.imunify.test'])
```

### **Etapa 6: Rodar Migrations do Tenant**
```bash
php artisan tenants:migrate
```

### **Etapa 7: Testar Acesso**
```
http://clinic-test.imunify.test
```

---

## 💡 Dicas Importantes

1. **Isolamento Total**: Cada tenant tem seu próprio banco de dados separado
2. **Performance**: Cache por tenant configurado automaticamente
3. **Segurança**: Impossível acessar dados de outro tenant
4. **WhatsApp**: Cada clínica usa suas próprias credenciais Z-API
5. **Backups**: Backup por tenant para segurança
6. **Escalabilidade**: Adicionar novos tenants é instantâneo

---

## ⚠️ Avisos e Cuidados

1. **BACKUP COMPLETO** antes de começar a migração
2. Testar TUDO em ambiente de desenvolvimento primeiro
3. Documentar credenciais de cada tenant
4. Criar plano de rollback caso necessário
5. Validar isolamento de dados entre tenants

---

## 📞 Próximos Passos Imediatos

1. ✅ Decidir: Subdomínios, Domínios ou Path?
2. ✅ Configurar servidor local para aceitar subdomínios
3. ✅ Mover migrations para pasta tenant/
4. ✅ Criar tenant de teste
5. ✅ Validar isolamento
6. ✅ Criar painel admin central

**Pronto para começar?** 🚀
