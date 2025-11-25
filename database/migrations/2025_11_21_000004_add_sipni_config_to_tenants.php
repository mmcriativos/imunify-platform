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
        // Usar conexão mysql (central/default)
        Schema::connection('mysql')->table('tenants', function (Blueprint $table) {
            if (!Schema::connection('mysql')->hasColumn('tenants', 'cnes')) {
                $table->string('cnes')->nullable()->after('id')
                    ->comment('Cadastro Nacional de Estabelecimentos de Saúde');
            }
            if (!Schema::connection('mysql')->hasColumn('tenants', 'sipni_config')) {
                $table->json('sipni_config')->nullable()->after('data')
                    ->comment('Configurações de integração SIPNI');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->table('tenants', function (Blueprint $table) {
            $table->dropColumn(['cnes', 'sipni_config']);
        });
    }
};
