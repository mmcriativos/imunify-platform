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
        Schema::create('estoque_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacina_id')->constrained('vacinas')->onDelete('cascade');
            $table->foreignId('lote_id')->nullable()->constrained('vacina_lotes')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Tipo de Movimentação
            $table->enum('tipo', [
                'entrada', 'saida', 'ajuste', 'perda', 'vencimento', 
                'transferencia', 'devolucao', 'aplicacao'
            ]);
            
            // Quantidades
            $table->integer('quantidade');
            $table->integer('estoque_anterior');
            $table->integer('estoque_atual');
            
            // Detalhes da Movimentação
            $table->string('motivo')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('documento_referencia')->nullable()->comment('NF, OS, etc');
            
            // Referências
            $table->foreignId('atendimento_id')->nullable()->constrained('atendimentos')->onDelete('set null');
            $table->foreignId('paciente_id')->nullable()->constrained('pacientes')->onDelete('set null');
            
            // Custo da movimentação (para cálculo de custo médio)
            $table->decimal('custo_unitario', 10, 2)->nullable();
            $table->decimal('custo_total', 10, 2)->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['vacina_id', 'created_at']);
            $table->index(['tipo', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque_movimentacoes');
    }
};
