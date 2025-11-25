<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar código SIPNI nas vacinas
        Schema::table('vacinas', function (Blueprint $table) {
            $table->string('codigo_sipni')->nullable()->after('codigo_barras')
                ->comment('Código da vacina no sistema SIPNI');
            $table->string('estrategia_vacinacao')->nullable()->after('codigo_sipni')
                ->comment('Rotina, Especial, Campanha, etc');
        });

        // Adicionar CNS dos profissionais
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->after('email')
                ->comment('CPF do profissional');
            $table->string('cns', 15)->nullable()->after('cpf')
                ->comment('Cartão Nacional de Saúde');
            $table->string('conselho_classe')->nullable()->after('cns')
                ->comment('COREN, CRM, etc');
            $table->string('numero_conselho')->nullable()->after('conselho_classe')
                ->comment('Número do registro no conselho');
        });

        // Adicionar CNS dos pacientes
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('cns', 15)->nullable()->after('cpf')
                ->comment('Cartão Nacional de Saúde do paciente');
            $table->string('nome_mae')->nullable()->after('data_nascimento')
                ->comment('Nome da mãe (obrigatório SIPNI)');
            $table->enum('sexo', ['M', 'F'])->nullable()->after('nome_mae')
                ->comment('Sexo biológico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacinas', function (Blueprint $table) {
            $table->dropColumn(['codigo_sipni', 'estrategia_vacinacao']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'cns', 'conselho_classe', 'numero_conselho']);
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['cns', 'nome_mae', 'sexo']);
        });
    }
};
