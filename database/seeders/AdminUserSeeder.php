<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário administrativo padrão
        User::updateOrCreate(
            ['email' => 'admin@multiimune.com.br'],
            [
                'name' => 'Administrador',
                'email' => 'admin@multiimune.com.br',
                'password' => Hash::make('multiimune123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Usuário administrativo criado com sucesso!');
        $this->command->info('📧 Email: admin@multiimune.com.br');
        $this->command->info('🔑 Senha: multiimune123');
        $this->command->warn('⚠️  IMPORTANTE: Altere esta senha após o primeiro acesso!');
    }
}
