<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Atendimento;
use App\Models\CampanhaVacinacao;
use App\Services\ProximaDoseService;
use Illuminate\Http\Request;

class CarteiraVacinacaoController extends Controller
{
    protected $proximaDoseService;
    
    public function __construct(ProximaDoseService $proximaDoseService)
    {
        $this->proximaDoseService = $proximaDoseService;
    }
    
    public function index(Request $request)
    {
        $query = Paciente::query();
        
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('cpf', 'like', "%{$busca}%");
            });
        }
        
        $pacientes = $query->orderBy('nome')->paginate(20);
        
        return view('carteira.index', compact('pacientes'));
    }
    
    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        
        // Buscar todos os atendimentos com vacinas aplicadas
        $atendimentos = Atendimento::with(['vacinas'])
            ->where('paciente_id', $id)
            ->orderBy('data', 'desc')
            ->get();
        
        // Agrupar vacinas por categoria/tipo
        $vacinasAplicadas = collect();
        
        foreach ($atendimentos as $atendimento) {
            foreach ($atendimento->vacinas as $vacina) {
                $vacinasAplicadas->push([
                    'vacina' => $vacina->nome,
                    'data' => $atendimento->data,
                    'dose' => $vacina->pivot->quantidade ?? 'Única',
                    'lote' => $vacina->pivot->lote,
                    'aplicador' => $atendimento->observacoes ?? 'Não informado',
                    'tipo' => $atendimento->tipo,
                    'status' => 'aplicada'
                ]);
            }
        }
        
        // Vacinas sugeridas - usar o novo serviço
        $proximasDosesRaw = $this->proximaDoseService->calcularProximasDoses($paciente);
        
        // Converter para formato esperado pela view
        $vacinasSugeridas = $proximasDosesRaw->map(function($dose) use ($paciente) {
            // Calcular idade recomendada baseada no esquema
            $idadeRecomendada = $dose['observacoes'] ?? '';
            
            // Se não houver observação, tentar gerar baseado na data prevista
            if (empty($idadeRecomendada) && isset($dose['data_prevista'])) {
                $dataPrevista = \Carbon\Carbon::parse($dose['data_prevista']);
                if ($paciente->data_nascimento) {
                    $mesesPrevistos = \Carbon\Carbon::parse($paciente->data_nascimento)
                        ->diffInMonths($dataPrevista);
                    
                    if ($mesesPrevistos < 12) {
                        $idadeRecomendada = $mesesPrevistos . ' meses';
                    } else {
                        $anos = floor($mesesPrevistos / 12);
                        $meses = $mesesPrevistos % 12;
                        $idadeRecomendada = $anos . ' ano' . ($anos > 1 ? 's' : '');
                        if ($meses > 0) {
                            $idadeRecomendada .= ' e ' . $meses . ' meses';
                        }
                    }
                    
                    $idadeRecomendada .= ' (' . $dataPrevista->format('d/m/Y') . ')';
                }
            }
            
            return [
                'nome' => $dose['vacina'],
                'dose' => $dose['dose'],
                'idade_recomendada' => $idadeRecomendada ?: 'Consulte o calendário',
                'prioridade' => $dose['obrigatoria'] ? 'alta' : 'média',
                'atrasada' => $dose['atrasada'] ?? false,
                'observacao' => isset($dose['atrasada']) && $dose['atrasada'] ? 'Dose atrasada - agendar urgente' : null
            ];
        });
        
        // Verificar campanhas ativas
        $campanhasAtivas = $this->getCampanhasAtivas($paciente, $vacinasAplicadas);
        
        return view('carteira.show', compact('paciente', 'vacinasAplicadas', 'vacinasSugeridas', 'campanhasAtivas'));
    }
    
    private function getVacinasSugeridas($paciente, $vacinasAplicadas)
    {
        // Método deprecado - mantido para compatibilidade, mas não usado mais
        // TODO: Remover após confirmar que views não chamam diretamente
        $sugeridas = collect();
        $idade = $paciente->data_nascimento ? 
            now()->diffInMonths($paciente->data_nascimento) : null;
        
        if (!$idade) {
            return $sugeridas;
        }
        
        $vacinasNomes = $vacinasAplicadas->pluck('vacina')->unique();
        $idadeAnos = floor($idade / 12);
        
        // 📋 CALENDÁRIO COMPLETO DO MINISTÉRIO DA SAÚDE
        
        // 👶 RECÉM-NASCIDOS (Ao nascer)
        if ($idade >= 0) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'BCG', 'Dose única', 'Ao nascer', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Hepatite B', '1ª dose', 'Ao nascer (primeiras 12h)', 'alta');
        }
        
        // 👶 2 MESES
        if ($idade >= 2) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Pentavalente', '1ª dose', '2 meses', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Pneumocócica 13', '1ª dose', '2 meses', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Rotavírus', '1ª dose', '2 meses', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Meningocócica C', '1ª dose', '2 meses (SUS)', 'alta');
            $this->verificarDoseAtrasada($sugeridas, $vacinasAplicadas, 'Pentavalente', 2, $idade);
        }
        
        // 👶 3 MESES
        if ($idade >= 3) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Meningocócica B', '1ª dose', '3 meses', 'alta');
        }
        
        // 👶 4 MESES
        if ($idade >= 4) {
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Pentavalente', 2, '2ª dose', '4 meses', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Pneumocócica 13', 2, '2ª dose', '4 meses', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Rotavírus', 2, '2ª dose', '4 meses', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Meningocócica C', 2, '2ª dose', '4 meses (SUS)', $idade);
        }
        
        // 👶 5 MESES
        if ($idade >= 5) {
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Meningocócica B', 2, '2ª dose', '5 meses', $idade);
        }
        
        // 👶 6 MESES
        if ($idade >= 6) {
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Pentavalente', 3, '3ª dose', '6 meses', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Pneumocócica 13', 3, '3ª dose', '6 meses (rede privada)', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Rotavírus', 3, '3ª dose', '6 meses (rede privada)', $idade);
            $this->sugerirInfluenza($sugeridas, $vacinasAplicadas, $idade, '6 meses', 'média');
        }
        
        // 👶 9 MESES
        if ($idade >= 9) {
            $this->sugerirFebreAmarela($sugeridas, $vacinasNomes, $paciente, '9 meses', 'alta');
        }
        
        // 👶 12 MESES (1 ANO)
        if ($idade >= 12) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Tríplice Viral', '1ª dose', '12 meses (1 ano)', 'alta');
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Meningocócica C', 'reforço', 'Reforço', '12 meses', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Pneumocócica 13', 'reforço', 'Reforço', '12 meses', $idade);
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Hepatite A', '1ª dose', '12-15 meses', 'alta');
        }
        
        // 👶 15 MESES
        if ($idade >= 15) {
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'DTP', 1, '1º reforço', '15 meses', $idade);
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Varicela', '1ª dose', '15 meses', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Tetraviral', 'Dose única', '15 meses', 'alta');
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Hepatite A', 2, '2ª dose', '18 meses', $idade);
        }
        
        // 🧒 4 ANOS
        if ($idadeAnos >= 4) {
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'DTP', 2, '2º reforço', '4 anos', $idade);
            $this->verificarDoseEspecifica($sugeridas, $vacinasAplicadas, 'Varicela', 2, '2ª dose', '4 anos', $idade);
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Poliomielite', 'Reforço', '4 anos', 'alta');
        }
        
        // 🧒 9 ANOS (HPV - meninas e meninos)
        if ($idadeAnos >= 9 && $idadeAnos <= 14) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'HPV', '1ª dose', '9-14 anos', 'alta');
        }
        
        // 🧑 11-12 ANOS (Adolescentes)
        if ($idadeAnos >= 11 && $idadeAnos <= 19) {
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Meningocócica ACWY', 'Reforço', '11-12 anos', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'dTpa', 'Reforço', 'Adolescente', 'média');
            
            // Verificar esquema completo de Hepatite B
            if (!$this->temEsquemaCompleto($vacinasAplicadas, 'Hepatite B', 3)) {
                $sugeridas->push([
                    'nome' => 'Hepatite B',
                    'dose' => 'Completar esquema',
                    'idade_recomendada' => 'Adolescente',
                    'prioridade' => 'média'
                ]);
            }
        }
        
        // 👨 ADULTOS (20-59 anos)
        if ($idadeAnos >= 20 && $idadeAnos < 60) {
            // dT a cada 10 anos
            $ultimaDT = $this->getUltimaAplicacao($vacinasAplicadas, ['dT', 'dTpa', 'DTP']);
            if (!$ultimaDT || now()->diffInYears($ultimaDT['data']) >= 10) {
                $sugeridas->push([
                    'nome' => 'dT (Dupla Adulto)',
                    'dose' => 'Reforço a cada 10 anos',
                    'idade_recomendada' => 'Adulto',
                    'prioridade' => $ultimaDT && now()->diffInYears($ultimaDT['data']) > 10 ? 'alta' : 'média',
                    'atrasada' => $ultimaDT && now()->diffInYears($ultimaDT['data']) > 10
                ]);
            }
            
            // Tríplice Viral (até 49 anos se não imunizado)
            if ($idadeAnos <= 49 && !$this->temEsquemaCompleto($vacinasAplicadas, 'Tríplice Viral', 2)) {
                $sugeridas->push([
                    'nome' => 'Tríplice Viral',
                    'dose' => $idadeAnos <= 29 ? '2 doses' : '1 dose',
                    'idade_recomendada' => $idadeAnos <= 29 ? 'Até 29 anos' : '30-49 anos',
                    'prioridade' => 'média'
                ]);
            }
            
            $this->sugerirInfluenza($sugeridas, $vacinasAplicadas, $idade, 'Anual', 'média');
        }
        
        // 👴 IDOSOS (60+ anos)
        if ($idadeAnos >= 60) {
            $this->sugerirInfluenza($sugeridas, $vacinasAplicadas, $idade, 'Anual (prioritário)', 'alta');
            $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Pneumocócica 23', 'Dose única', '60+ anos', 'alta');
            
            // Herpes Zóster (50+ anos)
            if ($idadeAnos >= 50) {
                $this->sugerirSeNaoAplicada($sugeridas, $vacinasNomes, 'Herpes Zóster', '2 doses', '50+ anos', 'média');
            }
            
            // dT a cada 10 anos
            $ultimaDT = $this->getUltimaAplicacao($vacinasAplicadas, ['dT', 'dTpa']);
            if (!$ultimaDT || now()->diffInYears($ultimaDT['data']) >= 10) {
                $sugeridas->push([
                    'nome' => 'dT (Dupla Adulto)',
                    'dose' => 'Reforço a cada 10 anos',
                    'idade_recomendada' => 'Idoso',
                    'prioridade' => 'alta',
                    'atrasada' => $ultimaDT && now()->diffInYears($ultimaDT['data']) > 10
                ]);
            }
        }
        
        return $sugeridas->sortByDesc('prioridade')->values();
    }
    
    // Métodos auxiliares
    private function sugerirSeNaoAplicada($sugeridas, $vacinasNomes, $vacina, $dose, $idade, $prioridade)
    {
        if (!$vacinasNomes->contains(fn($v) => stripos($v, $vacina) !== false)) {
            $sugeridas->push([
                'nome' => $vacina,
                'dose' => $dose,
                'idade_recomendada' => $idade,
                'prioridade' => $prioridade
            ]);
        }
    }
    
    private function verificarDoseEspecifica($sugeridas, $vacinasAplicadas, $vacina, $doseNumero, $doseTexto, $idadeRecomendada, $idadeAtual)
    {
        $doses = $vacinasAplicadas->filter(fn($v) => stripos($v['vacina'], $vacina) !== false);
        
        if ($doses->count() < $doseNumero) {
            $ultimaDose = $doses->sortByDesc('data')->first();
            $atrasada = false;
            
            if ($ultimaDose) {
                $mesesDesdeUltima = now()->diffInMonths($ultimaDose['data']);
                $atrasada = $mesesDesdeUltima > 4; // Mais de 4 meses atrasada
            }
            
            $sugeridas->push([
                'nome' => $vacina,
                'dose' => $doseTexto,
                'idade_recomendada' => $idadeRecomendada,
                'prioridade' => $atrasada ? 'alta' : 'média',
                'atrasada' => $atrasada
            ]);
        }
    }
    
    private function verificarDoseAtrasada($sugeridas, $vacinasAplicadas, $vacina, $idadeEsperada, $idadeAtual)
    {
        $doses = $vacinasAplicadas->filter(fn($v) => stripos($v['vacina'], $vacina) !== false);
        
        if ($doses->isEmpty() && $idadeAtual > $idadeEsperada + 2) {
            $sugeridas->push([
                'nome' => $vacina,
                'dose' => '1ª dose (ATRASADA)',
                'idade_recomendada' => $idadeEsperada . ' meses',
                'prioridade' => 'alta',
                'atrasada' => true
            ]);
        }
    }
    
    private function sugerirInfluenza($sugeridas, $vacinasAplicadas, $idade, $texto, $prioridade)
    {
        $ultimaInfluenza = $this->getUltimaAplicacao($vacinasAplicadas, ['Influenza', 'Gripe']);
        
        if (!$ultimaInfluenza || now()->diffInMonths($ultimaInfluenza['data']) >= 12) {
            $sugeridas->push([
                'nome' => 'Influenza (Gripe)',
                'dose' => 'Anual',
                'idade_recomendada' => $texto,
                'prioridade' => $prioridade
            ]);
        }
    }
    
    private function sugerirFebreAmarela($sugeridas, $vacinasNomes, $paciente, $idade, $prioridade)
    {
        // Áreas de risco no Brasil
        $estadosRisco = ['AC', 'AM', 'RO', 'RR', 'AP', 'PA', 'TO', 'MA', 'MT', 'MS', 'GO', 'DF', 'MG', 'ES', 'RJ', 'SP', 'PR', 'SC', 'RS'];
        
        $emAreaRisco = false;
        if ($paciente->cidade && $paciente->cidade->estado) {
            $emAreaRisco = in_array($paciente->cidade->estado, $estadosRisco);
        }
        
        if (!$vacinasNomes->contains(fn($v) => stripos($v, 'Febre Amarela') !== false)) {
            $sugeridas->push([
                'nome' => 'Febre Amarela',
                'dose' => 'Dose única',
                'idade_recomendada' => $idade,
                'prioridade' => $emAreaRisco ? 'alta' : $prioridade,
                'observacao' => $emAreaRisco ? '⚠️ Área de risco' : 'Conforme área de risco'
            ]);
        }
    }
    
    private function getUltimaAplicacao($vacinasAplicadas, $nomes)
    {
        return $vacinasAplicadas
            ->filter(function($v) use ($nomes) {
                foreach ($nomes as $nome) {
                    if (stripos($v['vacina'], $nome) !== false) return true;
                }
                return false;
            })
            ->sortByDesc('data')
            ->first();
    }
    
    private function temEsquemaCompleto($vacinasAplicadas, $vacina, $dosesNecessarias)
    {
        $doses = $vacinasAplicadas->filter(fn($v) => stripos($v['vacina'], $vacina) !== false);
        return $doses->count() >= $dosesNecessarias;
    }
    
    public function print($id)
    {
        $paciente = Paciente::findOrFail($id);
        
        $atendimentos = Atendimento::with(['vacinas'])
            ->where('paciente_id', $id)
            ->orderBy('data', 'desc')
            ->get();
        
        $vacinasAplicadas = collect();
        
        foreach ($atendimentos as $atendimento) {
            foreach ($atendimento->vacinas as $vacina) {
                $vacinasAplicadas->push([
                    'vacina' => $vacina->nome,
                    'data' => $atendimento->data,
                    'dose' => $vacina->pivot->quantidade ?? 'Única',
                    'lote' => $vacina->pivot->lote,
                    'aplicador' => $atendimento->observacoes ?? 'Não informado',
                    'tipo' => $atendimento->tipo ?? 'clinica',
                ]);
            }
        }
        
        return view('carteira.print', compact('paciente', 'vacinasAplicadas'));
    }
    
    public function certificado($id)
    {
        $paciente = Paciente::findOrFail($id);
        
        $atendimentos = Atendimento::with(['vacinas'])
            ->where('paciente_id', $id)
            ->orderBy('data', 'desc')
            ->get();
        
        $vacinasAplicadas = collect();
        
        foreach ($atendimentos as $atendimento) {
            foreach ($atendimento->vacinas as $vacina) {
                $vacinasAplicadas->push([
                    'vacina' => $vacina->nome,
                    'data' => $atendimento->data,
                    'dose' => $vacina->pivot->quantidade ?? 'Única',
                    'lote' => $vacina->pivot->lote,
                    'tipo' => $atendimento->tipo,
                ]);
            }
        }
        
        return view('carteira.certificado', compact('paciente', 'vacinasAplicadas'));
    }
    
    /**
     * Visualização pública da carteira (via token único)
     */
    public function carteiraPublica($token)
    {
        $paciente = Paciente::where('token_carteira', $token)
            ->firstOrFail();
        
        $atendimentos = Atendimento::with(['vacinas'])
            ->where('paciente_id', $paciente->id)
            ->orderBy('data', 'desc')
            ->get();
        
        $vacinasAplicadas = collect();
        
        foreach ($atendimentos as $atendimento) {
            foreach ($atendimento->vacinas as $vacina) {
                $vacinasAplicadas->push([
                    'vacina' => $vacina->nome,
                    'data' => $atendimento->data,
                    'dose' => $vacina->pivot->quantidade ?? 'Única',
                    'lote' => $vacina->pivot->lote,
                    'tipo' => $atendimento->tipo,
                    'pendente_pagamento' => false
                ]);
            }
        }
        
        $vacinasSugeridas = $this->proximaDoseService->calcularProximasDoses($paciente)
            ->map(function($dose) use ($paciente) {
                // Calcular idade recomendada
                $idadeRecomendada = $dose['observacoes'] ?? '';
                
                if (empty($idadeRecomendada) && isset($dose['data_prevista'])) {
                    $dataPrevista = \Carbon\Carbon::parse($dose['data_prevista']);
                    if ($paciente->data_nascimento) {
                        $mesesPrevistos = \Carbon\Carbon::parse($paciente->data_nascimento)
                            ->diffInMonths($dataPrevista);
                        
                        if ($mesesPrevistos < 12) {
                            $idadeRecomendada = $mesesPrevistos . ' meses';
                        } else {
                            $anos = floor($mesesPrevistos / 12);
                            $meses = $mesesPrevistos % 12;
                            $idadeRecomendada = $anos . ' ano' . ($anos > 1 ? 's' : '');
                            if ($meses > 0) {
                                $idadeRecomendada .= ' e ' . $meses . ' meses';
                            }
                        }
                        
                        $idadeRecomendada .= ' (' . $dataPrevista->format('d/m/Y') . ')';
                    }
                }
                
                return [
                    'nome' => $dose['vacina'],
                    'dose' => $dose['dose'],
                    'idade_recomendada' => $idadeRecomendada ?: 'Consulte o calendário',
                    'prioridade' => $dose['obrigatoria'] ? 'alta' : 'média',
                    'atrasada' => $dose['atrasada'] ?? false,
                    'observacao' => isset($dose['atrasada']) && $dose['atrasada'] ? 'Dose atrasada - agendar urgente' : null
                ];
            });
        $campanhasAtivas = $this->getCampanhasAtivas($paciente, $vacinasAplicadas);
        
        return view('carteira.publica', compact('paciente', 'vacinasAplicadas', 'vacinasSugeridas', 'campanhasAtivas'));
    }

    /**
     * Busca campanhas ativas que se aplicam ao paciente
     */
    private function getCampanhasAtivas($paciente, $vacinasAplicadas)
    {
        $idade = $paciente->data_nascimento ? 
            now()->diffInMonths($paciente->data_nascimento) : null;
        
        if (!$idade) {
            return collect();
        }
        
        $campanhas = CampanhaVacinacao::ativas()->get();
        $campanhasAplicaveis = collect();
        
        foreach ($campanhas as $campanha) {
            if (!$campanha->pacienteEstaNoPublico($idade)) {
                continue;
            }
            
            $vacinasCampanha = $vacinasAplicadas->filter(function($v) use ($campanha) {
                return stripos($v['vacina'], $campanha->vacina) !== false;
            });
            
            $tomaAnualmente = in_array($campanha->vacina, ['Influenza', 'Gripe', 'COVID-19']);
            
            if ($tomaAnualmente) {
                $ultimaAplicacao = $vacinasCampanha->sortByDesc('data')->first();
                
                if (!$ultimaAplicacao || now()->diffInMonths($ultimaAplicacao['data']) >= 10) {
                    $campanhasAplicaveis->push([
                        'id' => $campanha->id,
                        'nome' => $campanha->nome,
                        'vacina' => $campanha->vacina,
                        'descricao' => $campanha->descricao,
                        'data_inicio' => $campanha->data_inicio->format('d/m/Y'),
                        'data_fim' => $campanha->data_fim->format('d/m/Y'),
                        'publico_alvo' => $campanha->publico_alvo,
                        'prioridade' => $campanha->prioridade,
                        'dias_restantes' => now()->diffInDays($campanha->data_fim)
                    ]);
                }
            } else {
                if ($vacinasCampanha->isEmpty()) {
                    $campanhasAplicaveis->push([
                        'id' => $campanha->id,
                        'nome' => $campanha->nome,
                        'vacina' => $campanha->vacina,
                        'descricao' => $campanha->descricao,
                        'data_inicio' => $campanha->data_inicio->format('d/m/Y'),
                        'data_fim' => $campanha->data_fim->format('d/m/Y'),
                        'publico_alvo' => $campanha->publico_alvo,
                        'prioridade' => $campanha->prioridade,
                        'dias_restantes' => now()->diffInDays($campanha->data_fim)
                    ]);
                }
            }
        }
        
        return $campanhasAplicaveis->sortBy('dias_restantes')->values();
    }

    /**
     * Retorna o número de doses esperadas por vacina
     */
    private function getNumerosDosesEsperadas($nomeVacina)
    {
        $configuracoes = [
            'BCG' => 1,
            'Hepatite B' => 3,
            'Pentavalente' => 3,
            'Pneumocócica 13 Valente' => 3,
            'Meningocócica' => 2,
            'Rotavírus' => 3,
            'Rotavírus Pentavalente' => 3,
            'Influenza' => 2,
            'Tríplice Viral' => 2,
            'Tetraviral' => 1,
            'DTP' => 3,
            'Varicela' => 2,
            'Hepatite A' => 2,
            'Febre Amarela' => 1,
            'HPV' => 2,
            'Meningocócica ACWY' => 2,
        ];

        // Busca exata ou parcial
        foreach ($configuracoes as $vacina => $doses) {
            if (stripos($nomeVacina, $vacina) !== false || stripos($vacina, $nomeVacina) !== false) {
                return $doses;
            }
        }

        return 3; // Padrão para vacinas não mapeadas
    }

    /**
     * Calcula data sugerida para próxima dose
     */
    private function calcularDataSugerida($ultimaData, $numeroDosesRestantes)
    {
        $intervalos = [
            1 => 60,  // 2 meses
            2 => 90,  // 3 meses
            3 => 180, // 6 meses
        ];

        $dias = $intervalos[$numeroDosesRestantes] ?? 90;
        
        $dataSugerida = \Carbon\Carbon::parse($ultimaData)->addDays($dias);
        
        return $dataSugerida->format('d/m/Y');
    }
}
