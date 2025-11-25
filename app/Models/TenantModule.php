<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantModule extends Model
{
    // SEMPRE usar banco central, nunca o banco do tenant
    protected $connection = 'mysql';
    protected $table = 'tenant_modules';

    protected $fillable = [
        'tenant_id',
        'module_name',
        'active',
        'activated_at',
        'expires_at',
        'monthly_fee',
        'billing_status',
        'settings',
    ];

    protected $casts = [
        'active' => 'boolean',
        'activated_at' => 'date',
        'expires_at' => 'date',
        'monthly_fee' => 'decimal:2',
        'settings' => 'array',
    ];

    /**
     * Força o uso da conexão central
     */
    public function getConnectionName()
    {
        return 'mysql';
    }

    // Relacionamentos
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(\Stancl\Tenancy\Database\Models\Tenant::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', now());
                    });
    }

    public function scopeSipni($query)
    {
        return $query->where('module_name', 'sipni_integration');
    }

    // Métodos auxiliares
    public function isActive(): bool
    {
        return $this->active && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function activate(): void
    {
        $this->update([
            'active' => true,
            'activated_at' => now(),
            'billing_status' => 'active',
        ]);
    }

    public function suspend(): void
    {
        $this->update([
            'active' => false,
            'billing_status' => 'suspended',
        ]);
    }

    public function renew(int $months = 1): void
    {
        $expiresAt = $this->expires_at ?? now();
        
        $this->update([
            'expires_at' => $expiresAt->addMonths($months),
            'active' => true,
            'billing_status' => 'active',
        ]);
    }

    // Configurações do módulo SIPNI
    public function getSipniConfig(): array
    {
        return $this->settings ?? [];
    }

    public function updateSipniConfig(array $config): void
    {
        $this->update([
            'settings' => array_merge($this->settings ?? [], $config)
        ]);
    }
}
