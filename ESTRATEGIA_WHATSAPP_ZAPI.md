# 📱 Estratégia de Negócio - WhatsApp com Z-API

## 🎯 Visão Geral

A Z-API é uma solução intermediária entre WhatsApp Business API oficial e APIs não oficiais. Oferece:
- ✅ Conexão via QR Code (não-oficial, mas estável)
- ✅ Custo mais acessível que WhatsApp Business API
- ✅ Sem necessidade de aprovação do Facebook
- ✅ Suporte a múltiplas instâncias
- ⚠️ Risco: pode ser bloqueado pelo WhatsApp (baixo, mas existe)

---

## 💰 Modelos de Negócio Possíveis

### **Modelo 1: NÚMERO PRÓPRIO DO CLIENTE (Recomendado)**

#### Como Funciona:
1. Cliente contrata um dos planos do Imunify
2. Cliente cria conta na Z-API e paga diretamente
3. Cliente fornece as credenciais da Z-API no Imunify
4. Cliente escaneia QR Code da própria clínica
5. Mensagens saem do número da clínica

#### Precificação:
```
Plano Starter   - R$ 39/mês  - 100 mensagens/mês + WhatsApp
Plano Pro       - R$ 79/mês  - 500 mensagens/mês + WhatsApp
Plano Premium   - R$ 149/mês - 2000 mensagens/mês + WhatsApp
Plano Enterprise- R$ 299/mês - Ilimitado + WhatsApp + Suporte Priority
```

#### Vantagens:
- ✅ Escalável (cada cliente sua própria instância Z-API)
- ✅ Sem preocupação com bloqueios em massa
- ✅ Cliente tem controle total do número
- ✅ Margem maior (você não paga infraestrutura WhatsApp)
- ✅ Imunify não arca com custos de envio

#### Desvantagens:
- ⚠️ Cliente precisa criar conta na Z-API
- ⚠️ Mais um login/senha para o cliente gerenciar
- ⚠️ Onboarding mais complexo

#### Preços Z-API (repassar ao cliente):
- **Plano Start**: R$ 39/mês - 1 instância + 1000 msgs
- **Plano Business**: R$ 79/mês - 3 instâncias + 5000 msgs
- **Plano Professional**: R$ 149/mês - 10 instâncias + 15000 msgs

---

### **Modelo 2: NÚMERO COMPARTILHADO DO IMUNIFY**

#### Como Funciona:
1. Imunify contrata Z-API Master Account
2. Todas as mensagens saem de 1 número do Imunify
3. Cliente paga mensalidade do Imunify
4. Mensagens identificam a clínica no início: "[Clínica XYZ] Lembrete..."

#### Precificação:
```
Plano Starter   - R$ 49/mês  - 50 mensagens/mês
Plano Pro       - R$ 99/mês  - 250 mensagens/mês
Plano Premium   - R$ 199/mês - 1000 mensagens/mês
Plano Enterprise- R$ 399/mês - 5000 mensagens/mês
```

#### Vantagens:
- ✅ Onboarding super simples (sem QR Code)
- ✅ Cliente não precisa gerenciar nada externo
- ✅ Você controla 100% da experiência

#### Desvantagens:
- ❌ Risco de bloqueio afeta todos os clientes
- ❌ Número não é da clínica (menos profissional)
- ❌ Custo de infraestrutura para você
- ❌ Limite de mensagens da Z-API pode ser problema

#### Custo Estimado (Imunify):
- R$ 149/mês (Z-API Professional) + margem

---

### **Modelo 3: HÍBRIDO (Melhor Custo-Benefício)**

#### Como Funciona:
1. **Plano Starter/Pro**: Número compartilhado do Imunify (mais barato)
2. **Plano Premium/Enterprise**: Número próprio com Z-API (mais profissional)

#### Precificação:
```
Plano Starter     - R$ 49/mês  - 50 msgs/mês (Número Imunify)
Plano Pro         - R$ 99/mês  - 250 msgs/mês (Número Imunify)
-------- UPGRADE PARA NÚMERO PRÓPRIO --------
Plano Premium     - R$ 149/mês - 2000 msgs/mês (Número Próprio)
Plano Enterprise  - R$ 299/mês - Ilimitado (Número Próprio)
```

#### Vantagens:
- ✅ Barreira de entrada baixa (Starter/Pro fácil)
- ✅ Upsell natural (cliente cresce e quer número próprio)
- ✅ Escalável
- ✅ Margem boa em todos os planos

#### Desvantagens:
- ⚠️ Gerenciar 2 sistemas diferentes
- ⚠️ Complexidade técnica maior

---

## 🏆 **RECOMENDAÇÃO: Modelo 3 (Híbrido)**

### Por quê?
1. **Conversão**: Planos baratos atraem mais clientes
2. **Escalabilidade**: Clientes pequenos não precisam Z-API
3. **Profissionalismo**: Clientes grandes têm número próprio
4. **Margem**: Lucra em ambos os cenários

### Exemplo Prático:
- Clínica pequena (30 pacientes/mês) → Starter R$ 49/mês
- Clínica média (100 pacientes/mês) → Pro R$ 99/mês
- Clínica grande (500 pacientes/mês) → Premium R$ 149/mês (número próprio)
- Clínica enterprise → R$ 299/mês (número próprio + suporte)

---

## 🔧 Implementação Técnica

### **1. Estrutura de Planos**

Já temos a tabela `plans` criada. Adicionar campos:

```php
// Migration adicional para plans
Schema::table('plans', function (Blueprint $table) {
    $table->enum('whatsapp_mode', ['none', 'shared', 'own'])->default('none');
    // none = sem WhatsApp
    // shared = número compartilhado Imunify
    // own = número próprio (precisa Z-API credentials)
    
    $table->integer('whatsapp_quota')->default(0); // msgs/mês
    $table->boolean('whatsapp_unlimited')->default(false);
});

// Seeders dos planos
Plan::create([
    'name' => 'Starter',
    'price' => 49.00,
    'whatsapp_mode' => 'shared',
    'whatsapp_quota' => 50,
]);

Plan::create([
    'name' => 'Pro',
    'price' => 99.00,
    'whatsapp_mode' => 'shared',
    'whatsapp_quota' => 250,
]);

Plan::create([
    'name' => 'Premium',
    'price' => 149.00,
    'whatsapp_mode' => 'own',
    'whatsapp_quota' => 2000,
]);

Plan::create([
    'name' => 'Enterprise',
    'price' => 299.00,
    'whatsapp_mode' => 'own',
    'whatsapp_unlimited' => true,
]);
```

### **2. Tabela de Configuração Z-API por Tenant**

```php
// Migration: create_whatsapp_connections_table
Schema::create('whatsapp_connections', function (Blueprint $table) {
    $table->id();
    $table->enum('mode', ['shared', 'own']); // compartilhado ou próprio
    
    // Para modo 'own' (número próprio)
    $table->string('zapi_instance_id')->nullable();
    $table->string('zapi_token')->nullable();
    $table->string('zapi_client_token')->nullable();
    $table->string('phone_number')->nullable();
    $table->enum('status', ['disconnected', 'qrcode', 'connected'])->default('disconnected');
    $table->text('qrcode_base64')->nullable(); // QR code para conexão
    $table->timestamp('connected_at')->nullable();
    $table->timestamp('last_check_at')->nullable();
    
    // Controle de quota
    $table->integer('messages_sent_month')->default(0);
    $table->integer('messages_quota')->default(0);
    $table->boolean('quota_unlimited')->default(false);
    $table->date('quota_reset_date')->nullable();
    
    $table->timestamps();
});
```

### **3. Service para Z-API**

```php
// app/Services/ZApiService.php
class ZApiService
{
    private $baseUrl;
    private $instanceId;
    private $token;
    
    public function __construct($instanceId, $token)
    {
        $this->baseUrl = 'https://api.z-api.io';
        $this->instanceId = $instanceId;
        $this->token = $token;
    }
    
    /**
     * Gera QR Code para conexão
     */
    public function getQRCode()
    {
        $response = Http::get("{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/qr-code/image");
        return $response->body(); // Base64 da imagem
    }
    
    /**
     * Verifica status da conexão
     */
    public function checkConnection()
    {
        $response = Http::get("{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/status");
        return $response->json();
    }
    
    /**
     * Envia mensagem de texto
     */
    public function sendMessage($phone, $message)
    {
        // Verificar quota antes
        if (!$this->hasQuota()) {
            throw new \Exception('Cota de mensagens WhatsApp esgotada. Upgrade seu plano.');
        }
        
        $response = Http::post("{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/send-text", [
            'phone' => $this->formatPhone($phone),
            'message' => $message,
        ]);
        
        // Incrementar contador
        $this->incrementMessageCount();
        
        return $response->json();
    }
    
    /**
     * Verifica se tem quota disponível
     */
    private function hasQuota()
    {
        $connection = WhatsAppConnection::first();
        
        if ($connection->quota_unlimited) {
            return true;
        }
        
        // Resetar contador se mudou o mês
        if ($connection->quota_reset_date < now()) {
            $connection->messages_sent_month = 0;
            $connection->quota_reset_date = now()->addMonth()->startOfMonth();
            $connection->save();
        }
        
        return $connection->messages_sent_month < $connection->messages_quota;
    }
    
    private function incrementMessageCount()
    {
        $connection = WhatsAppConnection::first();
        $connection->increment('messages_sent_month');
    }
}
```

### **4. Service para Número Compartilhado**

```php
// app/Services/SharedWhatsAppService.php
class SharedWhatsAppService
{
    private $zapi;
    
    public function __construct()
    {
        // Credenciais do Imunify (centralizadas)
        $instanceId = config('services.zapi.shared_instance_id');
        $token = config('services.zapi.shared_token');
        
        $this->zapi = new ZApiService($instanceId, $token);
    }
    
    public function sendMessage($phone, $message, $clinicName)
    {
        // Adiciona identificação da clínica
        $fullMessage = "*[{$clinicName}]*\n\n{$message}";
        
        return $this->zapi->sendMessage($phone, $fullMessage);
    }
}
```

### **5. Controller de Configuração WhatsApp**

```php
// app/Http/Controllers/WhatsAppConfigController.php
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
            'hasWhatsApp' => $plan->whatsapp_mode !== 'none',
            'needsOwnNumber' => $plan->whatsapp_mode === 'own',
            'quota' => $plan->whatsapp_quota,
            'unlimited' => $plan->whatsapp_unlimited,
            'used' => $connection->messages_sent_month ?? 0,
        ]);
    }
    
    public function connectOwn(Request $request)
    {
        $request->validate([
            'zapi_instance_id' => 'required',
            'zapi_token' => 'required',
            'zapi_client_token' => 'required',
        ]);
        
        $zapi = new ZApiService($request->zapi_instance_id, $request->zapi_token);
        
        // Gerar QR Code
        $qrcode = $zapi->getQRCode();
        
        $connection = WhatsAppConnection::updateOrCreate(
            ['id' => 1],
            [
                'mode' => 'own',
                'zapi_instance_id' => $request->zapi_instance_id,
                'zapi_token' => $request->zapi_token,
                'zapi_client_token' => $request->zapi_client_token,
                'status' => 'qrcode',
                'qrcode_base64' => $qrcode,
            ]
        );
        
        return back()->with('success', 'Escaneie o QR Code com seu WhatsApp Business');
    }
    
    public function checkStatus()
    {
        $connection = WhatsAppConnection::first();
        $zapi = new ZApiService($connection->zapi_instance_id, $connection->zapi_token);
        
        $status = $zapi->checkConnection();
        
        if ($status['connected']) {
            $connection->update([
                'status' => 'connected',
                'phone_number' => $status['phoneNumber'],
                'connected_at' => now(),
            ]);
        }
        
        return response()->json($status);
    }
}
```

---

## 📊 Comparativo de Custos

### **Custos do Imunify (Modelo Híbrido)**

| Item | Custo Mensal | Observações |
|------|--------------|-------------|
| Z-API Shared (1 número) | R$ 39 | Para planos Starter/Pro |
| Servidor | R$ 50 | Já incluso no Imunify |
| **TOTAL FIXO** | **R$ 89** | Base operacional |

### **Receita Estimada (100 clientes)**

| Plano | Clientes | Mensalidade | Receita |
|-------|----------|-------------|---------|
| Starter | 60 | R$ 49 | R$ 2.940 |
| Pro | 30 | R$ 99 | R$ 2.970 |
| Premium | 8 | R$ 149 | R$ 1.192 |
| Enterprise | 2 | R$ 299 | R$ 598 |
| **TOTAL** | **100** | - | **R$ 7.700** |

**Margem**: R$ 7.700 - R$ 89 = **R$ 7.611/mês (98,8%)**

---

## 🎯 Plano de Ação

### **Fase 1: MVP (Semana 1-2)**
1. ✅ Implementar `plans` com campos WhatsApp
2. ✅ Criar `whatsapp_connections` table
3. ✅ Implementar `ZApiService`
4. ✅ Implementar `SharedWhatsAppService`
5. ✅ Criar tela de configuração básica

### **Fase 2: Número Compartilhado (Semana 3)**
1. Contratar Z-API Shared Account do Imunify
2. Testar envios com identificação de clínica
3. Implementar controle de quota

### **Fase 3: Número Próprio (Semana 4)**
1. Interface para inserir credenciais Z-API
2. Geração e exibição de QR Code
3. Polling de status de conexão
4. Testes de envio

### **Fase 4: Refinamentos (Semana 5)**
1. Dashboard de uso (mensagens enviadas)
2. Alertas de quota
3. Upsell automático quando quota esgotar
4. Documentação para cliente

---

## 🚀 Páginas de Venda

### **Landing Page - Comparativo de Planos**

```
🎯 QUAL PLANO É IDEAL PARA SUA CLÍNICA?

┌─────────────────────────────────────────────────────┐
│  STARTER          PRO              PREMIUM           │
│  R$ 49/mês        R$ 99/mês        R$ 149/mês       │
├─────────────────────────────────────────────────────┤
│  ✓ Agenda         ✓ Tudo Starter  ✓ Tudo Pro       │
│  ✓ Pacientes      ✓ 250 msgs      ✓ 2000 msgs      │
│  ✓ Vacinas        ✓ WhatsApp      ✓ NÚMERO PRÓPRIO │
│  ✓ 50 msgs        ✓ Confirmações  ✓ Sem branding   │
│  ✓ WhatsApp       ✓ Relatórios    ✓ API acesso     │
│                                                      │
│  Ideal: até       Ideal: até      Ideal: 100-500   │
│  30 pacientes     100 pacientes   pacientes/mês    │
└─────────────────────────────────────────────────────┘
```

---

## ❓ FAQ para o Cliente

**Q: Preciso ter WhatsApp Business?**
A: Sim, para usar número próprio (Premium/Enterprise). Planos Starter/Pro usam número do Imunify.

**Q: Como funciona o QR Code?**
A: No plano Premium+, você escaneia o QR Code uma vez. Depois disso, todas as mensagens saem automaticamente.

**Q: E se meu número for bloqueado?**
A: Risco baixo. Seguimos boas práticas. Se bloquear, você pode trocar o número e escanear novamente.

**Q: Posso enviar mensagens manualmente também?**
A: Sim! As automações não bloqueiam o uso normal do WhatsApp.

---

**Qual modelo você prefere implementar primeiro?** 🚀
