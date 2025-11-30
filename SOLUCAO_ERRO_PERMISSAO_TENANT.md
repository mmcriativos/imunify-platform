# 🔧 SOLUÇÃO: Erro de Permissão ao Criar Tenant

## 🔴 PROBLEMA

```
SQLSTATE[42000] [1044] Access denied for user 'imunifycom_user'@'localhost' 
to database 'imunifycom_tenant_saudetotal'
```

## 🎯 CAUSA RAIZ

Quando o sistema cria um novo tenant, ele:
1. Aloca um database do pool (ex: `imunifycom_tenant_001`)
2. Tenta conectar ao database usando o usuário padrão (`imunifycom_user`)
3. **FALHA** porque esse usuário não tem permissão para acessar esse database específico

## ✅ SOLUÇÃO EM PRODUÇÃO (cPanel)

### Opção 1: Adicionar Usuário aos Databases Existentes (RECOMENDADO)

Para cada database do pool já criado no cPanel:

1. Acesse **MySQL Databases** no cPanel
2. Localize a seção **"Add User To Database"**
3. Para cada database do pool (`imunifycom_tenant_001`, `imunifycom_tenant_002`, etc.):
   - User: `imunifycom_user`
   - Database: `imunifycom_tenant_XXX`
   - Clique em **Add**
4. Na tela de privilégios, marque **ALL PRIVILEGES**
5. Clique em **Make Changes**

### Opção 2: Script Automático via SSH

Se você tem acesso SSH ao servidor, pode usar este script:

```bash
#!/bin/bash
# Adiciona usuário aos databases do pool

USER="imunifycom_user"
PASSWORD="SUA_SENHA_AQUI"

for i in {001..050}; do
  DB="imunifycom_tenant_${i}"
  
  mysql -u root -p <<EOF
GRANT ALL PRIVILEGES ON \`${DB}\`.* TO '${USER}'@'localhost';
FLUSH PRIVILEGES;
EOF
  
  echo "✓ Permissões concedidas para ${DB}"
done
```

### Opção 3: Criar Script PHP (se não tem SSH)

```php
<?php
// grant_permissions.php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$user = env('DB_USERNAME');
$databases = DB::select("SHOW DATABASES LIKE 'imunifycom_tenant_%'");

foreach ($databases as $db) {
    $dbName = array_values((array)$db)[0];
    
    try {
        DB::statement("GRANT ALL PRIVILEGES ON `{$dbName}`.* TO '{$user}'@'localhost'");
        echo "✓ Permissões concedidas para {$dbName}\n";
    } catch (\Exception $e) {
        echo "✗ Erro em {$dbName}: " . $e->getMessage() . "\n";
    }
}

DB::statement("FLUSH PRIVILEGES");
echo "\n✅ Concluído!\n";
```

Execute: `php grant_permissions.php`

## 🔧 VERIFICAÇÃO

Após aplicar as permissões, teste a conexão:

```php
<?php
// test_tenant_connection.php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$dbName = 'imunifycom_tenant_001'; // Ajuste conforme necessário

try {
    $config = config('database.connections.mysql');
    $config['database'] = $dbName;
    
    config(['database.connections.test_tenant' => $config]);
    
    $result = DB::connection('test_tenant')->select('SELECT DATABASE() as db');
    echo "✅ CONEXÃO OK!\n";
    echo "Database conectado: " . $result[0]->db . "\n";
    
    // Testar permissões
    DB::connection('test_tenant')->statement('CREATE TABLE IF NOT EXISTS _test (id INT)');
    DB::connection('test_tenant')->statement('DROP TABLE _test');
    echo "✅ PERMISSÕES OK! (CREATE/DROP testados)\n";
    
} catch (\Exception $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
}
```

## 📋 CHECKLIST COMPLETO

- [ ] Verificar que os databases do pool existem no cPanel
- [ ] Adicionar usuário `imunifycom_user` a TODOS os databases do pool
- [ ] Conceder ALL PRIVILEGES para cada database
- [ ] Executar FLUSH PRIVILEGES
- [ ] Testar conexão com script de verificação
- [ ] Testar registro de novo tenant em `/registrar`

## 🏠 CONFIGURAÇÃO LOCAL (Laragon)

No ambiente local, o usuário `root` já tem acesso a todos os databases, então não há problema. Basta ter os databases criados:

```bash
php setup_local_pool.php
```

## 📝 NOTAS IMPORTANTES

1. **Cada database do pool precisa ter o usuário adicionado** - não basta criar o database
2. Em cPanel, isso é feito manualmente ou via script
3. O erro acontece especificamente quando o Laravel tenta executar `SHOW TABLES` no database do tenant
4. A conexão `central` está OK (por isso a transação funciona), mas a conexão `tenant` dinâmica falha

## 🆘 SE AINDA DER ERRO

Verifique:

```bash
# No servidor via SSH ou phpMyAdmin, execute:
SHOW GRANTS FOR 'imunifycom_user'@'localhost';
```

Você deve ver linhas como:
```
GRANT ALL PRIVILEGES ON `imunifycom_tenant_001`.* TO `imunifycom_user`@`localhost`
GRANT ALL PRIVILEGES ON `imunifycom_tenant_002`.* TO `imunifycom_user`@`localhost`
...
```

Se não aparecer, o usuário não tem acesso ao database.
