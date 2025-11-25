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
        Schema::create('confirmacoes_presenca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained('agendamentos')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('lembrete_enviado_id')->nullable()->constrained('lembretes_enviados')->onDelete('set null');
            $table->string('telefone', 20);
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->text('mensagem_botao')->nullable(); // Mensagem com botões enviada
            $table->string('resposta_botao')->nullable(); // Qual botão foi clicado
            $table->string('message_id')->nullable(); // ID da mensagem Z-API
            $table->timestamp('enviado_em')->nullable();
            $table->timestamp('respondido_em')->nullable();
            $table->timestamps();
            
            $table->index(['agendamento_id', 'status']);
            $table->index(['paciente_id', 'status']);
            $table->index('enviado_em');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirmacoes_presenca');
    }
};
