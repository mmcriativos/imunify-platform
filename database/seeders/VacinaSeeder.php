<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacinas = [
            [
                'nome' => 'Influenza (Gripe)',
                'fabricante' => 'Sanofi Pasteur',
                'descricao' => 'Vacina contra gripe sazonal',
                'valor_padrao' => 80.00,
                'validade_dias' => 365,
                'numero_doses' => 1,
                'intervalo_doses_dias' => null,
                'ativo' => true
            ],
            [
                'nome' => 'COVID-19',
                'fabricante' => 'Pfizer',
                'descricao' => 'Vacina contra COVID-19',
                'valor_padrao' => 120.00,
                'validade_dias' => 180,
                'numero_doses' => 2,
                'intervalo_doses_dias' => 30,
                'ativo' => true
            ],
            [
                'nome' => 'Hepatite B',
                'fabricante' => 'GSK',
                'descricao' => 'Vacina contra Hepatite B',
                'valor_padrao' => 150.00,
                'validade_dias' => null,
                'numero_doses' => 3,
                'intervalo_doses_dias' => 60,
                'ativo' => true
            ],
            [
                'nome' => 'Febre Amarela',
                'fabricante' => 'Bio-Manguinhos',
                'descricao' => 'Vacina contra Febre Amarela',
                'valor_padrao' => 100.00,
                'validade_dias' => 3650,
                'numero_doses' => 1,
                'intervalo_doses_dias' => null,
                'ativo' => true
            ],
            [
                'nome' => 'Tríplice Viral (Sarampo, Caxumba, Rubéola)',
                'fabricante' => 'Merck',
                'descricao' => 'Vacina MMR',
                'valor_padrao' => 180.00,
                'validade_dias' => null,
                'numero_doses' => 2,
                'intervalo_doses_dias' => 30,
                'ativo' => true
            ],
            [
                'nome' => 'Tetraviral (Sarampo, Caxumba, Rubéola e Varicela)',
                'fabricante' => 'GSK',
                'descricao' => 'Vacina MMRV',
                'valor_padrao' => 250.00,
                'validade_dias' => null,
                'numero_doses' => 2,
                'intervalo_doses_dias' => 30,
                'ativo' => true
            ],
            [
                'nome' => 'HPV',
                'fabricante' => 'Merck',
                'descricao' => 'Vacina contra HPV',
                'valor_padrao' => 450.00,
                'validade_dias' => null,
                'numero_doses' => 2,
                'intervalo_doses_dias' => 180,
                'ativo' => true
            ],
            [
                'nome' => 'Pentavalente',
                'fabricante' => 'Sanofi Pasteur',
                'descricao' => 'DTP + Hib + Hepatite B',
                'valor_padrao' => 200.00,
                'validade_dias' => null,
                'numero_doses' => 3,
                'intervalo_doses_dias' => 60,
                'ativo' => true
            ],
            [
                'nome' => 'Meningocócica ACWY',
                'fabricante' => 'GSK',
                'descricao' => 'Vacina contra meningite',
                'valor_padrao' => 380.00,
                'validade_dias' => 1825,
                'numero_doses' => 1,
                'intervalo_doses_dias' => null,
                'ativo' => true
            ],
            [
                'nome' => 'Pneumocócica 13',
                'fabricante' => 'Pfizer',
                'descricao' => 'Vacina contra pneumonia',
                'valor_padrao' => 320.00,
                'validade_dias' => null,
                'numero_doses' => 4,
                'intervalo_doses_dias' => 60,
                'ativo' => true
            ],
        ];

        foreach ($vacinas as $vacina) {
            \App\Models\Vacina::create($vacina);
        }
    }
}
