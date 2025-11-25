<?php

namespace App\Observers;

use App\Models\AtendimentoVacina;
use App\Services\SipniExportService;
use Illuminate\Support\Facades\Log;

class AtendimentoVacinaObserver
{
    /**
     * Handle the AtendimentoVacina "created" event.
     */
    public function created(AtendimentoVacina $atendimentoVacina): void
    {
        // Verificar se módulo SIPNI está ativo
        if (!SipniExportService::isEnabled()) {
            return;
        }

        try {
            $sipniService = new SipniExportService();
            $export = $sipniService->exportarVacinacao($atendimentoVacina);

            if ($export) {
                Log::info('SIPNI: Exportação automática iniciada', [
                    'atendimento_vacina_id' => $atendimentoVacina->id,
                    'export_id' => $export->id,
                ]);
            }

        } catch (\Exception $e) {
            // Não bloquear o cadastro em caso de erro
            Log::error('SIPNI: Erro ao iniciar exportação automática', [
                'atendimento_vacina_id' => $atendimentoVacina->id,
                'erro' => $e->getMessage(),
            ]);
        }
    }
}
