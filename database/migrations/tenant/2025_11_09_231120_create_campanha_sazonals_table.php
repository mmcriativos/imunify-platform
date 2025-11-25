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
        Schema::create('campanhas_sazonais', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->comment('Nome da campanha');
            $table->text('descricao')->nullable();
            $table->string('vacina')->comment('Vacina da campanha');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->boolean('ativa')->default(true);
            $table->string('publico_alvo')->nullable()->comment('Ex: Idosos, Gestantes, Crianças');
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->timestamps();
            
            $table->index(['ativa', 'data_fim']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campanhas_sazonais');
    }
};
