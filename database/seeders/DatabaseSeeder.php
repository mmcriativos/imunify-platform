<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário admin padrão
        User::factory()->create([
            'name' => 'Administrador MultiImune',
            'email' => 'admin@multiimune.com.br',
        ]);

        // Chamar os seeders
        $this->call([
            CidadeSeeder::class,
            VacinaSeeder::class,
        ]);
    }
}
