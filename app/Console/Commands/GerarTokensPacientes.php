<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paciente;
use Illuminate\Support\Str;

class GerarTokensPacientes extends Command
{
    protected $signature = 'pacientes:gerar-tokens';
    protected $description = 'Gera tokens únicos para pacientes que não possuem';

    public function handle()
    {
        $pacientes = Paciente::whereNull('token_carteira')->get();
        
        if ($pacientes->isEmpty()) {
            $this->info('Todos os pacientes já possuem tokens!');
            return 0;
        }
        
        $this->info("Gerando tokens para {$pacientes->count()} pacientes...");
        
        foreach ($pacientes as $paciente) {
            $paciente->token_carteira = Str::random(32);
            $paciente->save();
        }
        
        $this->info('✓ Tokens gerados com sucesso!');
        return 0;
    }
}
