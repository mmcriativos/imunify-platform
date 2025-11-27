<?php

namespace App\Tenancy;

use Stancl\Tenancy\Contracts\TenantWithDatabase;

/**
 * Resolver customizado que obtém o nome do banco do pool
 * em vez de usar o padrão prefix + tenant_id
 */
class PoolTenantDatabaseNameResolver
{
    /**
     * Resolve o nome do banco para o tenant
     */
    public static function resolve(TenantWithDatabase $tenant): string
    {
        // Obter do internal data (JSON column 'data')
        $dbName = $tenant->getInternal('tenancy_db_name');
        
        if ($dbName) {
            return $dbName;
        }
        
        // Fallback: usar padrão (não deveria acontecer)
        return config('tenancy.database.prefix') . $tenant->getTenantKey() . config('tenancy.database.suffix');
    }
}
