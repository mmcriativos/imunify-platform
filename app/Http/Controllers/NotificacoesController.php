<?php

namespace App\Http\Controllers;

use App\Models\Lembrete;
use App\Models\Paciente;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificacoesController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index(Request $request)
    {
        // Métricas do dia
        $enviadasHoje = Lembrete::whereDate('data_envio', today())
            ->where('status', 'enviado')
            ->count();

        $pendentes = Lembrete::where('status', 'pendente')->count();

        $falhasHoje = Lembrete::whereDate('created_at', today())
            ->where('status', 'erro')
            ->count();

        // Comparação com ontem
        $enviadasOntem = Lembrete::whereDate('data_envio', today()->subDay())
            ->where('status', 'enviado')
            ->count();
        
        $variacaoPercentual = $enviadasOntem > 0 
            ? round((($enviadasHoje - $enviadasOntem) / $enviadasOntem) * 100, 1)
            : 0;

        // Uso da quota
        $usageInfo = $this->whatsappService->getUsageInfo();

        // Dados do gráfico (últimos 7 dias)
        $chartData = $this->getChartData();

        // Taxa de sucesso (últimos 7 dias)
        $taxaSucesso = $this->getTaxaSucesso();

        // Histórico com filtros
        $query = Lembrete::with('paciente');

        // Filtro por período
        if ($request->filled('periodo')) {
            switch ($request->periodo) {
                case 'hoje':
                    $query->whereDate('created_at', today());
                    break;
                case 'ontem':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case '7dias':
                    $query->whereDate('created_at', '>=', today()->subDays(7));
                    break;
                case '30dias':
                    $query->whereDate('created_at', '>=', today()->subDays(30));
                    break;
            }
        } else {
            // Padrão: últimos 7 dias
            $query->whereDate('created_at', '>=', today()->subDays(7));
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Busca por nome do paciente
        if ($request->filled('busca')) {
            $query->whereHas('paciente', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->busca . '%');
            });
        }

        $lembretes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas adicionais
        $totalEnviados = Lembrete::whereDate('created_at', '>=', today()->subDays(7))
            ->where('status', 'enviado')
            ->count();

        return view('notificacoes.index', compact(
            'enviadasHoje',
            'pendentes',
            'falhasHoje',
            'variacaoPercentual',
            'usageInfo',
            'chartData',
            'taxaSucesso',
            'lembretes',
            'totalEnviados'
        ));
    }

    public function show($id)
    {
        $lembrete = Lembrete::with('paciente')->findOrFail($id);

        return response()->json([
            'paciente' => $lembrete->paciente->nome ?? 'N/A',
            'telefone' => $lembrete->paciente->telefone ?? 'N/A',
            'data_envio' => $lembrete->data_envio 
                ? $lembrete->data_envio->format('d/m/Y H:i:s') 
                : 'Não enviado',
            'mensagem' => $lembrete->mensagem,
            'status' => $lembrete->status,
            'erro_mensagem' => $lembrete->erro_mensagem
        ]);
    }

    public function reenviar($id)
    {
        $lembrete = Lembrete::with('paciente')->findOrFail($id);

        // Validar se paciente tem telefone
        if (!$lembrete->paciente->telefone) {
            return back()->with('error', '❌ Paciente não possui telefone cadastrado!');
        }

        // Limpar telefone
        $telefone = preg_replace('/[^0-9]/', '', $lembrete->paciente->telefone);

        // Validar número básico (Brasil: 11-13 dígitos)
        if (strlen($telefone) < 10 || strlen($telefone) > 13) {
            return back()->with('error', '❌ Número de telefone inválido: ' . $lembrete->paciente->telefone);
        }

        // Verificar quota
        if (!$this->whatsappService->hasQuota()) {
            return back()->with('error', '⚠️ Quota de mensagens esgotada! Faça upgrade do seu plano.');
        }

        try {
            // Enviar via WhatsApp
            $resultado = $this->whatsappService->sendMessage($telefone, $lembrete->mensagem);

            if ($resultado['success']) {
                // Atualizar lembrete
                $lembrete->update([
                    'status' => 'enviado',
                    'data_envio' => now(),
                    'erro_mensagem' => null
                ]);

                return back()->with('success', '✅ Mensagem reenviada com sucesso para ' . $lembrete->paciente->nome . '!');
            } else {
                return back()->with('error', '❌ Erro ao enviar: ' . $resultado['message']);
            }
        } catch (\Exception $e) {
            return back()->with('error', '❌ Erro ao enviar: ' . $e->getMessage());
        }
    }

    private function getChartData()
    {
        $dados = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $data = today()->subDays($i);
            $labels[] = $data->format('D');
            
            $total = Lembrete::whereDate('data_envio', $data)
                ->where('status', 'enviado')
                ->count();
            
            $dados[] = $total;
        }

        return [
            'labels' => $labels,
            'data' => $dados
        ];
    }

    private function getTaxaSucesso()
    {
        $total = Lembrete::whereDate('created_at', '>=', today()->subDays(7))->count();
        
        if ($total === 0) {
            return 0;
        }

        $enviados = Lembrete::whereDate('created_at', '>=', today()->subDays(7))
            ->where('status', 'enviado')
            ->count();

        return round(($enviados / $total) * 100, 1);
    }

    public function getTipoLabel($tipo)
    {
        $labels = [
            'dose_proxima' => ['icone' => '🔔', 'texto' => 'Lembrete de Vacinação'],
            'dose_atrasada' => ['icone' => '⚠️', 'texto' => 'Dose Atrasada'],
            'campanha_terminando' => ['icone' => '📢', 'texto' => 'Campanha de Vacinação'],
            'confirmacao_presenca' => ['icone' => '✅', 'texto' => 'Confirmação de Presença'],
            'conclusao_atendimento' => ['icone' => '📋', 'texto' => 'Conclusão de Atendimento'],
        ];

        return $labels[$tipo] ?? ['icone' => '📱', 'texto' => 'Notificação'];
    }
}
