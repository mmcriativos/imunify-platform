<?php
/**
 * Mostra logs APENAS de hoje com formatação melhorada
 */

$logPath = __DIR__ . '/../storage/logs/laravel.log';

if (!file_exists($logPath)) {
    die("Arquivo de log não encontrado: {$logPath}\n");
}

$today = date('Y-m-d');
$lines = file($logPath);

echo "=== LOGS DE HOJE ({$today}) ===\n\n";

$foundToday = false;
$currentBlock = [];
$inBlock = false;

foreach ($lines as $line) {
    // Detecta início de nova entrada de log
    if (preg_match('/^\[' . preg_quote($today) . '/', $line)) {
        // Imprime bloco anterior se existir
        if (!empty($currentBlock)) {
            echo implode('', $currentBlock);
            echo str_repeat('-', 80) . "\n\n";
        }
        
        $currentBlock = [$line];
        $inBlock = true;
        $foundToday = true;
    } elseif ($inBlock) {
        // Continua coletando linhas do bloco atual
        $currentBlock[] = $line;
        
        // Se encontrar início de outro log (outra data), para o bloco
        if (preg_match('/^\[\d{4}-\d{2}-\d{2}/', $line) && !preg_match('/^\[' . preg_quote($today) . '/', $line)) {
            $inBlock = false;
            $currentBlock = [];
        }
    }
}

// Imprime último bloco
if (!empty($currentBlock)) {
    echo implode('', $currentBlock);
    echo str_repeat('-', 80) . "\n";
}

if (!$foundToday) {
    echo "❌ Nenhum log encontrado para hoje ({$today})\n";
    echo "\nÚltimas 20 linhas do arquivo:\n";
    echo str_repeat('=', 80) . "\n";
    $lastLines = array_slice($lines, -20);
    echo implode('', $lastLines);
}

echo "\n=== FIM ===\n";
