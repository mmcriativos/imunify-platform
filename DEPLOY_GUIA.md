# 🚀 Scripts de Deploy - ImuniFy Platform

## Scripts Disponíveis

### 1. `deploy_production.sh` - Deploy Automático Completo

Script principal para deploy em produção com backup e rollback automático.

#### Características:

- ✅ **Backup automático** do banco de dados antes de qualquer alteração
- ✅ **Modo de manutenção** durante o deploy
- ✅ **Rollback automático** em caso de erro
- ✅ **Otimização** de caches e configurações
- ✅ **Verificação de tenants** após deploy
- ✅ **Logs coloridos** para fácil visualização

#### Como usar:

```bash
# 1. Fazer upload do script via FTP/cPanel File Manager ou criar via SSH
# 2. Dar permissão de execução
chmod +x deploy_production.sh

# 3. Executar o deploy
./deploy_production.sh
```

#### O que o script faz:

1. **Ativa modo de manutenção** - Visitantes veem mensagem amigável
2. **Cria backup do banco de dados** - Segurança antes de qualquer mudança
3. **Verifica atualizações no Git** - Pergunta se quer continuar se já estiver atualizado
4. **Faz git pull** - Baixa código mais recente
5. **Instala dependências** - Composer install otimizado
6. **Executa migrations** - Atualiza estrutura do banco
7. **Limpa caches** - Remove caches antigos
8. **Recompila otimizações** - Cache de config, rotas e views
9. **Verifica tenants** - Dry-run do comando de status
10. **Ajusta permissões** - Garante que storage tem permissões corretas
11. **Desativa manutenção** - Site volta ao ar
12. **Exibe resumo** - Mostra informações do deploy

#### Rollback Automático:

Se qualquer passo falhar, o script:
- Reverte código para versão anterior (git reset)
- Restaura backup do banco de dados
- Reativa o site
- Exibe mensagem de erro

### 2. Deploy Manual (Passo a Passo)

Se preferir fazer manualmente via SSH:

```bash
# Acessar diretório
cd /home/imunifyc/public_html

# Modo manutenção
php artisan down --retry=60

# Backup (IMPORTANTE!)
mysqldump -u imunifycom_user -p imunifycom_central > ~/backup_$(date +%Y%m%d_%H%M%S).sql

# Atualizar código
git pull origin main

# Dependências
composer install --no-dev --optimize-autoloader

# Migrations
php artisan migrate --force --database=central

# Limpar caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verificar tenants
php artisan tenants:check-status --dry-run

# Reativar site
php artisan up
```

### 3. Deploy via cPanel (Sem SSH)

Se não tem acesso SSH, use o **Terminal** do cPanel:

1. Acesse **cPanel → Terminal**
2. Execute cada comando manualmente (ver "Deploy Manual" acima)
3. Ou faça upload do script `deploy_production.sh` via **File Manager**
4. No Terminal: `chmod +x deploy_production.sh && ./deploy_production.sh`

## 📋 Checklist Pré-Deploy

Antes de executar o deploy, verifique:

- [ ] Código commitado e pushed para o repositório
- [ ] Migrations testadas localmente
- [ ] Backup manual do banco (segurança extra)
- [ ] Horário de baixo tráfego (madrugada recomendado)
- [ ] Notificação para usuários (se aplicável)

## 🔧 Configuração do Cron Job

Após o primeiro deploy, configurar o cron job para verificação automática de tenants:

### Via cPanel → Cron Jobs:

```bash
# Comando
0 2 * * * cd /home/imunifyc/public_html && php artisan tenants:check-status >> /dev/null 2>&1

# Com logs (recomendado)
0 2 * * * cd /home/imunifyc/public_html && php artisan tenants:check-status >> /home/imunifyc/logs/tenant-status.log 2>&1
```

**Configurações:**
- **Minuto:** 0
- **Hora:** 2 (2h da manhã)
- **Dia do mês:** * (todos)
- **Mês:** * (todos)
- **Dia da semana:** * (todos)

### Via SSH (crontab):

```bash
# Editar crontab
crontab -e

# Adicionar linha
0 2 * * * cd /home/imunifyc/public_html && php artisan tenants:check-status >> /home/imunifyc/logs/tenant-status.log 2>&1

# Salvar e sair (Ctrl+X, Y, Enter)
```

## 🐛 Troubleshooting

### Erro: "Permission denied" ao executar script

```bash
chmod +x deploy_production.sh
```

### Erro: "Database connection failed"

Verificar credenciais em `.env`:
```bash
cat .env | grep DB_
```

### Erro: "Class not found" após deploy

```bash
composer dump-autoload
php artisan clear-compiled
php artisan optimize
```

### Site não sai do modo manutenção

```bash
php artisan up
# ou remover manualmente
rm storage/framework/down
```

### Migrations já executadas

```bash
# Ver status
php artisan migrate:status

# Rollback última migration
php artisan migrate:rollback --step=1

# Re-executar
php artisan migrate --force
```

## 📊 Monitoramento Pós-Deploy

Após deploy, monitore:

### 1. Logs do Laravel
```bash
tail -f storage/logs/laravel.log
```

### 2. Logs do Servidor
```bash
# cPanel → Metrics → Errors
# Ou via SSH:
tail -f /home/imunifyc/logs/error_log
```

### 3. Status dos Tenants
```bash
php artisan tenants:check-status --dry-run
```

### 4. Testes Funcionais
- [ ] Login em tenant funciona
- [ ] Dashboard carrega corretamente
- [ ] Banners de trial aparecem
- [ ] Criação de novo tenant funciona
- [ ] Middleware não está bloqueando rotas normais

## 🔄 Rollback Manual

Se algo der errado e o rollback automático não funcionar:

### 1. Reverter código
```bash
cd /home/imunifyc/public_html
git log --oneline  # Ver commits
git reset --hard COMMIT_HASH  # Voltar para commit específico
```

### 2. Restaurar banco
```bash
mysql -u imunifycom_user -p imunifycom_central < ~/backup_YYYYMMDD_HHMMSS.sql
```

### 3. Limpar caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan up
```

## 📞 Suporte

Em caso de problemas:

1. Verificar logs (laravel.log e error_log)
2. Consultar documentação: `SISTEMA_TRIAL_ASSINATURAS.md`
3. Rollback para versão estável anterior
4. Contatar desenvolvedor com logs do erro

---

**Última atualização:** 30/11/2025  
**Versão do script:** 1.0
