<?php

namespace App\Console\Commands;

use App\Models\DatabasePool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddDatabaseToPool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:add-database {database_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona um novo database ao pool de databases disponíveis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = $this->argument('database_name');

        // Valida o formato do nome do database
        if (!preg_match('/^imunifycom_tenant_[a-z0-9_]+$/', $databaseName)) {
            $this->error('O nome do database deve seguir o formato: imunifycom_tenant_nomedotenante');
            $this->info('Exemplo: imunifycom_tenant_multiimune');
            return 1;
        }

        // Verifica se já existe no pool
        if (DatabasePool::where('database_name', $databaseName)->exists()) {
            $this->error("O database '{$databaseName}' já existe no pool!");
            return 1;
        }

        // Tenta conectar ao database para validar que ele existe
        try {
            DB::connection('mysql')->select("SHOW DATABASES LIKE '{$databaseName}'");
            
            DatabasePool::create([
                'database_name' => $databaseName,
                'in_use' => false,
            ]);

            $this->info("✓ Database '{$databaseName}' adicionado ao pool com sucesso!");
            
            $available = DatabasePool::getAvailableCount();
            $this->info("Databases disponíveis no pool: {$available}");

            if (DatabasePool::isPoolLow()) {
                $this->warn("⚠ ATENÇÃO: Pool está ficando baixo! Considere criar mais databases.");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error("Erro ao validar o database: {$e->getMessage()}");
            $this->info("Certifique-se de que o database foi criado no cPanel primeiro.");
            return 1;
        }
    }
}
