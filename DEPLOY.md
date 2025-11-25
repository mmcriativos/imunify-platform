# 🚀 Guia de Deploy - MultiImune

## 📋 Pré-requisitos no Servidor

- PHP 8.1 ou superior
- Composer
- Node.js 18+ e NPM
- MySQL/MariaDB
- Git
- Acesso SSH

## 🔧 Configuração Inicial (Primeira vez)

### 1. No seu computador local

```powershell
# Inicializar Git (se ainda não tiver)
git init
git add .
git commit -m "Initial commit"

# Criar repositório no GitHub e conectar
git remote add origin https://github.com/SEU-USUARIO/multiimune.git
git branch -M main
git push -u origin main
```

### 2. No servidor (via SSH)

```bash
# Clonar o repositório
cd /home/seu-usuario/
git clone https://github.com/SEU-USUARIO/multiimune.git
cd multiimune

# Instalar dependências
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Configurar ambiente
cp .env.example .env
nano .env  # Configure as variáveis de produção

# Gerar chave
php artisan key:generate

# Executar migrations
php artisan migrate --force

# Criar link de storage
php artisan storage:link

# Ajustar permissões
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 3. Configurar .env de Produção

```env
APP_NAME=MultiImune
APP_ENV=production
APP_KEY=base64:... (gerado pelo artisan key:generate)
APP_DEBUG=false
APP_URL=https://sistema.seudominio.com.br

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multiimune_prod
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha_segura

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## 🔄 Deploy Automático (GitHub Actions)

### Configurar Secrets no GitHub

1. Acesse: `https://github.com/SEU-USUARIO/multiimune/settings/secrets/actions`
2. Adicione os seguintes secrets:

- `SSH_PRIVATE_KEY`: Sua chave SSH privada
- `REMOTE_HOST`: IP ou domínio do servidor (ex: 123.45.67.89)
- `REMOTE_USER`: Usuário SSH (ex: root ou seu-usuario)
- `REMOTE_PATH`: Caminho no servidor (ex: /home/usuario/multiimune)

### Como gerar chave SSH (se não tiver)

```powershell
# No seu computador
ssh-keygen -t rsa -b 4096 -C "deploy@multiimune"

# Copiar chave pública para o servidor
ssh-copy-id -i ~/.ssh/id_rsa.pub usuario@seu-servidor.com
```

### Deploy Automático

Após configurado, cada `git push` na branch `main` irá:
1. ✅ Instalar dependências
2. ✅ Compilar assets
3. ✅ Enviar para servidor
4. ✅ Executar migrations
5. ✅ Limpar e otimizar cache

## 🛠️ Deploy Manual

```bash
# No servidor
cd /home/usuario/multiimune
bash deploy.sh
```

Ou passo a passo:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔒 Checklist de Segurança

- [ ] `APP_DEBUG=false` em produção
- [ ] Senha forte do banco de dados
- [ ] `.env` fora do DocumentRoot
- [ ] Permissões corretas (755 para pastas, 644 para arquivos)
- [ ] HTTPS configurado (SSL/TLS)
- [ ] Firewall ativo
- [ ] Backup automático do banco
- [ ] Git pull apenas da branch main
- [ ] Composer com `--no-dev`

## 📁 Estrutura de Pastas no Servidor

```
/home/usuario/
├── multiimune/              (repositório Git)
│   ├── app/
│   ├── public/              (apontar DocumentRoot aqui)
│   ├── storage/
│   ├── .env                 (produção)
│   └── ...
└── backups/                 (opcional - backups do DB)
```

## 🌐 Configuração Apache/Nginx

### Apache (.htaccess já incluído)

```apache
<VirtualHost *:80>
    ServerName sistema.seudominio.com.br
    DocumentRoot /home/usuario/multiimune/public

    <Directory /home/usuario/multiimune/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx

```nginx
server {
    listen 80;
    server_name sistema.seudominio.com.br;
    root /home/usuario/multiimune/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔄 Workflow de Desenvolvimento

```
Local (desenvolvimento)
    ↓ git push
GitHub (repositório)
    ↓ GitHub Actions (automático)
Servidor (produção)
```

## 📝 Comandos Úteis

```bash
# Ver logs
tail -f storage/logs/laravel.log

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Status do sistema
php artisan about

# Backup banco de dados
mysqldump -u usuario -p multiimune_prod > backup_$(date +%Y%m%d).sql
```

## 🆘 Troubleshooting

### Erro 500

```bash
# Verificar logs
tail -f storage/logs/laravel.log

# Verificar permissões
chmod -R 755 storage bootstrap/cache

# Recriar cache
php artisan config:cache
```

### Assets não carregam

```bash
# Recompilar
npm run build

# Verificar permissões
chmod -R 755 public/build
```

### Banco não conecta

```bash
# Testar conexão
php artisan migrate:status

# Verificar .env
cat .env | grep DB_
```

## 📞 Suporte

- Email: suporte@seudominio.com.br
- Documentação Laravel: https://laravel.com/docs
