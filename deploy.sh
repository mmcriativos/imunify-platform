#!/bin/bash

# Script de Deploy Manual - MultiImune
# Execute: bash deploy.sh

echo "🚀 Iniciando deploy do MultiImune..."

# Cores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 1. Git Pull
echo -e "${BLUE}📥 Baixando atualizações do GitHub...${NC}"
git pull origin main

if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Erro no git pull!${NC}"
    exit 1
fi

# 2. Composer
echo -e "${BLUE}📦 Instalando dependências PHP...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# 3. NPM
echo -e "${BLUE}📦 Instalando dependências Node...${NC}"
npm ci

# 4. Build Assets
echo -e "${BLUE}🔨 Compilando assets...${NC}"
npm run build

# 5. Migrations
echo -e "${BLUE}🔧 Corrigindo migrations problemáticas (se houver)...${NC}"
php fix_migrations_production.php

echo -e "${BLUE}🗄️  Executando migrations centrais...${NC}"
php artisan migrate --force

# 5.1. Migrations dos Tenants
echo -e "${BLUE}🏢 Executando migrations dos tenants...${NC}"
php artisan tenants:run migrate

# 6. Cache
echo -e "${BLUE}⚡ Otimizando cache...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Storage Link
echo -e "${BLUE}🔗 Criando link de storage...${NC}"
php artisan storage:link

# 8. Permissões
echo -e "${BLUE}🔐 Ajustando permissões...${NC}"
chmod -R 755 storage bootstrap/cache

echo -e "${GREEN}✅ Deploy concluído com sucesso!${NC}"
echo -e "${GREEN}🎉 MultiImune está atualizado!${NC}"
