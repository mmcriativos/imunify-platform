#!/bin/bash

# Script para deploy e limpeza de caches no cPanel

echo "=== Iniciando Deploy e Limpeza de Caches ==="

# 1. Git Pull
echo "1. Atualizando código..."
git pull origin main

# 2. Limpar config cache
echo "2. Limpando config cache..."
php artisan config:clear

# 3. Limpar application cache
echo "3. Limpando application cache..."
php artisan cache:clear

# 4. Limpar route cache
echo "4. Limpando route cache..."
php artisan route:clear

# 5. Limpar view cache
echo "5. Limpando view cache..."
php artisan view:clear

# 6. Otimizar autoloader
echo "6. Otimizando autoloader..."
composer dump-autoload --optimize

# 7. Cache config para produção
echo "7. Cacheando configurações..."
php artisan config:cache

echo ""
echo "=== Deploy Concluído! ==="
echo ""
echo "Próximos passos:"
echo "1. Acesse: https://imunify.com.br/clear_opcache.php"
echo "2. Teste a aplicação"
echo ""
