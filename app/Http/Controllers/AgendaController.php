<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\Atendimento;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::orderBy('nome')->get();
        $cores = Agendamento::getCoresDisponiveis();

        $statusTotals = Agendamento::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total' => Agendamento::count(),
            'hoje' => Agendamento::whereDate('data_inicio', Carbon::today())->count(),
            'proximos7dias' => Agendamento::whereBetween('data_inicio', [Carbon::now(), Carbon::now()->addDays(7)])->count(),
            'confirmados' => $statusTotals['confirmado'] ?? 0,
            'cancelados' => $statusTotals['cancelado'] ?? 0,
        ];

        return view('agenda.index', compact('pacientes', 'cores', 'stats'));
    }

    // API: Retorna eventos para o FullCalendar (alias)
    public function eventos(Request $request)
    {
        return $this->getEventos($request);
    }

    // API: Retorna eventos para o FullCalendar
    public function getEventos(Request $request)
    {
        $inicio = Carbon::parse($request->start);
        $fim = Carbon::parse($request->end);

        $agendamentos = Agendamento::with(['paciente', 'atendimento'])
            ->porPeriodo($inicio, $fim)
            ->get();

        $eventos = $agendamentos->map(function ($agendamento) {
            return $agendamento->toFullCalendarEvent();
        });

        return response()->json($eventos);
    }

    // API: Criar novo agendamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'tipo' => 'required|in:atendimento,consulta,lembrete,outros',
            'status' => 'nullable|in:agendado,confirmado,realizado,cancelado',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'atendimento_id' => 'nullable|exists:atendimentos,id',
            'local' => 'nullable|string|max:255',
            'cor' => 'nullable|string|max:20',
            'observacoes' => 'nullable|string',
            'dia_inteiro' => 'nullable|boolean',
        ]);

        // Define cor padrão baseada no tipo
        if (empty($validated['cor'])) {
            $cores = Agendamento::getCoresDisponiveis();
            $validated['cor'] = $cores[$validated['tipo']] ?? '#3B82F6';
        }

        $agendamento = Agendamento::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento criado com sucesso!',
            'agendamento' => $agendamento->toFullCalendarEvent(),
        ]);
    }

    // API: Buscar um agendamento específico
    public function show(Agendamento $agendamento)
    {
        $agendamento->load(['paciente', 'atendimento']);
        
        return response()->json([
            'success' => true,
            'agendamento' => [
                'id' => $agendamento->id,
                'titulo' => $agendamento->titulo,
                'paciente_id' => $agendamento->paciente_id,
                'paciente_nome' => $agendamento->paciente?->nome,
                'data_inicio' => Carbon::parse($agendamento->data_inicio)->format('Y-m-d\TH:i'),
                'data_fim' => Carbon::parse($agendamento->data_fim)->format('Y-m-d\TH:i'),
                'tipo' => $agendamento->tipo,
                'status' => $agendamento->status,
                'local' => $agendamento->local,
                'cor' => $agendamento->cor,
                'descricao' => $agendamento->descricao,
                'observacoes' => $agendamento->observacoes,
                'dia_inteiro' => $agendamento->dia_inteiro,
            ]
        ]);
    }

    // API: Atualizar agendamento
    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'tipo' => 'required|in:atendimento,consulta,lembrete,outros',
            'status' => 'nullable|in:agendado,confirmado,realizado,cancelado',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'atendimento_id' => 'nullable|exists:atendimentos,id',
            'local' => 'nullable|string|max:255',
            'cor' => 'nullable|string|max:20',
            'observacoes' => 'nullable|string',
            'dia_inteiro' => 'nullable|boolean',
        ]);

        $agendamento->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento atualizado com sucesso!',
            'agendamento' => $agendamento->fresh()->toFullCalendarEvent(),
        ]);
    }

    // API: Atualizar datas (drag and drop)
    public function updateDatas(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'dia_inteiro' => 'nullable|boolean',
        ]);

        $agendamento->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data atualizada com sucesso!',
        ]);
    }

    // API: Deletar agendamento
    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agendamento excluído com sucesso!',
        ]);
    }

    // Criar agendamento a partir de um atendimento
    public function criarDoAtendimento(Atendimento $atendimento)
    {
        $paciente = $atendimento->paciente;
        
        $agendamento = Agendamento::create([
            'paciente_id' => $paciente->id,
            'atendimento_id' => $atendimento->id,
            'titulo' => "Atendimento - {$paciente->nome}",
            'descricao' => "Atendimento {$atendimento->tipo}",
            'data_inicio' => $atendimento->data . ' ' . ($atendimento->hora ?? '08:00:00'),
            'data_fim' => Carbon::parse($atendimento->data . ' ' . ($atendimento->hora ?? '08:00:00'))->addHour(),
            'tipo' => 'atendimento',
            'status' => 'agendado',
            'local' => $atendimento->tipo === 'clinica' ? 'Clínica' : ($atendimento->cidade->nome ?? 'Domiciliar'),
            'cor' => $atendimento->tipo === 'clinica' ? '#3B82F6' : '#10B981',
        ]);

        return redirect()->route('agenda.index')
            ->with('success', 'Agendamento criado a partir do atendimento!');
    }
}
