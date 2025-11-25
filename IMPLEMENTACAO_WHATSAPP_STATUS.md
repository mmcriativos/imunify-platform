# 🎯 Implementação WhatsApp Z-API - Modelo Híbrido

## ✅ IMPLEMENTADO COM SUCESSO

### 1. **Banco de Dados** ✅
- ✅ Migration `2025_11_16_000001_add_whatsapp_fields_to_plans_table.php`
  - Campos: `whatsapp_mode`, `whatsapp_quota`, `whatsapp_unlimited`
  
- ✅ Migration `2025_11_16_000002_create_whatsapp_connections_table.php`
  - Tabela completa para gerenciar conexões (shared e own)
  - Controle de quota, QR code, status
  
- ✅ Migrations executadas com sucesso (central + todos os tenants)

### 2. **Models** ✅
- ✅ `app/Models/Plan.php` - Atualizado com campos WhatsApp
- ✅ `app/Models/WhatsAppConnection.php` - Model completo com métodos:
  - `hasQuota()` - Verifica quota disponível
  - `getRemainingMessages()` - Mensagens restantes
  - `incrementMessageCount()` - Incrementa contador
  - `syncQuotaFromPlan()` - Sincroniza com plano do tenant
  - `resetMonthlyQuota()` - Reset automático mensal

### 3. **Services** ✅
- ✅ `app/Services/ZApiService.php` - Integração completa Z-API
  - `getQRCode()` - Gera QR Code para conexão
  - `checkConnection()` - Verifica status
  - `sendMessage()` - Envia texto
  - `sendImage()` - Envia imagem
  - `disconnect()` - Desconecta instância
  - Formatação automática de telefone (55XXXXXXXXXXX)

- ✅ `app/Services/SharedWhatsAppService.php` - Número compartilhado
  - Adiciona badge da clínica: "🏥 *Nome da Clínica*"
  - Usa credenciais centralizadas do Imunify
  - Wrapper sobre ZApiService

- ⚠️ `app/Services/WhatsAppService.php` - **PRECISA SER REESCRITO**
  - Arquivo com problema de encoding
  - Lógica já está pronta (veja código no chat)
  - Precisa ser criado manualmente

### 4. **Configurações** ✅
- ✅ `.env` - Variáveis Z-API adicionadas:
  ```
  ZAPI_SHARED_INSTANCE_ID=
  ZAPI_SHARED_TOKEN=
  ZAPI_SHARED_CLIENT_TOKEN=
  ```

- ✅ `config/services.php` - Array `zapi` configurado

---

## ⚠️ FALTA IMPLEMENTAR

### 5. **Seeder de Planos** 🔄
**Arquivo**: `database/seeders/PlansSeeder.php`

Criar seeder com 4 planos:

```php
Plan::create([
    'name' => 'Starter',
    'slug' => 'starter',
    'price_monthly' => 49.00,
    'whatsapp_mode' => 'shared', // Número Imunify
    'whatsapp_quota' => 50,
    'whatsapp_unlimited' => false,
]);

Plan::create([
    'name' => 'Pro',
    'slug' => 'pro',
    'price_monthly' => 99.00,
    'whatsapp_mode' => 'shared',
    'whatsapp_quota' => 250,
]);

Plan::create([
    'name' => 'Premium',
    'slug' => 'premium',
    'price_monthly' => 149.00,
    'whatsapp_mode' => 'own', // Número próprio
    'whatsapp_quota' => 2000,
]);

Plan::create([
    'name' => 'Enterprise',
    'slug' => 'enterprise',
    'price_monthly' => 299.00,
    'whatsapp_mode' => 'own',
    'whatsapp_unlimited' => true,
]);
```

**Executar**: `php artisan db:seed --class=PlansSeeder`

---

### 6. **Controller WhatsAppConfig** 🔄
**Arquivo**: `app/Http/Controllers/WhatsAppConfigController.php`

```php
class WhatsAppConfigController extends Controller
{
    public function index()
    {
        $tenant = tenant();
        $plan = $tenant->plan;
        $connection = WhatsAppConnection::firstOrNew();
        
        return view('whatsapp.config', [
            'plan' => $plan,
            'connection' => $connection,
            'usage' => app(WhatsAppService::class)->getUsageInfo(),
        ]);
    }
    
    public function connectOwn(Request $request)
    {
        // Salvar credenciais Z-API
        // Gerar QR Code
        // Redirecionar para tela de scanning
    }
    
    public function checkStatus()
    {
        // Verificar se conectou
        // Retornar JSON com status
    }
    
    public function testMessage(Request $request)
    {
        // Enviar mensagem de teste
    }
}
```

---

### 7. **Views** 🔄
**Arquivo**: `resources/views/whatsapp/config.blade.php`

Interface para:
- **Planos Starter/Pro**: Mostrar que usa número compartilhado
- **Planos Premium/Enterprise**: 
  - Form para inserir credenciais Z-API
  - Exibir QR Code
  - Status da conexão
  - Botão de teste

- **Todos os planos**:
  - Dashboard de uso (mensagens enviadas/restantes)
  - Botão de upgrade se quota esgotar

---

### 8. **Rotas** 🔄
**Arquivo**: `routes/tenant.php`

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/whatsapp/config', [WhatsAppConfigController::class, 'index'])
        ->name('whatsapp.config');
    
    Route::post('/whatsapp/connect', [WhatsAppConfigController::class, 'connectOwn'])
        ->name('whatsapp.connect');
    
    Route::get('/whatsapp/status', [WhatsAppConfigController::class, 'checkStatus'])
        ->name('whatsapp.status');
    
    Route::post('/whatsapp/test', [WhatsAppConfigController::class, 'testMessage'])
        ->name('whatsapp.test');
});
```

---

### 9. **Atualizar Comando SendReminders** 🔄
**Arquivo**: `app/Console/Commands/SendReminders.php`

O comando já usa `WhatsAppService`, então vai funcionar automaticamente quando o `WhatsAppService.php` for corrigido.

Apenas garantir que está usando:
```php
$whatsapp = app(WhatsAppService::class);
if ($whatsapp->isAvailable() && $whatsapp->hasQuota()) {
    $whatsapp->sendMessage($phone, $message);
}
```

---

## 🔧 CORREÇÃO URGENTE NECESSÁRIA

### WhatsAppService.php está com encoding corrompido

**Solução**:
1. Deletar `app/Services/WhatsAppService.php`
2. Criar novo arquivo manualmente no VS Code
3. Copiar o código abaixo:

```php
<?php

namespace App\Services;

use App\Models\WhatsAppConnection;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private ?WhatsAppConnection $connection = null;
    private $service = null;

    public function __construct()
    {
        $this->initializeService();
    }

    private function initializeService(): void
    {
        $tenant = tenant();
        
        if (!$tenant) {
            Log::warning('WhatsAppService: Tenant não inicializado');
            return;
        }

        $plan = $tenant->plan;
        
        if (!$plan || $plan->whatsapp_mode === 'none') {
            return;
        }

        $this->connection = WhatsAppConnection::firstOrNew();
        
        if (!$this->connection->exists || $this->connection->mode !== $plan->whatsapp_mode) {
            $this->connection->syncQuotaFromPlan();
        }

        if ($plan->whatsapp_mode === 'shared') {
            $this->service = new SharedWhatsAppService();
        } elseif ($plan->whatsapp_mode === 'own') {
            if ($this->connection->zapi_instance_id && $this->connection->zapi_token) {
                $this->service = new ZApiService(
                    $this->connection->zapi_instance_id,
                    $this->connection->zapi_token,
                    $this->connection->zapi_client_token
                );
            }
        }
    }

    public function isAvailable(): bool
    {
        return $this->service !== null;
    }

    public function hasQuota(): bool
    {
        return $this->connection && $this->connection->hasQuota();
    }

    public function sendMessage(string $phone, string $message): bool
    {
        if (!$this->isAvailable() || !$this->hasQuota()) {
            return false;
        }

        $success = $this->service->sendMessage($phone, $message);
        
        if ($success && $this->connection) {
            $this->connection->incrementMessageCount();
        }
        
        return $success;
    }

    public function getUsageInfo(): array
    {
        if (!$this->connection) {
            return [
                'available' => false,
                'mode' => 'none',
                'quota_used' => 0,
                'quota_limit' => 0,
            ];
        }

        return [
            'available' => $this->isAvailable(),
            'mode' => $this->connection->mode,
            'quota_used' => $this->connection->messages_sent_month,
            'quota_limit' => $this->connection->messages_quota,
            'quota_remaining' => $this->connection->getRemainingMessages(),
            'quota_unlimited' => $this->connection->quota_unlimited,
        ];
    }

    public function isConfigured(): bool
    {
        return $this->isAvailable();
    }
}
```

---

## 📋 CHECKLIST FINAL

### Para Testar:
- [ ] Corrigir `WhatsAppService.php` (encoding)
- [ ] Rodar seeder de planos
- [ ] Atribuir plano "Starter" ao tenant multiimune
- [ ] Criar controller e views de configuração
- [ ] Adicionar rotas
- [ ] Testar envio de mensagem

### Para Produção:
- [ ] Contratar conta Z-API para número compartilhado
- [ ] Configurar credenciais no `.env`
- [ ] Documentar para clientes como conectar número próprio
- [ ] Criar landing page de planos
- [ ] Implementar upsell quando quota esgotar

---

## 💡 COMO USAR

### Planos Starter/Pro (Número Compartilhado):
1. Cliente assina plano
2. Sistema automaticamente usa número Imunify
3. Mensagens saem com badge: "🏥 *Nome da Clínica*"

### Planos Premium/Enterprise (Número Próprio):
1. Cliente assina plano
2. Cliente vai em `/whatsapp/config`
3. Cliente insere credenciais Z-API
4. Sistema gera QR Code
5. Cliente escaneia com WhatsApp Business
6. Pronto! Mensagens saem do número da clínica

---

## 🎯 PRÓXIMOS PASSOS

1. **Corrigir WhatsAppService.php** (URGENTE)
2. Criar seeder e rodar
3. Criar controller + views básicas
4. Testar envio de mensagem
5. Refinar interface
6. Documentação para clientes

**Status**: 70% implementado - falta UI e testes
