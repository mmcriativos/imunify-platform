<?php

namespace App\Tenancy;

use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Support\Facades\Log;

/**
 * Bootstrapper customizado que força o uso do database do pool
 */
class PoolDatabaseTenancyBootstrapper implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant)
    {
        // Obter database do pool
        $databaseName = $tenant->getTenantDatabaseName();
        
        Log::info("🔧 PoolDatabaseTenancyBootstrapper: Configurando database '{$databaseName}' para tenant '{$tenant->getTenantKey()}'");
        
        // Configurar conexão tenant
        $centralConnection = config('tenancy.database.central_connection');
        $baseConfig = config("database.connections.{$centralConnection}");
        
        // Criar configuração para a conexão tenant
        $tenantConfig = array_merge($baseConfig, [
            'database' => $databaseName,
        ]);
        
        // Registrar conexão tenant
        config(['database.connections.tenant' => $tenantConfig]);
        
        // Limpar conexões existentes
        DB::purge('tenant');
        
        // Reconectar com o database correto
        DB::reconnect('tenant');
        
        // Definir como conexão padrão
        DB::setDefaultConnection('tenant');
        
        Log::info("✅ Database configurado: " . DB::connection('tenant')->getDatabaseName());
    }

    public function revert()
    {
        // Voltar para conexão central
        $centralConnection = config('tenancy.database.central_connection');
        DB::setDefaultConnection($centralConnection);
        DB::purge('tenant');
        
        Log::info("🔄 Revertido para conexão central");
    }
}
