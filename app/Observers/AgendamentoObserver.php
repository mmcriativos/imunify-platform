<?php

namespace App\Observers;

use App\Models\Agendamento;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class AgendamentoObserver
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Disparado quando um agendamento é criado
     */
    public function created(Agendamento $agendamento)
    {
        // Só envia confirmação se tiver paciente e telefone
        if (!$agendamento->paciente || !$agendamento->paciente->telefone) {
            Log::info('Agendamento criado sem paciente/telefone', ['agendamento_id' => $agendamento->id]);
            return;
        }

        // Verificar se WhatsApp está disponível
        if (!$this->whatsappService->isAvailable() || !$this->whatsappService->hasQuota()) {
            Log::warning('WhatsApp não disponível para confirmação de agendamento', [
                'agendamento_id' => $agendamento->id,
                'available' => $this->whatsappService->isAvailable(),
                'has_quota' => $this->whatsappService->hasQuota()
            ]);
            return;
        }

        try {
            $this->enviarConfirmacaoImediata($agendamento);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar confirmação de agendamento', [
                'agendamento_id' => $agendamento->id,
                'erro' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envia confirmação imediata via WhatsApp
     */
    protected function enviarConfirmacaoImediata(Agendamento $agendamento)
    {
        $paciente = $agendamento->paciente;
        $dataFormatada = $agendamento->data_inicio->format('d/m/Y');
        $horaFormatada = $agendamento->data_inicio->format('H:i');
        
        $mensagem = "Olá, {$paciente->nome}! 👋\n\n";
        $mensagem .= "✅ *Agendamento Confirmado*\n\n";
        $mensagem .= "📅 *Data:* {$dataFormatada}\n";
        $mensagem .= "🕐 *Horário:* {$horaFormatada}\n";
        
        if ($agendamento->titulo) {
            $mensagem .= "💉 *Vacina/Serviço:* {$agendamento->titulo}\n";
        }
        
        if ($agendamento->local) {
            $mensagem .= "📍 *Local:* {$agendamento->local}\n";
        }
        
        $mensagem .= "\n📲 Você receberá lembretes automáticos:\n";
        $mensagem .= "• 7 dias antes\n";
        $mensagem .= "• 1 dia antes\n";
        $mensagem .= "• No dia do atendimento\n\n";
        $mensagem .= "Qualquer dúvida, entre em contato conosco!";

        $telefone = preg_replace('/[^0-9]/', '', $paciente->telefone);
        
        Log::info('Enviando confirmação de agendamento', [
            'agendamento_id' => $agendamento->id,
            'paciente_id' => $paciente->id,
            'telefone' => $telefone
        ]);

        $resultado = $this->whatsappService->sendMessage($telefone, $mensagem);

        if ($resultado) {
            Log::info('Confirmação enviada com sucesso', [
                'agendamento_id' => $agendamento->id,
            ]);
        } else {
            Log::warning('Falha ao enviar confirmação', [
                'agendamento_id' => $agendamento->id,
            ]);
        }
    }
}
