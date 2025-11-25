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
        Schema::create('vacina_esquema_doses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacina_id')->constrained('vacinas')->onDelete('cascade');
            $table->integer('dose_numero'); // 1, 2, 3, etc
            $table->string('nome_dose')->nullable(); // "1ª dose", "Reforço", "Dose única"
            $table->integer('idade_minima_meses')->nullable(); // Idade mínima recomendada (ex: 2 meses)
            $table->integer('idade_maxima_meses')->nullable(); // Idade máxima (ex: 12 meses)
            $table->integer('intervalo_minimo_dias')->nullable(); // Dias após dose anterior
            $table->integer('intervalo_maximo_dias')->nullable(); // Intervalo máximo recomendado
            $table->boolean('obrigatoria')->default(true); // Se é do calendário SUS ou opcional
            $table->string('rede')->default('sus'); // 'sus', 'privada', 'ambas'
            $table->text('observacoes')->nullable(); // Ex: "Apenas para grupos de risco"
            $table->integer('ordem')->default(0); // Ordem de exibição
            $table->timestamps();
            
            // Índices
            $table->index(['vacina_id', 'dose_numero']);
            $table->index('idade_minima_meses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacina_esquema_doses');
    }
};
