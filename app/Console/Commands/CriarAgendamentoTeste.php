<?php

namespace App\Console\Commands;

use App\Models\Paciente;
use App\Models\Agendamento;
use Illuminate\Console\Command;

class CriarAgendamentoTeste extends Command
{
    protected $signature = 'teste:criar-agendamento {--telefone=11952060833}';
    protected $description = 'Cria um agendamento de teste para amanhã';

    public function handle()
    {
        $telefone = $this->option('telefone');
        
        // Buscar paciente pelo telefone ou criar um teste
        $paciente = Paciente::where('telefone', 'LIKE', "%{$telefone}%")->first();
        
        if (!$paciente) {
            $this->error("Paciente com telefone {$telefone} não encontrado!");
            $this->info("Criando paciente de teste...");
            
            $paciente = Paciente::create([
                'nome' => 'Paciente Teste Lembretes',
                'cpf' => '00000000000',
                'data_nascimento' => '1990-01-01',
                'telefone' => $telefone,
                'cidade_id' => 1,
                'ativo' => true,
            ]);
        }

        // Criar agendamento para amanhã às 14h
        $agendamento = Agendamento::create([
            'paciente_id' => $paciente->id,
            'titulo' => 'Vacina Teste - Gripe',
            'descricao' => 'Teste de lembrete automático',
            'data_inicio' => now()->addDay()->setTime(14, 0),
            'data_fim' => now()->addDay()->setTime(14, 30),
            'tipo' => 'atendimento',
            'status' => 'agendado',
            'local' => 'UBS Centro',
            'cor' => '#3b82f6',
        ]);

        $this->info('✅ Agendamento criado com sucesso!');
        $this->newLine();
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Paciente', $paciente->nome],
                ['Telefone', $paciente->telefone],
                ['Vacina', $agendamento->titulo],
                ['Data', $agendamento->data_inicio->format('d/m/Y H:i')],
                ['Local', $agendamento->local],
                ['Status', $agendamento->status],
            ]
        );

        return 0;
    }
}
