# 📱 Sistema de Confirmação de Presença via WhatsApp

## Visão Geral

O MultiImune agora envia mensagens com **botões interativos** no WhatsApp, permitindo que pacientes **confirmem ou cancelem** seus agendamentos com um simples clique!

---

## 🎯 Como Funciona

### 1. **Envio Automático**
O sistema envia lembretes automáticos em 4 momentos:
- **7 dias antes** (09:00)
- **1 dia antes** (18:00)
- **No dia do agendamento** (08:00)
- **Agendamentos atrasados** (Segunda-feira, 10:00)

### 2. **Mensagem com Botões**
Cada lembrete inclui dois botões interativos:
```
✅ Confirmar Presença
❌ Cancelar Agendamento
```

### 3. **Resposta Automática**
Quando o paciente clica em um botão:
- A Z-API envia um **webhook** para o sistema
- O MultiImune registra a resposta automaticamente
- O status do agendamento é atualizado
- Tudo fica registrado no banco de dados

---

## ⚙️ Configuração do Webhook na Z-API

### Passo 1: Acessar o Painel Z-API
1. Acesse: https://api.z-api.io
2. Faça login com suas credenciais
3. Selecione sua instância

### Passo 2: Configurar Webhook
1. No menu lateral, clique em **"Webhooks"**
2. Procure por **"Mensagens Recebidas"** ou **"Message Received"**
3. Cole a URL do webhook:

```
https://seu-dominio.com/webhook/whatsapp
```

**⚠️ IMPORTANTE**: Substitua `seu-dominio.com` pelo domínio real da sua aplicação!

#### Exemplos de URLs:

**Desenvolvimento Local (Laragon)**:
```
http://localhost/multiimune/webhook/whatsapp
```

**Produção**:
```
https://multiimune.com.br/webhook/whatsapp
```

**Usando ngrok para testes locais**:
```bash
# Instalar ngrok (se ainda não tiver)
choco install ngrok

# Expor aplicação local
ngrok http 80

# Use a URL gerada pelo ngrok
https://abc123.ngrok.io/webhook/whatsapp
```

### Passo 3: Configurar Eventos
Marque os seguintes eventos para webhook:
- ✅ **Mensagens Recebidas** (Messages Received)
- ✅ **Botões Clicados** (Button Clicked / List Response)
- ✅ **Respostas de Lista** (List Response)

### Passo 4: Testar Webhook
```bash
# Testar se o webhook está acessível
curl https://seu-dominio.com/webhook/whatsapp/teste

# Resposta esperada:
{
  "status": "ok",
  "message": "Webhook funcionando",
  "timestamp": "2025-11-10T..."
}
```

---

## 🧪 Testando o Sistema

### 1. Criar Agendamento de Teste
```bash
cd M:\laragon\www\multiimune

# Criar agendamento para amanhã
php artisan teste:criar-agendamento
```

### 2. Enviar Lembrete com Botões
```bash
# Enviar lembretes para 1 dia antes
php artisan lembretes:auto --tipo=1dia
```

### 3. Verificar no WhatsApp
- Você receberá a mensagem com 2 botões
- Clique em "✅ Confirmar Presença"
- O sistema registra automaticamente!

### 4. Verificar no Dashboard
```
http://localhost/multiimune/dashboard/confirmacoes
```

---

## 📊 Banco de Dados

### Tabela: `confirmacoes_presenca`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `agendamento_id` | bigint | FK para agendamentos |
| `paciente_id` | bigint | FK para pacientes |
| `lembrete_enviado_id` | bigint | FK para lembretes_enviados |
| `telefone` | varchar(20) | Telefone do paciente |
| `status` | enum | `pendente`, `confirmado`, `cancelado` |
| `mensagem_botao` | text | Mensagem enviada com botões |
| `resposta_botao` | varchar | ID do botão clicado |
| `message_id` | varchar | ID da mensagem Z-API |
| `enviado_em` | timestamp | Quando foi enviado |
| `respondido_em` | timestamp | Quando paciente respondeu |

---

## 🔍 Monitoramento

### Logs do Laravel
```bash
# Ver logs em tempo real
Get-Content storage/logs/laravel.log -Wait -Tail 50

# Logs específicos de webhook
Get-Content storage/logs/laravel.log -Wait | Select-String "Webhook"
```

### Logs da Z-API
No painel da Z-API, você pode ver:
- Mensagens enviadas
- Webhooks recebidos
- Erros de entrega
- Histórico completo

---

## 🚀 Comandos Úteis

```bash
# Enviar lembretes manualmente (com botões)
php artisan lembretes:auto --tipo=1dia
php artisan lembretes:auto --tipo=7dias
php artisan lembretes:auto --tipo=hoje
php artisan lembretes:auto --tipo=atrasados

# Ver últimas confirmações no banco
php artisan tinker
>>> \App\Models\ConfirmacaoPresenca::with('paciente')->latest()->take(5)->get()

# Ver agendamentos confirmados
>>> \App\Models\ConfirmacaoPresenca::confirmado()->count()

# Ver taxa de resposta
>>> $total = \App\Models\ConfirmacaoPresenca::count()
>>> $respondidos = \App\Models\ConfirmacaoPresenca::whereNotNull('respondido_em')->count()
>>> round(($respondidos / $total) * 100, 1) . '%'
```

---

## 📱 Formato da Mensagem

### Exemplo Enviado:
```
🏥 *MultiImune - Lembrete de Vacinação*

📋 Olá, João Silva!

📅 *Agendamento:*
🗓 Data: 12/11/2025
🕐 Horário: 14:00
📍 Local: Sala 1

💉 *Vacina Agendada:*
Influenza (Gripe)

⏰ *Seu agendamento é amanhã!*
Não esqueça de comparecer no horário marcado.

⚠️ *Importante:*
• Traga documento de identidade
• Chegue com 10 minutos de antecedência

---
🏥 MultiImune - Saúde em primeiro lugar

❓ *Você confirma sua presença?*
👇 Clique em uma das opções abaixo:
```

**Botões:**
- ✅ Confirmar Presença
- ❌ Cancelar Agendamento

---

## 🐛 Troubleshooting

### Webhook não está recebendo respostas

**Verificar:**
1. ✅ URL do webhook está correta na Z-API?
2. ✅ Aplicação está acessível publicamente?
3. ✅ Rota está pública (sem middleware auth)?
4. ✅ Firewall permite requisições da Z-API?

**Teste manual:**
```bash
# Simular webhook
curl -X POST https://seu-dominio.com/webhook/whatsapp \
  -H "Content-Type: application/json" \
  -d '{
    "messageId": "teste123",
    "phone": "5511952060833",
    "selectedButtonId": "btn_confirmar"
  }'
```

### Mensagem enviada mas sem botões

**Verificar:**
1. ✅ Z-API suporta botões? (plan Business ou superior)
2. ✅ Endpoint correto: `/send-button-list`
3. ✅ Formato dos botões está correto?
4. ✅ Logs mostram erro específico?

### Status não atualiza no banco

**Verificar:**
```bash
# Ver logs de webhook
Get-Content storage/logs/laravel.log | Select-String "Webhook Z-API"

# Ver última confirmação
php artisan tinker
>>> \App\Models\ConfirmacaoPresenca::latest()->first()
```

---

## 📈 Métricas Disponíveis

No dashboard `/dashboard/confirmacoes`:

- 📊 **Total de Confirmações Enviadas**
- ✅ **Taxa de Confirmação**
- ⏳ **Pendentes de Resposta**
- ❌ **Cancelamentos**
- 📱 **Taxa de Resposta**
- 📅 **Confirmações Hoje/Esta Semana**

---

## 🔐 Segurança

### Validação de Webhooks

O sistema valida:
- ✅ Dados obrigatórios (messageId, phone, resposta)
- ✅ Telefone corresponde a confirmação pendente
- ✅ Message ID único (evita duplicação)
- ✅ Logs completos para auditoria

### Dados Sensíveis

- ❌ Não expor Client-Token publicamente
- ❌ Não commitar tokens no Git
- ✅ Usar .env para credenciais
- ✅ HTTPS em produção obrigatório

---

## 🎨 Próximos Passos

- [ ] Criar view de dashboard de confirmações
- [ ] Adicionar gráficos de taxa de resposta
- [ ] Relatório Excel de confirmações
- [ ] Notificações push para cancelamentos
- [ ] Reminders automáticos para pendentes

---

## 📞 Suporte Z-API

- **Site**: https://z-api.io
- **Docs**: https://developer.z-api.io
- **Suporte**: suporte@z-api.io
- **WhatsApp**: +55 11 9XXXX-XXXX

---

**✅ Sistema pronto para uso! Basta configurar o webhook na Z-API!**
