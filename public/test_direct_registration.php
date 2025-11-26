<?php
/**
 * Testa o fluxo de registro diretamente (simulação)
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

header('Content-Type: text/plain; charset=utf-8');

echo "=== TESTE DIRETO DE REGISTRO ===\n\n";

// Simula dados de registro
$data = [
    'subdomain' => 'testetenant',
    'name' => 'Teste Tenant',
    'email' => 'admin@testetenant.com',
    'password' => 'senha123',
];

echo "1. Dados de entrada:\n";
echo "   - Subdomínio: {$data['subdomain']}\n";
echo "   - Nome: {$data['name']}\n";
echo "   - Email: {$data['email']}\n\n";

try {
    echo "2. Verificando DatabasePool...\n";
    $pool = DB::table('database_pool')
        ->where('in_use', false)
        ->lockForUpdate()
        ->first();
    
    if (!$pool) {
        die("   ✗ ERRO: Nenhum database disponível no pool!\n");
    }
    echo "   ✓ Pool encontrado: {$pool->database_name}\n\n";

    echo "3. Iniciando transação...\n";
    DB::beginTransaction();

    try {
        echo "4. Criando tenant no banco central...\n";
        
        // Cria tenant
        DB::table('tenants')->insert([
            'id' => $data['subdomain'],
            'data' => json_encode([
                'name' => $data['name'],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✓ Tenant inserido\n";

        // Cria domínio
        echo "5. Criando domínio...\n";
        DB::table('domains')->insert([
            'domain' => $data['subdomain'] . '.imunify.com.br',
            'tenant_id' => $data['subdomain'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✓ Domínio inserido\n";

        // Atualiza pool
        echo "6. Alocando database do pool...\n";
        DB::table('database_pool')
            ->where('id', $pool->id)
            ->update([
                'in_use' => true,
                'tenant_id' => $data['subdomain'],
                'allocated_at' => now(),
            ]);
        echo "   ✓ Database alocada\n";

        echo "7. Commitando transação...\n";
        DB::commit();
        echo "   ✓ COMMIT realizado com sucesso!\n\n";

        // Verifica se realmente salvou
        echo "8. Verificando persistência...\n";
        $tenant = DB::table('tenants')->where('id', $data['subdomain'])->first();
        $domain = DB::table('domains')->where('tenant_id', $data['subdomain'])->first();
        $poolUsed = DB::table('database_pool')->where('tenant_id', $data['subdomain'])->first();

        echo "   Tenant: " . ($tenant ? "✓ ENCONTRADO" : "✗ NÃO ENCONTRADO") . "\n";
        echo "   Domain: " . ($domain ? "✓ ENCONTRADO" : "✗ NÃO ENCONTRADO") . "\n";
        echo "   Pool: " . ($poolUsed ? "✓ ALOCADO" : "✗ NÃO ALOCADO") . "\n";

        if ($tenant && $domain && $poolUsed) {
            echo "\n✓✓✓ TESTE BEM-SUCEDIDO! ✓✓✓\n";
            echo "\nO problema NÃO é o banco de dados.\n";
            echo "O problema está no RegisterTenantController não sendo executado ou tendo erro antes do commit.\n";
        } else {
            echo "\n✗✗✗ TESTE FALHOU! ✗✗✗\n";
            echo "Mesmo com commit manual, dados não persistiram.\n";
        }

    } catch (\Exception $e) {
        DB::rollBack();
        echo "   ✗ ERRO na transação: " . $e->getMessage() . "\n";
        echo "   Stack trace:\n";
        echo $e->getTraceAsString() . "\n";
    }

} catch (\Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== FIM DO TESTE ===\n";
