<?php

namespace App\Console\Commands;

use App\Models\DatabasePool;
use Illuminate\Console\Command;

class PoolStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exibe o status atual do pool de databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $total = DatabasePool::count();
        $available = DatabasePool::getAvailableCount();
        $inUse = $total - $available;

        $this->info("═══════════════════════════════════════");
        $this->info("       STATUS DO POOL DE DATABASES     ");
        $this->info("═══════════════════════════════════════");
        $this->line("");
        $this->info("Total de databases: {$total}");
        $this->info("Disponíveis: {$available}");
        $this->info("Em uso: {$inUse}");
        $this->line("");

        if (DatabasePool::isPoolLow()) {
            $this->warn("⚠ ALERTA: Pool está baixo! Crie mais databases no cPanel.");
        } else {
            $this->info("✓ Pool está saudável.");
        }

        $this->line("");
        $this->info("═══════════════════════════════════════");
        $this->line("");

        // Lista os databases
        $databases = DatabasePool::orderBy('in_use', 'desc')
            ->orderBy('allocated_at', 'desc')
            ->get();

        if ($databases->isEmpty()) {
            $this->warn("Nenhum database no pool. Use: php artisan pool:add-database <nome>");
            return 0;
        }

        $this->table(
            ['ID', 'Database', 'Status', 'Tenant', 'Alocado em'],
            $databases->map(function ($db) {
                return [
                    $db->id,
                    $db->database_name,
                    $db->in_use ? '🔴 Em uso' : '🟢 Disponível',
                    $db->tenant_id ?? '-',
                    $db->allocated_at ? $db->allocated_at->format('d/m/Y H:i') : '-',
                ];
            })
        );

        return 0;
    }
}
