<?php

namespace App\Console\Commands;

use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\LembreteEnviado;
use App\Models\ConfirmacaoPresenca;
use App\Models\CampanhaVacinacao;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnviarLembretesAutomaticos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lembretes:auto {--tipo=todos : Tipo de lembrete (7dias|1dia|hoje|atrasados|todos)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia lembretes automáticos de vacinação via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $this->info('🚀 Iniciando envio de lembretes automáticos...');
        $this->newLine();

        if (!$whatsappService->isConfigured()) {
            $this->error('❌ WhatsApp não configurado! Configure no .env');
            return 1;
        }

        // Verificar se há quota disponível
        if (!$whatsappService->hasQuota()) {
            $usageInfo = $whatsappService->getUsageInfo();
            $this->error('⚠️  Quota de mensagens esgotada!');
            $this->warn("   Enviadas: {$usageInfo['sent']} / {$usageInfo['quota']}");
            $this->warn("   Faça upgrade do seu plano para continuar enviando mensagens.");
            return 1;
        }

        // Exibir informações de uso
        $usageInfo = $whatsappService->getUsageInfo();
        if ($usageInfo['quota_unlimited']) {
            $this->info("📊 Quota: Ilimitado (Enviadas: {$usageInfo['sent']} este mês)");
        } else {
            $this->info("📊 Quota: {$usageInfo['sent']} / {$usageInfo['quota']} ({$usageInfo['remaining']} restantes)");
        }
        $this->newLine();

        $tipo = $this->option('tipo');
        $enviados = 0;
        $erros = 0;

        // Determinar quais lembretes enviar
        if ($tipo === 'todos' || $tipo === '7dias') {
            [$env, $err] = $this->enviarLembretes7Dias($whatsappService);
            $enviados += $env;
            $erros += $err;
        }

        if ($tipo === 'todos' || $tipo === '1dia') {
            [$env, $err] = $this->enviarLembretes1Dia($whatsappService);
            $enviados += $env;
            $erros += $err;
        }

        if ($tipo === 'todos' || $tipo === 'hoje') {
            [$env, $err] = $this->enviarLembretesHoje($whatsappService);
            $enviados += $env;
            $erros += $err;
        }

        if ($tipo === 'todos' || $tipo === 'atrasados') {
            [$env, $err] = $this->enviarLembretesAtrasados($whatsappService);
            $enviados += $env;
            $erros += $err;
        }

        // Resumo
        $this->newLine();
        $this->info("📊 Resumo:");
        $this->table(
            ['Métrica', 'Quantidade'],
            [
                ['✅ Enviados com sucesso', $enviados],
                ['❌ Erros', $erros],
                ['📱 Total processado', $enviados + $erros],
            ]
        );

        Log::info('Lembretes automáticos enviados', [
            'enviados' => $enviados,
            'erros' => $erros,
            'tipo' => $tipo,
        ]);

        return 0;
    }

    /**
     * Envia lembretes para agendamentos daqui a 7 dias
     */
    private function enviarLembretes7Dias(WhatsAppService $whatsappService): array
    {
        $this->info('📅 Processando lembretes para 7 dias antes...');

        $dataAlvo = Carbon::now()->addDays(7)->startOfDay();
        $dataFim = Carbon::now()->addDays(7)->endOfDay();

        $agendamentos = Agendamento::with('paciente')
            ->whereBetween('data_inicio', [$dataAlvo, $dataFim])
            ->whereIn('status', ['agendado', 'confirmado'])
            ->whereHas('paciente', function ($query) {
                $query->whereNotNull('telefone');
            })
            ->get();

        return $this->processarEnvio($agendamentos, $whatsappService, '7dias');
    }

    /**
     * Envia lembretes para agendamentos daqui a 1 dia
     */
    private function enviarLembretes1Dia(WhatsAppService $whatsappService): array
    {
        $this->info('📅 Processando lembretes para 1 dia antes...');

        $dataAlvo = Carbon::tomorrow()->startOfDay();
        $dataFim = Carbon::tomorrow()->endOfDay();

        $agendamentos = Agendamento::with('paciente')
            ->whereBetween('data_inicio', [$dataAlvo, $dataFim])
            ->whereIn('status', ['agendado', 'confirmado'])
            ->whereHas('paciente', function ($query) {
                $query->whereNotNull('telefone');
            })
            ->get();

        return $this->processarEnvio($agendamentos, $whatsappService, '1dia');
    }

    /**
     * Envia lembretes para agendamentos de hoje
     */
    private function enviarLembretesHoje(WhatsAppService $whatsappService): array
    {
        $this->info('📅 Processando lembretes para hoje...');

        $agendamentos = Agendamento::with('paciente')
            ->whereDate('data_inicio', Carbon::today())
            ->whereIn('status', ['agendado', 'confirmado'])
            ->whereHas('paciente', function ($query) {
                $query->whereNotNull('telefone');
            })
            ->get();

        return $this->processarEnvio($agendamentos, $whatsappService, 'hoje');
    }

    /**
     * Envia lembretes para agendamentos atrasados
     */
    private function enviarLembretesAtrasados(WhatsAppService $whatsappService): array
    {
        $this->info('⚠️  Processando lembretes de agendamentos atrasados...');

        $agendamentos = Agendamento::with('paciente')
            ->where('data_inicio', '<', Carbon::now())
            ->where('status', 'agendado')
            ->whereHas('paciente', function ($query) {
                $query->whereNotNull('telefone');
            })
            ->get();

        return $this->processarEnvio($agendamentos, $whatsappService, 'atrasado');
    }

    /**
     * Processa o envio de mensagens
     */
    private function processarEnvio($agendamentos, WhatsAppService $whatsappService, string $tipo): array
    {
        $enviados = 0;
        $erros = 0;

        foreach ($agendamentos as $agendamento) {
            $paciente = $agendamento->paciente;
            
            if (!$paciente || !$paciente->telefone) {
                continue;
            }

            // Verificar quota antes de cada envio
            if (!$whatsappService->hasQuota()) {
                $this->warn("⚠️  Quota esgotada! Parando o envio de lembretes.");
                break;
            }

            $mensagem = $this->gerarMensagem($agendamento, $paciente, $tipo);

            // Adicionar texto solicitando confirmação
            $mensagemComBotoes = $mensagem . "\n\n" . 
                "❓ *Você confirma sua presença?*\n" .
                "👇 Clique em uma das opções abaixo:";

            // Definir botões de confirmação
            $botoes = [
                ['id' => 'btn_confirmar', 'label' => '✅ Confirmar Presença'],
                ['id' => 'btn_cancelar', 'label' => '❌ Cancelar Agendamento']
            ];

            $this->line("📤 Enviando para {$paciente->nome} ({$paciente->telefone})...");

            // Tentar enviar com botões se disponível, senão enviar mensagem simples
            $resultado = null;
            if (method_exists($whatsappService, 'sendButtonMessage')) {
                $resultado = $whatsappService->sendButtonMessage($paciente->telefone, $mensagemComBotoes, $botoes);
            } else {
                // Fallback: enviar mensagem simples
                $sucesso = $whatsappService->sendMessage($paciente->telefone, $mensagemComBotoes);
                $resultado = ['success' => $sucesso, 'data' => []];
            }

            if ($resultado['success']) {
                $this->info("  ✅ Enviado com sucesso");
                $enviados++;
                
                // Registrar no banco
                $lembreteEnviado = LembreteEnviado::create([
                    'paciente_id' => $paciente->id,
                    'agendamento_id' => $agendamento->id,
                    'tipo' => $tipo,
                    'telefone' => $paciente->telefone,
                    'mensagem' => $mensagem,
                    'sucesso' => true,
                    'message_id' => $resultado['data']['messageId'] ?? null,
                    'enviado_em' => now(),
                ]);

                // Criar registro de confirmação pendente
                ConfirmacaoPresenca::create([
                    'agendamento_id' => $agendamento->id,
                    'paciente_id' => $paciente->id,
                    'lembrete_enviado_id' => $lembreteEnviado->id,
                    'telefone' => $paciente->telefone,
                    'status' => 'pendente',
                    'mensagem_botao' => $mensagemComBotoes,
                    'message_id' => $resultado['data']['messageId'] ?? null,
                    'enviado_em' => now(),
                ]);
                
                Log::info('Lembrete com botões enviado', [
                    'paciente_id' => $paciente->id,
                    'agendamento_id' => $agendamento->id,
                    'tipo' => $tipo,
                    'telefone' => $paciente->telefone,
                ]);
            } else {
                $this->error("  ❌ Erro: {$resultado['message']}");
                $erros++;
                
                // Registrar falha no banco
                LembreteEnviado::create([
                    'paciente_id' => $paciente->id,
                    'agendamento_id' => $agendamento->id,
                    'tipo' => $tipo,
                    'telefone' => $paciente->telefone,
                    'mensagem' => $mensagem,
                    'sucesso' => false,
                    'erro' => $resultado['message'],
                    'enviado_em' => now(),
                ]);
                
                Log::error('Erro ao enviar lembrete', [
                    'paciente_id' => $paciente->id,
                    'agendamento_id' => $agendamento->id,
                    'tipo' => $tipo,
                    'erro' => $resultado['message'],
                ]);
            }

            // Pequeno delay para não sobrecarregar a API
            usleep(500000); // 0.5 segundos
        }

        $this->line("  Total: {$enviados} enviados, {$erros} erros");
        $this->newLine();

        return [$enviados, $erros];
    }

    /**
     * Gera a mensagem personalizada de acordo com o tipo
     */
    private function gerarMensagem(Agendamento $agendamento, Paciente $paciente, string $tipo): string
    {
        $primeiroNome = explode(' ', $paciente->nome)[0];
        $dataFormatada = $agendamento->data_inicio->format('d/m/Y');
        $horaFormatada = $agendamento->data_inicio->format('H:i');
        $diaSemanaMapa = [
            'Sunday' => 'domingo',
            'Monday' => 'segunda-feira',
            'Tuesday' => 'terça-feira',
            'Wednesday' => 'quarta-feira',
            'Thursday' => 'quinta-feira',
            'Friday' => 'sexta-feira',
            'Saturday' => 'sábado',
        ];
        $diaSemana = $diaSemanaMapa[$agendamento->data_inicio->format('l')] ?? '';

        // 🎯 VERIFICAR SE EXISTE CAMPANHA ATIVA
        $campanha = $this->verificarCampanhaAtiva($agendamento, $paciente);
        
        if ($campanha) {
            return $this->gerarMensagemComCampanha($agendamento, $paciente, $campanha, $tipo, $primeiroNome, $dataFormatada, $horaFormatada, $diaSemana);
        }

        // Mensagem padrão (sem campanha)
        switch ($tipo) {
            case '7dias':
                return "🩺 *MultiImune - Lembrete de Vacinação*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "📅 Lembramos que você tem um agendamento de vacinação em *7 dias*:" . PHP_EOL . PHP_EOL .
                       "🗓️ Data: *{$dataFormatada}* ({$diaSemana})" . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Tipo: *{$agendamento->titulo}*" . PHP_EOL . PHP_EOL .
                       "⚠️ *Importante:*" . PHP_EOL .
                       "• Chegue com 10 minutos de antecedência" . PHP_EOL .
                       "• Traga documento com foto" . PHP_EOL .
                       "• Traga sua carteira de vacinação" . PHP_EOL . PHP_EOL .
                       "📞 Precisa reagendar? Entre em contato!" . PHP_EOL . PHP_EOL .
                       "_Enviado automaticamente pelo Sistema MultiImune_";

            case '1dia':
                return "🩺 *MultiImune - Lembrete Importante*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "⏰ Sua vacinação é *AMANHÃ*!" . PHP_EOL . PHP_EOL .
                       "🗓️ Data: *{$dataFormatada}* ({$diaSemana})" . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Vacina: *{$agendamento->titulo}*" . PHP_EOL . PHP_EOL .
                       "✅ *Não esqueça de trazer:*" . PHP_EOL .
                       "• Documento com foto (RG ou CNH)" . PHP_EOL .
                       "• Carteira de vacinação" . PHP_EOL .
                       "• Cartão do SUS (se tiver)" . PHP_EOL . PHP_EOL .
                       "💙 Contamos com você!" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            case 'hoje':
                return "🩺 *MultiImune - É HOJE!*" . PHP_EOL . PHP_EOL .
                       "Bom dia, *{$primeiroNome}*! ☀️" . PHP_EOL . PHP_EOL .
                       "⏰ Sua vacinação é *HOJE*!" . PHP_EOL . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Vacina: *{$agendamento->titulo}*" . PHP_EOL . PHP_EOL .
                       "✅ Tudo pronto? Não esqueça:" . PHP_EOL .
                       "• Documento com foto" . PHP_EOL .
                       "• Carteira de vacinação" . PHP_EOL . PHP_EOL .
                       "Até logo! 😊" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            case 'atrasado':
                $diasAtrasado = abs($agendamento->data_inicio->diffInDays(Carbon::now()));
                return "🩺 *MultiImune - Agendamento Pendente*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "⚠️ Percebemos que você tinha um agendamento em:" . PHP_EOL .
                       "📅 *{$dataFormatada}* às *{$horaFormatada}*" . PHP_EOL . PHP_EOL .
                       "💉 Vacina: *{$agendamento->titulo}*" . PHP_EOL . PHP_EOL .
                       "🔄 Que tal reagendar? A vacinação é importante para sua saúde!" . PHP_EOL . PHP_EOL .
                       "📞 Entre em contato conosco para marcar um novo horário." . PHP_EOL . PHP_EOL .
                       "💙 Cuidar da saúde é cuidar do futuro!" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            default:
                return "Lembrete de vacinação - {$agendamento->titulo} em {$dataFormatada} às {$horaFormatada}";
        }
    }

    /**
     * Verifica se existe campanha ativa para o agendamento
     */
    private function verificarCampanhaAtiva(Agendamento $agendamento, Paciente $paciente): ?CampanhaVacinacao
    {
        // Buscar título da vacina do agendamento
        $tituloVacina = $agendamento->titulo ?? '';
        
        // Buscar campanhas ativas que correspondam à vacina
        $campanhas = CampanhaVacinacao::where('ativa', true)
            ->where('data_inicio', '<=', now())
            ->where('data_fim', '>=', now())
            ->get();
        
        foreach ($campanhas as $campanha) {
            // Verificar se a vacina da campanha corresponde ao agendamento
            if (stripos($tituloVacina, $campanha->vacina) !== false || 
                stripos($campanha->vacina, $tituloVacina) !== false) {
                
                // Verificar se o paciente está no público-alvo (idade)
                if ($this->pacienteNoPubricoAlvo($paciente, $campanha)) {
                    return $campanha;
                }
            }
        }
        
        return null;
    }

    /**
     * Verifica se o paciente está no público-alvo da campanha
     */
    private function pacienteNoPubricoAlvo(Paciente $paciente, CampanhaVacinacao $campanha): bool
    {
        // Se não há restrição de idade, todos são elegíveis
        if (!$campanha->idade_minima && !$campanha->idade_maxima) {
            return true;
        }
        
        // Calcular idade do paciente
        if (!$paciente->data_nascimento) {
            return true; // Se não tem data de nascimento, não filtrar
        }
        
        $idade = Carbon::parse($paciente->data_nascimento)->age;
        
        // Verificar idade mínima
        if ($campanha->idade_minima && $idade < $campanha->idade_minima) {
            return false;
        }
        
        // Verificar idade máxima
        if ($campanha->idade_maxima && $idade > $campanha->idade_maxima) {
            return false;
        }
        
        return true;
    }

    /**
     * Gera mensagem personalizada com informações da campanha
     */
    private function gerarMensagemComCampanha(
        Agendamento $agendamento, 
        Paciente $paciente, 
        CampanhaVacinacao $campanha, 
        string $tipo,
        string $primeiroNome,
        string $dataFormatada,
        string $horaFormatada,
        string $diaSemana
    ): string {
        $badgePrioridade = $campanha->prioridade === 'alta' ? '🔴' : ($campanha->prioridade === 'média' ? '🟡' : '🟢');
        
        switch ($tipo) {
            case '7dias':
                return "🩺 *MultiImune - Lembrete de Vacinação*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "🎯 *{$campanha->nome}*" . PHP_EOL .
                       "{$badgePrioridade} Prioridade: *" . ucfirst($campanha->prioridade) . "*" . PHP_EOL . PHP_EOL .
                       "📅 Seu agendamento é em *7 dias*:" . PHP_EOL . PHP_EOL .
                       "🗓️ Data: *{$dataFormatada}* ({$diaSemana})" . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Vacina: *{$campanha->vacina}*" . PHP_EOL . PHP_EOL .
                       ($campanha->descricao ? "ℹ️ {$campanha->descricao}" . PHP_EOL . PHP_EOL : "") .
                       "⚠️ *Importante:*" . PHP_EOL .
                       "• Chegue com 10 minutos de antecedência" . PHP_EOL .
                       "• Traga documento com foto" . PHP_EOL .
                       "• Traga sua carteira de vacinação" . PHP_EOL . PHP_EOL .
                       "📞 Precisa reagendar? Entre em contato!" . PHP_EOL . PHP_EOL .
                       "_Enviado automaticamente pelo Sistema MultiImune_";

            case '1dia':
                return "🩺 *MultiImune - Lembrete Importante*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "🎯 *{$campanha->nome}*" . PHP_EOL .
                       "⏰ Sua vacinação é *AMANHÃ*!" . PHP_EOL . PHP_EOL .
                       "🗓️ Data: *{$dataFormatada}* ({$diaSemana})" . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Vacina: *{$campanha->vacina}*" . PHP_EOL . PHP_EOL .
                       ($campanha->descricao ? "ℹ️ {$campanha->descricao}" . PHP_EOL . PHP_EOL : "") .
                       "✅ *Não esqueça de trazer:*" . PHP_EOL .
                       "• Documento com foto (RG ou CNH)" . PHP_EOL .
                       "• Carteira de vacinação" . PHP_EOL .
                       "• Cartão do SUS (se tiver)" . PHP_EOL . PHP_EOL .
                       "💙 Contamos com você!" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            case 'hoje':
                return "🩺 *MultiImune - É HOJE!*" . PHP_EOL . PHP_EOL .
                       "Bom dia, *{$primeiroNome}*! ☀️" . PHP_EOL . PHP_EOL .
                       "🎯 *{$campanha->nome}*" . PHP_EOL .
                       "⏰ Sua vacinação é *HOJE*!" . PHP_EOL . PHP_EOL .
                       "🕐 Horário: *{$horaFormatada}*" . PHP_EOL .
                       "📍 Local: *{$agendamento->local}*" . PHP_EOL .
                       "💉 Vacina: *{$campanha->vacina}*" . PHP_EOL . PHP_EOL .
                       "✅ Tudo pronto? Não esqueça:" . PHP_EOL .
                       "• Documento com foto" . PHP_EOL .
                       "• Carteira de vacinação" . PHP_EOL . PHP_EOL .
                       "Até logo! 😊" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            case 'atrasado':
                return "🩺 *MultiImune - Agendamento Pendente*" . PHP_EOL . PHP_EOL .
                       "Olá, *{$primeiroNome}*!" . PHP_EOL . PHP_EOL .
                       "🎯 *{$campanha->nome}*" . PHP_EOL .
                       "⚠️ Percebemos que você tinha um agendamento em:" . PHP_EOL .
                       "📅 *{$dataFormatada}* às *{$horaFormatada}*" . PHP_EOL . PHP_EOL .
                       "💉 Vacina: *{$campanha->vacina}*" . PHP_EOL . PHP_EOL .
                       ($campanha->descricao ? "ℹ️ {$campanha->descricao}" . PHP_EOL . PHP_EOL : "") .
                       "🔄 Que tal reagendar? A vacinação é importante para sua saúde!" . PHP_EOL . PHP_EOL .
                       "📞 Entre em contato conosco para marcar um novo horário." . PHP_EOL . PHP_EOL .
                       "💙 Cuidar da saúde é cuidar do futuro!" . PHP_EOL . PHP_EOL .
                       "_Sistema MultiImune_";

            default:
                return "🎯 {$campanha->nome} - {$agendamento->titulo} em {$dataFormatada} às {$horaFormatada}";
        }
    }
}
