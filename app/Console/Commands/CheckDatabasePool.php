<?php

namespace App\Console\Commands;

use App\Models\DatabasePool;
use App\Notifications\DatabasePoolLowNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckDatabasePool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica o pool de databases e notifica admin se estiver baixo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $available = DatabasePool::getAvailableCount();
        
        $this->info("Databases disponíveis no pool: {$available}");
        
        if (DatabasePool::isPoolLow()) {
            $this->warn('⚠ Pool está baixo! Enviando notificação...');
            
            // Enviar notificação para admin
            $adminEmail = env('ADMIN_EMAIL', 'admin@imunify.com.br');
            
            Notification::route('mail', $adminEmail)
                ->notify(new DatabasePoolLowNotification($available));
            
            $this->info("✓ Notificação enviada para: {$adminEmail}");
            
            return 1; // Exit code 1 para indicar que ação é necessária
        }
        
        $this->info('✓ Pool está saudável.');
        return 0;
    }
}
