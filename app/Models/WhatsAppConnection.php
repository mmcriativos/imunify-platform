<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppConnection extends Model
{
    protected $table = 'whatsapp_connections';
    
    protected $fillable = [
        'mode',
        'zapi_instance_id',
        'zapi_token',
        'zapi_client_token',
        'status',
        'phone_number',
        'qrcode_base64',
        'connected_at',
        'last_check_at',
        'messages_sent_month',
        'messages_quota',
        'quota_unlimited',
        'quota_reset_date',
    ];

    protected $casts = [
        'connected_at' => 'datetime',
        'last_check_at' => 'datetime',
        'quota_reset_date' => 'date',
        'quota_unlimited' => 'boolean',
        'messages_sent_month' => 'integer',
        'messages_quota' => 'integer',
    ];

    /**
     * Verifica se está conectado
     */
    public function isConnected(): bool
    {
        return $this->status === 'connected';
    }

    /**
     * Verifica se está em modo 'own' (número próprio)
     */
    public function isOwnNumber(): bool
    {
        return $this->mode === 'own';
    }

    /**
     * Verifica se está em modo 'shared' (número compartilhado)
     */
    public function isSharedNumber(): bool
    {
        return $this->mode === 'shared';
    }

    /**
     * Verifica se tem quota disponível
     */
    public function hasQuota(): bool
    {
        if ($this->quota_unlimited) {
            return true;
        }

        // Resetar contador se mudou o mês
        if ($this->quota_reset_date && $this->quota_reset_date->isPast()) {
            $this->resetMonthlyQuota();
        }

        return $this->messages_sent_month < $this->messages_quota;
    }

    /**
     * Obtém mensagens restantes no mês
     */
    public function getRemainingMessages(): int
    {
        if ($this->quota_unlimited) {
            return PHP_INT_MAX;
        }

        return max(0, $this->messages_quota - $this->messages_sent_month);
    }

    /**
     * Incrementa contador de mensagens
     */
    public function incrementMessageCount(): void
    {
        $this->increment('messages_sent_month');
    }

    /**
     * Reseta contador mensal
     */
    public function resetMonthlyQuota(): void
    {
        $this->update([
            'messages_sent_month' => 0,
            'quota_reset_date' => now()->addMonth()->startOfMonth(),
        ]);
    }

    /**
     * Sincroniza quota com o plano do tenant
     */
    public function syncQuotaFromPlan(): void
    {
        $tenant = tenant();
        $plan = $tenant->plan;

        if (!$plan) {
            return;
        }

        $this->update([
            'mode' => $plan->whatsapp_mode === 'own' ? 'own' : 'shared',
            'messages_quota' => $plan->whatsapp_quota,
            'quota_unlimited' => $plan->whatsapp_unlimited,
        ]);

        // Inicializar data de reset se não existir
        if (!$this->quota_reset_date) {
            $this->update([
                'quota_reset_date' => now()->addMonth()->startOfMonth(),
            ]);
        }
    }
}
