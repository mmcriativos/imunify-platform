<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppConnection;
use App\Services\WhatsAppService;
use App\Services\ZApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WhatsAppConfigController extends Controller
{
    protected $whatsappService = null;

    /**
     * Obtém a instância do WhatsAppService (lazy loading)
     */
    private function getWhatsAppService(): WhatsAppService
    {
        if ($this->whatsappService === null) {
            $this->whatsappService = new WhatsAppService();
        }
        return $this->whatsappService;
    }

    /**
     * Busca o plano do tenant atual no banco central
     */
    private function getTenantPlan()
    {
        $tenantId = tenant()->id;
        
        // Busca o tenant model que acessa o campo 'data' corretamente
        $tenantModel = \App\Models\Tenant::find($tenantId);
        
        if (!$tenantModel || !$tenantModel->plan_id) {
            abort(500, 'Plano não encontrado para este tenant');
        }
        
        // Busca o plano usando query raw no banco central
        $centralDb = config('database.connections.mysql.database');
        
        $plans = DB::select("
            SELECT * FROM `{$centralDb}`.plans WHERE id = ?
        ", [$tenantModel->plan_id]);
        
        if (empty($plans)) {
            abort(500, 'Plano não encontrado para este tenant');
        }
        
        return (object) $plans[0];
    }

    /**
     * Exibe a página de configuração do WhatsApp
     */
    public function index()
    {
        $plan = $this->getTenantPlan();
        
        // Busca ou cria a conexão WhatsApp para o tenant (sem tenant_id pois já está no DB do tenant)
        $connection = WhatsAppConnection::firstOrCreate(
            ['id' => 1], // ID fixo, apenas uma conexão por tenant
            [
                'mode' => $plan->whatsapp_mode,
                'status' => 'connected',
                'messages_sent_month' => 0,
                'messages_quota' => $plan->whatsapp_quota,
                'quota_unlimited' => $plan->whatsapp_unlimited,
                'quota_reset_date' => now()->addMonth(),
            ]
        );

        // Sincroniza quota com o plano atual
        $connection->syncQuotaFromPlan();

        // Obtém informações de uso
        $usageInfo = $this->getWhatsAppService()->getUsageInfo();

        return view('whatsapp.config', [
            'plan' => $plan,
            'connection' => $connection,
            'usageInfo' => $usageInfo,
            'isAvailable' => $this->getWhatsAppService()->isAvailable(),
        ]);
    }

    /**
     * Inicia o processo de conexão para planos com número próprio
     */
    public function connect(Request $request)
    {
        $plan = $this->getTenantPlan();

        // Verifica se o plano permite número próprio
        if ($plan->whatsapp_mode !== 'own') {
            return response()->json([
                'success' => false,
                'message' => 'Seu plano não permite configurar um número próprio de WhatsApp. Faça upgrade para Premium ou Enterprise.',
            ], 403);
        }

        $request->validate([
            'zapi_instance_id' => 'required|string',
            'zapi_token' => 'required|string',
            'zapi_client_token' => 'required|string',
        ]);

        try {
            // Busca ou cria a conexão (sem tenant_id)
            $connection = WhatsAppConnection::firstOrNew(['id' => 1]);
            
            // Atualiza as credenciais
            $connection->mode = 'own';
            $connection->zapi_instance_id = $request->zapi_instance_id;
            $connection->zapi_token = $request->zapi_token;
            $connection->zapi_client_token = $request->zapi_client_token;
            $connection->status = 'qrcode';
            $connection->save();

            // Cria instância do serviço Z-API
            $zapiService = new ZApiService(
                $connection->zapi_instance_id,
                $connection->zapi_token,
                $connection->zapi_client_token
            );

            // Obtém o QR Code
            $qrcodeData = $zapiService->getQRCode();

            if ($qrcodeData && isset($qrcodeData['qrcode'])) {
                // Salva o QR Code na conexão
                $connection->qrcode_base64 = $qrcodeData['qrcode'];
                $connection->save();

                return response()->json([
                    'success' => true,
                    'message' => 'QR Code gerado com sucesso. Escaneie com seu WhatsApp.',
                    'qrcode' => $qrcodeData['qrcode'],
                    'status' => $qrcodeData['status'] ?? 'qrcode',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Não foi possível gerar o QR Code. Verifique suas credenciais Z-API.',
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao conectar WhatsApp', [
                'tenant_id' => tenant()->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao conectar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verifica o status da conexão
     */
    public function checkStatus()
    {
        try {
            $status = $this->getWhatsAppService()->checkConnection();

            return response()->json([
                'success' => true,
                'status' => $status,
                'is_connected' => $status === 'connected',
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao verificar status do WhatsApp', [
                'tenant_id' => tenant()->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Envia uma mensagem de teste
     */
    public function sendTest(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'message' => 'required|string|max:1000',
        ]);

        try {
            if (!$this->getWhatsAppService()->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'WhatsApp não está disponível. Verifique sua configuração ou plano.',
                ], 400);
            }

            if (!$this->getWhatsAppService()->hasQuota()) {
                $usageInfo = $this->getWhatsAppService()->getUsageInfo();
                return response()->json([
                    'success' => false,
                    'message' => 'Quota de mensagens esgotada. Faça upgrade do seu plano.',
                    'usage' => $usageInfo,
                ], 429);
            }

            $result = $this->getWhatsAppService()->sendMessage(
                $request->phone,
                $request->message
            );

            if ($result) {
                $usageInfo = $this->getWhatsAppService()->getUsageInfo();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Mensagem de teste enviada com sucesso!',
                    'usage' => $usageInfo,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao enviar mensagem. Verifique os logs.',
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem de teste', [
                'tenant_id' => tenant()->id,
                'phone' => $request->phone,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar mensagem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Desconecta o WhatsApp (apenas para modo 'own')
     */
    public function disconnect()
    {
        $tenant = tenant();
        $connection = WhatsAppConnection::first();

        if (!$connection || $connection->mode !== 'own') {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma conexão própria encontrada para desconectar.',
            ], 400);
        }

        try {
            if ($connection->isConnected()) {
                $zapiService = new ZApiService(
                    $connection->zapi_instance_id,
                    $connection->zapi_token,
                    $connection->zapi_client_token
                );

                $zapiService->disconnect();
            }

            // Limpa os dados da conexão
            $connection->status = 'disconnected';
            $connection->qrcode_base64 = null;
            $connection->phone_number = null;
            $connection->save();

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp desconectado com sucesso.',
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao desconectar WhatsApp', [
                'tenant_id' => $tenant->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao desconectar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exibe informações de uso e quota
     */
    public function usage()
    {
        try {
            $usageInfo = $this->getWhatsAppService()->getUsageInfo();

            return response()->json([
                'success' => true,
                'usage' => $usageInfo,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao obter informações de uso', [
                'tenant_id' => tenant()->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter informações: ' . $e->getMessage(),
            ], 500);
        }
    }
}
