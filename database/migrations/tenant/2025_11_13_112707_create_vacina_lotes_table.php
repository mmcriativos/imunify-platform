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
        Schema::create('vacina_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacina_id')->constrained('vacinas')->onDelete('cascade');
            
            // Identificação do Lote
            $table->string('numero_lote')->comment('Número do lote do fabricante');
            $table->string('lote_interno')->nullable()->comment('Código interno do lote');
            
            // Datas
            $table->date('data_fabricacao')->nullable();
            $table->date('data_validade');
            $table->date('data_recebimento');
            
            // Quantidades
            $table->integer('quantidade_recebida')->comment('Quantidade recebida neste lote');
            $table->integer('quantidade_atual')->comment('Quantidade atual disponível');
            $table->integer('quantidade_utilizada')->default(0)->comment('Quantidade já utilizada');
            
            // Informações da Compra
            $table->decimal('preco_unitario_compra', 10, 2)->nullable();
            $table->decimal('valor_total_compra', 10, 2)->nullable();
            $table->string('numero_nota_fiscal')->nullable();
            $table->date('data_compra')->nullable();
            
            // Fornecedor específico do lote (pode diferir do cadastro principal)
            $table->string('fornecedor_lote')->nullable();
            $table->text('observacoes')->nullable();
            
            // Status do Lote
            $table->enum('status', ['Disponivel', 'Reservado', 'Vencido', 'Bloqueado', 'Esgotado'])->default('Disponivel');
            
            // Rastreabilidade
            $table->string('origem_distribuicao')->nullable()->comment('Distribuidor/origem');
            $table->json('historico_temperatura')->nullable()->comment('Log de temperaturas se houver');
            
            $table->timestamps();
            
            // Índices
            $table->index(['vacina_id', 'data_validade']);
            $table->index(['numero_lote', 'vacina_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacina_lotes');
    }
};
