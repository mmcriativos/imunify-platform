<?php

/**
 * Força reset completo do OPcache
 * Acesse via: https://imunify.com.br/force_reset_opcache.php
 */

if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✓ OPcache resetado\n";
} else {
    echo "❌ OPcache não está habilitado\n";
}

if (function_exists('opcache_invalidate')) {
    // Invalidar arquivos específicos
    $files = [
        __DIR__ . '/../app/Http/Controllers/Auth/RegisterTenantController.php',
        __DIR__ . '/../app/Http/Controllers/Auth/LoginController.php',
    ];
    
    foreach ($files as $file) {
        if (file_exists($file)) {
            opcache_invalidate($file, true);
            echo "✓ Invalidado: " . basename($file) . "\n";
        }
    }
}

echo "\n✓ Reset completo realizado!\n";
echo "Agora teste o registro novamente.\n";
