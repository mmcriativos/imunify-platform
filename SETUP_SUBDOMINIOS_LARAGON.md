# 🌐 Configurar Subdomínios no Laragon (Windows)

## Passo 1: Configurar Apache Virtual Host

### 1.1 Abrir arquivo de configuração
```
C:\laragon\etc\apache2\sites-enabled\auto.imunify.test.conf
```

### 1.2 Criar arquivo com este conteúdo:
```apache
<VirtualHost *:80>
    DocumentRoot "M:/laragon/www/multiimune/public"
    ServerName imunify.test
    ServerAlias *.imunify.test
    
    <Directory "M:/laragon/www/multiimune/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Passo 2: Configurar DNS Local (hosts)

### 2.1 Abrir arquivo hosts como Administrador:
```
C:\Windows\System32\drivers\etc\hosts
```

### 2.2 Adicionar linhas:
```
127.0.0.1   imunify.test
127.0.0.1   clinica-teste.imunify.test
127.0.0.1   clinica-a.imunify.test
127.0.0.1   clinica-b.imunify.test
```

**OU usar Laragon Auto Virtual Hosts:**

### Opção Fácil: Usar Acrylic DNS (Recomendado!)

1. Baixar Acrylic DNS Proxy: http://mayakron.altervista.org/
2. Instalar
3. Adicionar no arquivo de configuração do Acrylic (`AcrylicHosts.txt`):
```
127.0.0.1 *.imunify.test
```
4. Reiniciar Acrylic DNS Service

## Passo 3: Configurar env.php do Tenancy

### 3.1 Editar: `config/tenancy.php`

Procure por `central_domains` e configure:
```php
'central_domains' => [
    'imunify.test', // Domínio central (admin)
],
```

## Passo 4: Reiniciar Apache

```powershell
# No Menu do Laragon: Apache > Restart
# Ou pelo PowerShell:
laragon stop
laragon start
```

## Passo 5: Testar

### 5.1 Criar tenant de teste:
```bash
php artisan tinker

$tenant = \Stancl\Tenancy\Database\Models\Tenant::create([
    'id' => 'clinica-teste'
]);

$tenant->domains()->create([
    'domain' => 'clinica-teste.imunify.test'
]);
```

### 5.2 Acessar no navegador:
```
http://imunify.test          → Domínio central (admin)
http://clinica-teste.imunify.test   → Tenant
```

---

## Alternativa: Usar .localhost (Mais Fácil!)

Se não quiser configurar DNS, use `.localhost` que funciona automaticamente:

```php
// Criar tenant com .localhost
$tenant->domains()->create([
    'domain' => 'clinica-teste.localhost'
]);
```

Acesse: `http://clinica-teste.localhost`

**✅ Funciona sem configurar hosts!**

---

## Troubleshooting

### Erro: "Site não encontrado"
- Verifique se Apache reiniciou
- Confirme que o arquivo vhost foi criado
- Teste: `ping imunify.test`

### Erro: "DNS não resolve"
- Use `.localhost` em vez de `.test`
- Ou instale Acrylic DNS

### Erro: "Tenant not found"
- Verifique se tenant existe no banco
- Confirme domínio está correto
- Limpe cache: `php artisan cache:clear`

---

## ⚡ Quick Setup (Recomendado)

**Use `.localhost` para desenvolvimento:**

1. Não precisa configurar hosts
2. Não precisa Acrylic DNS
3. Funciona imediatamente

```bash
# Criar tenant
php artisan tinker
>>> $tenant = \Stancl\Tenancy\Database\Models\Tenant::create(['id' => 'test'])
>>> $tenant->domains()->create(['domain' => 'test.localhost'])

# Acessar
http://test.localhost
```

**✅ Pronto!**
