<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabasePool extends Model
{
    protected $table = 'database_pool';

    protected $fillable = [
        'database_name',
        'in_use',
        'tenant_id',
        'allocated_at',
    ];

    protected $casts = [
        'in_use' => 'boolean',
        'allocated_at' => 'datetime',
    ];

    /**
     * Aloca o próximo database disponível do pool
     */
    public static function allocateDatabase(string $tenantId): ?string
    {
        $database = self::where('in_use', false)
            ->orderBy('id')
            ->lockForUpdate()
            ->first();

        if (!$database) {
            return null;
        }

        $database->update([
            'in_use' => true,
            'tenant_id' => $tenantId,
            'allocated_at' => now(),
        ]);

        return $database->database_name;
    }

    /**
     * Libera um database de volta para o pool
     */
    public static function releaseDatabase(string $tenantId): bool
    {
        $database = self::where('tenant_id', $tenantId)->first();

        if (!$database) {
            return false;
        }

        $database->update([
            'in_use' => false,
            'tenant_id' => null,
            'allocated_at' => null,
        ]);

        return true;
    }

    /**
     * Verifica quantos databases ainda estão disponíveis
     */
    public static function getAvailableCount(): int
    {
        return self::where('in_use', false)->count();
    }

    /**
     * Verifica se o pool está ficando baixo (menos de 3 disponíveis)
     */
    public static function isPoolLow(): bool
    {
        return self::getAvailableCount() < 3;
    }
}
