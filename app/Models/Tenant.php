<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'plan_id', 
        'clinic_name',
        'cnpj',
        'phone',
        'email',
        'address',
        'city', 
        'state',
        'zip_code',
        'whatsapp_api_url',
        'whatsapp_instance',
        'whatsapp_token',
        'whatsapp_client_token',
        'whatsapp_enabled',
        'logo_url',
        'primary_color',
        'timezone',
        'status',
        'trial_ends_at',
        'subscription_ends_at',
        'cnes',
        'crm',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'whatsapp_enabled' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    /**
     * Relationship: Tenant belongs to a Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if tenant has access to a feature based on their plan
     */
    public function hasFeature(string $feature): bool
    {
        if (!$this->plan) {
            return false;
        }

        return match($feature) {
            'whatsapp' => $this->plan->whatsapp_enabled,
            'whatsapp_own_number' => $this->plan->whatsapp_own_number,
            'analytics' => $this->plan->analytics_enabled,
            'multi_unit' => $this->plan->multi_unit_enabled,
            'api_access' => $this->plan->api_access,
            'priority_support' => $this->plan->priority_support,
            default => false,
        };
    }

    /**
     * Check if tenant is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if tenant is on trial
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if tenant subscription has expired
     */
    public function subscriptionExpired(): bool
    {
        return $this->subscription_ends_at && $this->subscription_ends_at->isPast();
    }

    /**
     * Get WhatsApp configuration for this tenant
     */
    public function getWhatsAppConfig(): array
    {
        return [
            'enabled' => $this->whatsapp_enabled && $this->hasFeature('whatsapp'),
            'api_url' => $this->whatsapp_api_url,
            'instance' => $this->whatsapp_instance,
            'token' => $this->whatsapp_token,
            'client_token' => $this->whatsapp_client_token,
        ];
    }

    /**
     * Get clinic logo URL (with fallback)
     */
    public function getClinicLogoAttribute()
    {
        return $this->logo_url;
    }

    /**
     * Get clinic subtitle (computed from other fields if not set)
     */
    public function getClinicSubtitleAttribute()
    {
        return $this->attributes['clinic_subtitle'] ?? $this->city . ', ' . $this->state;
    }

    /**
     * Get clinic description (with fallback)
     */
    public function getClinicDescriptionAttribute()
    {
        return $this->attributes['clinic_description'] ?? 'Oferecemos serviços completos de vacinação com tecnologia moderna e atendimento humanizado.';
    }

    /**
     * Get contact info formatted
     */
    public function getContactInfoAttribute()
    {
        if (isset($this->attributes['contact_info']) && $this->attributes['contact_info']) {
            return $this->attributes['contact_info'];
        }

        $contact = [];
        if ($this->phone) $contact[] = "📞 " . $this->phone;
        if ($this->email) $contact[] = "✉️ " . $this->email;
        if ($this->address) $contact[] = "📍 " . $this->address;
        if ($this->city && $this->state) $contact[] = "    " . $this->city . ", " . $this->state;

        return implode("\n", $contact);
    }
}
