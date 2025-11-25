<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembrete;
use App\Models\Paciente;
use Illuminate\Support\Facades\Artisan;

class LembreteController extends Controller
{
    public function index()
    {
        $lembretes = Lembrete::with('paciente')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        $estatisticas = [
            'total' => Lembrete::count(),
            'pendentes' => Lembrete::where('status', 'pendente')->count(),
            'enviados' => Lembrete::where('status', 'enviado')->count(),
            'erros' => Lembrete::where('status', 'erro')->count(),
        ];
        
        return view('lembretes.index', compact('lembretes', 'estatisticas'));
    }

    public function processar()
    {
        Artisan::call('lembretes:enviar');
        
        return redirect()->route('lembretes.index')
            ->with('success', 'Lembretes processados com sucesso!');
    }

    public function simular()
    {
        // Capturar output do comando
        Artisan::call('lembretes:enviar', ['--dry-run' => true]);
        $output = Artisan::output();
        
        // Processar output para HTML
        $linhas = explode("\n", trim($output));
        $outputHtml = '<div class="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm overflow-x-auto">';
        foreach ($linhas as $linha) {
            if (!empty(trim($linha))) {
                $outputHtml .= '<div>' . htmlspecialchars($linha) . '</div>';
            }
        }
        $outputHtml .= '</div>';
        
        return redirect()->route('lembretes.index')
            ->with('simulation_output', $outputHtml);
    }
}
