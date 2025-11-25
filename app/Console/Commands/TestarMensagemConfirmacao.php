<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class TestarMensagemConfirmacao extends Command
{
    protected $signature = 'whatsapp:testar-confirmacao {telefone}';
    protected $description = 'Envia mensagem de teste com modelo de confirmação';

    public function handle(WhatsAppService $whatsappService)
    {
        $telefone = $this->argument('telefone');
        
        $this->info("📱 Enviando modelo de confirmação para: {$telefone}");
        $this->newLine();

        // Mensagem completa formatada
        $mensagem = "🏥 *MultiImune - Lembrete de Vacinação*\n\n";
        $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $mensagem .= "📋 Olá, *{$this->getNome()}*!\n\n";
        $mensagem .= "📅 *AGENDAMENTO CONFIRMADO*\n\n";
        $mensagem .= "🗓 *Data:* " . Carbon::tomorrow()->format('d/m/Y') . "\n";
        $mensagem .= "🕐 *Horário:* 14:00\n";
        $mensagem .= "📍 *Local:* Sala de Vacinação - Térreo\n";
        $mensagem .= "⏱ *Duração:* Aproximadamente 30 minutos\n\n";
        $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $mensagem .= "💉 *VACINA AGENDADA*\n\n";
        $mensagem .= "🔹 Influenza (Gripe) - Dose Única\n";
        $mensagem .= "🔹 Campanha 2025\n";
        $mensagem .= "🔹 Validade: 12 meses\n\n";
        $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $mensagem .= "⏰ *IMPORTANTE*\n\n";
        $mensagem .= "✓ Seu agendamento é *AMANHÃ*!\n";
        $mensagem .= "✓ Chegue com 10 min de antecedência\n";
        $mensagem .= "✓ Traga documento de identidade\n";
        $mensagem .= "✓ Use máscara se possível\n";
        $mensagem .= "✓ Em jejum NÃO é necessário\n\n";
        $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $mensagem .= "❓ *CONFIRMAR PRESENÇA*\n\n";
        $mensagem .= "Por favor, responda esta mensagem com:\n\n";
        $mensagem .= "✅ *SIM* - para confirmar\n";
        $mensagem .= "❌ *NÃO* - para cancelar\n\n";
        $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $mensagem .= "📞 *Dúvidas?*\n";
        $mensagem .= "Entre em contato: (11) 9999-9999\n\n";
        $mensagem .= "🏥 *MultiImune*\n";
        $mensagem .= "_Saúde em primeiro lugar_ 💙";

        $this->info("📤 Enviando...");
        
        $resultado = $whatsappService->sendMessage($telefone, $mensagem);

        $this->newLine();
        
        if ($resultado['success']) {
            $this->info("✅ Mensagem enviada com sucesso!");
            $this->newLine();
            $this->line("📊 Detalhes:");
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['Telefone', $telefone],
                    ['Message ID', $resultado['data']['messageId'] ?? 'N/A'],
                    ['Status', 'Enviado'],
                    ['Formato', 'Texto com emojis e formatação'],
                ]
            );
            
            $this->newLine();
            $this->info("📱 Confira seu WhatsApp!");
            $this->info("💡 O paciente pode responder com SIM ou NÃO");
        } else {
            $this->error("❌ Erro ao enviar mensagem:");
            $this->error($resultado['message']);
            return 1;
        }

        return 0;
    }

    private function getNome()
    {
        return "Paciente"; // Em produção seria o nome real do banco
    }
}
