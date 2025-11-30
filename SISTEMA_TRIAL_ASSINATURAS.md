# Sistema de Gerenciamento de Trial e Assinaturas

## 📋 Visão Geral

Este documento descreve a implementação completa do sistema de gestão do ciclo de vida de assinaturas dos tenants, incluindo período de teste, período de graça, suspensão, arquivamento e exclusão.

## 🔄 Ciclo de Vida do Tenant

### Fluxo Completo

```
TRIAL (7 dias) 
    ↓ (acesso completo)
GRACE PERIOD (7 dias) 
    ↓ (modo somente leitura)
SUSPENSO (30 dias) 
    ↓ (sem acesso)
ARQUIVADO (60 dias) 
    ↓ (última chance)
DELETADO 
    ↓ (permanente)
```

### Detalhamento das Etapas

#### 1. **Trial (7 dias)**
- ✅ Acesso completo a todos os recursos
- ✅ Banner informativo no dashboard
- ✅ Contagem regressiva visual
- 📧 Email: 2 dias antes do fim

**Campos:**
- `trial_ends_at`: Data de término do trial

#### 2. **Grace Period (7 dias)**
- ⚠️ Modo somente leitura (read-only)
- ❌ Não pode criar/editar/excluir
- ✅ Pode visualizar todos os dados
- 🔔 Banner urgente no dashboard
- 📧 Emails: início + 3 dias antes do fim

**Campos:**
- `grace_period_ends_at`: Data de término do período de graça

#### 3. **Suspenso (30 dias)**
- 🚫 Sem acesso ao sistema
- 💾 Dados preservados
- 📄 Página de suspensão com CTA
- 📧 Emails: suspensão + avisos semanais

**Campos:**
- `suspended_at`: Data da suspensão

#### 4. **Arquivado (60 dias)**
- 🚫 Sem acesso ao sistema
- ⚠️ Última chance antes da exclusão
- 📄 Página de arquivamento urgente
- 📧 Emails: arquivamento + avisos mensais

**Campos:**
- `archived_at`: Data do arquivamento

#### 5. **Deletado**
- 🗑️ Exclusão permanente
- ❌ Não pode ser recuperado
- 🔥 Todos os dados removidos

## 🗄️ Estrutura do Banco de Dados

### Tabela `tenants`

```sql
-- Campos existentes
id
trial_ends_at         -- Término do período de teste

-- Novos campos adicionados
grace_period_ends_at  -- Término do período de graça (nullable)
suspended_at          -- Data da suspensão (nullable)
archived_at           -- Data do arquivamento (nullable)
subscription_id       -- ID da assinatura ativa (nullable)
```

## 🛠️ Componentes Implementados

### 1. **Model: `app/Models/Tenant.php`**

#### Campos Fillable
```php
protected $fillable = [
    // ... campos existentes
    'grace_period_ends_at',
    'suspended_at',
    'archived_at',
];
```

#### Métodos de Status
```php
// Verificadores de estado
onTrial()              // Em período de teste
inGracePeriod()        // Em período de graça
isSuspended()          // Conta suspensa
isArchived()           // Conta arquivada
hasActiveSubscription() // Tem assinatura ativa

// Verificadores de acesso
canAccess()            // Pode acessar o sistema
isReadOnly()           // Está em modo somente leitura
subscriptionExpired()  // Assinatura expirou
```

### 2. **Middleware: `app/Http/Middleware/CheckTenantAccess.php`**

Aplicado em todas as rotas autenticadas via alias `tenant.access`.

#### Fluxo de Verificação
1. Se não é tenant (domínio central) → permite acesso
2. Se está suspenso/arquivado → redireciona para página de status
3. Se está em grace period E é requisição de escrita → bloqueia com mensagem
4. Se trial expirou sem assinatura → redireciona para página de assinatura

#### Rotas Permitidas Mesmo Expirado
- `dashboard`
- `profile.*`
- `subscription.*`
- `logout`

### 3. **Command: `app/Console/Commands/TenantStatusCommand.php`**

#### Uso
```bash
# Execução normal (faz alterações)
php artisan tenants:check-status

# Modo dry-run (simula sem alterar)
php artisan tenants:check-status --dry-run
```

#### Funcionalidades
1. **Processa trials expirados** → Inicia período de graça (7 dias)
2. **Processa grace periods expirados** → Suspende conta
3. **Processa suspensões antigas** → Arquiva após 30 dias
4. **Processa arquivos antigos** → Deleta após 60 dias

#### Agendamento (cron)
Adicionar ao `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('tenants:check-status')
             ->daily()
             ->at('02:00');
}
```

### 4. **Rotas: `routes/tenant.php`**

#### Rotas Públicas (Status)
```php
/suspended              // Página de conta suspensa
/archived               // Página de conta arquivada
/subscription-required  // Página de assinatura necessária
```

#### Middleware Aplicado
```php
Route::middleware(['auth', 'tenant.access'])->group(function () {
    // Todas as rotas protegidas
});
```

### 5. **Views**

#### Dashboard com Banners
**`resources/views/dashboard/index.blade.php`**

**Banner de Trial:**
- Fundo: gradiente azul claro
- Ícone: relógio
- Barra de progresso: azul/verde
- CTA: "Ver Planos"

**Banner de Grace Period:**
- Fundo: gradiente laranja/vermelho
- Ícone: alerta (animado)
- Barra de progresso: laranja/vermelho
- CTA: "Reativar Conta Agora" (urgente)

#### Páginas de Status

**`resources/views/tenant/suspended.blade.php`**
- Ícone de alerta
- Explicação da suspensão
- Info: dados seguros por 30 dias
- Alerta: exclusão em 90 dias
- CTA: Reativar conta

**`resources/views/tenant/archived.blade.php`**
- Ícone de arquivo
- Status: conta arquivada
- Alerta urgente: exclusão iminente
- Info: última chance
- CTA: Recuperar conta (vermelho)

**`resources/views/tenant/subscription-required.blade.php`**
- Ícone de cadeado
- Plano em destaque
- Features listadas
- Oferta especial
- CTA: Ativar assinatura

## 📊 Fluxo de Dados

### Criação de Tenant
```php
// RegisterTenantController.php
$tenant = Tenant::create([...]);
$tenant->trial_ends_at = now()->addDays(7);
$tenant->save();
```

### Comando Automático (Diário)
```php
// TenantStatusCommand.php

// Trial → Grace
if (trial_ends_at <= now() && !grace_period_ends_at) {
    grace_period_ends_at = now()->addDays(7);
}

// Grace → Suspended
if (grace_period_ends_at <= now() && !suspended_at) {
    suspended_at = now();
}

// Suspended → Archived (após 30 dias)
if (suspended_at <= now()->subDays(30) && !archived_at) {
    archived_at = now();
}

// Archived → Deleted (após 60 dias)
if (archived_at <= now()->subDays(60)) {
    tenant->delete();
}
```

### Verificação de Acesso (Middleware)
```php
// CheckTenantAccess.php

// Bloqueio total
if (isSuspended() || isArchived()) {
    return redirect()->route('suspended/archived');
}

// Bloqueio de escrita
if (isReadOnly() && isWriteRequest()) {
    return back()->with('error', 'Modo somente leitura');
}

// Permite acesso
return $next($request);
```

## 🎯 Como Usar

### Verificar Status no Controller
```php
$tenant = tenant();

if ($tenant->onTrial()) {
    // Ainda em trial
}

if ($tenant->inGracePeriod()) {
    // Em período de graça - exibir aviso
}

if ($tenant->isReadOnly()) {
    // Bloquear botões de criar/editar/excluir
}

if (!$tenant->canAccess()) {
    // Redirecionar para página de status
}
```

### Verificar Status na View (Blade)
```blade
@if(tenant()->onTrial())
    <!-- Mostrar banner de trial -->
@endif

@if(tenant()->isReadOnly())
    <!-- Desabilitar botões de edição -->
    <button disabled>Não disponível no modo leitura</button>
@endif
```

### Executar Verificação Manual
```bash
# Ver o que seria alterado
php artisan tenants:check-status --dry-run

# Aplicar alterações
php artisan tenants:check-status
```

## 📧 Emails (TODO)

### Templates a Criar

1. **Trial Started** - Boas-vindas
2. **Trial Ending Soon** - 2 dias antes do fim (Day 5)
3. **Grace Period Started** - Trial expirou
4. **Grace Period Ending Soon** - 3 dias antes (Day 4)
5. **Account Suspended** - Suspensão ativa
6. **Suspension Reminder** - Avisos semanais
7. **Account Archived** - Arquivamento
8. **Archive Reminder** - Avisos mensais
9. **Final Warning** - Último aviso antes de deletar

## 🔒 Segurança

### Proteção de Rotas
- Middleware `tenant.access` verifica permissões
- Rotas essenciais sempre acessíveis (profile, logout)
- Redirect automático para páginas apropriadas

### Validação de Escrita
```php
// Métodos bloqueados em read-only
POST, PUT, PATCH, DELETE → bloqueados
GET → permitido
```

## 🧪 Testes Recomendados

### Teste Manual do Ciclo Completo

```php
// 1. Criar tenant de teste
$tenant = Tenant::create([...]);
$tenant->trial_ends_at = now()->subDays(1);
$tenant->save();

// 2. Rodar comando
php artisan tenants:check-status --dry-run

// 3. Verificar que grace_period_ends_at foi definido

// 4. Simular fim do grace period
$tenant->grace_period_ends_at = now()->subDays(1);
$tenant->save();

// 5. Rodar comando novamente
php artisan tenants:check-status

// 6. Verificar suspensão...
```

### Checklist de Testes

- [ ] Trial expira → Grace period inicia
- [ ] Grace period expira → Suspensão ativa
- [ ] 30 dias suspenso → Arquivamento
- [ ] 60 dias arquivado → Deletado
- [ ] Banner de trial aparece corretamente
- [ ] Banner de grace period aparece quando apropriado
- [ ] Modo read-only bloqueia POST/PUT/PATCH/DELETE
- [ ] Modo read-only permite GET
- [ ] Página de suspensão acessível
- [ ] Página de arquivamento acessível
- [ ] Comando dry-run não altera dados
- [ ] Comando normal altera dados corretamente

## 📝 Próximos Passos

### Curto Prazo
1. ✅ Executar migration em produção
2. ⏳ Configurar cron job para comando diário
3. ⏳ Criar templates de email
4. ⏳ Implementar envio de emails nos momentos certos
5. ⏳ Adicionar links reais de assinatura/pagamento

### Médio Prazo
1. ⏳ Integrar com gateway de pagamento
2. ⏳ Sistema de assinaturas (subscription_id)
3. ⏳ Painel de gerenciamento de assinaturas
4. ⏳ Relatórios de conversão trial → pago

### Longo Prazo
1. ⏳ Sistema de cupons/descontos
2. ⏳ Planos diferenciados
3. ⏳ Upgrade/downgrade de planos
4. ⏳ Billing automático

## 🎨 Design System

### Cores por Status

| Status | Cor Principal | Uso |
|--------|---------------|-----|
| Trial | Azul (#3ebddb) | Banner, progresso |
| Grace Period | Laranja/Vermelho | Banner urgente |
| Suspended | Vermelho (#dc2626) | Alertas |
| Archived | Cinza (#6b7280) | Status final |

### Componentes Visuais

**Banner Trial:**
- Gradiente suave
- Animações sutis
- CTA positivo

**Banner Grace:**
- Cores quentes (urgência)
- Animação pulse no ícone
- CTA urgente

**Páginas de Status:**
- Centrado verticalmente
- Card clean
- CTAs destacados
- Info clara e objetiva

## 🔍 Debugging

### Verificar Status Atual
```php
$tenant = Tenant::find('tenant-id');
dd([
    'on_trial' => $tenant->onTrial(),
    'in_grace' => $tenant->inGracePeriod(),
    'suspended' => $tenant->isSuspended(),
    'archived' => $tenant->isArchived(),
    'can_access' => $tenant->canAccess(),
    'read_only' => $tenant->isReadOnly(),
    'trial_ends' => $tenant->trial_ends_at,
    'grace_ends' => $tenant->grace_period_ends_at,
    'suspended_at' => $tenant->suspended_at,
    'archived_at' => $tenant->archived_at,
]);
```

### Logs do Comando
```bash
# Ver output detalhado
php artisan tenants:check-status -v
```

---

**Documentação criada em:** {{ date('d/m/Y') }}  
**Versão:** 1.0  
**Autor:** Sistema ImuniFy
