<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vacina;

class FluarixVacinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vacina::create([
            'nome' => 'INFLUENZA - Fluarix® (Influenza Vaccine)',
            'fabricante' => 'GSK (GlaxoSmithKline)',
            'modo_agir' => 'A Fluarix® é uma vacina inativada (vírus fragmentados ou split-virion) para prevenção da gripe, estimulando o sistema imunológico a produzir anticorpos contra os vírus da gripe A e B contidos na vacina.',
            'indicacoes' => 'Pessoas a partir de 6 meses de idade ou mais para imunização ativa contra a doença causada por vírus influenza A subtipos e influenza B.

Usada para prevenção das infecções por influenza dos tipos contidos na formulação da vacina.',
            'descricao' => 'Vacina injetável, normalmente apresentada em dose de 0,5 mL, pré-enchida, para administração intramuscular.

A vacina cobre vírus da influenza dos tipos A e B contidos na formulação.

Armazenamento recomendado entre 2°C e 8°C (não congelar).',
            'preco_custo' => 35.00, // Preço de custo
            'preco_venda_cartao' => 95.00, // Preço venda no cartão
            'preco_venda_pix' => 80.00, // Preço venda PIX/Dinheiro (desconto)
            'preco_promocional' => 70.00, // Preço promocional
            'validade_dias' => 365, // 1 ano de proteção
            'numero_doses' => 1, // Geralmente 1 dose por temporada (pode ser 2 para crianças não vacinadas)
            'intervalo_doses_dias' => 28, // 4 semanas quando aplicável (2 doses para crianças)
            'ativo' => true,
        ]);
    }
}
