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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->boolean('e_menor')->default(false)->after('ativo');
            $table->string('responsavel_nome')->nullable()->after('e_menor');
            $table->string('responsavel_cpf', 14)->nullable()->after('responsavel_nome');
            $table->string('responsavel_telefone', 20)->nullable()->after('responsavel_cpf');
            $table->string('responsavel_parentesco')->nullable()->after('responsavel_telefone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn([
                'e_menor',
                'responsavel_nome',
                'responsavel_cpf',
                'responsavel_telefone',
                'responsavel_parentesco'
            ]);
        });
    }
};
