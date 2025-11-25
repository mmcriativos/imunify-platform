<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categorias Financeiras
        Schema::create('categorias_financeiras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo', ['receita', 'despesa']);
            $table->string('cor', 7)->default('#3B82F6');
            $table->string('icone')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Formas de Pagamento
        Schema::create('formas_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo', ['dinheiro', 'pix', 'debito', 'credito', 'boleto', 'transferencia', 'outro']);
            $table->decimal('taxa_percentual', 5, 2)->default(0)->comment('Taxa em %');
            $table->integer('prazo_recebimento')->default(0)->comment('Dias para receber');
            $table->boolean('requer_conciliacao')->default(false);
            $table->string('adquirente')->nullable()->comment('Stone, Cielo, PagSeguro, etc');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Caixas
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->time('hora_abertura')->nullable();
            $table->time('hora_fechamento')->nullable();
            $table->decimal('saldo_inicial', 10, 2)->default(0);
            $table->decimal('saldo_final', 10, 2)->nullable();
            $table->decimal('total_entradas', 10, 2)->default(0);
            $table->decimal('total_saidas', 10, 2)->default(0);
            $table->decimal('saldo_esperado', 10, 2)->nullable();
            $table->decimal('diferenca', 10, 2)->nullable();
            $table->enum('status', ['aberto', 'fechado'])->default('aberto');
            $table->foreignId('usuario_abertura_id')->constrained('users')->comment('Quem abriu');
            $table->foreignId('usuario_fechamento_id')->nullable()->constrained('users')->comment('Quem fechou');
            $table->text('observacoes_abertura')->nullable();
            $table->text('observacoes_fechamento')->nullable();
            $table->timestamps();
            
            $table->index(['data', 'status']);
        });

        // Lançamentos Financeiros
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caixa_id')->nullable()->constrained('caixas')->onDelete('set null');
            $table->enum('tipo', ['receita', 'despesa']);
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->time('hora')->nullable();
            
            $table->foreignId('categoria_id')->nullable()->constrained('categorias_financeiras');
            $table->foreignId('forma_pagamento_id')->nullable()->constrained('formas_pagamento');
            
            // Relacionamentos opcionais
            $table->foreignId('atendimento_id')->nullable()->constrained('atendimentos')->onDelete('set null');
            $table->foreignId('paciente_id')->nullable()->constrained('pacientes')->onDelete('set null');
            
            $table->foreignId('usuario_id')->constrained('users')->comment('Quem registrou');
            
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('confirmado');
            $table->boolean('conciliado')->default(false);
            $table->date('data_conciliacao')->nullable();
            
            $table->text('observacoes')->nullable();
            $table->json('metadata')->nullable()->comment('Dados extras: NSU, parcelas, etc');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['data', 'tipo', 'status']);
            $table->index('caixa_id');
        });

        // Conciliações de Cartão
        Schema::create('conciliacoes_cartao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lancamento_id')->nullable()->constrained('lancamentos');
            
            $table->string('adquirente'); // Stone, Cielo, etc
            $table->string('bandeira')->nullable(); // Visa, Master, etc
            $table->string('nsu')->nullable();
            $table->string('autorizacao')->nullable();
            
            $table->date('data_venda');
            $table->date('data_prevista_recebimento');
            $table->date('data_recebimento')->nullable();
            
            $table->decimal('valor_bruto', 10, 2);
            $table->decimal('taxa_percentual', 5, 2);
            $table->decimal('valor_taxa', 10, 2);
            $table->decimal('valor_liquido', 10, 2);
            
            $table->integer('numero_parcelas')->default(1);
            $table->integer('parcela_atual')->default(1);
            
            $table->enum('status', ['previsto', 'recebido', 'divergente'])->default('previsto');
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
            
            $table->index(['data_prevista_recebimento', 'status']);
            $table->index('adquirente');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conciliacoes_cartao');
        Schema::dropIfExists('lancamentos');
        Schema::dropIfExists('caixas');
        Schema::dropIfExists('formas_pagamento');
        Schema::dropIfExists('categorias_financeiras');
    }
};
