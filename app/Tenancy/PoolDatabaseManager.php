<?php

namespace App\Tenancy;

use Stancl\Tenancy\Contracts\TenantDatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

/**
 * Database Manager customizado que NÃO cria bancos dinamicamente.
 * 
 * Em vez disso, usa bancos pré-alocados do DatabasePool.
 * A criação do banco já foi feita manualmente no cPanel.
 */
class PoolDatabaseManager implements TenantDatabaseManager
{
    /**
     * Não cria database - ele já foi alocado pelo DatabasePool
     */
    public function createDatabase(TenantWithDatabase $tenant): bool
    {
        // Banco já existe e foi alocado - não fazer nada
        return true;
    }

    /**
     * Não deleta database - apenas libera de volta para o pool
     */
    public function deleteDatabase(TenantWithDatabase $tenant): bool
    {
        // DatabasePool::releaseDatabase() já cuida disso via observer
        return true;
    }

    /**
     * Nome do database vem do pool (salvo em tenancy_db_name)
     */
    public function databaseExists(string $name): bool
    {
        // Sempre retorna true pois o banco já existe no pool
        return true;
    }

    /**
     * Cria um usuário para o database (não usado no pool)
     */
    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        return array_merge($baseConfig, [
            'database' => $databaseName,
        ]);
    }

    /**
     * Define os grants do usuário (não usado no pool)
     */
    public function setConnection(string $connection): self
    {
        return $this;
    }
}
