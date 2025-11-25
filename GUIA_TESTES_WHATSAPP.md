# 🧪 Guia Rápido de Testes - WhatsApp Multi-Tenant

## Pré-requisitos
1. ✅ Sistema implementado (100%)
2. ⏳ Credenciais Z-API (provisionar no z-api.io)
3. ⏳ Número WhatsApp Business para instância compartilhada

---

## 🔑 Passo 1: Configurar Credenciais Compartilhadas

### 1.1 Criar Instância Z-API
1. Acesse https://www.z-api.io
2. Criar conta / Login
3. Dashboard → Criar Nova Instância
4. Copiar:
   - Instance ID
   - Token
   - Client Token

### 1.2 Adicionar no .env
```env
# Adicionar no final do arquivo .env
ZAPI_SHARED_INSTANCE_ID=3DA2F1E0C1FA
ZAPI_SHARED_TOKEN=C5B8F4E2D9A1
ZAPI_SHARED_CLIENT_TOKEN=E8D2A4F6C9B1
```

### 1.3 Conectar WhatsApp
1. No dashboard Z-API, clicar "Conectar"
2. Escanear QR Code com WhatsApp Business
3. Aguardar status "CONNECTED"

### 1.4 Limpar Cache Laravel
```bash
cd M:\laragon\www\imunify
php artisan config:clear
php artisan cache:clear
```

---

## 🧪 Passo 2: Testar Número Compartilhado (Tenant: multiimune)

### 2.1 Via Interface Web

```
http://multiimune.imunify.test/login
```

**Credenciais**:
- Email: `admin@multiimune.com`
- Senha: [usar senha atual]

**Navegação**:
1. Login no tenant
2. Dashboard → WhatsApp Config
3. URL: `http://multiimune.imunify.test/dashboard/whatsapp/config`

**Verificações**:
- ✅ Plano exibido: **Starter** (R$ 49/mês)
- ✅ Modo: **Compartilhado**
- ✅ Quota: **0 / 50** (inicialmente)
- ✅ Status: **Ativo** (se credenciais corretas)

**Teste de Envio**:
1. Preencher número: `11999999999` (seu celular)
2. Mensagem:
   ```
   🧪 Teste de integração WhatsApp
   
   Se você está recebendo esta mensagem, o sistema está funcionando!
   ```
3. Clicar "Enviar Teste"
4. **Esperado**: 
   - ✅ Mensagem recebida no WhatsApp
   - ✅ Prefixo adicionado: "🏥 **MultiImune**"
   - ✅ Quota atualizada: **1 / 50**

### 2.2 Via Tinker

```bash
php artisan tinker
```

```php
# Inicializar contexto do tenant
tenancy()->initialize('multiimune');

# Criar instância do serviço
$whatsapp = new App\Services\WhatsAppService();

# Verificar disponibilidade
$whatsapp->isAvailable();
// Esperado: true

# Verificar quota
$whatsapp->hasQuota();
// Esperado: true

# Ver estatísticas
$usage = $whatsapp->getUsageInfo();
print_r($usage);
// Esperado:
// [
//   'sent' => 1,
//   'quota' => 50,
//   'remaining' => 49,
//   'has_quota' => true,
//   'quota_unlimited' => false,
//   'mode' => 'shared',
//   'status' => 'active'
// ]

# Enviar mensagem de teste
$result = $whatsapp->sendMessage('11999999999', 'Teste via Tinker');
var_dump($result);
// Esperado: bool(true)

# Verificar quota novamente
$usage = $whatsapp->getUsageInfo();
echo "Quota: {$usage['sent']} / {$usage['quota']}\n";
// Esperado: Quota: 2 / 50
```

### 2.3 Via Comando Artisan

```bash
# Listar agendamentos que receberão lembretes
php artisan lembretes:auto --tipo=7dias
```

**Esperado**:
```
🚀 Iniciando envio de lembretes automáticos...

📊 Quota: 2 / 50 (48 restantes)

📅 Lembretes para 7 dias (XX agendamentos encontrados)
📤 Enviando para João Silva (11999999999)...
  ✅ Enviado com sucesso
📤 Enviando para Maria Santos (11988888888)...
  ✅ Enviado com sucesso

✅ Resumo Final:
   📤 Enviados: 2
   ❌ Erros: 0
```

### 2.4 Verificar no Banco de Dados

```sql
-- Conectar ao database do tenant
USE multiimune;

-- Ver quota atual
SELECT 
    mode,
    status,
    messages_sent_month,
    messages_quota,
    quota_unlimited,
    quota_reset_date
FROM whatsapp_connections;

-- Esperado:
-- mode: shared
-- status: connected
-- messages_sent_month: 4 (exemplo)
-- messages_quota: 50
-- quota_unlimited: 0
-- quota_reset_date: 2025-12-16 (1 mês depois)
```

---

## 🏆 Passo 3: Testar Número Próprio (Premium)

### 3.1 Criar Tenant Premium (Script PHP)

```bash
cd M:\laragon\www\imunify
php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Buscar plano Premium
\$plan = Plan::where('slug', 'premium')->first();

// Criar tenant
\$tenant = Tenant::create([
    'id' => 'premium-test',
    'plan_id' => \$plan->id,
]);

\$tenant->domains()->create(['domain' => 'premium-test.imunify.test']);

echo '✅ Tenant criado: premium-test.imunify.test\n';
echo 'Plano: Premium (R\$ 149/mês)\n';
echo 'Quota: 2000 mensagens/mês\n\n';

// Criar usuário admin no contexto do tenant
tenancy()->initialize(\$tenant);

User::create([
    'name' => 'Admin Premium',
    'email' => 'admin@premium-test.com',
    'password' => Hash::make('password'),
]);

echo '✅ Usuário criado:\n';
echo '   Email: admin@premium-test.com\n';
echo '   Senha: password\n';
"
```

### 3.2 Configurar Hosts do Windows

Adicionar em `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 premium-test.imunify.test
```

### 3.3 Fazer Login
```
http://premium-test.imunify.test/login
```
- Email: `admin@premium-test.com`
- Senha: `password`

### 3.4 Configurar Z-API Próprio

1. **Criar Nova Instância Z-API**:
   - Dashboard Z-API → Nova Instância
   - Nome: `premium-test-clinic`
   - Copiar credenciais

2. **Inserir Credenciais na Interface**:
   - Acessar: `http://premium-test.imunify.test/dashboard/whatsapp/config`
   - Preencher formulário:
     - Instance ID: `[sua instância]`
     - Token: `[seu token]`
     - Client Token: `[seu client token]`
   - Clicar "🔗 Conectar WhatsApp"

3. **Escanear QR Code**:
   - QR Code aparecerá na tela
   - Abrir WhatsApp → Aparelhos Conectados
   - Escanear código
   - Aguardar (auto-refresh a cada 5s)

4. **Confirmar Conexão**:
   - Status mudará para "✅ WhatsApp Conectado"
   - Número conectado será exibido

5. **Enviar Teste**:
   - Formulário aparecerá abaixo
   - Enviar mensagem de teste
   - **Diferença**: Mensagem NÃO terá prefixo "🏥 *Nome*"

### 3.5 Testar Quota Premium

```bash
php artisan tinker
```

```php
tenancy()->initialize('premium-test');

$whatsapp = new App\Services\WhatsAppService();

# Ver quota do plano Premium
$usage = $whatsapp->getUsageInfo();
print_r($usage);
// Esperado:
// [
//   'sent' => 1,
//   'quota' => 2000,
//   'remaining' => 1999,
//   'has_quota' => true,
//   'quota_unlimited' => false,
//   'mode' => 'own',
//   'status' => 'connected'
// ]
```

---

## 🔥 Passo 4: Testar Esgotamento de Quota

### 4.1 Simular Quota Esgotada (Starter)

```sql
-- Conectar ao banco do tenant
USE multiimune;

-- Forçar quota esgotada
UPDATE whatsapp_connections 
SET messages_sent_month = 50 
WHERE mode = 'shared';
```

### 4.2 Tentar Enviar

```bash
php artisan tinker
```

```php
tenancy()->initialize('multiimune');

$whatsapp = new App\Services\WhatsAppService();

# Verificar quota
$whatsapp->hasQuota();
// Esperado: false

# Tentar enviar
$result = $whatsapp->sendMessage('11999999999', 'Teste');
// Esperado: false (não envia)

# Ver mensagem de erro
$usage = $whatsapp->getUsageInfo();
echo "Enviadas: {$usage['sent']} / {$usage['quota']}\n";
// Esperado: Enviadas: 50 / 50
```

### 4.3 Testar via Interface

Acessar: `http://multiimune.imunify.test/dashboard/whatsapp/config`

**Esperado**:
- ❌ Formulário de teste desaparece
- ⚠️ Banner vermelho: "Quota Esgotada"
- 🚀 Botão "Fazer Upgrade"
- 📊 Barra de progresso: 50/50 (100%)

### 4.4 Testar via Comando

```bash
php artisan lembretes:auto --tipo=7dias
```

**Esperado**:
```
🚀 Iniciando envio de lembretes automáticos...

⚠️  Quota de mensagens esgotada!
   Enviadas: 50 / 50
   Faça upgrade do seu plano para continuar enviando mensagens.
```

### 4.5 Restaurar Quota

```sql
USE multiimune;

UPDATE whatsapp_connections 
SET messages_sent_month = 0;
```

---

## 🔄 Passo 5: Testar Reset Automático

### 5.1 Simular Virada do Mês

```sql
USE multiimune;

-- Forçar data de reset para o passado
UPDATE whatsapp_connections 
SET 
    messages_sent_month = 45,
    quota_reset_date = '2025-10-16 00:00:00';
```

### 5.2 Verificar Reset

```bash
php artisan tinker
```

```php
tenancy()->initialize('multiimune');

$whatsapp = new App\Services\WhatsAppService();

# Chamar hasQuota() para trigger reset
$hasQuota = $whatsapp->hasQuota();
// Esperado: true

# Verificar se resetou
$usage = $whatsapp->getUsageInfo();
echo "Enviadas: {$usage['sent']}\n";
// Esperado: Enviadas: 0 (resetou!)

# Verificar nova data de reset
$connection = App\Models\WhatsAppConnection::first();
echo "Próximo reset: {$connection->quota_reset_date}\n";
// Esperado: Próximo reset: 2025-11-16 (1 mês depois de hoje)
```

---

## 📊 Passo 6: Verificações de Integridade

### 6.1 Verificar Planos no Banco Central

```sql
USE imunify;

SELECT 
    id,
    name,
    slug,
    price,
    whatsapp_mode,
    whatsapp_quota,
    whatsapp_unlimited
FROM plans
WHERE whatsapp_mode != 'none';

-- Esperado: 4 planos (Starter, Pro, Premium, Enterprise)
```

### 6.2 Verificar Associação de Planos

```sql
USE imunify;

SELECT 
    t.id AS tenant_id,
    t.plan_id,
    p.name AS plan_name,
    p.whatsapp_mode,
    p.whatsapp_quota
FROM tenants t
LEFT JOIN plans p ON t.plan_id = p.id;

-- Esperado:
-- multiimune → Starter (shared, 50)
-- premium-test → Premium (own, 2000)
```

### 6.3 Verificar Conexões por Tenant

```sql
-- Tenant multiimune
USE multiimune;
SELECT * FROM whatsapp_connections;

-- Tenant premium-test (se criado)
USE `premium-test`;
SELECT * FROM whatsapp_connections;
```

---

## ⚠️ Troubleshooting

### Problema: "WhatsApp não disponível"

**Causa**: Credenciais Z-API não configuradas

**Fix**:
1. Verificar `.env`:
   ```bash
   php artisan config:clear
   cat .env | findstr ZAPI
   ```
2. Garantir que as variáveis estão preenchidas
3. Verificar se Z-API está com status "CONNECTED"

---

### Problema: "Quota não incrementa"

**Causa**: WhatsAppConnection não encontrado

**Fix**:
```sql
-- Verificar se conexão existe
USE multiimune;
SELECT * FROM whatsapp_connections;

-- Se não existir, criar manualmente
INSERT INTO whatsapp_connections (
    tenant_id, mode, status, messages_sent_month, 
    messages_quota, quota_unlimited, quota_reset_date
) VALUES (
    'multiimune', 'shared', 'connected', 0, 
    50, 0, DATE_ADD(NOW(), INTERVAL 1 MONTH)
);
```

---

### Problema: QR Code não aparece (Premium)

**Causa**: Z-API retornou erro

**Fix**:
1. Verificar logs Laravel:
   ```bash
   tail -f storage/logs/laravel.log
   ```
2. Verificar credenciais Z-API
3. Tentar desconectar e reconectar
4. Verificar se instância Z-API não está em uso

---

### Problema: Mensagem não chega no WhatsApp

**Checklist**:
- [ ] Z-API com status "CONNECTED"?
- [ ] Número formatado corretamente (DDI + DDD)?
- [ ] Logs no Laravel (`storage/logs/laravel.log`)?
- [ ] Verificar dashboard Z-API (histórico de mensagens)
- [ ] Número não está bloqueado pelo WhatsApp?

---

## 📝 Logs Úteis

### Ver Logs do Laravel
```bash
tail -50 storage/logs/laravel.log
```

### Ver Requisições Z-API
```php
# Em ZApiService.php, adicionar antes do return:
Log::info('Z-API Request', [
    'method' => 'POST',
    'url' => $url,
    'body' => $body,
    'response' => $response->json()
]);
```

---

## ✅ Checklist de Testes

- [ ] Credenciais Z-API compartilhadas adicionadas no `.env`
- [ ] Instância Z-API compartilhada conectada
- [ ] Teste via interface (multiimune) - OK
- [ ] Teste via Tinker (multiimune) - OK
- [ ] Teste via Artisan (multiimune) - OK
- [ ] Quota incrementa corretamente - OK
- [ ] Prefixo "🏥 *Nome*" aparece na mensagem - OK
- [ ] Tenant Premium criado
- [ ] QR Code gerado e escaneado
- [ ] Mensagem sem prefixo enviada (Premium) - OK
- [ ] Quota esgotada bloqueia envio - OK
- [ ] Reset automático funciona - OK
- [ ] Interface exibe informações corretas - OK

---

## 🚀 Após Testes Bem-Sucedidos

1. ✅ Marcar sistema como "Homologado"
2. 📝 Documentar credenciais em local seguro
3. 🎓 Treinar equipe sobre novo fluxo
4. 📊 Configurar monitoramento de quota
5. 💳 Implementar página de upgrade de planos
6. 📈 Configurar analytics de uso

---

**Status**: Aguardando credenciais Z-API para iniciar testes  
**Data**: 16/11/2025  
**Implementação**: 100% Completa
