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
        Schema::table('lancamentos', function (Blueprint $table) {
            // Data de vencimento (para controle de contas a pagar/receber)
            $table->date('data_vencimento')->nullable()->after('data')
                ->comment('Data de vencimento da conta');
            
            // Data de pagamento/recebimento efetivo
            $table->date('data_pagamento')->nullable()->after('data_vencimento')
                ->comment('Data em que foi efetivamente pago/recebido');
            
            // Número do documento (boleto, nota fiscal, etc)
            $table->string('numero_documento')->nullable()->after('descricao')
                ->comment('Número do boleto, NF, recibo, etc');
            
            // Controle de parcelas
            $table->integer('parcela_numero')->nullable()->after('numero_documento')
                ->comment('Número da parcela (ex: 1 de 12)');
            
            $table->integer('parcela_total')->nullable()->after('parcela_numero')
                ->comment('Total de parcelas');
            
            // Juros e multas por atraso
            $table->decimal('valor_juros', 10, 2)->default(0)->after('valor')
                ->comment('Valor de juros por atraso');
            
            $table->decimal('valor_multa', 10, 2)->default(0)->after('valor_juros')
                ->comment('Valor de multa por atraso');
            
            $table->decimal('valor_desconto', 10, 2)->default(0)->after('valor_multa')
                ->comment('Valor de desconto aplicado');
            
            // Índice para consultas de vencimento
            $table->index(['data_vencimento', 'status']);
            $table->index(['status', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            $table->dropIndex(['data_vencimento', 'status']);
            $table->dropIndex(['status', 'tipo']);
            
            $table->dropColumn([
                'data_vencimento',
                'data_pagamento',
                'numero_documento',
                'parcela_numero',
                'parcela_total',
                'valor_juros',
                'valor_multa',
                'valor_desconto'
            ]);
        });
    }
};
