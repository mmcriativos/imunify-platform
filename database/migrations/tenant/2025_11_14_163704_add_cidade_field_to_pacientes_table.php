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
            // Adiciona campo de cidade livre
            $table->string('cidade')->nullable()->after('cep');
            
            // Remove a constraint foreign key primeiro
            $table->dropForeign(['cidade_id']);
            
            // Remove o campo cidade_id 
            $table->dropColumn('cidade_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Adiciona de volta o campo cidade_id
            $table->foreignId('cidade_id')->nullable()->constrained('cidades')->after('cep');
            
            // Remove o campo cidade
            $table->dropColumn('cidade');
        });
    }
};
