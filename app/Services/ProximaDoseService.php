<?php

namespace App\Services;

use App\Models\Paciente;
use App\Models\Vacina;
use App\Models\VacinaEsquemaDose;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProximaDoseService
{
    /**
     * Calcular todas as próximas doses pendentes de um paciente
     */
    public function calcularProximasDoses(Paciente $paciente): Collection
    {
        $proximasDoses = collect();
        
        if (!$paciente->data_nascimento) {
            return $proximasDoses;
        }
        
        $idadeMeses = Carbon::parse($paciente->data_nascimento)->diffInMonths(now());
        
        // Buscar todas as vacinas com esquema configurado
        $vacinas = Vacina::with('esquemaDoses')->where('ativo', true)->get();
        
        foreach ($vacinas as $vacina) {
            $dosesPendentes = $this->calcularDosesPendentesVacina($paciente, $vacina, $idadeMeses);
            $proximasDoses = $proximasDoses->merge($dosesPendentes);
        }
        
        return $proximasDoses->sortBy('data_prevista');
    }
    
    /**
     * Calcular doses pendentes de uma vacina específica
     */
    private function calcularDosesPendentesVacina(Paciente $paciente, Vacina $vacina, int $idadeMeses): Collection
    {
        $dosesPendentes = collect();
        
        // Se não tem esquema configurado, pular
        if ($vacina->esquemaDoses->isEmpty()) {
            return $dosesPendentes;
        }
        
        // Buscar aplicações anteriores desta vacina
        $aplicacoes = DB::table('atendimento_vacina')
            ->join('atendimentos', 'atendimento_vacina.atendimento_id', '=', 'atendimentos.id')
            ->where('atendimentos.paciente_id', $paciente->id)
            ->where('atendimento_vacina.vacina_id', $vacina->id)
            ->select('atendimentos.data')
            ->orderBy('atendimentos.data')
            ->get();
        
        $totalAplicadas = $aplicacoes->count();
        
        // Para cada dose do esquema
        foreach ($vacina->esquemaDoses as $esquemaDose) {
            // Se já aplicou essa dose ou mais, pular
            if ($totalAplicadas >= $esquemaDose->dose_numero) {
                continue;
            }
            
            // Calcular data prevista baseada na dose imediatamente anterior
            $dataUltimaDose = null;
            if ($esquemaDose->dose_numero > 1 && $totalAplicadas >= ($esquemaDose->dose_numero - 1)) {
                // Pegar a data da dose anterior (índice dose_numero - 2, pois array começa em 0)
                $dataUltimaDose = $aplicacoes[$esquemaDose->dose_numero - 2]->data ?? null;
            }
            
            $dataPrevista = $esquemaDose->calcularDataPrevista(
                $dataUltimaDose, 
                $paciente->data_nascimento
            );
            
            // Adicionar à lista todas as doses pendentes
            if ($dataPrevista) {
                $dosesPendentes->push([
                    'vacina_id' => $vacina->id,
                    'vacina' => $vacina->nome,
                    'dose' => $esquemaDose->nome_dose ?? ($esquemaDose->dose_numero . 'ª dose'),
                    'dose_numero' => $esquemaDose->dose_numero,
                    'data_prevista' => $dataPrevista->format('Y-m-d'),
                    'atrasada' => $esquemaDose->estaAtrasada($idadeMeses),
                    'obrigatoria' => $esquemaDose->obrigatoria,
                    'rede' => $esquemaDose->rede,
                    'observacoes' => $esquemaDose->observacoes
                ]);
                
                // Retornar apenas a próxima dose pendente desta vacina
                break;
            }
        }
        
        return $dosesPendentes;
    }
    
    /**
     * Verificar se dose está próxima do vencimento (para lembretes)
     * 
     * @param int $diasAntecedencia Dias de antecedência (padrão: 7)
     */
    public function dosesProximasVencimento(Paciente $paciente, int $diasAntecedencia = 7): Collection
    {
        $proximasDoses = $this->calcularProximasDoses($paciente);
        
        return $proximasDoses->filter(function ($dose) use ($diasAntecedencia) {
            $dataPrevista = Carbon::parse($dose['data_prevista']);
            $diasAteVencimento = now()->diffInDays($dataPrevista, false);
            
            // Retornar doses que estão entre (diasAntecedencia - 2) e (diasAntecedencia)
            // Ex: para 7 dias, retorna entre 5 e 7 dias de antecedência
            return $diasAteVencimento >= ($diasAntecedencia - 2) && 
                   $diasAteVencimento <= $diasAntecedencia;
        });
    }
    
    /**
     * Calcular próxima dose de uma vacina específica
     */
    public function proximaDoseVacina(Paciente $paciente, Vacina $vacina): Collection
    {
        if (!$paciente->data_nascimento) {
            return collect();
        }
        
        $idadeMeses = Carbon::parse($paciente->data_nascimento)->diffInMonths(now());
        $dosesPendentes = $this->calcularDosesPendentesVacina($paciente, $vacina, $idadeMeses);
        
        return $dosesPendentes;
    }
}
