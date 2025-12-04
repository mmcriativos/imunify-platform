<?php

/*
 * Script para habilitar logs de DEBUG temporariamente
 * ATENÇÃO: Usar apenas para diagnóstico!
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "❌ Arquivo .env não encontrado!\n";
    exit(1);
}

echo "=== HABILITANDO LOGS DE DEBUG ===\n\n";

$content = file_get_contents($envFile);
$originalContent = $content;

// Alterar LOG_LEVEL de error para debug
if (strpos($content, 'LOG_LEVEL=error') !== false) {
    $content = str_replace('LOG_LEVEL=error', 'LOG_LEVEL=debug', $content);
    echo "✅ LOG_LEVEL alterado de 'error' para 'debug'\n";
} else if (strpos($content, 'LOG_LEVEL=') !== false) {
    $content = preg_replace('/LOG_LEVEL=\w+/', 'LOG_LEVEL=debug', $content);
    echo "✅ LOG_LEVEL alterado para 'debug'\n";
} else {
    $content .= "\nLOG_LEVEL=debug\n";
    echo "✅ LOG_LEVEL=debug adicionado ao .env\n";
}

// Salvar arquivo
if ($content !== $originalContent) {
    file_put_contents($envFile, $content);
    echo "✅ Arquivo .env atualizado!\n\n";
    
    echo "IMPORTANTE:\n";
    echo "1. Os logs agora vão aparecer no terminal\n";
    echo "2. Execute: ./watch-login.sh\n";
    echo "3. Tente fazer login\n";
    echo "4. Após o diagnóstico, REVERTA para LOG_LEVEL=error\n";
    echo "   (logs de debug podem lotar o disco!)\n\n";
    
    echo "Para reverter depois:\n";
    echo "  sed -i 's/LOG_LEVEL=debug/LOG_LEVEL=error/' .env\n";
} else {
    echo "ℹ️  Nenhuma alteração necessária\n";
}

echo "\n=== FIM ===\n";
