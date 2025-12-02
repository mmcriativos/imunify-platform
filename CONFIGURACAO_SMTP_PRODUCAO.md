# 🔧 Guia de Configuração SMTP para Produção

## 📌 Resumo

No sistema multi-tenant Imunify, **todos os tenants compartilham a mesma configuração SMTP**. Isso é feito através do arquivo `.env` principal.

---

## 🎯 Configuração Atual

**Ambiente:** Desenvolvimento  
**Modo:** `MAIL_MAILER=log` (emails salvos em logs, não enviados)

```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🚀 Configuração para Produção

### **Passo 1: Criar Email Corporativo**

Crie um email no cPanel do domínio `imunify.com.br`:
- Email sugerido: `noreply@imunify.com.br` ou `sistema@imunify.com.br`
- Senha forte e segura
- Quota mínima: 500MB

---

### **Passo 2: Obter Credenciais SMTP do cPanel**

No cPanel:
1. Vá em **Email Accounts**
2. Clique em **Connect Devices** ao lado do email criado
3. Anote as configurações SMTP:
   - **Host:** `mail.imunify.com.br`
   - **Porta:** `587` (TLS) ou `465` (SSL)
   - **Usuário:** `noreply@imunify.com.br`
   - **Senha:** (a que você definiu)

---

### **Passo 3: Editar `.env` no Servidor**

**No servidor de produção** (`/home/imunifyc/public_html/.env`):

```env
# ====== CONFIGURAÇÃO DE EMAIL ======
MAIL_MAILER=smtp
MAIL_HOST=mail.imunify.com.br
MAIL_PORT=587
MAIL_USERNAME=noreply@imunify.com.br
MAIL_PASSWORD=SuaSenhaSeguraAqui123
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@imunify.com.br
MAIL_FROM_NAME="Imunify - Sistema de Vacinação"
```

**Importante:** 
- Use `MAIL_ENCRYPTION=tls` para porta 587
- Use `MAIL_ENCRYPTION=ssl` para porta 465
- Mantenha a senha segura (não compartilhe)

---

### **Passo 4: Limpar Cache**

Execute no servidor:

```bash
cd /home/imunifyc/public_html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

### **Passo 5: Testar Envio**

#### **Opção A: Script de Teste (Recomendado)**

```bash
php test_smtp_config.php
# Digite seu email quando solicitado
```

#### **Opção B: Tinker**

```bash
php artisan tinker
```

Dentro do tinker:
```php
Mail::raw('Teste de SMTP', function($message) {
    $message->to('seu-email-pessoal@gmail.com')
            ->subject('Teste do Imunify');
});
```

#### **Opção C: Criar Usuário Real**

1. Acesse um tenant
2. Vá em **Configurações → Usuários**
3. Crie um novo usuário com seu email pessoal
4. Verifique se o email chegou

---

## 🔒 Configurações Avançadas de Segurança

### **DNS: SPF Record**

Adicione no DNS do domínio `imunify.com.br`:

```
Tipo: TXT
Nome: @
Valor: v=spf1 mx a ip4:SEU_IP_DO_SERVIDOR ~all
```

Substitua `SEU_IP_DO_SERVIDOR` pelo IP real do servidor.

---

### **DNS: DKIM**

No cPanel:
1. Vá em **Email Deliverability**
2. Localize seu domínio
3. Clique em **Manage**
4. Copie o registro DKIM
5. Adicione no DNS

---

### **DNS: DMARC**

Adicione no DNS:

```
Tipo: TXT
Nome: _dmarc
Valor: v=DMARC1; p=quarantine; rua=mailto:postmaster@imunify.com.br
```

---

## 🌐 Opções de Provedor SMTP

### **Opção 1: cPanel/Hosting (Atual - Recomendado)**

✅ **Prós:**
- Já incluído no hosting
- Configuração simples
- Sem custos adicionais
- Controle total

❌ **Contras:**
- Limites de envio menores
- Pode ter problemas de deliverability se IP for compartilhado

**Configuração:**
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.imunify.com.br
MAIL_PORT=587
MAIL_USERNAME=noreply@imunify.com.br
MAIL_PASSWORD=senha_do_email
MAIL_ENCRYPTION=tls
```

---

### **Opção 2: Gmail SMTP (Simples)**

✅ **Prós:**
- Alta taxa de entrega
- Confiável
- Grátis até 500 emails/dia

❌ **Contras:**
- Limite de 500 emails/dia
- Precisa gerar "Senha de App"
- Menos profissional

**Configuração:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=senha-de-app-do-google
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
```

**Como obter Senha de App:**
1. https://myaccount.google.com/security
2. Ativar verificação em 2 etapas
3. Senhas de app → Gerar nova
4. Use a senha gerada

---

### **Opção 3: Mailgun (Profissional)**

✅ **Prós:**
- Excelente deliverability
- APIs robustas
- Analytics de emails
- 5.000 emails grátis/mês

❌ **Contras:**
- Requer cadastro e configuração DNS
- Curva de aprendizado

**Configuração:**
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.imunify.com.br
MAILGUN_SECRET=sua-chave-api
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@imunify.com.br
```

---

### **Opção 4: SendGrid (Escalável)**

✅ **Prós:**
- 100 emails grátis/dia
- Muito confiável
- Boas ferramentas de analytics

❌ **Contras:**
- Precisa verificar domínio
- API key necessária

**Configuração:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.sua_chave_api_aqui
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@imunify.com.br
```

---

## 🎨 Personalização por Tenant (Futuro)

Se no futuro você quiser que cada tenant tenha seu próprio email:

### **Opção A: Nome Dinâmico (Simples)**

Modificar `app/Mail/UserCredentialsMail.php`:

```php
use Illuminate\Mail\Mailables\Address;

public function envelope(): Envelope
{
    $tenantName = tenant()->name ?? config('app.name');
    
    return new Envelope(
        subject: '🔐 Suas credenciais de acesso - ' . $tenantName,
        from: new Address(
            config('mail.from.address'),
            $tenantName  // Nome do tenant aparece como remetente
        ),
    );
}
```

**Resultado:** Email vem de "Clínica ABC <noreply@imunify.com.br>"

---

### **Opção B: SMTP Próprio por Tenant (Avançado)**

1. Criar tabela `tenant_smtp_settings`
2. Adicionar campos SMTP nas configurações do tenant
3. Modificar dinamicamente a configuração antes de enviar

**Complexidade:** Alta  
**Recomendado:** Apenas se tenants pagarem por isso

---

## ✅ Checklist de Configuração

### **Desenvolvimento (Atual):**
- [x] MAIL_MAILER=log configurado
- [x] Emails salvos em storage/logs/laravel.log
- [x] Sistema de envio implementado
- [x] Template HTML criado

### **Produção (Pendente):**
- [ ] Criar email noreply@imunify.com.br no cPanel
- [ ] Obter credenciais SMTP
- [ ] Editar .env no servidor
- [ ] Limpar cache (config:clear)
- [ ] Testar envio com test_smtp_config.php
- [ ] Configurar SPF no DNS
- [ ] Configurar DKIM no DNS
- [ ] Configurar DMARC no DNS
- [ ] Criar usuário real e verificar recebimento
- [ ] Verificar pasta SPAM
- [ ] Documentar credenciais em local seguro

---

## 🆘 Troubleshooting

### **Erro: "Connection refused"**
- Verifique se porta 587 ou 465 está aberta no firewall
- Teste com telnet: `telnet mail.imunify.com.br 587`
- Tente porta alternativa

### **Erro: "Authentication failed"**
- Confirme usuário e senha no cPanel
- Verifique se email está ativo
- Tente resetar senha do email

### **Email vai para SPAM:**
- Configure SPF, DKIM e DMARC
- Use remetente profissional (não @gmail.com)
- Evite palavras spam no assunto
- Mantenha proporção texto/imagem adequada

### **Email não chega:**
- Verifique logs: `tail -f storage/logs/laravel.log`
- Teste com outro email
- Verifique quota do email no cPanel
- Confirme que domínio não está em blacklist

---

## 📞 Suporte

**Documentação Laravel Mail:**  
https://laravel.com/docs/11.x/mail

**Testar Deliverability:**  
https://www.mail-tester.com/

**Verificar Blacklist:**  
https://mxtoolbox.com/blacklists.aspx

---

**Última atualização:** 02/12/2025  
**Versão:** 1.0
