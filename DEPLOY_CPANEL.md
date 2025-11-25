# Deploy Imunify - cPanel TurboCloud

## ⚡ Deploy Rápido (Após Primeira Configuração)

```bash
cd ~/repositories/imunify-platform
bash deploy_and_clear.sh
```

Depois acesse: https://imunify.com.br/clear_opcache.php

---

## 📋 Pré-requisitos

- cPanel com acesso SSH
- Git instalado no servidor
- Composer instalado
- Node.js e NPM instalados
- MySQL 8.0+
- PHP 8.2+

## 🚀 Passo 1: Preparar o cPanel

### 1.1 Acessar cPanel
- URL: Fornecido pela TurboCloud
- Login com credenciais fornecidas

### 1.2 Criar Banco de Dados Principal (Central)
- MySQL Database Wizard
- Nome: `imunifycom_central` (cPanel adiciona prefixo automaticamente)
- Usuário: `imunifycom_user`
- Senha: `,o)7#hRReY6)`
- **Credenciais finais:**
  - Database: `imunifycom_central`
  - Username: `imunifycom_user`
  - Password: `,o)7#hRReY6)`

### 1.3 Configurar DNS Wildcard ✅ **JÁ CONFIGURADO**

**Status:** Wildcard já ativo em `*.imunify.com.br` → `177.154.191.146`

**No cPanel, acesse uma dessas opções:**

#### Opção 1: Zone Editor (Recomendado)
1. Procure por "Zone Editor" no cPanel
2. Clique em "Manage" ao lado do seu domínio
3. Clique em "+ Add Record"
4. Configure:
   ```
   Type: A
   Name: *
   Address: 177.154.191.146
   TTL: 14400
   ```
5. Clique em "Add Record"

#### Opção 2: Advanced Zone Editor
1. Procure por "Advanced Zone Editor"
2. Selecione seu domínio
3. Adicione registro A:
   ```
   Name: *.imunify.com.br.
   TTL: 14400
   Type: A
   Address: 177.154.191.146
   ```

#### Opção 3: Simple Zone Editor
1. Procure por "Simple Zone Editor"
2. Selecione tipo "A"
3. Name: `*`
4. Address: IP do servidor

**Verificar propagação (pode demorar até 48h):**
```bash
# Testar se wildcard está funcionando
ping teste123.imunify.com.br
ping cliente1.imunify.com.br
ping multiimune.imunify.com.br
```

Todos devem apontar para `177.154.191.146`.

Isso permite subdomínios dinâmicos: `multiimune.imunify.com.br`, `cliente2.imunify.com.br`, etc.

## 📦 Passo 2: Deploy via SSH Terminal

### 2.1 Gerar Chave SSH no Servidor

**Abra o Terminal SSH no cPanel** (procure "Terminal" no cPanel)

```bash
# Gerar chave SSH (pressione Enter em todas as perguntas)
ssh-keygen -t ed25519 -C "imunify@imunify.com.br"

# Exibir a chave pública
cat ~/.ssh/id_ed25519.pub
```

**Copie toda a saída** (começa com `ssh-ed25519`)

### 2.2 Adicionar Deploy Key no GitHub

1. Acesse: https://github.com/mmcriativos/imunify-platform/settings/keys
2. Clique em **"Add deploy key"**
3. Configure:
   - **Title**: `cPanel Imunify Production`
   - **Key**: Cole a chave SSH copiada
   - ✅ **Marque "Allow write access"**
4. Clique em "Add key"

### 2.3 Clonar Repositório via Terminal

**No Terminal SSH do cPanel:**

```bash
# Criar diretório repositories
mkdir -p ~/repositories
cd ~/repositories

# Adicionar GitHub aos known hosts
ssh-keyscan github.com >> ~/.ssh/known_hosts

# Clonar repositório
git clone git@github.com:mmcriativos/imunify-platform.git imunify

# Entrar no diretório
cd imunify

# Verificar branch
git branch
```

✅ Se aparecer `* main`, o clone funcionou!

## 🔧 Passo 3: Configurar Aplicação

### 3.1 Acessar via SSH
```bash
ssh imunifycom@imunify.com.br
# ou SSH via cPanel Terminal
cd repositories/imunify
```

### 3.2 Instalar Dependências
```bash
# Composer
composer install --optimize-autoloader --no-dev

# NPM
npm install
npm run build
```

### 3.3 Configurar .env
```bash
cp .env.example .env
nano .env
```

**Configurações essenciais:**
```env
APP_NAME="Imunify"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://imunify.com.br

# Gerar nova chave
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=imunifycom_central
DB_USERNAME=imunifycom_user
DB_PASSWORD=,o)7#hRReY6)

# Session - IMPORTANTE para subdomínios
SESSION_DRIVER=database
SESSION_DOMAIN=null

# Cache
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Mail (configurar conforme SMTP da hospedagem)
MAIL_MAILER=smtp
MAIL_HOST=mail.imunify.com.br
MAIL_PORT=587
MAIL_USERNAME=noreply@imunify.com.br
MAIL_PASSWORD=senha_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@imunify.com.br
MAIL_FROM_NAME="${APP_NAME}"

# Tenancy
CENTRAL_DOMAINS=imunify.com.br
```

### 3.4 Gerar Application Key
```bash
php artisan key:generate
```

### 3.5 Executar Migrations (Banco Central)
```bash
php artisan migrate --database=central --force
```

### 3.6 Executar Seeders
```bash
php artisan db:seed --class=PlansSeeder
```

## 📁 Passo 4: Configurar DocumentRoot

### 4.1 Via cPanel File Manager ou SSH
Mover conteúdo de `public/` para `public_html/`:

```bash
# Backup do public_html antigo
mv ~/public_html ~/public_html.bak

# Criar symlink do public para public_html
ln -s ~/repositories/imunify/public ~/public_html
```

### 4.2 Configurar Permissões
```bash
cd ~/repositories/imunify
chmod -R 755 storage bootstrap/cache
chown -R imunifycom:imunifycom storage bootstrap/cache
```

### 4.3 Configurar .htaccess (já incluído no Laravel)
Verificar se `public/.htaccess` existe e está correto.

## 🌐 Passo 5: Configurar Subdomínios Automáticos

### 5.1 Criar .htaccess na Raiz do cPanel
Em `/home/imunifycom/.htaccess`:

```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^(.+)\.imunify\.com\.br$ [NC]
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{REQUEST_URI} !^/public_html/
RewriteRule ^(.*)$ public_html/$1 [L]
```

### 5.2 Verificar Configuração Apache (MultiViews)
Pedir ao suporte TurboCloud para habilitar se necessário.

## 🔒 Passo 6: Configurar SSL

### 6.1 Via AutoSSL (Recomendado)
- cPanel → SSL/TLS Status
- Marcar domínio principal
- Clicar em "Run AutoSSL"

### 6.2 Wildcard SSL (Let's Encrypt)
Requer acesso via SSH e certbot:

```bash
sudo certbot certonly --manual --preferred-challenges=dns \
  -d imunify.com.br -d *.imunify.com.br
```

Seguir instruções para adicionar TXT record no DNS.

### 6.3 Forçar HTTPS
Em `.env`:
```env
APP_URL=https://imunify.com.br
```

No Laravel já há middleware de redirect para HTTPS em produção.

## ⚙️ Passo 7: Configurar Cronjobs

### 7.1 Acessar Cron Jobs no cPanel

### 7.2 Adicionar Task do Laravel Scheduler
```
* * * * * cd /home/imunifycom/repositories/imunify && php artisan schedule:run >> /dev/null 2>&1
```

Isso executa:
- Envio de lembretes automáticos
- Limpeza de sessões
- Outras tasks agendadas

## 🚦 Passo 8: Configurar Queue Worker

### 8.1 Via Supervisor (se disponível no servidor)
Criar `/etc/supervisor/conf.d/imunify-worker.conf`:

```ini
[program:imunify-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/imunifycom/repositories/imunify/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=imunifycom
numprocs=2
redirect_stderr=true
stdout_logfile=/home/imunifycom/repositories/imunify/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start imunify-worker:*
```

### 8.2 Alternativa: Cron (menos eficiente)
Se Supervisor não disponível:
```
* * * * * cd /home/imunifycom/repositories/imunify && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

## 🏥 Passo 9: Criar Primeiro Tenant (MultiImune)

### 9.1 Via Tinker
```bash
php artisan tinker
```

```php
$tenant = \App\Models\Tenant::create([
    'name' => 'MultiImune',
    'plan_id' => 1, // ID do plano criado no seeder
    'config' => [
        'nome_clinica' => 'MultiImune Clínica de Vacinação',
        'logo_url' => null,
        'primary_color' => '#1e40af',
    ],
]);

$tenant->domains()->create([
    'domain' => 'multiimune.imunify.com.br'
]);

exit
```

### 9.2 Executar Migrations no Tenant
```bash
php artisan tenants:migrate --tenants=multiimune
```

### 9.3 Criar Usuário Admin do Tenant
```bash
php artisan tinker
```

```php
tenancy()->initialize('multiimune');

\App\Models\User::create([
    'name' => 'Admin MultiImune',
    'email' => 'admin@multiimune.com.br',
    'password' => bcrypt('senha_temporaria_aqui'),
]);

exit
```

### 9.4 Seed de Vacinas (Esquemas de Doses)
```bash
php artisan tenants:seed --tenants=multiimune --class=VacinaEsquemaDoseSeeder
```

## ✅ Passo 10: Verificação

### 10.1 Testar Domínio Principal
```
https://imunify.com.br
```
Deve mostrar landing page do Imunify.

### 10.2 Testar Subdomínio Tenant
```
https://multiimune.imunify.com.br
```
Deve mostrar login do tenant MultiImune.

### 10.3 Verificar Logs
```bash
tail -f storage/logs/laravel.log
```

### 10.4 Checklist Funcional
- [ ] Landing page carrega
- [ ] Tenant login funciona
- [ ] Dashboard do tenant carrega
- [ ] Criar paciente funciona
- [ ] Criar vacina funciona
- [ ] SSL ativo (cadeado verde)
- [ ] Cronjob executando (verificar logs)
- [ ] Queue worker ativo

## 🔄 Passo 11: Atualizações Futuras

### 11.1 Via cPanel Git Version Control
1. Fazer push no GitHub
2. Acessar cPanel → Git Version Control
3. Clicar em "Manage" no repositório
4. "Pull or Deploy" → "Update from Remote"

### 11.2 Pós-Deploy
```bash
cd ~/repositories/imunify

# Dependências (se houver mudanças)
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Migrations
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue restart (se usando Supervisor)
php artisan queue:restart
```

## 📊 Passo 12: Monitoramento

### 12.1 Logs do Servidor
```bash
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log
```

### 12.2 Uso de Disco
```bash
du -sh ~/repositories/imunify
```

### 12.3 Performance
- Usar Laravel Telescope (apenas em staging, não em produção)
- Monitorar query times no log
- Verificar uso de memória: `free -m`

## 🆘 Troubleshooting

### Erro 500
```bash
# Verificar logs
tail -n 50 storage/logs/laravel.log

# Verificar permissões
chmod -R 755 storage bootstrap/cache

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Subdomínio não funciona
- Verificar DNS wildcard propagou (pode demorar até 48h)
- Testar: `ping teste.imunify.com.br` (deve responder 177.154.191.146)
- Verificar .htaccess

### Sessão expira rapidamente
```env
SESSION_LIFETIME=120
SESSION_DOMAIN=null  # NUNCA use .dominio.com.br se acessar via HTTP
```

### WhatsApp não envia
- Verificar credenciais Z-API no banco
- Verificar saldo da conta Z-API
- Checar logs: `storage/logs/laravel.log`

## 📞 Suporte TurboCloud

Em caso de problemas técnicos do servidor:
- Abrir ticket no painel da TurboCloud
- Contato: suporte@turbocloud.com.br (verificar site oficial)

## 🔐 Segurança Pós-Deploy

### Essencial:
1. [ ] Mudar senhas padrão de usuários admin
2. [ ] Configurar backup automático no cPanel
3. [ ] Ativar firewall (CSF se disponível)
4. [ ] Revisar permissões de arquivos (nenhum 777)
5. [ ] Manter Laravel e dependências atualizadas

---

**Última atualização:** $(date +%Y-%m-%d)
**Versão:** 1.0
