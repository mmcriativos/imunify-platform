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
        Schema::create('campanhas_vacinacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ex: "Campanha Influenza 2025"
            $table->string('vacina'); // Ex: "Influenza", "COVID-19"
            $table->text('descricao')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('publico_alvo')->nullable(); // Ex: "Idosos 60+", "Crianças 6m-5a"
            $table->integer('idade_minima')->nullable(); // Em meses
            $table->integer('idade_maxima')->nullable(); // Em meses
            $table->boolean('ativa')->default(true);
            $table->string('prioridade')->default('média'); // alta, média, baixa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campanhas_vacinacao');
    }
};
