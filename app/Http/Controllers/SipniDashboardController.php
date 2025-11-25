<?php

namespace App\Http\Controllers;

use App\Models\SipniExport;
use App\Services\SipniExportService;
use Illuminate\Http\Request;

class SipniDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = SipniExport::with(['paciente', 'vacina', 'usuario'])
            ->latest();

        // Filtros
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->data_inicio) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->data_fim) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $exports = $query->paginate(20);

        // Estatísticas
        $sipniService = new SipniExportService();
        $stats = $sipniService->estatisticas();

        return view('sipni.dashboard', compact('exports', 'stats'));
    }

    public function show(SipniExport $export)
    {
        $export->load(['paciente', 'vacina', 'atendimento', 'usuario']);

        return view('sipni.show', compact('export'));
    }

    public function retry(SipniExport $export)
    {
        if (!$export->podeRetentar()) {
            return redirect()
                ->back()
                ->with('error', 'Esta exportação já atingiu o limite de tentativas');
        }

        try {
            $sipniService = new SipniExportService();
            $sucesso = $sipniService->processar($export);

            if ($sucesso) {
                return redirect()
                    ->back()
                    ->with('success', 'Exportação reenviada com sucesso!');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Erro ao reenviar exportação. Verifique os logs.');
            }

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro: ' . $e->getMessage());
        }
    }

    public function retryAll()
    {
        try {
            $sipniService = new SipniExportService();
            $resultados = $sipniService->reprocessarErros();

            return redirect()
                ->back()
                ->with('success', "Reprocessados: {$resultados['processados']} | Sucesso: {$resultados['sucesso']} | Erro: {$resultados['erro']}");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro: ' . $e->getMessage());
        }
    }
}
