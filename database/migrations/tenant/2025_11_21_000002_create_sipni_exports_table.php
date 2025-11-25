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
        Schema::create('sipni_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atendimento_id')->constrained('atendimentos')->onDelete('cascade');
            $table->foreignId('atendimento_vacina_id')->constrained('atendimento_vacina')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->foreignId('vacina_id')->constrained('vacinas');
            $table->foreignId('usuario_id')->nullable()->constrained('users')
                ->comment('Profissional que aplicou');
            
            // Status da exportação
            $table->enum('status', ['pendente', 'processando', 'enviado', 'erro', 'rejeitado'])
                ->default('pendente');
            $table->timestamp('data_tentativa')->nullable();
            $table->timestamp('data_envio')->nullable();
            $table->integer('tentativas')->default(0);
            
            // Dados da resposta SIPNI
            $table->string('protocolo_sipni')->nullable()
                ->comment('Número de protocolo retornado pelo SIPNI');
            $table->text('resposta_sipni')->nullable()
                ->comment('Resposta completa da API');
            $table->text('erro_mensagem')->nullable();
            
            // Payload enviado
            $table->json('payload')->nullable()
                ->comment('JSON/XML enviado ao SIPNI');
            
            $table->timestamps();
            
            // Índices
            $table->index('status');
            $table->index('data_envio');
            $table->index('protocolo_sipni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipni_exports');
    }
};
