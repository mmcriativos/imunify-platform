<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TenantStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:check-status {--dry-run : Simula a execução sem fazer alterações}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica e atualiza o status de trials, períodos de graça e suspensões dos tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 Modo dry-run ativo - nenhuma alteração será feita');
        }

        $this->info('Verificando status dos tenants...');
        
        $stats = [
            'grace_period_started' => 0,
            'suspended' => 0,
            'archived' => 0,
            'deleted' => 0,
        ];

        // 1. Verificar trials expirados → iniciar período de graça
        $this->processExpiredTrials($dryRun, $stats);

        // 2. Verificar períodos de graça expirados → suspender
        $this->processExpiredGracePeriods($dryRun, $stats);

        // 3. Verificar suspensões com mais de 30 dias → arquivar
        $this->processExpiredSuspensions($dryRun, $stats);

        // 4. Verificar arquivados com mais de 60 dias → deletar
        $this->processExpiredArchives($dryRun, $stats);

        // Resumo
        $this->newLine();
        $this->info('✅ Processamento concluído!');
        $this->table(
            ['Ação', 'Quantidade'],
            [
                ['Períodos de graça iniciados', $stats['grace_period_started']],
                ['Tenants suspensos', $stats['suspended']],
                ['Tenants arquivados', $stats['archived']],
                ['Tenants deletados', $stats['deleted']],
            ]
        );
    }

    protected function processExpiredTrials($dryRun, &$stats)
    {
        $expiredTrials = Tenant::where('trial_ends_at', '<=', Carbon::now())
            ->whereNull('grace_period_ends_at')
            ->whereNull('subscription_id') // Sem assinatura ativa
            ->get();

        foreach ($expiredTrials as $tenant) {
            $this->warn("Trial expirado: {$tenant->id} - Iniciando período de graça");
            
            if (!$dryRun) {
                $tenant->grace_period_ends_at = Carbon::now()->addDays(7);
                $tenant->save();
                
                // TODO: Enviar email notificando período de graça
                // Mail::to($tenant->admin_email)->send(new GracePeriodStarted($tenant));
            }
            
            $stats['grace_period_started']++;
        }
    }

    protected function processExpiredGracePeriods($dryRun, &$stats)
    {
        $expiredGracePeriods = Tenant::where('grace_period_ends_at', '<=', Carbon::now())
            ->whereNull('suspended_at')
            ->whereNull('subscription_id')
            ->get();

        foreach ($expiredGracePeriods as $tenant) {
            $this->warn("Período de graça expirado: {$tenant->id} - Suspendendo conta");
            
            if (!$dryRun) {
                $tenant->suspended_at = Carbon::now();
                $tenant->save();
                
                // TODO: Enviar email notificando suspensão
                // Mail::to($tenant->admin_email)->send(new AccountSuspended($tenant));
            }
            
            $stats['suspended']++;
        }
    }

    protected function processExpiredSuspensions($dryRun, &$stats)
    {
        $expiredSuspensions = Tenant::where('suspended_at', '<=', Carbon::now()->subDays(30))
            ->whereNull('archived_at')
            ->get();

        foreach ($expiredSuspensions as $tenant) {
            $this->warn("Suspensão há mais de 30 dias: {$tenant->id} - Arquivando");
            
            if (!$dryRun) {
                $tenant->archived_at = Carbon::now();
                $tenant->save();
                
                // TODO: Enviar email final antes de deletar em 60 dias
                // Mail::to($tenant->admin_email)->send(new AccountArchived($tenant));
            }
            
            $stats['archived']++;
        }
    }

    protected function processExpiredArchives($dryRun, &$stats)
    {
        $expiredArchives = Tenant::where('archived_at', '<=', Carbon::now()->subDays(60))
            ->get();

        foreach ($expiredArchives as $tenant) {
            $this->error("Arquivado há mais de 60 dias: {$tenant->id} - DELETANDO permanentemente");
            
            if (!$dryRun) {
                // Deleta o tenant e todos os seus dados
                $tenant->delete();
            }
            
            $stats['deleted']++;
        }
    }
}
