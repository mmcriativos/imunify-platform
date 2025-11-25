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
        Schema::create('vacinas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('fabricante')->nullable();
            $table->text('modo_agir')->nullable();
            $table->text('indicacoes')->nullable();
            $table->text('descricao')->nullable();
            $table->decimal('preco_custo', 10, 2)->nullable();
            $table->decimal('preco_venda_cartao', 10, 2)->nullable();
            $table->decimal('preco_venda_pix', 10, 2)->nullable();
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->decimal('valor_padrao', 10, 2)->nullable();
            $table->integer('validade_dias')->nullable()->comment('Validade em dias após aplicação');
            $table->integer('numero_doses')->nullable()->default(1);
            $table->integer('intervalo_doses_dias')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacinas');
    }
};
