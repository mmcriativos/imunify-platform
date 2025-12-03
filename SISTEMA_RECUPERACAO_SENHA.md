# Sistema de Recuperação de Senha

## 📋 Visão Geral

O sistema de recuperação de senha permite que usuários que esqueceram suas credenciais possam redefinir sua senha de forma segura através de um link enviado por email.

## 🔒 Fluxo de Segurança

### 1. Solicitação de Redefinição
- Usuário acessa a tela de login
- Clica em "Esqueceu a senha?"
- Informa seu email cadastrado
- Sistema valida se o email existe e se o usuário está ativo

### 2. Geração de Token
- Token aleatório de 64 caracteres é gerado
- Token é armazenado como hash SHA-256 no banco de dados
- Registro inclui: email, token (hasheado) e timestamp
- Token expira em **60 minutos**

### 3. Envio de Email
- Email profissional com link de redefinição
- Link inclui token original (não hasheado) e email
- Template responsivo com instruções claras
- Avisos de segurança e tempo de expiração

### 4. Redefinição de Senha
- Usuário clica no link do email
- Sistema valida:
  - Se o token existe no banco
  - Se o token corresponde (usando hash_equals)
  - Se o token não expirou (60 minutos)
- Formulário para nova senha com confirmação
- Senha deve ter no mínimo 8 caracteres

### 5. Conclusão
- Senha é atualizada no banco (hash bcrypt)
- Token usado é deletado
- Usuário é redirecionado para login com mensagem de sucesso
- Pode fazer login imediatamente com a nova senha

## 📁 Estrutura de Arquivos

### Migrations
```
database/migrations/tenant/2025_12_03_105310_create_password_reset_tokens_table.php
```
- Tabela: `password_reset_tokens`
- Campos:
  - `email` (primary key)
  - `token` (string, hash SHA-256)
  - `created_at` (timestamp)

### Controllers

**app/Http/Controllers/Auth/ForgotPasswordController.php**
- `showLinkRequestForm()` - Exibe formulário de solicitação
- `sendResetLinkEmail()` - Valida email, gera token, envia email

**app/Http/Controllers/Auth/ResetPasswordController.php**
- `showResetForm($token)` - Exibe formulário de redefinição
- `reset()` - Valida token, atualiza senha, deleta token

### Views

**resources/views/auth/forgot-password.blade.php**
- Formulário para solicitar redefinição
- Campo de email com validação
- Mensagens de sucesso/erro
- Informações de segurança
- Design moderno com gradientes

**resources/views/auth/reset-password.blade.php**
- Formulário para nova senha
- Campo de senha com confirmação
- Botão para mostrar/ocultar senha
- Validação de força de senha
- Dicas de segurança

**resources/views/emails/password-reset.blade.php**
- Email responsivo profissional
- Botão de redefinição destacado
- Link alternativo (copiar/colar)
- Alertas de expiração (60 min)
- Dicas de segurança
- Footer com branding

### Mailable

**app/Mail/PasswordResetMail.php**
- Recebe: User, URL de reset, token
- Subject: "Redefinição de Senha - {app_name}"
- View: emails.password-reset
- Passa dados para o template

## 🛣️ Rotas

```php
// Formulário de solicitação
GET  /password/reset          → password.request

// Envio de email
POST /password/email          → password.email

// Formulário de redefinição
GET  /password/reset/{token}  → password.reset

// Processamento de redefinição
POST /password/reset          → password.update
```

## 🎨 Design

### Paleta de Cores
- Gradiente primário: `#3ebddb` → `#8b5cf6` (azul → roxo)
- Alertas: amarelo (#fef3c7) para avisos
- Info: azul claro (#dbeafe) para dicas
- Sucesso: verde para confirmações
- Erro: vermelho para validações

### Elementos Visuais
- Cards arredondados (rounded-2xl)
- Sombras suaves (shadow-xl)
- Ícones SVG inline
- Animações hover (scale, shadow)
- Responsivo (mobile-first)

## 🔐 Segurança

### Validações Implementadas

1. **Email deve existir no banco**
   - Mensagem: "Não encontramos um usuário com este e-mail"

2. **Usuário deve estar ativo**
   - Mensagem: "Esta conta está inativa. Entre em contato com o administrador"

3. **Token deve ser válido**
   - Comparação usando `hash_equals()` (timing-safe)
   - Mensagem: "Token de redefinição inválido"

4. **Token não pode estar expirado**
   - Validade: 60 minutos
   - Mensagem: "Este link de redefinição expirou. Solicite um novo"

5. **Senha deve ser forte**
   - Mínimo 8 caracteres
   - Validação: `Password::min(8)`
   - Confirmação obrigatória

### Proteções Contra Ataques

- **Timing Attack**: `hash_equals()` para comparação de tokens
- **Replay Attack**: Token é deletado após uso
- **Brute Force**: Token tem expiração de 60 minutos
- **SQL Injection**: Uso de Query Builder e validações
- **XSS**: Blade escapa automaticamente variáveis
- **CSRF**: Token CSRF em todos os formulários

## 📧 Configuração de Email

### Desenvolvimento (Atual)
```env
MAIL_MAILER=log
```
Emails são salvos em: `storage/logs/laravel.log`

### Produção
Configurar SMTP conforme: `CONFIGURACAO_SMTP_PRODUCAO.md`

Recomendado:
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.imunify.com.br
MAIL_PORT=465
MAIL_USERNAME=noreply@imunify.com.br
MAIL_PASSWORD=senha_segura
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@imunify.com.br
MAIL_FROM_NAME="${APP_NAME}"
```

## 🧪 Testando o Sistema

### 1. Solicitar Redefinição
```
1. Acesse: https://clinica-demo.imunify.test/login
2. Clique em "Esqueceu a senha?"
3. Digite: admin@clinica.com
4. Clique em "Enviar Link de Redefinição"
```

### 2. Verificar Email
```
# Ambiente de desenvolvimento (log)
tail -f storage/logs/laravel.log | grep -A 50 "password/reset"

# Copie a URL completa do email
```

### 3. Redefinir Senha
```
1. Acesse a URL do email
2. Digite nova senha (min 8 caracteres)
3. Confirme a nova senha
4. Clique em "Redefinir Senha"
```

### 4. Testar Login
```
1. Será redirecionado para /login
2. Use o email e a NOVA senha
3. Deve entrar normalmente
```

## 📊 Banco de Dados

### Estrutura da Tabela

```sql
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `password_reset_tokens_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Exemplo de Registro

```sql
-- Ao solicitar redefinição
INSERT INTO password_reset_tokens VALUES (
    'admin@clinica.com',
    'a7b9c1d2...', -- Hash SHA-256 do token
    '2025-12-03 14:30:00'
);

-- Após usar o token
DELETE FROM password_reset_tokens WHERE email = 'admin@clinica.com';
```

### Limpeza Automática (Opcional)

Adicionar ao `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    // Limpar tokens expirados (maiores que 60 minutos)
    $schedule->call(function () {
        DB::table('password_reset_tokens')
            ->where('created_at', '<', now()->subHour())
            ->delete();
    })->hourly();
}
```

## ⚡ Melhorias Futuras

### 1. Rate Limiting
Limitar tentativas de redefinição por IP/email:
```php
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/password/email', ...);
});
```

### 2. Notificação de Segurança
Enviar email informando sobre a alteração de senha:
```php
// Após redefinir senha
Mail::to($user)->send(new PasswordChangedNotification($user));
```

### 3. Histórico de Senhas
Evitar reutilização de senhas antigas:
```php
// Salvar hash das últimas 5 senhas
// Validar na redefinição
```

### 4. Autenticação em 2 Fatores
Requerer código adicional para redefinição sensível.

### 5. Dashboard de Segurança
Mostrar ao usuário:
- Último login
- Últimas alterações de senha
- Dispositivos ativos

## 🎯 Checklist de Implementação

- [x] Migration criada e executada
- [x] Controllers implementados
- [x] Views criadas (forgot-password, reset-password)
- [x] Email template criado
- [x] Mailable configurado
- [x] Rotas definidas
- [x] Link no login adicionado
- [x] Validações de segurança
- [x] Documentação completa
- [ ] Testes automatizados
- [ ] Rate limiting configurado
- [ ] Limpeza automática de tokens

## 📝 Notas Importantes

1. **Multi-tenancy**: Cada tenant tem sua própria tabela de tokens
2. **Segurança**: Nunca envie o token hasheado, sempre o original
3. **UX**: Mensagens genéricas para evitar enumeration attack
4. **Email**: Testar em produção com SMTP real
5. **Expiração**: 60 minutos é o padrão do Laravel e é adequado

## 🆘 Troubleshooting

### Email não está sendo enviado
- Verificar `MAIL_MAILER` no .env
- Em desenvolvimento: verificar logs
- Em produção: verificar credenciais SMTP

### Token inválido
- Verificar se passou 60 minutos
- Verificar se já foi usado
- Solicitar novo token

### Erro ao redefinir senha
- Verificar validação (min 8 caracteres)
- Verificar se confirmação está correta
- Verificar conexão com banco de dados

### Link não funciona
- Verificar domínio do tenant na URL
- Verificar se token está completo
- Verificar se não há quebra de linha no email

## 📚 Referências

- [Laravel Password Reset Documentation](https://laravel.com/docs/11.x/passwords)
- [OWASP Password Storage Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html)
- [Multi-tenant Password Reset Best Practices](https://tenancyforlaravel.com/)
