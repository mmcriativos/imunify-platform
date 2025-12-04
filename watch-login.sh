#!/bin/bash

echo "=========================================="
echo "  MONITORAMENTO DE LOGIN EM TEMPO REAL"
echo "=========================================="
echo ""
echo "Aguardando tentativas de login..."
echo "Pressione Ctrl+C para parar"
echo ""
echo "=========================================="
echo ""

# Monitorar log em tempo real
tail -f storage/logs/laravel.log | grep --line-buffered -E "login|LOGIN|TENTATIVA|Auth::attempt|Usuário|senha|===|✅|❌"
