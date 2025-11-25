<?php

namespace App\Services;

use App\Models\WhatsAppConnection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WhatsAppService
{
    private ?WhatsAppConnection $connection = null;
    private $service = null;
    private bool $initialized = false;

    /**
     * Busca o plano do tenant atual no banco central
     */
    private function getTenantPlan()
    {
        $tenant = tenant();
        
        if (!$tenant) {
            return null;
        }
        
        // Busca o tenant model que acessa o campo 'data' corretamente
        $tenantModel = \App\Models\Tenant::find($tenant->id);
        
        if (!$tenantModel || !$tenantModel->plan_id) {
            return null;
        }
        
        // Busca o plano usando query raw no banco central
        $centralDb = config('database.connections.mysql.database');
        
        $plans = DB::select("
            SELECT * FROM `{$centralDb}`.plans WHERE id = ?
        ", [$tenantModel->plan_id]);
        
        return !empty($plans) ? (object) $plans[0] : null;
    }

    /**
     * Garante que o service foi inicializado (lazy initialization)
     */
    private function ensureInitialized(): void
    {
        if ($this->initialized) {
            return;
        }
        
        $this->initializeService();
        $this->initialized = true;
    }

    /**
     * Inicializa o service correto baseado no plano do tenant
     */
    private function initializeService(): void
    {
        $tenant = tenant();
        
        if (!$tenant) {
            Log::warning('WhatsAppService: Tenant não inicializado');
            return;
        }

        $plan = $this->getTenantPlan();
        
        if (!$plan || $plan->whatsapp_mode === 'none') {
            Log::info('WhatsAppService: Plano sem WhatsApp habilitado');
            return;
        }

        // Buscar ou criar conexão
        $this->connection = WhatsAppConnection::firstOrNew();

        // Se as credenciais não estiverem na conexão do tenant, tentar carregar do registro central do tenant (compatibilidade)
        try {
            $tenantModel = \App\Models\Tenant::find(tenant()->id);
            if ($tenantModel) {
                // Copiar instance/token/client token do tenant central para a conexão local se estiverem ausentes
                $needSave = false;
                if (empty($this->connection->zapi_instance_id) && !empty($tenantModel->whatsapp_instance)) {
                    $this->connection->zapi_instance_id = $tenantModel->whatsapp_instance;
                    $needSave = true;
                }
                if (empty($this->connection->zapi_token) && !empty($tenantModel->whatsapp_token)) {
                    $this->connection->zapi_token = $tenantModel->whatsapp_token;
                    $needSave = true;
                }
                if (empty($this->connection->zapi_client_token) && !empty($tenantModel->whatsapp_client_token)) {
                    $this->connection->zapi_client_token = $tenantModel->whatsapp_client_token;
                    $needSave = true;
                }

                if ($needSave) {
                    $this->connection->save();
                }
            }
        } catch (\Exception $e) {
            Log::warning('WhatsAppService: falha ao carregar credenciais do tenant central', ['error' => $e->getMessage()]);
        }
        
        // Sincronizar quota com o plano
        if (!$this->connection->exists || $this->connection->mode !== $plan->whatsapp_mode) {
            $this->connection->syncQuotaFromPlan();
        }

        // Inicializar service baseado no modo
        if ($plan->whatsapp_mode === 'shared') {
            $this->service = new SharedWhatsAppService();
        } elseif ($plan->whatsapp_mode === 'own') {
            // Verificar se tem credenciais configuradas
            if ($this->connection->zapi_instance_id && $this->connection->zapi_token) {
                $this->service = new ZApiService(
                    $this->connection->zapi_instance_id,
                    $this->connection->zapi_token,
                    $this->connection->zapi_client_token
                );
            } else {
                Log::warning('WhatsAppService: Modo own mas sem credenciais Z-API configuradas');
            }
        }
    }

    /**
     * Verifica se o WhatsApp está disponível e configurado
     */
    public function isAvailable(): bool
    {
        $this->ensureInitialized();
        return $this->service !== null;
    }

    /**
     * Verifica se tem quota disponível
     */
    public function hasQuota(): bool
    {
        $this->ensureInitialized();
        
        if (!$this->connection) {
            return false;
        }

        return $this->connection->hasQuota();
    }

    /**
     * Envia mensagem via WhatsApp
     */
    public function sendMessage(string $phone, string $message): bool
    {
        $this->ensureInitialized();
        
        if (!$this->isAvailable()) {
            Log::warning('WhatsAppService: Serviço não disponível', ['phone' => $phone]);
            return false;
        }

        if (!$this->hasQuota()) {
            Log::warning('WhatsAppService: Quota de mensagens esgotada', [
                'phone' => $phone,
                'used' => $this->connection->messages_sent_month,
                'limit' => $this->connection->messages_quota,
            ]);
            return false;
        }

        try {
            $success = $this->service->sendMessage($phone, $message);
            
            if ($success && $this->connection) {
                $this->connection->incrementMessageCount();
                
                Log::info('WhatsAppService: Mensagem enviada', [
                    'phone' => $phone,
                    'mode' => $this->connection->mode,
                    'quota_used' => $this->connection->messages_sent_month,
                    'quota_limit' => $this->connection->messages_quota,
                ]);
            }
            
            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsAppService: Erro ao enviar mensagem', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envia imagem via WhatsApp
     */
    public function sendImage(string $phone, string $imageUrl, ?string $caption = null): bool
    {
        $this->ensureInitialized();
        
        if (!$this->isAvailable()) {
            return false;
        }

        if (!$this->hasQuota()) {
            Log::warning('WhatsAppService: Quota esgotada para envio de imagem');
            return false;
        }

        try {
            $success = $this->service->sendImage($phone, $imageUrl, $caption);
            
            if ($success && $this->connection) {
                $this->connection->incrementMessageCount();
            }
            
            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsAppService: Erro ao enviar imagem', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Obtém informações sobre o uso
     */
    public function getUsageInfo(): array
    {
        $this->ensureInitialized();
        
        if (!$this->connection) {
            return [
                'available' => false,
                'mode' => 'none',
                'sent' => 0,
                'quota' => 0,
                'remaining' => 0,
                'quota_unlimited' => false,
                'has_quota' => false,
                'percentage' => 0,
                'status' => 'disconnected',
                'phone_number' => null,
            ];
        }

        $hasQuota = $this->connection->quota_unlimited || $this->connection->getRemainingMessages() > 0;
        
        // Calcular percentual
        $percentage = 0;
        if (!$this->connection->quota_unlimited && $this->connection->messages_quota > 0) {
            $percentage = round(($this->connection->messages_sent_month / $this->connection->messages_quota) * 100, 1);
        }

        return [
            'available' => $this->isAvailable(),
            'mode' => $this->connection->mode,
            'sent' => $this->connection->messages_sent_month,
            'quota' => $this->connection->messages_quota,
            'remaining' => $this->connection->getRemainingMessages(),
            'quota_unlimited' => $this->connection->quota_unlimited,
            'has_quota' => $hasQuota,
            'percentage' => $percentage,
            'status' => $this->connection->status,
            'phone_number' => $this->connection->phone_number,
        ];
    }

    /**
     * Verifica se está configurado (legado - manter compatibilidade)
     */
    public function isConfigured(): bool
    {
        return $this->isAvailable();
    }

    /**
     * Verifica status da conexão
     */
    public function checkConnection(): array
    {
        $this->ensureInitialized();
        
        if (!$this->isAvailable()) {
            return [
                'success' => false,
                'message' => 'WhatsApp não configurado ou plano sem suporte',
            ];
        }

        try {
            if ($this->connection->isOwnNumber() && $this->service instanceof ZApiService) {
                $status = $this->service->checkConnection();
                
                // Atualizar status da conexão
                if ($status['connected']) {
                    $this->connection->update([
                        'status' => 'connected',
                        'phone_number' => $status['phone_number'],
                        'connected_at' => now(),
                        'last_check_at' => now(),
                    ]);
                } else {
                    $this->connection->update([
                        'status' => 'disconnected',
                        'last_check_at' => now(),
                    ]);
                }
                
                return [
                    'success' => $status['connected'],
                    'message' => $status['connected'] ? 'Conectado' : 'Desconectado',
                    'phone_number' => $status['phone_number'],
                ];
            }
            
            // Para modo shared, sempre retorna conectado se o service existe
            return [
                'success' => true,
                'message' => 'Número compartilhado Imunify',
                'mode' => 'shared',
            ];
        } catch (\Exception $e) {
            Log::error('WhatsAppService: Erro ao verificar conexão', [
                'error' => $e->getMessage(),
            ]);
            
            return [
                'success' => false,
                'message' => 'Erro ao verificar conexão: ' . $e->getMessage(),
            ];
        }
    }
}
