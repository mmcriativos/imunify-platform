<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Categorias padrão
        $categorias = [
            // Receitas
            ['nome' => 'Vacinação', 'tipo' => 'receita', 'cor' => '#10B981', 'icone' => '💉'],
            ['nome' => 'Consultas', 'tipo' => 'receita', 'cor' => '#3B82F6', 'icone' => '🩺'],
            ['nome' => 'Produtos', 'tipo' => 'receita', 'cor' => '#8B5CF6', 'icone' => '🛒'],
            ['nome' => 'Outros Serviços', 'tipo' => 'receita', 'cor' => '#06B6D4', 'icone' => '💼'],
            
            // Despesas
            ['nome' => 'Vacinas (Compra)', 'tipo' => 'despesa', 'cor' => '#EF4444', 'icone' => '💉'],
            ['nome' => 'Salários', 'tipo' => 'despesa', 'cor' => '#F59E0B', 'icone' => '💰'],
            ['nome' => 'Aluguel', 'tipo' => 'despesa', 'cor' => '#DC2626', 'icone' => '🏢'],
            ['nome' => 'Energia/Água', 'tipo' => 'despesa', 'cor' => '#F97316', 'icone' => '⚡'],
            ['nome' => 'Material de Consumo', 'tipo' => 'despesa', 'cor' => '#FB923C', 'icone' => '📦'],
            ['nome' => 'Marketing', 'tipo' => 'despesa', 'cor' => '#EC4899', 'icone' => '📢'],
            ['nome' => 'Telefone/Internet', 'tipo' => 'despesa', 'cor' => '#A855F7', 'icone' => '📞'],
            ['nome' => 'Impostos/Taxas', 'tipo' => 'despesa', 'cor' => '#B91C1C', 'icone' => '📋'],
            ['nome' => 'Manutenção', 'tipo' => 'despesa', 'cor' => '#F97316', 'icone' => '🔧'],
            ['nome' => 'Outras Despesas', 'tipo' => 'despesa', 'cor' => '#64748B', 'icone' => '📝'],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias_financeiras')->insert(array_merge($categoria, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Formas de pagamento padrão
        $formasPagamento = [
            [
                'nome' => 'Dinheiro',
                'tipo' => 'dinheiro',
                'taxa_percentual' => 0,
                'prazo_recebimento' => 0,
                'requer_conciliacao' => false,
            ],
            [
                'nome' => 'PIX',
                'tipo' => 'pix',
                'taxa_percentual' => 0,
                'prazo_recebimento' => 0,
                'requer_conciliacao' => false,
            ],
            [
                'nome' => 'Débito',
                'tipo' => 'debito',
                'taxa_percentual' => 1.99,
                'prazo_recebimento' => 1,
                'requer_conciliacao' => true,
            ],
            [
                'nome' => 'Crédito à Vista',
                'tipo' => 'credito',
                'taxa_percentual' => 2.49,
                'prazo_recebimento' => 30,
                'requer_conciliacao' => true,
            ],
            [
                'nome' => 'Crédito 2x',
                'tipo' => 'credito',
                'taxa_percentual' => 3.99,
                'prazo_recebimento' => 30,
                'requer_conciliacao' => true,
            ],
            [
                'nome' => 'Crédito 3x',
                'tipo' => 'credito',
                'taxa_percentual' => 4.99,
                'prazo_recebimento' => 30,
                'requer_conciliacao' => true,
            ],
            [
                'nome' => 'Transferência Bancária',
                'tipo' => 'transferencia',
                'taxa_percentual' => 0,
                'prazo_recebimento' => 0,
                'requer_conciliacao' => false,
            ],
            [
                'nome' => 'Boleto',
                'tipo' => 'boleto',
                'taxa_percentual' => 1.99,
                'prazo_recebimento' => 1,
                'requer_conciliacao' => false,
            ],
        ];

        foreach ($formasPagamento as $forma) {
            DB::table('formas_pagamento')->insert(array_merge($forma, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        DB::table('formas_pagamento')->truncate();
        DB::table('categorias_financeiras')->truncate();
    }
};
