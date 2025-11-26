<?php
/**
 * Limpa tenant de teste e testa registro novamente
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain; charset=utf-8');

echo "=== LIMPEZA E TESTE COMPLETO ===\n\n";

try {
    // 1. Limpar tenant de teste anterior
    echo "1. Limpando tenant 'testetenant' anterior...\n";
    DB::table('domains')->where('tenant_id', 'testetenant')->delete();
    DB::table('database_pool')->where('tenant_id', 'testetenant')->update([
        'in_use' => false,
        'tenant_id' => null,
        'allocated_at' => null,
    ]);
    $deleted = DB::table('tenants')->where('id', 'testetenant')->delete();
    echo "   ✓ Limpeza concluída (deletados: {$deleted})\n\n";

    // 2. Dados de teste
    $data = [
        'subdomain' => 'testetenant',
        'name' => 'Teste Tenant',
        'email' => 'admin@testetenant.com',
        'password' => 'senha123',
    ];

    echo "2. Dados de entrada:\n";
    echo "   - Subdomínio: {$data['subdomain']}\n";
    echo "   - Nome: {$data['name']}\n";
    echo "   - Email: {$data['email']}\n\n";

    // 3. Buscar pool disponível
    echo "3. Verificando DatabasePool...\n";
    $pool = DB::table('database_pool')
        ->where('in_use', false)
        ->lockForUpdate()
        ->first();
    
    if (!$pool) {
        die("   ✗ ERRO: Nenhum database disponível no pool!\n");
    }
    echo "   ✓ Pool encontrado: {$pool->database_name}\n\n";

    // 4. Iniciar transação
    echo "4. Iniciando transação...\n";
    DB::beginTransaction();

    try {
        // 5. Criar tenant
        echo "5. Criando tenant no banco central...\n";
        DB::table('tenants')->insert([
            'id' => $data['subdomain'],
            'data' => json_encode([
                'name' => $data['name'],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✓ Tenant inserido\n";

        // 6. Criar domínio
        echo "6. Criando domínio...\n";
        DB::table('domains')->insert([
            'domain' => $data['subdomain'] . '.imunify.com.br',
            'tenant_id' => $data['subdomain'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✓ Domínio inserido\n";

        // 7. Atualizar pool
        echo "7. Alocando database do pool...\n";
        DB::table('database_pool')
            ->where('id', $pool->id)
            ->update([
                'in_use' => true,
                'tenant_id' => $data['subdomain'],
                'allocated_at' => now(),
            ]);
        echo "   ✓ Database alocada\n";

        // 8. Commit
        echo "8. Commitando transação...\n";
        DB::commit();
        echo "   ✓ COMMIT realizado com sucesso!\n\n";

        // 9. Verificar persistência
        echo "9. Verificando persistência...\n";
        $tenant = DB::table('tenants')->where('id', $data['subdomain'])->first();
        $domain = DB::table('domains')->where('tenant_id', $data['subdomain'])->first();
        $poolUsed = DB::table('database_pool')->where('tenant_id', $data['subdomain'])->first();

        echo "   Tenant: " . ($tenant ? "✓ ENCONTRADO (ID: {$tenant->id})" : "✗ NÃO ENCONTRADO") . "\n";
        echo "   Domain: " . ($domain ? "✓ ENCONTRADO ({$domain->domain})" : "✗ NÃO ENCONTRADO") . "\n";
        echo "   Pool: " . ($poolUsed ? "✓ ALOCADO ({$poolUsed->database_name})" : "✗ NÃO ALOCADO") . "\n\n";

        if ($tenant && $domain && $poolUsed) {
            echo "✓✓✓ SUCESSO TOTAL! ✓✓✓\n\n";
            echo "Tenant '{$data['subdomain']}' criado com sucesso!\n";
            echo "Database alocada: {$poolUsed->database_name}\n";
            echo "Domínio: {$domain->domain}\n\n";
            echo "O problema NÃO é no banco de dados.\n";
            echo "O RegisterTenantController pode não estar sendo executado ou tem erro antes do commit.\n";
        } else {
            echo "✗✗✗ FALHA NA PERSISTÊNCIA! ✗✗✗\n";
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
