<?php
/**
 * Verifica se mbstring está carregado no contexto web
 */

header('Content-Type: text/plain; charset=utf-8');

echo "=== VERIFICAÇÃO MBSTRING ===\n\n";

echo "1. extension_loaded('mbstring'): ";
echo extension_loaded('mbstring') ? "✓ SIM\n" : "✗ NÃO\n";

echo "\n2. function_exists('mb_split'): ";
echo function_exists('mb_split') ? "✓ SIM\n" : "✗ NÃO\n";

echo "\n3. function_exists('mb_strlen'): ";
echo function_exists('mb_strlen') ? "✓ SIM\n" : "✗ NÃO\n";

echo "\n4. function_exists('mb_substr'): ";
echo function_exists('mb_substr') ? "✓ SIM\n" : "✗ NÃO\n";

echo "\n5. Todas as funções mb_* disponíveis:\n";
if (extension_loaded('mbstring')) {
    $functions = get_extension_funcs('mbstring');
    if ($functions) {
        echo "   Total: " . count($functions) . " funções\n";
        echo "   Primeiras 10: " . implode(', ', array_slice($functions, 0, 10)) . "\n";
    } else {
        echo "   Nenhuma função encontrada\n";
    }
} else {
    echo "   Extensão não carregada\n";
}

echo "\n6. Versão PHP: " . PHP_VERSION . "\n";

echo "\n7. SAPI: " . php_sapi_name() . "\n";

echo "\n8. Teste prático mb_split():\n";
try {
    if (function_exists('mb_split')) {
        $result = mb_split('_', 'teste_string');
        echo "   ✓ mb_split funcionou! Resultado: " . json_encode($result) . "\n";
    } else {
        echo "   ✗ Função mb_split não existe\n";
    }
} catch (Throwable $e) {
    echo "   ✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n9. Extensões carregadas:\n";
$extensions = get_loaded_extensions();
$has_mb = in_array('mbstring', $extensions);
echo "   Total: " . count($extensions) . "\n";
echo "   mbstring presente: " . ($has_mb ? "✓ SIM" : "✗ NÃO") . "\n";

echo "\n10. php.ini sendo usado:\n";
echo "    " . php_ini_loaded_file() . "\n";

echo "\n11. Arquivos .ini adicionais:\n";
$scanned = php_ini_scanned_files();
if ($scanned) {
    echo "    " . $scanned . "\n";
} else {
    echo "    Nenhum\n";
}

echo "\n=== FIM DA VERIFICAÇÃO ===\n";
