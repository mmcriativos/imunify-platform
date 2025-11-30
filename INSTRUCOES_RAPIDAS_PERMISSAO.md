# 🚨 ERRO RESOLVIDO: Permissão Negada ao Criar Tenant

## ❌ ERRO ORIGINAL

```
SQLSTATE[42000] [1044] Access denied for user 'imunifycom_user'@'localhost' 
to database 'imunifycom_tenant_saudetotal'
```

## ✅ SOLUÇÃO

O problema ocorre porque **o usuário MySQL não tem permissão nos databases do pool**.

### 🏭 PRODUÇÃO (URGENTE)

Execute estes passos NO SERVIDOR:

#### 1️⃣ Faça upload do script

Faça upload do arquivo `grant_pool_permissions.php` para o servidor.

#### 2️⃣ Execute o script

Via SSH ou terminal do cPanel:

```bash
php grant_pool_permissions.php
```

**OU** use phpMyAdmin com usuário root e execute:

```sql
-- Para cada database do pool (ajuste o número conforme necessário)
GRANT ALL PRIVILEGES ON `imunifycom_tenant_001`.* TO 'imunifycom_user'@'localhost';
GRANT ALL PRIVILEGES ON `imunifycom_tenant_002`.* TO 'imunifycom_user'@'localhost';
GRANT ALL PRIVILEGES ON `imunifycom_tenant_003`.* TO 'imunifycom_user'@'localhost';
-- ... repita para todos os databases do pool

FLUSH PRIVILEGES;
```

#### 3️⃣ Verifique as permissões

Execute o script de teste:

```bash
php test_tenant_permissions.php
```

Você deve ver:

```
✅ TODAS AS PERMISSÕES ESTÃO OK!
```

#### 4️⃣ Teste o registro

Acesse `https://imunify.com.br/registrar` e tente criar uma nova clínica.

---

### 🏠 LOCAL (Laragon)

No ambiente local já está configurado! Execute apenas:

```bash
# 1. Criar databases do pool
php setup_local_pool.php

# 2. Testar permissões
php test_tenant_permissions.php

# 3. Iniciar servidor
php artisan serve
```

Acesse: http://localhost:8000/registrar

---

## 📋 ARQUIVOS CRIADOS

| Arquivo | Descrição |
|---------|-----------|
| `grant_pool_permissions.php` | Concede permissões aos databases do pool |
| `test_tenant_permissions.php` | Testa se as permissões estão corretas |
| `setup_local_pool.php` | Configura pool local (apenas dev) |
| `SOLUCAO_ERRO_PERMISSAO_TENANT.md` | Documentação completa |

---

## 🔧 ALTERAÇÕES NO CÓDIGO

### config/database.php

Adicionada conexão `central`:

```php
'central' => [
    'driver' => 'mysql',
    // ... mesmas configurações de 'mysql'
],
```

### config/tenancy.php

Atualizado para usar conexão central explícita:

```php
'database' => [
    'central_connection' => 'central', // Antes: env('DB_CONNECTION', 'central')
```

---

## 🎯 POR QUE ISSO ACONTECEU?

1. **Databases do pool foram criados** no cPanel manualmente
2. **MAS o usuário não foi adicionado** aos databases
3. Quando o Laravel tenta conectar, o MySQL **bloqueia** por falta de permissão

**Analogia:** É como ter uma casa (database), mas sem dar a chave (permissão) para a pessoa (usuário).

---

## ✅ CHECKLIST FINAL

### Produção
- [ ] Upload do `grant_pool_permissions.php`
- [ ] Executar o script (ou SQL manual)
- [ ] Verificar com `test_tenant_permissions.php`
- [ ] Testar registro em `/registrar`
- [ ] Confirmar que tenant foi criado com sucesso

### Local
- [ ] Executar `php setup_local_pool.php`
- [ ] Verificar com `php test_tenant_permissions.php`
- [ ] Testar registro em http://localhost:8000/registrar

---

## 🆘 SE AINDA DER ERRO

### No servidor, execute:

```sql
-- Ver permissões do usuário
SHOW GRANTS FOR 'imunifycom_user'@'localhost';
```

Você DEVE ver linhas como:

```
GRANT ALL PRIVILEGES ON `imunifycom_tenant_001`.* TO `imunifycom_user`@`localhost`
```

Se não aparecer, as permissões não foram aplicadas corretamente.

### Verifique também:

1. O usuário `imunifycom_user` existe?
2. A senha está correta no `.env`?
3. O database do pool existe? (`SHOW DATABASES LIKE 'imunifycom_tenant_%'`)

---

## 📞 SUPORTE

Se o problema persistir após seguir todos os passos, forneça:

1. Output do `grant_pool_permissions.php`
2. Output do `test_tenant_permissions.php`
3. Output de `SHOW GRANTS FOR 'imunifycom_user'@'localhost'`
4. Logs do Laravel (`storage/logs/laravel.log`)
