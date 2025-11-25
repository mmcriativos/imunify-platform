# 💉 Fluxo Automático: Lembrete de Vacinação

## 📋 Como Funciona na Prática

### 🎯 **Cenário Real**

**Paciente:** Maria Silva  
**Data de Nascimento:** 15/10/2025  
**Última Vacina:** Hepatite B - 1ª dose (aplicada no nascimento)  
**Próxima Dose:** Hepatite B - 2ª dose (prevista para 15/11/2025)

---

## 🔄 Fluxo Completo do Sistema

### **1️⃣ Detecção Automática de Doses Pendentes**

**Arquivo:** `app/Console/Commands/EnviarLembretesVacinas.php`  
**Método:** `gerarLembretesProximasDoses()`

```php
// O sistema roda DIARIAMENTE às 9h da manhã
Schedule::command('lembretes:enviar')->dailyAt('09:00')
```

**O que o sistema faz:**

1. **Busca todos os pacientes** do banco de dados
2. **Para cada paciente**, verifica:
   - Quais vacinas ele já tomou
   - Quais vacinas ele DEVERIA ter tomado (baseado na idade)
   - Calcula a data prevista de cada dose pendente

3. **Identifica doses próximas do vencimento** (6 a 8 dias de antecedência)

**Exemplo com Maria Silva:**

```php
// Maria nasceu em 15/10/2025
// Hoje é 08/11/2025 (7 dias antes da 2ª dose)

$proximasDoses = $this->calcularProximasDoses($paciente);
// Retorna:
[
    'vacina' => 'Hepatite B',
    'dose' => '2ª dose',
    'data_prevista' => '15/11/2025'
]

// Calcula: 15/11 - 08/11 = 7 dias
// ✅ Está no intervalo de 6-8 dias? SIM!
// ✅ Criar lembrete!
```

---

### **2️⃣ Criação do Lembrete Personalizado**

**Método:** `criarLembrete()`

O sistema cria um registro na tabela `lembretes`:

```sql
INSERT INTO lembretes (
    paciente_id,
    tipo,
    canal,
    destinatario,
    mensagem,
    status,
    data_agendamento,
    metadata
) VALUES (
    123,                    -- ID da Maria
    'dose_proxima',         -- Tipo: dose próxima
    'ambos',                -- Canal: WhatsApp + Email
    '5511952060833',        -- Telefone da Maria
    '🏥 *Multi Imune* ...'  -- Mensagem personalizada
    'pendente',             -- Status: aguardando envio
    '2025-11-08 09:00',     -- Criado agora
    '{"vacina": "Hepatite B", "dose": "2ª dose", ...}'
);
```

**Mensagem gerada:**

```
🏥 *Multi Imune*

Olá Maria Silva! 👋

💉 Você tem uma dose pendente de vacinação:

📋 Vacina: Hepatite B - 2ª dose
📅 Previsão: 15/12/2025
⏰ Horário sugerido: 14:00h

📞 Para agendar, entre em contato:
Telefone: (11) 9999-9999

✅ Mantenha sua carteira em dia!
```

---

### **3️⃣ Envio Automático via WhatsApp**

**Método:** `enviarLembretesPendentes()`

**O sistema:**

1. Busca todos os lembretes com `status = 'pendente'`
2. Para cada lembrete:
   - Valida o telefone do paciente
   - Chama o `WhatsAppService`
   - Envia via Z-API
   - Atualiza o status para `'enviado'`

```php
// Busca lembretes pendentes
$lembretes = Lembrete::where('status', 'pendente')
                     ->where('data_agendamento', '<=', now())
                     ->get();

foreach ($lembretes as $lembrete) {
    // Envia via WhatsApp
    $resultado = $this->whatsappService->sendMessage(
        '5511952060833',  // Telefone da Maria
        $mensagem
    );
    
    if ($resultado['success']) {
        // Marca como enviado
        $lembrete->status = 'enviado';
        $lembrete->data_envio = now();
        $lembrete->save();
        
        // ✅ Maria recebe mensagem no WhatsApp!
    }
}
```

---

## 📅 **Calendário de Execução**

### **Quando o sistema envia lembretes?**

| Horário | Comando | Descrição |
|---------|---------|-----------|
| **09:00** | `lembretes:enviar` | Verifica e envia lembretes de doses próximas (7 dias antes) |
| **Diário** | Automático | Roda todos os dias via Laravel Schedule |

**Configurado em:** `routes/console.php`

```php
Schedule::command('lembretes:enviar')
    ->dailyAt('09:00')
    ->timezone('America/Sao_Paulo');
```

---

## 🧮 **Lógica de Cálculo: Próximas Doses**

**Método:** `calcularProximasDoses($paciente)`

### **Calendário Nacional de Vacinação (hardcoded)**

```php
$calendario = [
    ['vacina' => 'BCG', 'dose' => 'Dose única', 'idade_meses' => 0],
    ['vacina' => 'Hepatite B', 'dose' => '1ª dose', 'idade_meses' => 0],
    ['vacina' => 'Hepatite B', 'dose' => '2ª dose', 'idade_meses' => 1],
    ['vacina' => 'Hepatite B', 'dose' => '3ª dose', 'idade_meses' => 6],
    ['vacina' => 'Pentavalente', 'dose' => '1ª dose', 'idade_meses' => 2],
    // ... etc
];
```

### **Exemplo de cálculo para Maria Silva:**

```php
// Maria nasceu em 15/10/2025
$dataNascimento = Carbon::parse('2025-10-15');

// Para Hepatite B - 2ª dose (1 mês de idade):
$dataPrevista = $dataNascimento->addMonths(1);
// = 15/11/2025

// Verifica se Maria já tomou essa dose:
$jaTomou = DB::table('atendimento_vacina')
    ->where('paciente_id', $paciente->id)
    ->where('vacina_id', $vacinaHepB->id)
    ->exists();

if (!$jaTomou) {
    // ✅ Adiciona na lista de doses pendentes
    $proximasDoses[] = [
        'vacina' => 'Hepatite B',
        'dose' => '2ª dose',
        'data_prevista' => '2025-11-15'
    ];
}
```

---

## 🎯 **Condições para Envio**

### ✅ **Sistema ENVIA lembrete quando:**

1. **Paciente tem dose pendente** (baseado na idade)
2. **Faltam 6 a 8 dias** para a data prevista
3. **Paciente tem telefone cadastrado**
4. **Não foi enviado lembrete nos últimos 10 dias** (evita duplicatas)
5. **WhatsApp está configurado** e tem quota disponível

### ❌ **Sistema NÃO envia lembrete quando:**

1. Paciente já tomou aquela dose
2. Data prevista está muito longe (> 8 dias)
3. Data prevista já passou há muito tempo (> 30 dias)
4. Já foi enviado lembrete recente
5. Paciente não tem telefone cadastrado

---

## 🔍 **Rastreamento e Histórico**

### **Tabela:** `lembretes`

Cada lembrete enviado fica registrado:

```sql
SELECT 
    id,
    paciente_id,
    tipo,
    status,
    mensagem,
    data_agendamento,
    data_envio,
    erro_mensagem
FROM lembretes
WHERE paciente_id = 123
ORDER BY created_at DESC;
```

**Resultado:**

| ID | Paciente | Tipo | Status | Data Envio | Vacina |
|----|----------|------|--------|------------|--------|
| 456 | Maria Silva | dose_proxima | enviado | 08/11/2025 09:03 | Hepatite B - 2ª |
| 123 | Maria Silva | dose_proxima | enviado | 15/10/2025 09:01 | Hepatite B - 1ª |

---

## 🧪 **Como Testar Manualmente**

### **1. Simular envio (sem enviar de verdade)**

```bash
php artisan lembretes:enviar --dry-run
```

**Saída esperada:**

```
🚀 Iniciando processamento de lembretes...
📅 Verificando doses próximas do vencimento...
   → 3 lembretes de doses próximas criados
🎯 Verificando campanhas terminando...
   → 0 lembretes de campanhas criados
⚠️  Verificando doses atrasadas...
   → 1 lembretes de doses atrasadas criados
📤 Enviando 4 lembretes...
   [SIMULAÇÃO] → dose_proxima para Maria Silva
   [SIMULAÇÃO] → dose_proxima para João Santos
   [SIMULAÇÃO] → dose_proxima para Ana Costa
   [SIMULAÇÃO] → dose_atrasada para Pedro Lima
✅ Processo concluído! 0 lembretes enviados.
```

### **2. Enviar lembretes de verdade**

```bash
php artisan lembretes:enviar
```

**Saída esperada:**

```
🚀 Iniciando processamento de lembretes...
📅 Verificando doses próximas do vencimento...
   → 3 lembretes de doses próximas criados
📤 Enviando 3 lembretes...
   ✅ Enviado para Maria Silva
   ✅ Enviado para João Santos
   ✅ Enviado para Ana Costa
✅ Processo concluído! 3 lembretes enviados.
```

---

## 🎨 **Personalização da Mensagem**

**Método:** `gerarMensagem($tipo, $paciente, $dados)`

### **Variáveis dinâmicas injetadas:**

- `{$paciente->nome}` → Nome do paciente
- `{$dados['vacina']}` → Nome da vacina
- `{$dados['dose']}` → Número da dose (1ª, 2ª, 3ª, etc.)
- `{$dataPrevista}` → Data formatada (15/11/2025)
- `{{ tenant()->name }}` → Nome da clínica

### **Exemplo de personalização:**

```php
// ANTES (template):
"Olá, {$paciente->nome}!\n\n" .
"⏰ A próxima dose da vacina *{$dados['vacina']}* " .
"({$dados['dose']}) está prevista para *{$dataPrevista}*.\n\n"

// DEPOIS (enviado):
"Olá, Maria Silva!\n\n" .
"⏰ A próxima dose da vacina *Hepatite B* " .
"(2ª dose) está prevista para *15/11/2025*.\n\n"
```

---

## 📊 **Métricas e Monitoramento**

### **Consultas úteis:**

```sql
-- Lembretes enviados hoje
SELECT COUNT(*) FROM lembretes 
WHERE DATE(data_envio) = CURDATE() 
AND status = 'enviado';

-- Taxa de sucesso
SELECT 
    status,
    COUNT(*) as total,
    ROUND(COUNT(*) * 100.0 / SUM(COUNT(*)) OVER(), 2) as percentual
FROM lembretes
GROUP BY status;

-- Lembretes por tipo
SELECT 
    tipo,
    COUNT(*) as total
FROM lembretes
WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY tipo;
```

---

## 🚀 **Ativação em Produção**

### **No servidor Linux:**

1. **Ativar o Laravel Scheduler:**

```bash
crontab -e
```

2. **Adicionar linha:**

```bash
* * * * * cd /var/www/imunify && php artisan schedule:run >> /dev/null 2>&1
```

3. **Salvar e sair**

✅ **Pronto!** O sistema vai rodar automaticamente todos os dias às 9h da manhã.

### **No Windows (Laragon/XAMPP):**

1. Abrir **Agendador de Tarefas**
2. Criar nova tarefa:
   - **Programa:** `php.exe`
   - **Argumentos:** `M:\laragon\www\imunify\artisan schedule:run`
   - **Iniciar em:** `M:\laragon\www\imunify`
   - **Gatilho:** A cada 1 minuto
   - **Executar estando o usuário conectado ou não**

---

## 🎯 **Resumo Final**

### **Fluxo Completo em 4 Passos:**

```
1. [DETECÇÃO]
   └─> Sistema verifica doses pendentes
       └─> Baseado em idade + histórico de vacinação

2. [CRIAÇÃO]
   └─> Cria registro na tabela 'lembretes'
       └─> Status: 'pendente'

3. [ENVIO]
   └─> WhatsApp Service envia mensagem
       └─> Status: 'enviado'

4. [REGISTRO]
   └─> Histórico completo salvo
       └─> Relatórios e auditorias
```

---

## ✅ **Benefícios**

| Benefício | Impacto |
|-----------|---------|
| 🤖 **Totalmente Automático** | Zero trabalho manual |
| 🎯 **Personalizado** | Nome, vacina, data específicos |
| 📊 **Rastreável** | Histórico completo de envios |
| 🔄 **Inteligente** | Evita duplicatas e spam |
| 📈 **Escalável** | Funciona com 10 ou 10.000 pacientes |
| ⏰ **Pontual** | Sempre 7 dias antes |

---

## 📞 **Próximos Passos**

1. ✅ Entender o fluxo (este documento)
2. 🧪 Testar com `--dry-run`
3. 📝 Criar paciente de teste
4. 🚀 Ativar em produção
5. 📊 Monitorar resultados

---

**Status:** ✅ Sistema 100% implementado e funcional  
**Última atualização:** 18/11/2025
