<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone?} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o envio de mensagem WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $phone = $this->argument('phone');
        $message = $this->option('message');

        if (!$phone) {
            $phone = $this->ask('Digite o número de telefone (com DDD)');
        }

        if (!$message) {
            $message = '🧪 *Teste de Notificação - MultiImune*' . PHP_EOL . PHP_EOL .
                      '✅ Sistema de notificações WhatsApp configurado com sucesso!' . PHP_EOL . PHP_EOL .
                      '📱 Você receberá lembretes de vacinação automaticamente.' . PHP_EOL . PHP_EOL .
                      '_Enviado em: ' . now()->format('d/m/Y H:i:s') . '_';
        }

        $this->info('Verificando configuração...');
        
        if (!$whatsappService->isConfigured()) {
            $this->error('❌ WhatsApp não configurado! Verifique as variáveis no .env');
            return 1;
        }

        $this->info("📤 Enviando mensagem para: {$phone}");
        $this->info("Aguarde...");

        $result = $whatsappService->sendMessage($phone, $message);

        if ($result['success']) {
            $this->info('');
            $this->info('✅ Mensagem enviada com sucesso!');
            $this->info('');
            $this->line('Detalhes:');
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['Status', '✅ Sucesso'],
                    ['Telefone', $phone],
                    ['Mensagem', $result['message'] ?? 'Enviado'],
                ]
            );
            
            if (isset($result['data'])) {
                $this->info('');
                $this->line('Resposta da API:');
                $this->line(json_encode($result['data'], JSON_PRETTY_PRINT));
            }
            
            return 0;
        } else {
            $this->error('');
            $this->error('❌ Erro ao enviar mensagem');
            $this->error('Motivo: ' . ($result['message'] ?? 'Erro desconhecido'));
            $this->error('');
            return 1;
        }
    }
}
