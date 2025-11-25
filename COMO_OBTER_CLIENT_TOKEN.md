# 🔑 Como Configurar a Z-API Corretamente

## ⚠️ Problema Atual

Erro: `{"error":"your client-token is not configured"}`

Este erro ocorre porque **a instância Z-API precisa ter os webhooks configurados** antes de poder enviar mensagens.

## ✅ Status da Sua Instância

Pelos dados que você mostrou:
- ✅ **Nome da instância**: Meu número
- ✅ **ID da instância**: `3EA00D045BBA411272EA262C2401B26D`
- ✅ **Token**: `53C7BCFE425BACB7D273D037`
- ✅ **Status**: Conectado (verde)
- ❌ **Webhooks**: NÃO CONFIGURADOS (aviso amarelo no painel)

## 🔧 Solução: Configurar Webhooks

### Passo 1: Configurar Webhooks no Painel Z-API

1. **Acesse o painel da Z-API**: https://developer.z-api.io/
2. **Clique na sua instância** "Meu número"
3. **Clique em "Configurar agora"** (no aviso amarelo sobre webhooks)
4. **Configure as URLs dos webhooks**:

#### URLs Recomendadas (temporárias para teste):

Para testar inicialmente, você pode usar URLs de teste:

```
Message URL: https://webhook.site/unique-url
Status URL: https://webhook.site/unique-url
```

**Ou deixe em branco por enquanto** - configure apenas quando for usar em produção.

### Passo 2: Salvar as Configurações

Após configurar (ou pular) os webhooks, clique em **Salvar**.

### Passo 3: Testar Novamente

Após salvar, aguarde alguns segundos e teste:

```bash
php artisan whatsapp:test 11952060833
```

## 🎯 Alternativa: Usar URL Completa da API

Na imagem, vi que você tem a **API da instância completa**:

```
https://api.z-api.io/instances/3EA00D045BBA411272EA262C2401B26D/token/53C7BCFE425BACB7D273D037/send-text
```

Vou criar um teste direto usando essa URL.

## 📝 Próximos Passos

1. **Acesse o painel da Z-API**
2. **Configure os webhooks** (ou clique em "Pular" se disponível)
3. **Salve as configurações**
4. **Teste novamente**: `php artisan whatsapp:test 11952060833`

## 🆘 Se Continuar com Erro

Se o erro persistir após configurar os webhooks:

1. **Verifique se a instância está "Conectada"** (deve mostrar verde)
2. **Tente desconectar e reconectar** o WhatsApp
3. **Gere um novo token** (botão "Gerar novo token" no painel)
4. **Entre em contato com o suporte da Z-API**

## 📚 Documentação Z-API

- **Painel**: https://developer.z-api.io/
- **Documentação**: https://developer.z-api.io/
- **Suporte**: Dentro do painel da Z-API

---

**Nota**: O erro "client-token is not configured" é específico da Z-API e indica que falta alguma configuração no painel deles, não no seu código Laravel.
