# 📱 Guia de Instalação - Evolution API WhatsApp

## ✅ **Integração Evolution API Implementada com Sucesso!**

### 📋 O que foi criado:

1. ✅ **WhatsAppService** - Service class completa
2. ✅ **Configurações no .env** - Variáveis de ambiente
3. ✅ **Controller de Configuração** - Painel admin
4. ✅ **Interface de testes** - Envio de mensagens teste
5. ✅ **Integração no comando de lembretes** - Envio automático real

---

## 🚀 Como Instalar a Evolution API

### **Opção 1: Docker (Recomendado) - Instalação Local**

```bash
# 1. Instalar Evolution API via Docker
docker run -d \
  --name evolution-api \
  -p 8080:8080 \
  -e AUTHENTICATION_API_KEY=minha-chave-secreta-123 \
  atendai/evolution-api

# 2. Verificar se está rodando
docker ps | grep evolution-api

# 3. Testar API
curl http://localhost:8080
```

### **Opção 2: Docker Compose (Produção)**

Crie um arquivo `docker-compose.yml`:

```yaml
version: '3.8'

services:
  evolution-api:
    image: atendai/evolution-api:latest
    container_name: evolution-api
    restart: always
    ports:
      - "8080:8080"
    environment:
      - AUTHENTICATION_API_KEY=${EVOLUTION_API_KEY}
      - DATABASE_ENABLED=true
      - DATABASE_CONNECTION_URI=postgresql://user:password@postgres:5432/evolution
    volumes:
      - evolution_data:/evolution/instances
    networks:
      - evolution-network

  postgres:
    image: postgres:15-alpine
    container_name: evolution-postgres
    restart: always
    environment:
      - POSTGRES_USER=evolution
      - POSTGRES_PASSWORD=evolution123
      - POSTGRES_DB=evolution
    volumes:
      - postgres_data:/var/lib/postgresql/data
    networks:
      - evolution-network

volumes:
  evolution_data:
  postgres_data:

networks:
  evolution-network:
    driver: bridge
```

Execute:
```bash
docker-compose up -d
```

### **Opção 3: Serviços Gerenciados Brasileiros**

Se não quer gerenciar servidor, use um destes serviços:

- **Evolution API Cloud**: https://evolution-api.com (~R$ 30/mês)
- **Whaticket Pro**: https://whaticket.com (inclui Evolution API)
- **Z-API**: https://z-api.io (alternativa paga oficial)

---

## ⚙️ Configuração no Laravel

### **1. Configure o .env**

```env
# Evolution API - WhatsApp
EVOLUTION_API_URL=http://localhost:8080
EVOLUTION_API_KEY=minha-chave-secreta-123
EVOLUTION_INSTANCE_NAME=multiimune
```

### **2. Limpe o cache de configuração**

```bash
php artisan config:clear
php artisan cache:clear
```

### **3. Acesse o painel de configuração**

```
http://multiimune.test/dashboard/whatsapp/config
```

---

## 📱 Como Conectar o WhatsApp

### **Método 1: Pelo Dashboard MultiImune**

1. Acesse: `/dashboard/whatsapp/config`
2. Clique em "Gerar QR Code"
3. Escaneie com o WhatsApp (Dispositivos Conectados)
4. Aguarde confirmação de conexão

### **Método 2: API Direto**

```bash
# 1. Criar instância
curl -X POST http://localhost:8080/instance/create \
  -H "apikey: minha-chave-secreta-123" \
  -H "Content-Type: application/json" \
  -d '{
    "instanceName": "multiimune",
    "qrcode": true
  }'

# 2. Pegar QR Code
curl http://localhost:8080/instance/connect/multiimune \
  -H "apikey: minha-chave-secreta-123"

# 3. Verificar status
curl http://localhost:8080/instance/connectionState/multiimune \
  -H "apikey: minha-chave-secreta-123"
```

---

## 🧪 Testar Envio de Mensagens

### **Pelo Dashboard:**

1. Acesse `/dashboard/whatsapp/config`
2. Preencha o formulário de teste
3. Clique em "Enviar Teste"

### **Via API (Postman/Insomnia):**

```bash
curl -X POST http://localhost:8080/message/sendText/multiimune \
  -H "apikey: minha-chave-secreta-123" \
  -H "Content-Type: application/json" \
  -d '{
    "number": "5519987654321@s.whatsapp.net",
    "text": "🏥 Teste de integração MultiImune!"
  }'
```

---

## 📊 Usando o Sistema de Lembretes

### **Envio Manual:**

```bash
# Simular (não envia de verdade)
php artisan lembretes:enviar --dry-run

# Enviar real
php artisan lembretes:enviar
```

### **Envio Automático (Cron):**

Edite o crontab:
```bash
crontab -e
```

Adicione:
```cron
# Enviar lembretes todo dia às 9h
0 9 * * * cd /caminho/multiimune && php artisan lembretes:enviar >> /dev/null 2>&1
```

Ou use o Laravel Scheduler em `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Enviar lembretes diariamente às 9h
    $schedule->command('lembretes:enviar')->dailyAt('09:00');
}
```

E configure o cron apenas uma vez:
```cron
* * * * * cd /caminho/multiimune && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔧 Troubleshooting

### **Problema: "Evolution API não configurada"**

✅ **Solução:**
```bash
# Verifique se as variáveis estão no .env
cat .env | grep EVOLUTION

# Limpe o cache
php artisan config:clear
```

### **Problema: "Erro ao conectar na API"**

✅ **Solução:**
```bash
# Verifique se a API está rodando
curl http://localhost:8080

# Verifique logs do Docker
docker logs evolution-api
```

### **Problema: "Número inválido"**

✅ **Solução:**
- Use formato: (19) 98765-4321
- O sistema formata automaticamente para: 5519987654321@s.whatsapp.net
- Certifique-se que o número tem WhatsApp ativo

### **Problema: "WhatsApp desconectado"**

✅ **Solução:**
1. Acesse `/dashboard/whatsapp/config`
2. Gere novo QR Code
3. Escaneie novamente com o WhatsApp

---

## 📈 Métricas e Logs

### **Ver logs de envio:**

```bash
# Logs do Laravel
tail -f storage/logs/laravel.log | grep WhatsApp

# Logs da Evolution API
docker logs -f evolution-api
```

### **Histórico no Dashboard:**

Acesse `/dashboard/lembretes` para ver:
- ✅ Mensagens enviadas
- ⏳ Mensagens pendentes
- ❌ Erros de envio
- 📊 Estatísticas

---

## 💰 Custos

- **Evolution API (self-hosted)**: 🟢 **GRÁTIS** (apenas custo do servidor)
- **Servidor VPS**: R$ 20-50/mês (Digital Ocean, AWS, etc)
- **Evolution API Cloud**: R$ 30-60/mês (gerenciado)
- **WhatsApp Business API Oficial**: R$ 0,15-0,30 por mensagem

**Recomendação:** Comece com Evolution API self-hosted (grátis) e migre para cloud se precisar de mais estabilidade.

---

## 🎯 Próximos Passos

1. ✅ Instalar Evolution API
2. ✅ Configurar .env
3. ✅ Conectar WhatsApp via QR Code
4. ✅ Testar envio manual
5. ✅ Configurar cron para automação
6. ✅ Monitorar logs e ajustar

---

## 📞 Suporte

- **Evolution API Docs**: https://doc.evolution-api.com
- **GitHub**: https://github.com/EvolutionAPI/evolution-api
- **Comunidade BR**: Telegram - @evolution_api

---

## ✅ Status da Implementação

- [x] WhatsAppService criado
- [x] Configuração no .env
- [x] Painel de configuração
- [x] Testes de envio
- [x] Integração com lembretes
- [x] Validação de números
- [x] Tratamento de erros
- [x] Logs detalhados
- [ ] Instalação da Evolution API (manual do usuário)
- [ ] Conexão do WhatsApp (manual do usuário)

**Tudo pronto no código! Falta apenas instalar e conectar a Evolution API.**
