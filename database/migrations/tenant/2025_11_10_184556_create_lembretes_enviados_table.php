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
        Schema::create('lembretes_enviados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('agendamento_id')->nullable()->constrained('agendamentos')->onDelete('set null');
            $table->string('tipo'); // 7dias, 1dia, hoje, atrasado
            $table->string('telefone');
            $table->text('mensagem');
            $table->boolean('sucesso')->default(false);
            $table->text('erro')->nullable();
            $table->string('message_id')->nullable(); // ID retornado pela API
            $table->timestamp('enviado_em');
            $table->timestamps();

            $table->index(['paciente_id', 'tipo', 'enviado_em']);
            $table->index('agendamento_id');
            $table->index('enviado_em');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembretes_enviados');
    }
};
