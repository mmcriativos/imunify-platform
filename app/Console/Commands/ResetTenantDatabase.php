<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\DatabasePool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResetTenantDatabase extends Command
{
    protected $signature = 'tenant:reset {database_name : Nome do database a ser resetado}';
    protected $description = 'Reseta um database do pool, limpando tenant e liberando para novo uso';

    public function handle()
    {
        $databaseName = $this->argument('database_name');
        
        // Verificar se database existe no pool
        $poolEntry = DatabasePool::where('database_name', $databaseName)->first();
        
        if (!$poolEntry) {
            $this->error("Database '{$databaseName}' não encontrado no pool!");
            return 1;
        }

        $this->info("Resetando database: {$databaseName}");

        // 1. Buscar tenant associado
        $tenant = null;
        if ($poolEntry->in_use && $poolEntry->tenant_id) {
            $tenant = Tenant::find($poolEntry->tenant_id);
            
            if ($tenant) {
                $this->info("Tenant encontrado: {$tenant->id} - {$tenant->clinic_name}");
                
                // Deletar domínios
                $this->info("Deletando domínios...");
                $tenant->domains()->delete();
                
                // Deletar tenant
                $this->info("Deletando tenant da central...");
                $tenant->delete();
            }
        }

        // 2. Dropar todas as tabelas do database do tenant
        $this->info("Limpando database {$databaseName}...");
        
        try {
            // Conectar ao database do tenant usando as mesmas credenciais da conexão padrão
            $defaultConnection = config('database.default');
            $dbConfig = config("database.connections.{$defaultConnection}");
            
            config(['database.connections.tenant_clean' => [
                'driver' => 'mysql',
                'host' => $dbConfig['host'],
                'port' => $dbConfig['port'],
                'database' => $databaseName,
                'username' => $dbConfig['username'],
                'password' => $dbConfig['password'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]]);

            DB::purge('tenant_clean');
            
            // Desabilitar foreign key checks
            DB::connection('tenant_clean')->statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Buscar todas as tabelas
            $tables = DB::connection('tenant_clean')
                ->select('SHOW TABLES');
            
            $tableKey = 'Tables_in_' . $databaseName;
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                $this->info("  Dropando tabela: {$tableName}");
                DB::connection('tenant_clean')->statement("DROP TABLE IF EXISTS `{$tableName}`");
            }
            
            // Reabilitar foreign key checks
            DB::connection('tenant_clean')->statement('SET FOREIGN_KEY_CHECKS=1');
            
            $this->info("✓ Database limpo com sucesso!");
            
        } catch (\Exception $e) {
            $this->error("❌ ERRO ao limpar database: " . $e->getMessage());
            $this->error("⚠️  O database NÃO foi liberado no pool!");
            Log::error('Erro ao resetar tenant database', [
                'database' => $databaseName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1; // Abortar sem liberar o pool
        }

        // 3. Liberar database no pool (só chega aqui se não houve erro)
        $this->info("Liberando database no pool...");
        $poolEntry->in_use = false;
        $poolEntry->tenant_id = null;
        $poolEntry->allocated_at = null;
        $poolEntry->save();

        $this->info("✓ Database '{$databaseName}' resetado e disponível para novo uso!");
        
        // Mostrar status do pool
        $this->newLine();
        $this->info("Status do Pool:");
        $this->info("Disponíveis: " . DatabasePool::getAvailableCount());
        $this->info("Em uso: " . DatabasePool::where('in_use', true)->count());

        return 0;
    }
}
