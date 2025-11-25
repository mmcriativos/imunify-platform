<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacina;
use App\Models\VacinaLote;
use App\Models\EstoqueMovimentacao;
use App\Services\EstoqueService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatoriosEstoqueController extends Controller
{
    protected $estoqueService;

    public function __construct(EstoqueService $estoqueService)
    {
        $this->estoqueService = $estoqueService;
    }

    /**
     * Dashboard de Relatórios
     */
    public function index()
    {
        // Alertas atuais
        $alertas = $this->estoqueService->verificarAlertas();
        
        // Estatísticas gerais
        $estatisticas = [
            'total_vacinas' => Vacina::where('ativo', true)->count(),
            'total_estoque' => Vacina::where('ativo', true)->sum('estoque_atual'),
            'valor_total_estoque' => Vacina::where('ativo', true)
                ->whereNotNull('custo_medio')
                ->get()
                ->sum(function($v) {
                    return ($v->estoque_atual ?? 0) * ($v->custo_medio ?? 0);
                }),
            'lotes_vencendo' => VacinaLote::vencendo()->count(),
            'lotes_vencidos' => VacinaLote::vencidos()->count(),
            'vacinas_estoque_baixo' => Vacina::where('ativo', true)->get()->filter(function($v) {
                return ($v->estoque_atual ?? 0) < ($v->estoque_minimo ?? 5);
            })->count()
        ];

        // Movimentações recentes
        $movimentacoesRecentes = EstoqueMovimentacao::with(['vacina', 'user', 'lote'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('relatorios.estoque.index', compact('alertas', 'estatisticas', 'movimentacoesRecentes'));
    }

    /**
     * Relatório de Posição de Estoque
     */
    public function posicaoEstoque(Request $request)
    {
        $query = Vacina::with(['lotes' => function($q) {
            $q->where('status', 'Disponivel')->orderBy('data_validade');
        }])->where('ativo', true);

        // Filtros
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('fabricante')) {
            $query->where('fabricante', 'like', '%' . $request->fabricante . '%');
        }

        if ($request->filled('situacao')) {
            switch ($request->situacao) {
                case 'estoque_baixo':
                    $query->whereRaw('estoque_atual < estoque_minimo');
                    break;
                case 'estoque_zero':
                    $query->where('estoque_atual', 0);
                    break;
                case 'lotes_vencendo':
                    $query->whereHas('lotes', function($q) {
                        $q->vencendo();
                    });
                    break;
            }
        }

        $vacinas = $query->orderBy('nome')->get();

        // Dados para filtros
        $categorias = Vacina::where('ativo', true)->distinct()->pluck('categoria')->filter();
        $fabricantes = Vacina::where('ativo', true)->distinct()->pluck('fabricante')->filter();

        return view('relatorios.estoque.posicao', compact('vacinas', 'categorias', 'fabricantes'));
    }

    /**
     * Relatório de Movimentações
     */
    public function movimentacoes(Request $request)
    {
        $dataInicio = $request->input('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->input('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = EstoqueMovimentacao::with(['vacina', 'user', 'lote', 'paciente'])
            ->whereBetween('created_at', [
                Carbon::parse($dataInicio)->startOfDay(),
                Carbon::parse($dataFim)->endOfDay()
            ]);

        // Filtros
        if ($request->filled('vacina_id')) {
            $query->where('vacina_id', $request->vacina_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        $movimentacoes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Dados para filtros
        $vacinas = Vacina::where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        $usuarios = \App\Models\User::orderBy('name')->get(['id', 'name']);

        // Resumo do período
        $resumo = [
            'total_entradas' => EstoqueMovimentacao::entradas()
                ->porPeriodo($dataInicio, $dataFim)
                ->sum('quantidade'),
            'total_saidas' => EstoqueMovimentacao::saidas()
                ->porPeriodo($dataInicio, $dataFim)
                ->sum('quantidade'),
            'valor_entradas' => EstoqueMovimentacao::entradas()
                ->porPeriodo($dataInicio, $dataFim)
                ->sum('custo_total'),
            'valor_saidas' => EstoqueMovimentacao::saidas()
                ->porPeriodo($dataInicio, $dataFim)
                ->sum('custo_total')
        ];

        return view('relatorios.estoque.movimentacoes', compact(
            'movimentacoes', 'vacinas', 'usuarios', 'resumo', 'dataInicio', 'dataFim'
        ));
    }

    /**
     * Relatório de Lotes e Validades
     */
    public function lotes(Request $request)
    {
        $query = VacinaLote::with('vacina');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('situacao_validade')) {
            switch ($request->situacao_validade) {
                case 'vencidos':
                    $query->where('data_validade', '<', Carbon::now());
                    break;
                case 'vencendo_30':
                    $query->where('data_validade', '<=', Carbon::now()->addDays(30))
                          ->where('data_validade', '>=', Carbon::now());
                    break;
                case 'vencendo_7':
                    $query->where('data_validade', '<=', Carbon::now()->addDays(7))
                          ->where('data_validade', '>=', Carbon::now());
                    break;
            }
        }

        if ($request->filled('vacina_id')) {
            $query->where('vacina_id', $request->vacina_id);
        }

        $lotes = $query->orderBy('data_validade')->get();

        // Dados para filtros
        $vacinas = Vacina::where('ativo', true)->orderBy('nome')->get(['id', 'nome']);

        // Resumo
        $resumo = [
            'total_lotes' => VacinaLote::count(),
            'lotes_disponiveis' => VacinaLote::where('status', 'Disponivel')->count(),
            'lotes_vencidos' => VacinaLote::vencidos()->count(),
            'lotes_vencendo' => VacinaLote::vencendo()->count(),
            'quantidade_total' => VacinaLote::where('status', 'Disponivel')->sum('quantidade_atual'),
            'valor_total' => VacinaLote::where('status', 'Disponivel')->get()->sum('valor_total_atual')
        ];

        return view('relatorios.estoque.lotes', compact('lotes', 'vacinas', 'resumo'));
    }

    /**
     * Relatório de Giro de Estoque
     */
    public function giroEstoque(Request $request)
    {
        $periodo = $request->input('periodo', 30); // dias
        $dataInicio = Carbon::now()->subDays($periodo);

        // Análise de giro por vacina
        $analiseGiro = Vacina::with(['movimentacoes' => function($q) use ($dataInicio) {
            $q->where('created_at', '>=', $dataInicio)
              ->whereIn('tipo', ['aplicacao', 'saida']);
        }])
        ->where('ativo', true)
        ->get()
        ->map(function($vacina) use ($periodo) {
            $saidasPeriodo = $vacina->movimentacoes->sum('quantidade');
            $estoqueAtual = $vacina->estoque_atual ?? 0;
            
            // Cálculo do giro
            $giro = $estoqueAtual > 0 ? ($saidasPeriodo / $estoqueAtual) * (365 / $periodo) : 0;
            
            // Classificação
            $classificacao = 'Baixo';
            if ($giro >= 12) $classificacao = 'Excelente';
            elseif ($giro >= 6) $classificacao = 'Bom';
            elseif ($giro >= 3) $classificacao = 'Regular';

            return [
                'vacina' => $vacina,
                'saidas_periodo' => $saidasPeriodo,
                'estoque_atual' => $estoqueAtual,
                'giro_anual' => round($giro, 2),
                'classificacao' => $classificacao,
                'dias_estoque' => $giro > 0 ? round(365 / $giro) : 999
            ];
        })
        ->sortByDesc('giro_anual');

        return view('relatorios.estoque.giro', compact('analiseGiro', 'periodo'));
    }

    /**
     * Exportar relatório (PDF/Excel)
     */
    public function exportar(Request $request)
    {
        $tipo = $request->input('tipo', 'posicao');
        $formato = $request->input('formato', 'pdf');
        
        // Implementar exportação baseada no tipo e formato
        // Por enquanto, retorna JSON para demonstração
        
        return response()->json([
            'message' => "Exportação de {$tipo} em {$formato} será implementada",
            'parametros' => $request->all()
        ]);
    }
}
