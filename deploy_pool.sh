#!/bin/bash

# ========================================
# SCRIPT DE DEPLOY - Sistema Pool Database
# ========================================
# Execute este script via Terminal do cPanel ou SSH
# URL: https://imunify.com.br:2083 → Terminal

echo "========================================="
echo "  DEPLOY: Sistema de Pool de Databases  "
echo "========================================="
echo ""

cd ~/repositories/imunify-platform

echo "1️⃣ Fazendo pull das alterações..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Erro ao fazer git pull!"
    echo "Solução: Acesse o cPanel Terminal e execute manualmente:"
    echo "  cd ~/repositories/imunify-platform"
    echo "  git pull origin main"
    exit 1
fi

echo "✓ Código atualizado!"
echo ""

echo "2️⃣ Rodando migration database_pool..."
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo "❌ Erro ao rodar migration!"
    exit 1
fi

echo "✓ Migration executada!"
echo ""

echo "3️⃣ Limpando cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "✓ Cache limpo!"
echo ""

echo "========================================="
echo "✅ DEPLOY CONCLUÍDO COM SUCESSO!"
echo "========================================="
echo ""
echo "📋 PRÓXIMOS PASSOS:"
echo ""
echo "1. Criar databases no cPanel (MySQL Databases):"
echo "   - imunifycom_tenant_multiimune"
echo "   - imunifycom_tenant_tenant01"
echo "   - imunifycom_tenant_tenant02"
echo "   - ... (até tenant09)"
echo ""
echo "2. Conceder ALL PRIVILEGES ao usuário: imunifycom_user"
echo ""
echo "3. Adicionar ao pool (execute para cada database):"
echo "   php artisan pool:add-database imunifycom_tenant_multiimune"
echo "   php artisan pool:add-database imunifycom_tenant_tenant01"
echo "   ..."
echo ""
echo "4. Verificar status do pool:"
echo "   php artisan pool:status"
echo ""
echo "5. Configurar cronjob (cPanel → Cron Jobs):"
echo "   Comando: cd ~/repositories/imunify-platform && php artisan pool:check"
echo "   Frequência: A cada hora (0 * * * *)"
echo ""
echo "6. Configurar ADMIN_EMAIL no .env:"
echo "   ADMIN_EMAIL=seu-email@dominio.com"
echo ""
echo "========================================="
