#!/bin/bash

###############################################################################
# Script de Deploy Automático - ImuniFy Platform
# Executa deploy seguro com backup e rollback automático em caso de erro
###############################################################################

set -e  # Parar em caso de erro

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configurações
PROJECT_DIR="/home/imunifyc/public_html"
BACKUP_DIR="/home/imunifyc/backups"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="backup_${DATE}.sql"

echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         🚀 Deploy ImuniFy Platform - Produção              ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""

# Função para exibir mensagens
print_step() {
    echo -e "\n${BLUE}▶ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Função de rollback em caso de erro
rollback() {
    print_error "Erro detectado! Iniciando rollback..."
    
    # Voltar para a versão anterior do git
    git reset --hard HEAD@{1}
    
    # Restaurar backup do banco de dados
    if [ -f "$BACKUP_DIR/$BACKUP_FILE" ]; then
        print_step "Restaurando backup do banco de dados..."
        mysql -u imunifycom_user -p imunifycom_central < "$BACKUP_DIR/$BACKUP_FILE"
        print_success "Banco de dados restaurado"
    fi
    
    # Reativar o site
    php artisan up
    
    print_error "Deploy cancelado. Sistema restaurado ao estado anterior."
    exit 1
}

# Configurar trap para capturar erros
trap rollback ERR

# 1. Verificar se está no diretório correto
print_step "Verificando diretório do projeto..."
cd $PROJECT_DIR || exit 1
print_success "Diretório: $(pwd)"

# 2. Ativar modo de manutenção
print_step "Ativando modo de manutenção..."
php artisan down --retry=60 --message="Atualizando o sistema. Voltamos em instantes!"
print_success "Modo de manutenção ativado"

# 3. Criar diretório de backup se não existir
print_step "Preparando backup..."
mkdir -p $BACKUP_DIR
print_success "Diretório de backup: $BACKUP_DIR"

# 4. Backup do banco de dados
print_step "Criando backup do banco de dados central..."
mysqldump -u imunifycom_user -p imunifycom_central > "$BACKUP_DIR/$BACKUP_FILE"
print_success "Backup criado: $BACKUP_FILE"

# 5. Verificar status do git
print_step "Verificando status do repositório Git..."
git fetch origin main
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse @{u})

if [ $LOCAL = $REMOTE ]; then
    print_warning "Nenhuma atualização disponível. Repositório já está atualizado."
    read -p "Deseja continuar mesmo assim? (s/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Ss]$ ]]; then
        php artisan up
        print_warning "Deploy cancelado pelo usuário."
        exit 0
    fi
fi

# 6. Fazer pull das alterações
print_step "Baixando alterações do repositório..."
git pull origin main
print_success "Código atualizado"

# 7. Instalar/atualizar dependências
print_step "Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader --no-interaction
print_success "Dependências instaladas"

# 8. Executar migrations
print_step "Executando migrations no banco central..."
php artisan migrate --force --database=central
print_success "Migrations executadas"

# 9. Limpar caches
print_step "Limpando caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
print_success "Caches limpos"

# 10. Recompilar e otimizar
print_step "Recompilando configurações otimizadas..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
print_success "Otimizações aplicadas"

# 11. Executar comando de verificação de tenants (dry-run primeiro)
print_step "Verificando status dos tenants (dry-run)..."
php artisan tenants:check-status --dry-run
print_success "Verificação de tenants concluída"

# 12. Definir permissões corretas
print_step "Ajustando permissões de arquivos..."
chmod -R 755 storage bootstrap/cache
print_success "Permissões ajustadas"

# 13. Desativar modo de manutenção
print_step "Desativando modo de manutenção..."
php artisan up
print_success "Site reativado"

# 14. Resumo final
echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║              ✓ Deploy Concluído com Sucesso!              ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}📊 Informações do Deploy:${NC}"
echo -e "   Data/Hora: $(date '+%d/%m/%Y %H:%M:%S')"
echo -e "   Backup: $BACKUP_FILE"
echo -e "   Commit: $(git log -1 --pretty=format:'%h - %s')"
echo ""
echo -e "${YELLOW}📋 Próximos passos recomendados:${NC}"
echo -e "   1. Verificar logs: tail -f storage/logs/laravel.log"
echo -e "   2. Testar funcionalidades críticas no navegador"
echo -e "   3. Verificar cron job do tenants:check-status"
echo -e "   4. Monitorar erros nas próximas horas"
echo ""
echo -e "${GREEN}✓ Sistema atualizado e funcionando!${NC}"
echo ""

# Opcional: Enviar notificação (descomentar se configurado)
# curl -X POST "https://api.telegram.org/bot<TOKEN>/sendMessage" \
#      -d "chat_id=<CHAT_ID>" \
#      -d "text=✅ Deploy ImuniFy concluído com sucesso em produção!"
