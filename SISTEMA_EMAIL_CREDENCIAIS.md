# 📧 Sistema de Envio de Credenciais por Email

## ✅ O que foi implementado

### 1. **Mailable - UserCredentialsMail**
Localização: `app/Mail/UserCredentialsMail.php`

Classe responsável por enviar as credenciais de acesso para novos usuários. Recebe:
- `$user` - Objeto do usuário criado
- `$password` - Senha em texto plano (temporariamente)
- `$tenantDomain` - Domínio do tenant para login

### 2. **Template de Email HTML**
Localização: `resources/views/emails/user-credentials.blade.php`

Email profissional e responsivo com:
- ✨ Design moderno com gradientes azul/roxo
- 📱 Totalmente responsivo (mobile-friendly)
- 🎨 Informações destacadas em cards
- 🔐 Alertas de segurança
- 🚀 Botão call-to-action para login
- 📋 Descrição das permissões por role

### 3. **Integração no Controller**
Localização: `app/Http/Controllers/UserManagementController.php` (método `store`)

O email é enviado automaticamente após criar o usuário:
```php
Mail::to($user->email)->send(new UserCredentialsMail($user, $plainPassword, $tenantDomain));
```

## 🔍 Como Verificar se o Email Está Sendo Enviado

### **Ambiente de Desenvolvimento (Atual)**

O sistema está configurado para usar `MAIL_MAILER=log`, que salva os emails em arquivos de log ao invés de enviá-los de verdade.

#### Onde encontrar os emails:

1. **Arquivo principal de logs:**
   ```
   storage/logs/laravel.log
   ```

2. **Como visualizar:**
   ```powershell
   # Ver últimas linhas do log
   Get-Content storage\logs\laravel.log -Tail 200

   # Buscar por "UserCredentials" ou "mail"
   Get-Content storage\logs\laravel.log | Select-String "UserCredentials|message-id"
   ```

3. **O que procurar:**
   - Subject: `🔐 Suas credenciais de acesso`
   - To: Email do usuário criado
   - Body: HTML completo do template

### **Teste Rápido**

1. Acesse um tenant (ex: http://teste.imunify.local)
2. Login como admin
3. Vá em **Configurações → Usuários**
4. Clique em **Adicionar Membro**
5. Preencha o formulário:
   - Nome: Teste Email
   - Email: teste@exemplo.com
   - Role: Operador
   - Senha: senha123456
6. Clique em **Criar Usuário e Enviar Credenciais**
7. Abra o arquivo `storage/logs/laravel.log`
8. Procure pelo email no final do arquivo

## 📤 Configuração para Produção

### **Opção 1: Gmail SMTP (Desenvolvimento/Testes)**

Edite `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Importante:** Use "Senhas de App" do Google, não a senha normal.

### **Opção 2: Mailgun (Recomendado para Produção)**

1. Crie conta em https://mailgun.com
2. Configure domínio
3. Edite `.env`:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=seu-dominio.com
MAILGUN_SECRET=sua-chave-api
MAIL_FROM_ADDRESS=noreply@seu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### **Opção 3: SendGrid**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.sua-chave-api
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### **Opção 4: SMTP do cPanel (Produção)**

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.imunify.com.br
MAIL_PORT=587
MAIL_USERNAME=noreply@imunify.com.br
MAIL_PASSWORD=senha-do-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@imunify.com.br
MAIL_FROM_NAME="Imunify"
```

## 🎨 Conteúdo do Email

O email enviado contém:

### **Header**
- Título: "🎉 Bem-vindo ao Imunify!"
- Gradiente azul/roxo

### **Corpo Principal**
- Saudação personalizada com nome do usuário
- Card com credenciais (email + senha)
- Botão "🚀 Acessar Minha Conta" (link direto para tenant)

### **Alertas de Segurança**
- Altere sua senha no primeiro acesso
- Não compartilhe credenciais
- Use senha forte

### **Descrição de Permissões**
Varia conforme o role:
- **Administrador:** Acesso total ao sistema
- **Gerente:** Gerencia pacientes, agendamentos, estoque e relatórios
- **Operador:** Gerencia pacientes e agendamentos do dia a dia
- **Visualizador:** Acesso de visualização aos dados

### **Footer**
- Informações de contato
- Copyright
- Nota "não responder"

## 🐛 Troubleshooting

### **Erro: "Falha ao enviar email"**

Se aparecer mensagem de warning após criar usuário:
1. Verifique `storage/logs/laravel.log` para detalhes do erro
2. Confirme configurações SMTP no `.env`
3. Teste conexão SMTP:
   ```bash
   php artisan tinker
   Mail::raw('Teste', function($msg) { $msg->to('seu@email.com')->subject('Teste'); });
   ```

### **Email não aparece no log**

1. Confirme que `MAIL_MAILER=log` no `.env`
2. Limpe o cache: `php artisan config:clear`
3. Verifique permissões da pasta `storage/logs/`

### **Email vai para spam**

Em produção:
1. Configure SPF record no DNS
2. Configure DKIM
3. Use domínio verificado
4. Evite palavras como "senha", "grátis", etc no subject

## 📋 Checklist de Configuração

- [x] Mailable criado (`UserCredentialsMail.php`)
- [x] Template HTML responsivo (`user-credentials.blade.php`)
- [x] Integração no controller (`UserManagementController@store`)
- [x] Tratamento de erro com try/catch
- [x] Log de falhas de envio
- [x] Feedback visual ao usuário
- [ ] Configurar SMTP de produção no servidor
- [ ] Testar envio real de email
- [ ] Configurar DNS (SPF/DKIM)
- [ ] Criar template "boas-vindas" adicional (opcional)

## 🚀 Próximos Passos

1. **Testar localmente** com Gmail SMTP
2. **Configurar produção** com Mailgun ou SMTP do cPanel
3. **Adicionar fila** para envios assíncronos:
   ```php
   Mail::to($user->email)->queue(new UserCredentialsMail(...));
   ```
4. **Criar emails adicionais:**
   - Redefinição de senha
   - Alteração de role/permissões
   - Conta desativada/reativada

## 📧 Teste Manual Completo

```bash
# 1. Entre no tinker
php artisan tinker

# 2. Crie um usuário de teste
$user = \App\Models\User::factory()->make([
    'name' => 'Teste Email',
    'email' => 'seu-email-real@gmail.com',
    'role' => 'operator'
]);

# 3. Envie o email
\Mail::to($user->email)->send(
    new \App\Mail\UserCredentialsMail(
        $user, 
        'senha123456', 
        'teste.imunify.local'
    )
);

# 4. Verifique o resultado
# - Se MAIL_MAILER=log: Veja storage/logs/laravel.log
# - Se SMTP configurado: Verifique sua caixa de entrada
```

---

**Desenvolvido por:** Sistema Imunify  
**Data:** 02/12/2025  
**Versão:** 1.0
