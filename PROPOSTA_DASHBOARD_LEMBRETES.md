# 📊 Dashboard de Notificações WhatsApp - Proposta UI/UX

## 🎯 Objetivo

Criar uma área onde o tenant pode:
- ✅ Ver histórico de mensagens enviadas
- 📊 Acompanhar estatísticas em tempo real
- 🔍 Filtrar por tipo, status, período
- 🔄 Reenviar mensagens que falharam
- ⚙️ Configurar templates personalizados

---

## 🖼️ Mockup da Interface

### **📍 Localização:** `Dashboard → Notificações WhatsApp`

```
╔══════════════════════════════════════════════════════════════════════╗
║  📊 Notificações WhatsApp                          [⚙️ Configurar]  ║
╠══════════════════════════════════════════════════════════════════════╣
║                                                                      ║
║  ┌────────────────┐  ┌────────────────┐  ┌────────────────┐       ║
║  │ 📤 Enviadas    │  │ ⏳ Pendentes   │  │ ❌ Falhas      │       ║
║  │   156 hoje     │  │   8 na fila    │  │   3 erros      │       ║
║  │   ━━━━━━━━━━   │  │   ━━━━━━━━━━   │  │   ━━━━━━━━━━   │       ║
║  │   +12% vs ontem│  │   Próxima: 09h │  │   📝 Ver logs  │       ║
║  └────────────────┘  └────────────────┘  └────────────────┘       ║
║                                                                      ║
║  ┌────────────────────────────────────────────────────────────────┐ ║
║  │ 📊 Uso da Quota                                                │ ║
║  │                                                                │ ║
║  │  156 / 250 mensagens (62%)                                    │ ║
║  │  ████████████████████░░░░░░░░░░░░░░                          │ ║
║  │                                                                │ ║
║  │  📅 Renovação: 01/12/2025 (13 dias)                           │ ║
║  │  💰 Plano: Pro (250 msg/mês)        [🚀 Fazer Upgrade]       │ ║
║  └────────────────────────────────────────────────────────────────┘ ║
║                                                                      ║
║  ┌────────────────────────────────────────────────────────────────┐ ║
║  │ 📈 Estatísticas dos Últimos 7 Dias                            │ ║
║  │                                                                │ ║
║  │    40 │                    ●                                  │ ║
║  │    30 │              ●           ●                            │ ║
║  │    20 │        ●                       ●                      │ ║
║  │    10 │  ●                                   ●                │ ║
║  │     0 └─────────────────────────────────────────              │ ║
║  │       Seg  Ter  Qua  Qui  Sex  Sáb  Dom                       │ ║
║  │                                                                │ ║
║  │  📊 Total: 234 enviadas  |  ✅ Taxa de sucesso: 98.3%        │ ║
║  └────────────────────────────────────────────────────────────────┘ ║
║                                                                      ║
║  ┌────────────────────────────────────────────────────────────────┐ ║
║  │ 📋 Histórico de Notificações                                  │ ║
║  │                                                                │ ║
║  │  🔍 Buscar...  [📅 Período ▾] [📱 Tipo ▾] [✅ Status ▾]      │ ║
║  │                                                                │ ║
║  │  ┌──────────────────────────────────────────────────────────┐ │ ║
║  │  │ 🔔 Lembrete de Vacinação          ✅ Enviado  09:15      │ │ ║
║  │  │ Para: Maria Silva (11) 95206-0833                        │ │ ║
║  │  │ Vacina: Hepatite B - 2ª dose                             │ │ ║
║  │  │ [👁️ Ver mensagem] [🔄 Reenviar]                          │ │ ║
║  │  └──────────────────────────────────────────────────────────┘ │ ║
║  │                                                                │ ║
║  │  ┌──────────────────────────────────────────────────────────┐ │ ║
║  │  │ ✅ Confirmação de Presença        ✅ Enviado  08:30      │ │ ║
║  │  │ Para: João Santos (11) 98765-4321                        │ │ ║
║  │  │ Agendamento: 20/11/2025 às 14:00                         │ │ ║
║  │  │ Resposta: ✅ SIM (confirmado)                            │ │ ║
║  │  │ [👁️ Ver conversa]                                        │ │ ║
║  │  └──────────────────────────────────────────────────────────┘ │ ║
║  │                                                                │ ║
║  │  ┌──────────────────────────────────────────────────────────┐ │ ║
║  │  │ ❌ Lembrete de Vacinação          ❌ Falha    09:16      │ │ ║
║  │  │ Para: Pedro Costa (11) 91111-2222                        │ │ ║
║  │  │ Erro: Número de telefone inválido                        │ │ ║
║  │  │ [✏️ Corrigir telefone] [🔄 Reenviar]                     │ │ ║
║  │  └──────────────────────────────────────────────────────────┘ │ ║
║  │                                                                │ ║
║  │  ┌──────────────────────────────────────────────────────────┐ │ ║
║  │  │ 📢 Campanha de Vacinação          ✅ Enviado  08:00      │ │ ║
║  │  │ Para: 45 pacientes (envio em lote)                       │ │ ║
║  │  │ Campanha: Vacinação Influenza 2025                       │ │ ║
║  │  │ [📊 Ver relatório]                                       │ │ ║
║  │  └──────────────────────────────────────────────────────────┘ │ ║
║  │                                                                │ ║
║  │  [◀ Anterior]  Página 1 de 8  [Próxima ▶]                    │ ║
║  └────────────────────────────────────────────────────────────────┘ ║
╚══════════════════════════════════════════════════════════════════════╝
```

---

## 🎨 Detalhamento dos Componentes

### **1. Cards de Métricas (Topo)**

**Enviadas Hoje:**
```html
<div class="bg-green-50 border-l-4 border-green-500 p-4">
  <div class="text-3xl font-bold text-green-700">156</div>
  <div class="text-sm text-green-600">Enviadas hoje</div>
  <div class="text-xs text-green-500">+12% vs ontem</div>
</div>
```

**Pendentes:**
```html
<div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
  <div class="text-3xl font-bold text-yellow-700">8</div>
  <div class="text-sm text-yellow-600">Pendentes</div>
  <div class="text-xs text-yellow-500">Próxima: 09h</div>
</div>
```

**Falhas:**
```html
<div class="bg-red-50 border-l-4 border-red-500 p-4">
  <div class="text-3xl font-bold text-red-700">3</div>
  <div class="text-sm text-red-600">Falhas</div>
  <div class="text-xs text-red-500">📝 Ver logs</div>
</div>
```

---

### **2. Barra de Uso da Quota**

```html
<div class="bg-white border rounded-lg p-6">
  <h3 class="font-bold mb-3">📊 Uso da Quota</h3>
  
  <!-- Progresso -->
  <div class="mb-2">
    <div class="flex justify-between text-sm mb-1">
      <span>156 / 250 mensagens</span>
      <span class="font-bold">62%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-3">
      <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full" 
           style="width: 62%"></div>
    </div>
  </div>
  
  <!-- Info -->
  <div class="flex justify-between text-sm text-gray-600">
    <span>📅 Renovação: 01/12/2025 (13 dias)</span>
    <button class="text-purple-600 font-semibold">🚀 Fazer Upgrade</button>
  </div>
</div>
```

**Alertas automáticos:**
- 🟡 **80% usado:** "Atenção! Você está perto do limite"
- 🔴 **100% usado:** "Quota esgotada! Faça upgrade para continuar"
- 🟢 **< 80%:** Barra verde normal

---

### **3. Gráfico de Envios (7 dias)**

```javascript
// Dados do backend
const chartData = {
  labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
  datasets: [{
    label: 'Mensagens Enviadas',
    data: [23, 35, 28, 42, 31, 18, 15],
    borderColor: 'rgb(59, 130, 246)',
    tension: 0.4
  }]
};

// Chart.js ou similar
```

**Métricas abaixo do gráfico:**
- Total de envios na semana
- Taxa de sucesso
- Horário de pico
- Tipo mais enviado

---

### **4. Tabela de Histórico**

**Colunas:**
```
┌──────────┬─────────────────┬────────┬─────────────┬─────────┐
│ Tipo     │ Destinatário    │ Status │ Data/Hora   │ Ações   │
├──────────┼─────────────────┼────────┼─────────────┼─────────┤
│ 🔔 Lembr │ Maria Silva     │ ✅ OK  │ 18/11 09:15 │ 👁️ 🔄  │
│ ✅ Confir│ João Santos     │ ✅ OK  │ 18/11 08:30 │ 👁️ 💬  │
│ ❌ Lembr │ Pedro Costa     │ ❌ Erro│ 18/11 09:16 │ ✏️ 🔄  │
│ 📢 Campa │ 45 pacientes    │ ✅ OK  │ 18/11 08:00 │ 📊     │
└──────────┴─────────────────┴────────┴─────────────┴─────────┘
```

**Filtros:**
- 📅 **Período:** Hoje, Ontem, Últimos 7 dias, Últimos 30 dias, Personalizado
- 📱 **Tipo:** Todos, Lembretes, Confirmações, Campanhas, Conclusões
- ✅ **Status:** Todos, Enviados, Pendentes, Falhas

---

### **5. Modal: Ver Mensagem**

```
╔══════════════════════════════════════════════════╗
║  📱 Mensagem Enviada                        [✕] ║
╠══════════════════════════════════════════════════╣
║                                                  ║
║  👤 Destinatário: Maria Silva                   ║
║  📞 Telefone: (11) 95206-0833                   ║
║  📅 Enviado em: 18/11/2025 às 09:15:32          ║
║  ⏱️ Status: ✅ Entregue (09:15:45)              ║
║                                                  ║
║  ┌────────────────────────────────────────────┐ ║
║  │ 📩 Conteúdo da Mensagem:                  │ ║
║  │                                            │ ║
║  │  🏥 Multi Imune                            │ ║
║  │                                            │ ║
║  │  Olá Maria Silva! 👋                       │ ║
║  │                                            │ ║
║  │  💉 Você tem uma dose pendente de          │ ║
║  │  vacinação:                                │ ║
║  │                                            │ ║
║  │  📋 Vacina: Hepatite B - 2ª dose          │ ║
║  │  📅 Previsão: 15/12/2025                  │ ║
║  │  ⏰ Horário sugerido: 14:00h              │ ║
║  │                                            │ ║
║  │  📞 Para agendar, entre em contato:       │ ║
║  │  Telefone: (11) 9999-9999                 │ ║
║  │                                            │ ║
║  │  ✅ Mantenha sua carteira em dia!         │ ║
║  └────────────────────────────────────────────┘ ║
║                                                  ║
║  📊 Detalhes Técnicos:                          ║
║  • Message ID: msg_123456789                    ║
║  • Tempo de envio: 0.8s                         ║
║  • Tentativas: 1/3                              ║
║  • Z-API Instance: 3EA00D04...                  ║
║                                                  ║
║  [🔄 Reenviar Mensagem]  [📋 Copiar Texto]     ║
╚══════════════════════════════════════════════════╝
```

---

## 📊 Dados Necessários no Backend

### **Tabela: `lembretes` (já existe)**

```sql
CREATE TABLE lembretes (
    id BIGINT PRIMARY KEY,
    paciente_id BIGINT,
    tipo ENUM('dose_proxima', 'campanha_terminando', 'dose_atrasada'),
    canal ENUM('whatsapp', 'email', 'ambos'),
    destinatario VARCHAR(255),
    mensagem TEXT,
    status ENUM('pendente', 'enviado', 'erro'),
    erro_mensagem TEXT NULL,
    data_agendamento DATETIME,
    data_envio DATETIME NULL,
    metadata JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### **Queries para o Dashboard:**

```php
// 1. Métricas do dia
$enviadasHoje = Lembrete::whereDate('data_envio', today())
    ->where('status', 'enviado')
    ->count();

$pendentes = Lembrete::where('status', 'pendente')->count();

$falhas = Lembrete::whereDate('created_at', today())
    ->where('status', 'erro')
    ->count();

// 2. Uso da quota (do WhatsApp)
$usageInfo = $whatsappService->getUsageInfo();

// 3. Gráfico últimos 7 dias
$chartData = Lembrete::where('status', 'enviado')
    ->whereDate('data_envio', '>=', now()->subDays(7))
    ->groupBy(DB::raw('DATE(data_envio)'))
    ->selectRaw('DATE(data_envio) as data, COUNT(*) as total')
    ->get();

// 4. Taxa de sucesso
$total = Lembrete::whereDate('created_at', '>=', now()->subDays(7))->count();
$enviados = Lembrete::whereDate('created_at', '>=', now()->subDays(7))
    ->where('status', 'enviado')
    ->count();
$taxaSucesso = $total > 0 ? ($enviados / $total) * 100 : 0;

// 5. Histórico com paginação
$lembretes = Lembrete::with('paciente')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

---

## 🎯 Funcionalidades Extras

### **1. Reenviar Mensagem**

```php
// Controller
public function reenviar($id)
{
    $lembrete = Lembrete::findOrFail($id);
    
    // Validar telefone
    $telefone = preg_replace('/[^0-9]/', '', $lembrete->paciente->telefone);
    
    // Enviar via WhatsApp
    $resultado = $this->whatsappService->sendMessage(
        $telefone,
        $lembrete->mensagem
    );
    
    if ($resultado['success']) {
        $lembrete->update([
            'status' => 'enviado',
            'data_envio' => now(),
            'erro_mensagem' => null
        ]);
        
        return back()->with('success', '✅ Mensagem reenviada com sucesso!');
    }
    
    return back()->with('error', '❌ Erro ao reenviar: ' . $resultado['message']);
}
```

---

### **2. Exportar Relatório**

```php
// Botão: [📥 Exportar Excel]

public function exportar(Request $request)
{
    $lembretes = Lembrete::with('paciente')
        ->whereBetween('created_at', [
            $request->data_inicio,
            $request->data_fim
        ])
        ->get();
    
    return Excel::download(
        new LembretesExport($lembretes),
        'lembretes-' . now()->format('Y-m-d') . '.xlsx'
    );
}
```

---

### **3. Configurar Templates**

```
╔══════════════════════════════════════════════════╗
║  ⚙️ Configurar Templates de Mensagens       [✕] ║
╠══════════════════════════════════════════════════╣
║                                                  ║
║  📝 Tipo: Lembrete de Vacinação                 ║
║                                                  ║
║  ┌────────────────────────────────────────────┐ ║
║  │ 🏥 {{ tenant_name }}                       │ ║
║  │                                            │ ║
║  │ Olá {{ paciente_nome }}! 👋               │ ║
║  │                                            │ ║
║  │ 💉 Você tem uma dose pendente:            │ ║
║  │                                            │ ║
║  │ 📋 Vacina: {{ vacina }} - {{ dose }}      │ ║
║  │ 📅 Previsão: {{ data_prevista }}          │ ║
║  │ ⏰ Horário: {{ horario }}                 │ ║
║  │                                            │ ║
║  │ 📞 Contato: {{ telefone_clinica }}        │ ║
║  │                                            │ ║
║  │ ✅ Mantenha sua carteira em dia!          │ ║
║  └────────────────────────────────────────────┘ ║
║                                                  ║
║  💡 Variáveis disponíveis:                      ║
║  • {{ tenant_name }} - Nome da clínica          ║
║  • {{ paciente_nome }} - Nome do paciente       ║
║  • {{ vacina }} - Nome da vacina                ║
║  • {{ dose }} - Número da dose                  ║
║  • {{ data_prevista }} - Data formatada         ║
║  • {{ telefone_clinica }} - Telefone da clínica ║
║                                                  ║
║  [👁️ Pré-visualizar]  [💾 Salvar Template]     ║
╚══════════════════════════════════════════════════╝
```

---

## 🚀 Benefícios para o SaaS

### **1. Aumento do Perceived Value** 💎

Cliente vê na prática:
- ✅ "Meu sistema enviou 156 mensagens hoje!"
- ✅ "Taxa de sucesso de 98.3%!"
- ✅ "Estou recuperando pacientes com doses atrasadas"

### **2. Upsell Facilitado** 💰

```
┌─────────────────────────────────────┐
│  ⚠️ ATENÇÃO!                       │
│                                     │
│  Você usou 240 / 250 mensagens     │
│  (96% da quota)                     │
│                                     │
│  Faltam 10 dias para renovação.    │
│                                     │
│  🚀 Faça upgrade agora e ganhe:    │
│  • 500 mensagens/mês                │
│  • Relatórios avançados             │
│  • Suporte prioritário              │
│                                     │
│  [💳 Upgrade por R$ 79/mês]        │
└─────────────────────────────────────┘
```

### **3. Redução de Churn** 📉

- Cliente vê valor tangível todos os dias
- Métricas provam ROI (redução de faltas)
- Transparência gera confiança

### **4. Diferencial Competitivo** 🏆

Poucos SaaS mostram:
- Histórico completo de automações
- Estatísticas em tempo real
- Controle granular pelo usuário

---

## ✅ Proposta de Implementação

### **Fase 1: MVP (Básico)** - 4 horas

```
✅ Cards de métricas (Enviadas, Pendentes, Falhas)
✅ Barra de uso da quota
✅ Tabela de histórico com paginação
✅ Modal "Ver mensagem"
✅ Filtro por período
```

### **Fase 2: Intermediário** - 6 horas

```
✅ Gráfico de envios (Chart.js)
✅ Filtros avançados (tipo, status)
✅ Função "Reenviar mensagem"
✅ Exportar relatório (Excel)
✅ Detalhes técnicos no modal
```

### **Fase 3: Avançado** - 8 horas

```
✅ Editor de templates personalizados
✅ Dashboard analytics avançado
✅ Notificações em tempo real (pusher)
✅ Agendamento manual de envios
✅ Teste A/B de mensagens
```

---

## 🎯 Conclusão

**SIM, vale MUITO a pena implementar!**

**Retorno:**
- 💰 Aumenta perceived value
- 📈 Facilita upsell
- 🛡️ Reduz churn
- 🏆 Diferencial competitivo

**Esforço:**
- MVP: ~4 horas
- Retorno: Alto

**Recomendação:** Implementar o MVP agora! 🚀
