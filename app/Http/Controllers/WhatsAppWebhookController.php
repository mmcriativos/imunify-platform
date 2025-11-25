<?php

namespace App\Http\Controllers;

use App\Models\ConfirmacaoPresenca;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Recebe callback quando paciente responde mensagem com botões
     */
    public function receberResposta(Request $request)
    {
        try {
            // Log completo do webhook para debug
            Log::info('Webhook Z-API recebido', [
                'body' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Z-API envia dados em formato específico
            $data = $request->all();
            
            // Extrair informações da resposta
            $messageId = $data['messageId'] ?? $data['key']['id'] ?? null;
            $phone = $data['phone'] ?? $data['key']['remoteJid'] ?? null;
            $responseText = $data['selectedButtonId'] ?? $data['text'] ?? null;
            
            if (!$messageId || !$phone || !$responseText) {
                Log::warning('Webhook com dados incompletos', $data);
                return response()->json(['status' => 'ignored', 'reason' => 'dados incompletos']);
            }

            // Limpar formato do telefone
            $phone = preg_replace('/[^0-9]/', '', $phone);

            // Buscar confirmação pendente por message_id ou telefone
            $confirmacao = ConfirmacaoPresenca::where('message_id', $messageId)
                ->orWhere(function($query) use ($phone) {
                    $query->where('telefone', 'like', "%{$phone}%")
                          ->where('status', 'pendente');
                })
                ->orderBy('enviado_em', 'desc')
                ->first();

            if (!$confirmacao) {
                Log::warning('Confirmação não encontrada para resposta', [
                    'messageId' => $messageId,
                    'phone' => $phone
                ]);
                return response()->json(['status' => 'ignored', 'reason' => 'confirmação não encontrada']);
            }

            // Processar resposta do botão
            $novoStatus = $this->processarResposta($responseText);
            
            if ($novoStatus) {
                $confirmacao->update([
                    'status' => $novoStatus,
                    'resposta_botao' => $responseText,
                    'respondido_em' => now()
                ]);

                // Atualizar status do agendamento se for cancelamento
                if ($novoStatus === 'cancelado') {
                    $agendamento = $confirmacao->agendamento;
                    if ($agendamento) {
                        $agendamento->update(['status' => 'cancelado']);
                        Log::info("Agendamento #{$agendamento->id} cancelado via WhatsApp");
                    }
                }

                Log::info('Confirmação atualizada com sucesso', [
                    'confirmacao_id' => $confirmacao->id,
                    'status' => $novoStatus,
                    'agendamento_id' => $confirmacao->agendamento_id
                ]);

                return response()->json([
                    'status' => 'success',
                    'confirmacao_id' => $confirmacao->id,
                    'novo_status' => $novoStatus
                ]);
            }

            return response()->json(['status' => 'ignored', 'reason' => 'resposta não reconhecida']);

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook Z-API: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa texto da resposta e retorna novo status
     */
    private function processarResposta(string $resposta): ?string
    {
        $resposta = strtolower(trim($resposta));

        // Mapeamento de IDs de botões ou palavras-chave
        $confirmacao = ['btn_confirmar', 'confirmar', 'sim', 'confirmado', 'vou', 'estarei'];
        $cancelamento = ['btn_cancelar', 'cancelar', 'nao', 'não', 'desmarcar', 'cancelado'];

        foreach ($confirmacao as $keyword) {
            if (str_contains($resposta, $keyword)) {
                return 'confirmado';
            }
        }

        foreach ($cancelamento as $keyword) {
            if (str_contains($resposta, $keyword)) {
                return 'cancelado';
            }
        }

        return null;
    }

    /**
     * Endpoint de teste para webhook
     */
    public function teste(Request $request)
    {
        Log::info('Webhook teste chamado', $request->all());
        
        return response()->json([
            'status' => 'ok',
            'message' => 'Webhook funcionando',
            'timestamp' => now()->toISOString(),
            'received_data' => $request->all()
        ]);
    }
}

