<?php
/**
 * Mostra APENAS o último erro/registro completo de hoje
 */

$logPath = __DIR__ . '/../storage/logs/laravel.log';

if (!file_exists($logPath)) {
    die("Arquivo de log não encontrado\n");
}

$content = file_get_contents($logPath);
$today = date('Y-m-d');

// Pegar apenas logs de hoje
$lines = explode("\n", $content);
$todayLogs = [];
$inTodayBlock = false;

foreach ($lines as $line) {
    if (preg_match('/^\[' . preg_quote($today) . '/', $line)) {
        $inTodayBlock = true;
    } elseif (preg_match('/^\[\d{4}-\d{2}-\d{2}/', $line) && !preg_match('/^\[' . preg_quote($today) . '/', $line)) {
        $inTodayBlock = false;
    }
    
    if ($inTodayBlock) {
        $todayLogs[] = $line;
    }
}

// Mostrar últimos 150 linhas dos logs de hoje
echo "=== ÚLTIMAS 150 LINHAS DOS LOGS DE HOJE ===\n\n";
echo implode("\n", array_slice($todayLogs, -150));
echo "\n\n=== FIM ===\n";
