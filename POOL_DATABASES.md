# Sistema de Pool de Databases - Imunify Platform

## 📋 Visão Geral

Devido às limitações do cPanel em criar databases programaticamente, implementamos um **sistema de pool de databases** onde:

1. ✅ Você cria 10-20 databases manualmente no cPanel (uma única vez)
2. ✅ Sistema automaticamente aloca o próximo database disponível quando um tenant se registra
3. ✅ Quando o pool ficar baixo (menos de 3 disponíveis), você recebe notificação por email
4. ✅ Você cria mais databases e adiciona ao pool

## 🏗️ Arquitetura

### Tabela `database_pool`
```sql
- id
- database_name (ex: imunifycom_tenant_multiimune)
- in_use (boolean)
- tenant_id (null se disponível)
- allocated_at (timestamp quando foi alocado)
```

### Fluxo de Registro
1. Tenant preenche formulário de registro
2. Sistema verifica se há databases disponíveis no pool
3. Se não houver, mostra mensagem: "Capacidade máxima no momento"
4. Se houver, aloca o próximo database disponível
5. Marca database como `in_use = true` e associa ao `tenant_id`
6. Se restar menos de 3 databases, envia email para admin

## 🚀 Como Usar

### 1️⃣ Criar Databases no cPanel

**Via interface do cPanel:**

1. Acesse: https://imunify.com.br:2083
2. Vá em **MySQL Databases**
3. Crie um novo database com nome no formato:
   ```
   imunifycom_tenant_[nomedotenante]
   ```
   Exemplos:
   - `imunifycom_tenant_multiimune`
   - `imunifycom_tenant_clinicasp`
   - `imunifycom_tenant_saudemaster`
   - `imunifycom_tenant_tenant01`
   - `imunifycom_tenant_tenant02`
   - etc...

4. Conceda **ALL PRIVILEGES** ao usuário: `imunifycom_user`

**IMPORTANTE:** Use nomes significativos para os primeiros tenants (multiimune, clinicasp, etc) e depois pode usar nomes genéricos (tenant01, tenant02...) para o pool.

### 2️⃣ Adicionar Database ao Pool

**Via SSH:**

```bash
cd ~/repositories/imunify-platform

php artisan pool:add-database imunifycom_tenant_multiimune
```

**Resposta esperada:**
```
✓ Database 'imunifycom_tenant_multiimune' adicionado ao pool com sucesso!
Databases disponíveis no pool: 10
```

Se estiver ficando baixo:
```
⚠ ATENÇÃO: Pool está ficando baixo! Considere criar mais databases.
```

### 3️⃣ Verificar Status do Pool

```bash
php artisan pool:status
```

**Saída:**
```
═══════════════════════════════════════
       STATUS DO POOL DE DATABASES     
═══════════════════════════════════════

Total de databases: 10
Disponíveis: 7
Em uso: 3

✓ Pool está saudável.

═══════════════════════════════════════

┌────┬────────────────────────────────────┬────────────────┬──────────────┬──────────────────┐
│ ID │ Database                           │ Status         │ Tenant       │ Alocado em       │
├────┼────────────────────────────────────┼────────────────┼──────────────┼──────────────────┤
│ 1  │ imunifycom_tenant_multiimune       │ 🔴 Em uso      │ multiimune   │ 25/11/2025 14:30 │
│ 2  │ imunifycom_tenant_clinicasp        │ 🔴 Em uso      │ clinicasp    │ 25/11/2025 15:45 │
│ 3  │ imunifycom_tenant_saudemaster      │ 🔴 Em uso      │ saudemaster  │ 25/11/2025 16:20 │
│ 4  │ imunifycom_tenant_tenant04         │ 🟢 Disponível  │ -            │ -                │
│ 5  │ imunifycom_tenant_tenant05         │ 🟢 Disponível  │ -            │ -                │
└────┴────────────────────────────────────┴────────────────┴──────────────┴──────────────────┘
```

### 4️⃣ Configurar Cronjob (Monitoramento Automático)

Adicione ao crontab para verificar pool a cada hora:

```bash
crontab -e
```

Adicione:
```
0 * * * * cd ~/repositories/imunify-platform && php artisan pool:check
```

Isso enviará email automaticamente quando o pool ficar com menos de 3 databases disponíveis.

## 📧 Notificações

### Email de Alerta

Quando o pool ficar baixo, você receberá um email com:

```
⚠️ Pool de Databases Ficando Baixo - Imunify Platform

Atenção!

O pool de databases está ficando baixo!
Databases disponíveis: 2

Você deve criar mais databases no cPanel e adicioná-los ao pool 
para evitar que novos cadastros sejam bloqueados.

Como adicionar databases ao pool:
1. Acesse o cPanel e crie um novo database MySQL
2. Use o padrão de nome: imunifycom_tenant_nomedotenante
3. Conceda permissões ao usuário: imunifycom_user
4. Execute via SSH: php artisan pool:add-database imunifycom_tenant_nomedotenante
```

### Configurar Email Admin

No arquivo `.env`, configure o email do administrador:

```env
ADMIN_EMAIL=seu-email@dominio.com
```

## 🔧 Comandos Disponíveis

### Adicionar Database ao Pool
```bash
php artisan pool:add-database <nome_do_database>
```
Valida e adiciona um database criado no cPanel ao pool.

### Ver Status do Pool
```bash
php artisan pool:status
```
Mostra status completo: total, disponíveis, em uso, e lista todos os databases.

### Verificar Pool (com notificação)
```bash
php artisan pool:check
```
Verifica o pool e envia email se estiver baixo. Use no cronjob.

## 📝 Exemplo Prático: Criando 10 Databases Iniciais

### No cPanel:

1. Crie os seguintes databases:
   - `imunifycom_tenant_multiimune` (primeiro tenant real)
   - `imunifycom_tenant_tenant01`
   - `imunifycom_tenant_tenant02`
   - `imunifycom_tenant_tenant03`
   - `imunifycom_tenant_tenant04`
   - `imunifycom_tenant_tenant05`
   - `imunifycom_tenant_tenant06`
   - `imunifycom_tenant_tenant07`
   - `imunifycom_tenant_tenant08`
   - `imunifycom_tenant_tenant09`

2. Para cada um, conceda ALL PRIVILEGES ao `imunifycom_user`

### Via SSH:

```bash
cd ~/repositories/imunify-platform

# Adicionar todos ao pool
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

## 🎯 Vantagens desta Solução

✅ **Isolamento completo de dados** - cada tenant tem seu próprio database  
✅ **Automático** - após setup inicial, tudo funciona automaticamente  
✅ **Seguro** - mantém arquitetura database-per-tenant (LGPD compliant)  
✅ **Escalável** - fácil adicionar mais databases quando necessário  
✅ **Monitorado** - notificações automáticas quando pool ficar baixo  
✅ **Compatível com cPanel** - não requer CREATE DATABASE privilege  

## ⚠️ Importante

- **Sempre** use o formato: `imunifycom_tenant_[nome]`
- **Sempre** conceda permissões ao usuário: `imunifycom_user`
- **Configure** o cronjob para monitoramento automático
- **Monitore** o email configurado em `ADMIN_EMAIL`
- **Crie** databases novos quando receber notificação

## 🔄 Workflow Completo

```
┌─────────────────────────────────────┐
│   Tenant preenche registro          │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│   Sistema verifica pool             │
│   (DatabasePool::getAvailableCount) │
└──────────────┬──────────────────────┘
               │
       ┌───────┴────────┐
       │                │
       ▼                ▼
   Disponível      Não disponível
       │                │
       │                ▼
       │   ┌──────────────────────────┐
       │   │ Mostra mensagem:         │
       │   │ "Capacidade máxima"      │
       │   └──────────────────────────┘
       │
       ▼
┌─────────────────────────────────────┐
│ Aloca próximo database do pool      │
│ (DatabasePool::allocateDatabase)    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ Cria tenant com database alocado    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ Verifica se pool está baixo         │
│ (< 3 disponíveis)                   │
└──────────────┬──────────────────────┘
               │
       ┌───────┴────────┐
       │                │
       ▼                ▼
    Baixo          Saudável
       │                │
       ▼                ▼
┌──────────────┐   ┌─────────┐
│ Envia email  │   │ Sucesso │
│ para admin   │   └─────────┘
└──────────────┘
```

## 📊 Próximos Passos

1. ✅ Rodar migration: `php artisan migrate`
2. ✅ Criar 10 databases no cPanel
3. ✅ Adicionar ao pool via `pool:add-database`
4. ✅ Configurar `ADMIN_EMAIL` no `.env`
5. ✅ Configurar cronjob para `pool:check`
6. ✅ Testar registro de primeiro tenant (MultiImune)

---

**Documentação criada em:** 25/11/2025  
**Versão:** 1.0
