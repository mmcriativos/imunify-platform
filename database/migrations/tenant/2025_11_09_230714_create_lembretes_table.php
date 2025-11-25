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
        Schema::create('lembretes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->enum('tipo', ['dose_proxima', 'campanha_terminando', 'dose_atrasada'])->comment('Tipo de lembrete');
            $table->enum('canal', ['whatsapp', 'email', 'ambos'])->default('ambos')->comment('Canal de envio');
            $table->string('destinatario')->comment('Telefone ou email do destinatário');
            $table->text('mensagem')->comment('Conteúdo da mensagem enviada');
            $table->enum('status', ['pendente', 'enviado', 'erro', 'cancelado'])->default('pendente');
            $table->text('erro_mensagem')->nullable()->comment('Detalhes do erro caso falhe');
            $table->timestamp('data_agendamento')->nullable()->comment('Quando deve ser enviado');
            $table->timestamp('data_envio')->nullable()->comment('Quando foi efetivamente enviado');
            $table->json('metadata')->nullable()->comment('Dados extras: vacina, dose, campanha_id, etc');
            $table->timestamps();
            
            // Índices para performance
            $table->index('paciente_id');
            $table->index('status');
            $table->index('data_agendamento');
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembretes');
    }
};
