# Instruções para Configurar Wildcard Subdomain

## Problema
Os subdomínios dos tenants não são criados automaticamente, resultando em erro 404.

## Solução 1: Wildcard Subdomain no cPanel (RECOMENDADO)

### Passo 1: Criar Subdomain Wildcard no cPanel

1. Acesse **cPanel** → **Subdomains**
2. Em "Create a Subdomain":
   - **Subdomain:** `*` (asterisco)
   - **Domain:** `imunify.com.br`
   - **Document Root:** `/home/imunifycom/repositories/imunify-platform/public`
3. Clique em **Create**

### Passo 2: Configurar DNS

Se usa **Cloudflare** (ou outro provedor DNS):

1. Acesse o painel DNS
2. Adicione um registro:
   - **Type:** `A`
   - **Name:** `*`
   - **Content:** IP do servidor (ex: `192.168.1.1`)
   - **Proxy status:** Proxied (laranja)
   - **TTL:** Auto

Se usa **DNS do cPanel**:
- O wildcard subdomain criado no Passo 1 já configura automaticamente

### Passo 3: Testar

Após 5-10 minutos (propagação DNS), teste:

```bash
# Teste se qualquer subdomínio resolve
ping qualquercoisa.imunify.com.br
ping teste123.imunify.com.br
```

Ambos devem retornar o IP do servidor.

---

## Solução 2: Criar Subdomínios Manualmente (Temporário)

Se não conseguir configurar wildcard, crie cada subdomínio manualmente:

### Via cPanel:

1. **Subdomains** → **Create a Subdomain**
2. Para cada tenant:
   - Subdomain: `saudetotal` (ou nome da clínica)
   - Domain: `imunify.com.br`
   - Document Root: `/home/imunifycom/repositories/imunify-platform/public`

### Via Script Automatizado (requer API do cPanel):

```php
// Adicionar ao RegisterTenantController após criar tenant
$this->createCPanelSubdomain($subdomain);
```

⚠️ **Desvantagem:** Requer credenciais da API do cPanel e pode ter limites de criação.

---

## Solução 3: Usar Domínios Próprios dos Clientes

Permitir que cada clínica use seu próprio domínio (ex: `www.clinicasaude.com.br`):

1. Cliente adiciona um registro CNAME no DNS dele:
   ```
   CNAME: www
   Aponta para: imunify.com.br
   ```

2. No cPanel, adicione o domínio como **Addon Domain**

⚠️ **Desvantagem:** Clientes precisam ter domínio próprio.

---

## ✅ Checklist de Verificação

Após configurar wildcard:

- [ ] Wildcard subdomain `*` criado no cPanel
- [ ] DNS configurado com registro `*` tipo A
- [ ] Aguardar propagação DNS (5-10 minutos)
- [ ] Testar ping em subdomínio aleatório
- [ ] Testar criação de tenant em `/registrar`
- [ ] Verificar acesso ao tenant criado

---

## 🔧 Troubleshooting

### "Subdomain já existe"
- Verifique se não há conflito com outros subdomínios
- Remova subdomínios específicos se houver

### "DNS não resolve"
```bash
# Verificar DNS
nslookup teste.imunify.com.br
dig teste.imunify.com.br

# Deve retornar o IP do servidor
```

### "Ainda dá 404 após criar wildcard"
```bash
# Verificar se o Apache reconhece
apachectl -S | grep imunify

# Reiniciar Apache
sudo systemctl restart httpd
```

---

## 📞 Se precisar de ajuda

Forneça:
1. Screenshot da seção "Subdomains" do cPanel
2. Screenshot da configuração DNS
3. Output de `nslookup teste.imunify.com.br`
