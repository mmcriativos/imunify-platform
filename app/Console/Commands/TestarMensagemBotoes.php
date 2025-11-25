<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class TestarMensagemBotoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:testar-botoes {telefone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia mensagem de teste com botões interativos';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $telefone = $this->argument('telefone');
        
        $this->info("📱 Enviando mensagem com botões para: {$telefone}");
        $this->newLine();

        // Mensagem exemplo de lembrete
        $mensagem = "🏥 *MultiImune - Lembrete de Vacinação*\n\n";
        $mensagem .= "📋 Olá, Paciente!\n\n";
        $mensagem .= "📅 *Agendamento:*\n";
        $mensagem .= "🗓 Data: " . Carbon::tomorrow()->format('d/m/Y') . "\n";
        $mensagem .= "🕐 Horário: 14:00\n";
        $mensagem .= "📍 Local: Sala de Vacinação\n\n";
        $mensagem .= "💉 *Vacina Agendada:*\n";
        $mensagem .= "Influenza (Gripe) - Dose Única\n\n";
        $mensagem .= "⏰ *Seu agendamento é amanhã!*\n";
        $mensagem .= "Não esqueça de comparecer no horário marcado.\n\n";
        $mensagem .= "⚠️ *Importante:*\n";
        $mensagem .= "• Traga documento de identidade\n";
        $mensagem .= "• Chegue com 10 minutos de antecedência\n";
        $mensagem .= "• Use máscara se possível\n\n";
        $mensagem .= "---\n";
        $mensagem .= "🏥 MultiImune - Saúde em primeiro lugar\n\n";
        $mensagem .= "❓ *Você confirma sua presença?*\n";
        $mensagem .= "👇 Clique em uma das opções abaixo:";

        // Botões de confirmação
        $botoes = [
            ['id' => 'btn_confirmar', 'label' => '✅ Confirmar Presença'],
            ['id' => 'btn_cancelar', 'label' => '❌ Cancelar Agendamento']
        ];

        $this->info("📤 Enviando...");
        
        $resultado = $whatsappService->sendButtonMessage($telefone, $mensagem, $botoes);

        $this->newLine();
        
        if ($resultado['success']) {
            $this->info("✅ Mensagem com botões enviada com sucesso!");
            $this->newLine();
            $this->line("📊 Detalhes:");
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['Telefone', $telefone],
                    ['Message ID', $resultado['data']['messageId'] ?? 'N/A'],
                    ['Status', 'Enviado'],
                    ['Botões', '2 (Confirmar e Cancelar)'],
                ]
            );
        } else {
            $this->error("❌ Erro ao enviar mensagem:");
            $this->error($resultado['message']);
            return 1;
        }

        return 0;
    }
}
