# 🚀 DEPLOY: Sistema de Pool de Databases

## ⚠️ SSH está bloqueado no cPanel

Como o SSH não está disponível, use uma destas opções:

---

## OPÇÃO 1: Terminal do cPanel (Recomendado)

### 1. Acesse o Terminal
- URL: https://imunify.com.br:2083
- Login: imunifycom
- Password: ,o)7#hRReY6)
- Vá em: **Terminal** (ícone na barra superior)

### 2. Execute os comandos:

```bash
cd ~/repositories/imunify-platform

# Pull das alterações
git pull origin main

# Rodar migration
php artisan migrate --force

# Limpar cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Verificar se migration rodou
php artisan migrate:status | grep database_pool
```

---

## OPÇÃO 2: File Manager do cPanel

### 1. Fazer upload dos arquivos
- Acesse: **File Manager** no cPanel
- Navegue até: `/home/imunifycom/repositories/imunify-platform/`
- Faça upload dos arquivos:
  - `app/Models/DatabasePool.php`
  - `app/Console/Commands/AddDatabaseToPool.php`
  - `app/Console/Commands/CheckDatabasePool.php`
  - `app/Console/Commands/PoolStatus.php`
  - `app/Notifications/DatabasePoolLowNotification.php`
  - `app/Http/Controllers/Auth/RegisterTenantController.php`
  - `database/migrations/2025_11_25_000001_create_database_pool_table.php`
  - `POOL_DATABASES.md`

### 2. Rodar migration via Terminal
```bash
cd ~/repositories/imunify-platform
php artisan migrate --force
```

---

## 📋 Após Deploy

### 1. Criar Databases no cPanel

**MySQL Databases → Create New Database:**

Criar os seguintes databases:
- `imunifycom_tenant_multiimune`
- `imunifycom_tenant_tenant01`
- `imunifycom_tenant_tenant02`
- `imunifycom_tenant_tenant03`
- `imunifycom_tenant_tenant04`
- `imunifycom_tenant_tenant05`
- `imunifycom_tenant_tenant06`
- `imunifycom_tenant_tenant07`
- `imunifycom_tenant_tenant08`
- `imunifycom_tenant_tenant09`

**MySQL Databases → Add User to Database:**

Para CADA database criado:
- User: `imunifycom_user`
- Privileges: **ALL PRIVILEGES** ✓

---

### 2. Adicionar ao Pool (via Terminal)

```bash
cd ~/repositories/imunify-platform

# Adicionar cada database ao pool
php artisan pool:add-database imunifycom_tenant_multiimune
php artisan pool:add-database imunifycom_tenant_tenant01
php artisan pool:add-database imunifycom_tenant_tenant02
php artisan pool:add-database imunifycom_tenant_tenant03
php artisan pool:add-database imunifycom_tenant_tenant04
php artisan pool:add-database imunifycom_tenant_tenant05
php artisan pool:add-database imunifycom_tenant_tenant06
php artisan pool:add-database imunifycom_tenant_tenant07
php artisan pool:add-database imunifycom_tenant_tenant08
php artisan pool:add-database imunifycom_tenant_tenant09

# Verificar status
php artisan pool:status
```

**Resposta esperada:**
```
✓ Database 'imunifycom_tenant_multiimune' adicionado ao pool com sucesso!
Databases disponíveis no pool: 1

✓ Database 'imunifycom_tenant_tenant01' adicionado ao pool com sucesso!
Databases disponíveis no pool: 2

... (até 10)
```

---

### 3. Configurar Email Admin

Edite `.env` (via File Manager ou Terminal):

```bash
nano ~/repositories/imunify-platform/.env
```

Adicione/edite:
```env
ADMIN_EMAIL=seu-email@dominio.com
```

Salve e limpe cache:
```bash
php artisan config:clear
```

---

### 4. Configurar Cronjob (Monitoramento Automático)

**cPanel → Cron Jobs:**

**Comando:**
```
cd /home/imunifycom/repositories/imunify-platform && /usr/local/bin/php artisan pool:check
```

**Frequência:** A cada hora
```
0 * * * *
```

Isso enviará email automaticamente quando o pool ficar com menos de 3 databases disponíveis.

---

### 5. Testar Sistema

**Via Terminal:**
```bash
cd ~/repositories/imunify-platform

# Ver status do pool
php artisan pool:status

# Testar notificação (se pool estiver baixo)
php artisan pool:check
```

**Via Browser:**
1. Acesse: https://imunify.com.br/register
2. Preencha formulário de registro para MultiImune
3. Use subdomain: `multiimune`
4. Complete o cadastro

Se tudo estiver correto:
- ✅ Sistema alocará `imunifycom_tenant_multiimune` automaticamente
- ✅ Criará tenant e rodará migrations
- ✅ Redirecionará para `http://multiimune.imunify.com.br/dashboard`

---

## 🔍 Comandos de Verificação

```bash
# Ver todos os databases no pool
php artisan pool:status

# Ver quantos disponíveis
php artisan pool:check

# Ver logs
tail -50 ~/repositories/imunify-platform/storage/logs/laravel.log

# Ver migrations executadas
php artisan migrate:status
```

---

## ⚠️ Troubleshooting

### Erro: "Class DatabasePool not found"
```bash
composer dump-autoload
```

### Erro: "Table database_pool doesn't exist"
```bash
php artisan migrate --force
```

### Erro ao adicionar database ao pool
Verifique se:
1. Database foi criado no cPanel
2. Nome segue padrão: `imunifycom_tenant_*`
3. Usuário `imunifycom_user` tem ALL PRIVILEGES

### Pool não está alocando
```bash
# Ver status detalhado
php artisan pool:status

# Ver logs
php artisan tinker
>>> \App\Models\DatabasePool::all()
```

---

## 📊 Status Atual

- ✅ Código commitado e pushed para GitHub
- ⏳ Aguardando deploy no servidor
- ⏳ Aguardando criação de databases no cPanel
- ⏳ Aguardando população do pool
- ⏳ Aguardando configuração de cronjob
- ⏳ Aguardando teste de registro

---

**Última atualização:** 25/11/2025
