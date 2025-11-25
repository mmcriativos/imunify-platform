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
        Schema::table('vacinas', function (Blueprint $table) {
            // Controle de Estoque
            $table->integer('estoque_atual')->default(0)->comment('Quantidade atual em estoque');
            $table->integer('estoque_minimo')->default(5)->comment('Alerta quando estoque baixo');
            $table->integer('estoque_ideal')->default(50)->comment('Quantidade ideal em estoque');
            
            // Informações do Fornecedor
            $table->string('fornecedor_nome')->nullable()->comment('Nome do fornecedor/laboratório');
            $table->string('fornecedor_cnpj')->nullable()->comment('CNPJ do fornecedor');
            $table->string('fornecedor_contato')->nullable()->comment('Telefone/email do fornecedor');
            
            // Controle de Qualidade
            $table->string('registro_anvisa')->nullable()->comment('Número de registro na ANVISA');
            $table->string('codigo_barras')->nullable()->comment('Código de barras do produto');
            $table->string('categoria')->default('Rotina')->comment('Categoria da vacina');
            
            // Rastreabilidade
            $table->string('origem_compra')->nullable()->comment('Origem da compra/distribuição');
            $table->decimal('temperatura_armazenamento_min', 4, 1)->nullable()->comment('Temperatura mínima °C');
            $table->decimal('temperatura_armazenamento_max', 4, 1)->nullable()->comment('Temperatura máxima °C');
            
            // Controle Financeiro
            $table->decimal('custo_medio', 10, 2)->nullable()->comment('Custo médio ponderado');
            $table->decimal('margem_lucro', 5, 2)->nullable()->comment('Margem de lucro %');
            
            // Status e Observações
            $table->enum('status', ['Ativo', 'Inativo', 'Descontinuado', 'Suspenso'])->default('Ativo');
            $table->text('observacoes_estoque')->nullable()->comment('Observações sobre estoque/armazenamento');
            
            // Alertas
            $table->boolean('alerta_validade')->default(true)->comment('Ativar alerta de validade');
            $table->integer('dias_alerta_validade')->default(30)->comment('Dias antes de vencer para alerta');
            $table->boolean('alerta_estoque_baixo')->default(true)->comment('Ativar alerta de estoque baixo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacinas', function (Blueprint $table) {
            $table->dropColumn([
                'estoque_atual', 'estoque_minimo', 'estoque_ideal',
                'fornecedor_nome', 'fornecedor_cnpj', 'fornecedor_contato',
                'registro_anvisa', 'codigo_barras', 'categoria',
                'origem_compra', 'temperatura_armazenamento_min', 'temperatura_armazenamento_max',
                'custo_medio', 'margem_lucro',
                'status', 'observacoes_estoque',
                'alerta_validade', 'dias_alerta_validade', 'alerta_estoque_baixo'
            ]);
        });
    }
};
