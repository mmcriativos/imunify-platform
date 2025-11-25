<?php

/**
 * Verifica últimos logs do Laravel
 */

$logFile = __DIR__.'/storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "❌ Arquivo de log não encontrado: {$logFile}\n";
    exit(1);
}

$lines = file($logFile);
$totalLines = count($lines);
$linesToShow = 100;

echo "========================================\n";
echo "ÚLTIMAS {$linesToShow} LINHAS DO LOG\n";
echo "========================================\n\n";

$startLine = max(0, $totalLines - $linesToShow);

for ($i = $startLine; $i < $totalLines; $i++) {
    echo $lines[$i];
}

echo "\n========================================\n";
