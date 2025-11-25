<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_users',
        'max_patients',
        'max_monthly_appointments',
        'storage_gb',
        'whatsapp_enabled',
        'whatsapp_own_number',
        'whatsapp_mode',
        'whatsapp_quota',
        'whatsapp_unlimited',
        'analytics_enabled',
        'multi_unit_enabled',
        'api_access',
        'priority_support',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'whatsapp_enabled' => 'boolean',
        'whatsapp_own_number' => 'boolean',
        'whatsapp_unlimited' => 'boolean',
        'whatsapp_quota' => 'integer',
        'analytics_enabled' => 'boolean',
        'multi_unit_enabled' => 'boolean',
        'api_access' => 'boolean',
        'priority_support' => 'boolean',
    ];

    /**
     * Relationship: Plan has many Tenants
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get the yearly discount percentage
     */
    public function getYearlyDiscountAttribute(): float
    {
        if ($this->price_monthly == 0) {
            return 0;
        }

        $yearlyTotal = $this->price_monthly * 12;
        $discount = (($yearlyTotal - $this->price_yearly) / $yearlyTotal) * 100;

        return round($discount, 1);
    }

    /**
     * Get formatted monthly price
     */
    public function getFormattedMonthlyPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price_monthly, 2, ',', '.');
    }

    /**
     * Get formatted yearly price
     */
    public function getFormattedYearlyPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price_yearly, 2, ',', '.');
    }

    /**
     * Scope for active plans (can add is_active column later)
     */
    public function scopeActive($query)
    {
        return $query; // All plans active for now
    }
}
