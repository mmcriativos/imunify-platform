<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MigrarParaTenant extends Command
{
    protected $signature = 'tenant:migrar-multiimune';
    protected $description = 'Migra dados existentes da Multi Imune para estrutura tenant';

    public function handle()
    {
        $this->info('🚀 Iniciando migração dos dados da Multi Imune para estrutura tenant...');
        $this->newLine();

        // 1. Verificar se tenant já existe
        $tenant = Tenant::where('id', 'multiimune')->first();
        
        if ($tenant) {
            $this->warn('⚠️  Tenant "multiimune" já existe!');
            if (!$this->confirm('Deseja recriar o tenant? (isso vai APAGAR os dados atuais do tenant)', false)) {
                $this->error('Migração cancelada.');
                return 1;
            }
            
            $this->info('Deletando tenant existente...');
            $tenant->delete();
        }

        // 2. Contar dados atuais
        $this->info('📊 Contando dados atuais no banco central...');
        $stats = [
            'pacientes' => DB::table('pacientes')->count(),
            'atendimentos' => DB::table('atendimentos')->count(),
            'vacinas' => DB::table('vacinas')->count(),
            'cidades' => DB::table('cidades')->count(),
            'atendimento_vacinas' => DB::table('atendimento_vacinas')->count(),
            'users' => DB::table('users')->count(),
        ];

        $this->table(
            ['Tabela', 'Quantidade'],
            collect($stats)->map(fn($count, $table) => [$table, $count])->toArray()
        );
        $this->newLine();

        if (!$this->confirm('Confirma a migração destes dados?', true)) {
            $this->error('Migração cancelada.');
            return 1;
        }

        // 3. Criar tenant Multi Imune
        $this->info('📝 Criando tenant Multi Imune...');
        
        $plan = Plan::where('name', 'Profissional')->first();
        if (!$plan) {
            $this->error('Plano Profissional não encontrado! Execute php artisan db:seed --class=PlanSeeder');
            return 1;
        }

        $tenant = Tenant::create([
            'id' => 'multiimune',
            'plan_id' => $plan->id,
            'name' => 'Multi Imune',
            'cnpj' => '12.345.678/0001-90', // Ajuste com o CNPJ real
            'email' => 'contato@multiimune.com.br',
            'phone' => '(11) 98765-4321', // Ajuste com telefone real
            'trial_ends_at' => now()->addDays(7),
        ]);

        $this->info("✅ Tenant criado: {$tenant->id}");
        $this->newLine();

        // 4. Criar domínio
        $this->info('🌐 Criando domínio...');
        $tenant->domains()->create([
            'domain' => 'multiimune.imunify.com.br', // Em produção
            // 'domain' => 'multiimune.localhost', // Local se preferir
        ]);
        $this->info('✅ Domínio criado: multiimune.imunify.com.br');
        $this->newLine();

        // 5. Executar migrations no banco tenant
        $this->info('🗄️  Executando migrations no banco tenant...');
        $tenant->run(function () {
            $this->call('migrate', ['--force' => true]);
        });
        $this->info('✅ Migrations executadas');
        $this->newLine();

        // 6. Migrar dados
        $this->info('📦 Migrando dados para o banco tenant...');
        
        $tenant->run(function () use ($stats) {
            $bar = $this->output->createProgressBar(array_sum($stats));
            $bar->start();

            // Migrar Cidades PRIMEIRO
            $cidades = DB::connection('mysql')->table('cidades')->get();
            foreach ($cidades as $cidade) {
                DB::table('cidades')->insert((array) $cidade);
                $bar->advance();
            }

            // Migrar Users ANTES de tudo que depende deles
            $users = DB::connection('mysql')->table('users')->get();
            foreach ($users as $user) {
                DB::table('users')->insert((array) $user);
                $bar->advance();
            }

            // Migrar Pacientes
            $pacientes = DB::connection('mysql')->table('pacientes')->get();
            foreach ($pacientes as $paciente) {
                DB::table('pacientes')->insert((array) $paciente);
                $bar->advance();
            }

            // Migrar Vacinas
            $vacinas = DB::connection('mysql')->table('vacinas')->get();
            foreach ($vacinas as $vacina) {
                DB::table('vacinas')->insert((array) $vacina);
                $bar->advance();
            }

            // Migrar Atendimentos (depende de users, pacientes, cidades)
            $atendimentos = DB::connection('mysql')->table('atendimentos')->get();
            foreach ($atendimentos as $atendimento) {
                DB::table('atendimentos')->insert((array) $atendimento);
                $bar->advance();
            }

            // Migrar Atendimento_Vacinas (depende de atendimentos e vacinas)
            $atendimentoVacinas = DB::connection('mysql')->table('atendimento_vacinas')->get();
            foreach ($atendimentoVacinas as $av) {
                DB::table('atendimento_vacinas')->insert((array) $av);
                $bar->advance();
            }

            $bar->finish();
        });

        $this->newLine(2);
        $this->info('✅ Dados migrados com sucesso!');
        $this->newLine();

        // 7. Verificar dados migrados
        $this->info('🔍 Verificando dados no tenant...');
        $tenant->run(function () {
            $tenantStats = [
                'pacientes' => DB::table('pacientes')->count(),
                'atendimentos' => DB::table('atendimentos')->count(),
                'vacinas' => DB::table('vacinas')->count(),
                'cidades' => DB::table('cidades')->count(),
                'atendimento_vacinas' => DB::table('atendimento_vacinas')->count(),
                'users' => DB::table('users')->count(),
            ];

            $this->table(
                ['Tabela', 'Quantidade no Tenant'],
                collect($tenantStats)->map(fn($count, $table) => [$table, $count])->toArray()
            );
        });

        $this->newLine();
        $this->info('✨ Migração concluída com sucesso!');
        $this->newLine();
        $this->info('🔑 Informações de Acesso:');
        $this->line("   URL: http://multiimune.imunify.com.br/login");
        $this->line("   Ou local: http://multiimune.localhost/login");
        $this->newLine();
        
        $this->warn('⚠️  IMPORTANTE:');
        $this->line('   1. Configure o subdomínio no seu servidor/hosts');
        $this->line('   2. Use as mesmas credenciais de usuário que já existiam');
        $this->line('   3. Em produção, ajuste o domínio no banco central (tabela domains)');
        $this->newLine();

        return 0;
    }
}
