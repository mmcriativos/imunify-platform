<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SharedWhatsAppService
{
    private ZApiService $zapi;
    private string $clinicName;

    public function __construct()
    {
        // Credenciais do número compartilhado do Imunify (centralizadas no .env)
        $instanceId = config('services.zapi.shared_instance_id');
        $token = config('services.zapi.shared_token');
        $clientToken = config('services.zapi.shared_client_token');

        $this->zapi = new ZApiService($instanceId, $token, $clientToken);
        $this->clinicName = tenant('clinic_name') ?? tenant('id');
    }

    /**
     * Envia mensagem via número compartilhado do Imunify
     * Adiciona identificação da clínica no início da mensagem
     */
    public function sendMessage(string $phone, string $message): bool
    {
        // Adiciona identificação da clínica
        $fullMessage = $this->formatMessage($message);

        return $this->zapi->sendMessage($phone, $fullMessage);
    }

    /**
     * Envia imagem via número compartilhado
     */
    public function sendImage(string $phone, string $imageUrl, ?string $caption = null): bool
    {
        // Adiciona identificação da clínica no caption
        $fullCaption = $caption ? $this->formatMessage($caption) : $this->getClinicBadge();

        return $this->zapi->sendImage($phone, $imageUrl, $fullCaption);
    }

    /**
     * Formata mensagem adicionando badge da clínica
     */
    private function formatMessage(string $message): string
    {
        $badge = $this->getClinicBadge();
        return "{$badge}\n\n{$message}";
    }

    /**
     * Retorna o badge de identificação da clínica
     */
    private function getClinicBadge(): string
    {
        return "🏥 *{$this->clinicName}*";
    }

    /**
     * Verifica se o serviço compartilhado está configurado
     */
    public function isConfigured(): bool
    {
        return $this->zapi->isConfigured();
    }

    /**
     * Obtém informações sobre o serviço
     */
    public function getInfo(): array
    {
        return [
            'mode' => 'shared',
            'clinic_name' => $this->clinicName,
            'configured' => $this->isConfigured(),
        ];
    }
}
