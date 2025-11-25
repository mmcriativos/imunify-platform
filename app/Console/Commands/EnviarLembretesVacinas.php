<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paciente;
use App\Models\Lembrete;
use App\Models\AtendimentoVacina;
use App\Models\Atendimento;
use App\Models\Vacina;
use App\Models\CampanhaSazonal;
use App\Services\WhatsAppService;
use App\Services\ProximaDoseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EnviarLembretesVacinas extends Command
{
    protected $signature = 'lembretes:enviar {--dry-run : Simular envio sem realmente enviar}';
    protected $description = 'Envia lembretes automáticos de vacinas e campanhas';

    private $whatsappService;
    private $proximaDoseService;

    public function __construct(WhatsAppService $whatsappService, ProximaDoseService $proximaDoseService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
        $this->proximaDoseService = $proximaDoseService;
    }

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🔸 MODO DE SIMULAÇÃO - Nenhuma mensagem será enviada');
        }

        $this->info('🚀 Iniciando processamento de lembretes...');
        
        // 1. Gerar lembretes de doses próximas (7 dias)
        $this->gerarLembretesProximasDoses();
        
        // 2. Gerar lembretes de campanhas terminando (3 dias)
        $this->gerarLembretesCampanhas();
        
        // 3. Gerar lembretes de doses atrasadas (mais de 30 dias)
        $this->gerarLembretesDosesAtrasadas();
        
        // 4. Enviar lembretes pendentes
        $enviados = $this->enviarLembretesPendentes($dryRun);
        
        $this->info("✅ Processo concluído! {$enviados} lembretes enviados.");
        
        return Command::SUCCESS;
    }

    private function gerarLembretesProximasDoses()
    {
        $this->info('📅 Verificando doses próximas do vencimento...');
        
        $pacientes = Paciente::with(['atendimentos.vacinas'])->get();
        $lembretesCriados = 0;
        
        foreach ($pacientes as $paciente) {
            // Usar o novo serviço de cálculo de próximas doses
            $proximasDoses = $this->proximaDoseService->dosesProximasVencimento($paciente, 7);
            
            foreach ($proximasDoses as $dose) {
                $jaExiste = Lembrete::where('paciente_id', $paciente->id)
                    ->where('tipo', 'dose_proxima')
                    ->where('metadata->vacina', $dose['vacina'])
                    ->where('metadata->dose', $dose['dose'])
                    ->where('created_at', '>=', now()->subDays(10))
                    ->exists();
                
                if (!$jaExiste) {
                    $this->criarLembrete($paciente, 'dose_proxima', $dose);
                    $lembretesCriados++;
                }
            }
        }
        
        $this->line("   → {$lembretesCriados} lembretes de doses próximas criados");
    }

    private function gerarLembretesCampanhas()
    {
        $this->info('🎯 Verificando campanhas terminando...');
        
        $campanhas = CampanhaSazonal::where('ativa', true)
            ->where('data_fim', '>=', now())
            ->where('data_fim', '<=', now()->addDays(3))
            ->get();
        
        $lembretesCriados = 0;
        
        foreach ($campanhas as $campanha) {
            $pacientes = Paciente::whereDoesntHave('atendimentos.vacinas', function($query) use ($campanha) {
                $query->where('vacina', $campanha->vacina)
                      ->where('data', '>=', $campanha->data_inicio);
            })->get();
            
            foreach ($pacientes as $paciente) {
                $jaExiste = Lembrete::where('paciente_id', $paciente->id)
                    ->where('tipo', 'campanha_terminando')
                    ->where('metadata->campanha_id', $campanha->id)
                    ->where('created_at', '>=', now()->subDays(5))
                    ->exists();
                
                if (!$jaExiste) {
                    $this->criarLembrete($paciente, 'campanha_terminando', [
                        'campanha_id' => $campanha->id,
                        'campanha_nome' => $campanha->nome,
                        'vacina' => $campanha->vacina,
                        'data_fim' => $campanha->data_fim
                    ]);
                    $lembretesCriados++;
                }
            }
        }
        
        $this->line("   → {$lembretesCriados} lembretes de campanhas criados");
    }

    private function gerarLembretesDosesAtrasadas()
    {
        $this->info('⚠️  Verificando doses atrasadas...');
        
        $pacientes = Paciente::with(['atendimentos.vacinas'])->get();
        $lembretesCriados = 0;
        
        foreach ($pacientes as $paciente) {
            $proximasDoses = $this->calcularProximasDoses($paciente);
            
            foreach ($proximasDoses as $dose) {
                $diasAtraso = now()->diffInDays(Carbon::parse($dose['data_prevista']), false);
                
                if ($diasAtraso >= 30) {
                    $ultimoLembrete = Lembrete::where('paciente_id', $paciente->id)
                        ->where('tipo', 'dose_atrasada')
                        ->where('metadata->vacina', $dose['vacina'])
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    $deveEnviar = !$ultimoLembrete || 
                                  $ultimoLembrete->created_at->diffInDays(now()) >= 30;
                    
                    if ($deveEnviar) {
                        $this->criarLembrete($paciente, 'dose_atrasada', $dose);
                        $lembretesCriados++;
                    }
                }
            }
        }
        
        $this->line("   → {$lembretesCriados} lembretes de doses atrasadas criados");
    }

    private function criarLembrete($paciente, $tipo, $dados)
    {
        $destinatario = $paciente->telefone ?: $paciente->email;
        
        if (!$destinatario) {
            return;
        }
        
        $mensagem = $this->gerarMensagem($tipo, $paciente, $dados);
        
        Lembrete::create([
            'paciente_id' => $paciente->id,
            'tipo' => $tipo,
            'canal' => 'ambos',
            'destinatario' => $destinatario,
            'mensagem' => $mensagem,
            'status' => 'pendente',
            'data_agendamento' => now(),
            'metadata' => $dados
        ]);
    }

    private function gerarMensagem($tipo, $paciente, $dados)
    {
        switch ($tipo) {
            case 'dose_proxima':
                $dataPrevista = Carbon::parse($dados['data_prevista'])->format('d/m/Y');
                return "🏥 *MultiImune - Lembrete de Vacinação*\n\n" .
                       "Olá, {$paciente->nome}!\n\n" .
                       "⏰ A próxima dose da vacina *{$dados['vacina']}* ({$dados['dose']}) está prevista para *{$dataPrevista}*.\n\n" .
                       "📱 Entre em contato para agendar seu atendimento!\n\n" .
                       "_Sua saúde em dia, sempre!_";
            
            case 'campanha_terminando':
                $dataFim = Carbon::parse($dados['data_fim'])->format('d/m/Y');
                return "🎯 *MultiImune - Campanha Encerrando*\n\n" .
                       "Olá, {$paciente->nome}!\n\n" .
                       "⚠️ A campanha *{$dados['campanha_nome']}* está terminando em *{$dataFim}*!\n\n" .
                       "Não perca esta oportunidade de se proteger com a vacina *{$dados['vacina']}*.\n\n" .
                       "📞 Agende já seu atendimento!";
            
            case 'dose_atrasada':
                $diasAtraso = now()->diffInDays(Carbon::parse($dados['data_prevista']));
                return "⚠️ *MultiImune - Vacina Atrasada*\n\n" .
                       "Olá, {$paciente->nome}!\n\n" .
                       "Sua vacina *{$dados['vacina']}* ({$dados['dose']}) está atrasada há *{$diasAtraso} dias*.\n\n" .
                       "É importante manter seu calendário vacinal em dia para garantir a proteção completa.\n\n" .
                       "📱 Entre em contato para regularizar sua carteira!";
            
            default:
                return "Lembrete de vacinação - MultiImune";
        }
    }

    private function enviarLembretesPendentes($dryRun = false)
    {
        $lembretes = Lembrete::paraEnviar()->with('paciente')->get();
        $enviados = 0;
        
        $this->info("📤 Enviando {$lembretes->count()} lembretes...");
        
        foreach ($lembretes as $lembrete) {
            if ($dryRun) {
                $this->line("   [SIMULAÇÃO] → {$lembrete->tipo} para {$lembrete->paciente->nome}");
                continue;
            }
            
            try {
                if (in_array($lembrete->canal, ['whatsapp', 'ambos']) && $lembrete->paciente->telefone) {
                    $this->enviarWhatsApp($lembrete);
                }
                
                if (in_array($lembrete->canal, ['email', 'ambos']) && $lembrete->paciente->email) {
                    $this->enviarEmail($lembrete);
                }
                
                $lembrete->marcarComoEnviado();
                $enviados++;
                
                $this->line("   ✅ Enviado para {$lembrete->paciente->nome}");
                
            } catch (\Exception $e) {
                $lembrete->marcarComoErro($e->getMessage());
                $this->error("   ❌ Erro: {$e->getMessage()}");
                Log::error("Erro ao enviar lembrete #{$lembrete->id}: " . $e->getMessage());
            }
        }
        
        return $enviados;
    }

    private function enviarWhatsApp($lembrete)
    {
        $telefone = preg_replace('/[^0-9]/', '', $lembrete->paciente->telefone);
        
        // Validar número
        if (!$this->whatsappService->validatePhoneNumber($telefone)) {
            throw new \Exception("Número de telefone inválido: {$telefone}");
        }

        // Enviar mensagem
        $resultado = $this->whatsappService->sendMessage($telefone, $lembrete->mensagem);
        
        if (!$resultado['success']) {
            throw new \Exception($resultado['message']);
        }
        
        Log::info("WhatsApp enviado com sucesso para {$telefone}", $resultado);
    }

    private function enviarEmail($lembrete)
    {
        Log::info("Email enviado para {$lembrete->paciente->email}: " . substr($lembrete->mensagem, 0, 50) . '...');
    }
}
