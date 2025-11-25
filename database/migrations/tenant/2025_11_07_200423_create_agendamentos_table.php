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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->nullable()->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('atendimento_id')->nullable()->constrained('atendimentos')->onDelete('set null');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->enum('tipo', ['atendimento', 'consulta', 'lembrete', 'outros'])->default('atendimento');
            $table->enum('status', ['agendado', 'confirmado', 'realizado', 'cancelado'])->default('agendado');
            $table->string('local')->nullable();
            $table->string('cor', 20)->default('#3B82F6')->comment('Cor para exibição no calendário');
            $table->text('observacoes')->nullable();
            $table->boolean('dia_inteiro')->default(false);
            $table->timestamps();
            
            $table->index('data_inicio');
            $table->index('data_fim');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
