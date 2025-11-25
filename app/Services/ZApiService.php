<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZApiService
{
    private string $baseUrl;
    private string $instanceId;
    private string $token;
    private ?string $clientToken;

    public function __construct(string $instanceId, string $token, ?string $clientToken = null)
    {
        $this->baseUrl = 'https://api.z-api.io';
        $this->instanceId = $instanceId;
        $this->token = $token;
        $this->clientToken = $clientToken;
    }

    /**
     * Gera QR Code para conexÃ£o
     */
    public function getQRCode(): ?string
    {
        try {
            $url = "{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/qr-code/image";
            
            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                // Z-API retorna a imagem diretamente
                return base64_encode($response->body());
            }

            Log::error('Erro ao obter QR Code da Z-API', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('ExceÃ§Ã£o ao obter QR Code da Z-API', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Verifica status da conexÃ£o
     */
    public function checkConnection(): array
    {
        try {
            $url = "{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/status";
            
            $response = Http::withoutVerifying()->timeout(10)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'connected' => $data['connected'] ?? false,
                    'phone_number' => $data['phoneNumber'] ?? null,
                    'status' => $data['status'] ?? 'unknown',
                ];
            }

            return [
                'connected' => false,
                'phone_number' => null,
                'status' => 'error',
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao verificar status Z-API', [
                'message' => $e->getMessage(),
            ]);

            return [
                'connected' => false,
                'phone_number' => null,
                'status' => 'error',
            ];
        }
    }

    /**
     * Envia mensagem de texto
     */
    public function sendMessage(string $phone, string $message): bool
    {
        try {
            $url = "{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/send-text";
            
            $headers = [];
            if ($this->clientToken) {
                $headers['Client-Token'] = $this->clientToken;
            }
            
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders($headers)
                ->post($url, [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                ]);

            if ($response->successful()) {
                Log::info('Mensagem WhatsApp enviada via Z-API', [
                    'phone' => $phone,
                    'instance' => $this->instanceId,
                ]);
                return true;
            }

            Log::error('Erro ao enviar mensagem via Z-API', [
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Exceção ao enviar mensagem via Z-API', [
                'phone' => $phone,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envia mensagem com mídia (imagem)
     */
    public function sendImage(string $phone, string $imageUrl, ?string $caption = null): bool
    {
        try {
            $url = "{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/send-image";
            
            $payload = [
                'phone' => $this->formatPhone($phone),
                'image' => $imageUrl,
            ];

            if ($caption) {
                $payload['caption'] = $caption;
            }

            $headers = [];
            if ($this->clientToken) {
                $headers['Client-Token'] = $this->clientToken;
            }

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders($headers)
                ->post($url, $payload);

            if ($response->successful()) {
                Log::info('Imagem WhatsApp enviada via Z-API', [
                    'phone' => $phone,
                ]);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar imagem via Z-API', [
                'phone' => $phone,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Desconecta a instÃ¢ncia
     */
    public function disconnect(): bool
    {
        try {
            $url = "{$this->baseUrl}/instances/{$this->instanceId}/token/{$this->token}/disconnect";
            
            $response = Http::timeout(10)->delete($url);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Erro ao desconectar Z-API', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Formata nÃºmero de telefone para padrÃ£o Z-API
     * Formato: 5511999999999 (DDI + DDD + NÃºmero)
     */
    private function formatPhone(string $phone): string
    {
        // Remove tudo que nÃ£o Ã© nÃºmero
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Se nÃ£o comeÃ§a com 55, adiciona
        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }

        return $phone;
    }

    /**
     * Valida se as credenciais estÃ£o configuradas
     */
    public function isConfigured(): bool
    {
        return !empty($this->instanceId) && !empty($this->token);
    }
}
