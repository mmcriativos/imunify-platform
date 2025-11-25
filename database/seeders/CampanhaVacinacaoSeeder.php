<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampanhaVacinacao;
use Carbon\Carbon;

class CampanhaVacinacaoSeeder extends Seeder
{
    public function run(): void
    {
        // Campanha Influenza 2025
        CampanhaVacinacao::create([
            'nome' => 'Campanha Nacional de Vacinação contra Influenza 2025',
            'vacina' => 'Influenza',
            'descricao' => 'Proteção contra o vírus da gripe sazonal. Prioritário para idosos, crianças e gestantes.',
            'data_inicio' => Carbon::create(2025, 4, 1),
            'data_fim' => Carbon::create(2025, 6, 30),
            'publico_alvo' => 'Idosos 60+, Crianças 6m-5a, Gestantes',
            'idade_minima' => null,
            'idade_maxima' => null,
            'ativa' => true,
            'prioridade' => 'alta'
        ]);

        // Campanha COVID-19 Reforço
        CampanhaVacinacao::create([
            'nome' => 'Reforço COVID-19 - Dose Bivalente',
            'vacina' => 'COVID-19',
            'descricao' => 'Nova dose de reforço com vacina bivalente para proteção contra variantes atualizadas.',
            'data_inicio' => Carbon::now()->subDays(30),
            'data_fim' => Carbon::now()->addMonths(3),
            'publico_alvo' => 'População geral acima de 12 anos',
            'idade_minima' => 144, // 12 anos em meses
            'idade_maxima' => null,
            'ativa' => true,
            'prioridade' => 'alta'
        ]);

        // Campanha HPV Adolescentes
        CampanhaVacinacao::create([
            'nome' => 'Vacinação HPV - Adolescentes',
            'vacina' => 'HPV',
            'descricao' => 'Proteção contra o vírus HPV. Previne câncer de colo de útero e verrugas genitais.',
            'data_inicio' => Carbon::create(2025, 3, 1),
            'data_fim' => Carbon::create(2025, 12, 31),
            'publico_alvo' => 'Meninas e meninos de 9 a 14 anos',
            'idade_minima' => 108, // 9 anos
            'idade_maxima' => 168, // 14 anos
            'ativa' => true,
            'prioridade' => 'média'
        ]);

        // Campanha Multivacinação (exemplo de campanha finalizada)
        CampanhaVacinacao::create([
            'nome' => 'Campanha de Multivacinação 2024',
            'vacina' => 'Múltiplas',
            'descricao' => 'Atualização da caderneta de vacinação para crianças e adolescentes.',
            'data_inicio' => Carbon::create(2024, 9, 1),
            'data_fim' => Carbon::create(2024, 9, 30),
            'publico_alvo' => 'Crianças e adolescentes até 15 anos',
            'idade_minima' => 0,
            'idade_maxima' => 180,
            'ativa' => false,
            'prioridade' => 'média'
        ]);

        // Campanha Pneumocócica Idosos
        CampanhaVacinacao::create([
            'nome' => 'Vacinação Pneumocócica para Idosos',
            'vacina' => 'Pneumocócica 23',
            'descricao' => 'Proteção contra pneumonia bacteriana. Dose única para idosos.',
            'data_inicio' => Carbon::now()->subMonth(),
            'data_fim' => Carbon::now()->addMonths(2),
            'publico_alvo' => 'Idosos com 60 anos ou mais',
            'idade_minima' => 720, // 60 anos em meses
            'idade_maxima' => null,
            'ativa' => true,
            'prioridade' => 'alta'
        ]);

        // Campanha Tríplice Viral (Sarampo)
        CampanhaVacinacao::create([
            'nome' => 'Campanha de Bloqueio - Sarampo',
            'vacina' => 'Tríplice Viral',
            'descricao' => 'Intensificação da vacinação contra sarampo, caxumba e rubéola devido a casos registrados.',
            'data_inicio' => Carbon::now()->subDays(15),
            'data_fim' => Carbon::now()->addDays(45),
            'publico_alvo' => 'Jovens de 18 a 29 anos',
            'idade_minima' => 216, // 18 anos
            'idade_maxima' => 348, // 29 anos
            'ativa' => true,
            'prioridade' => 'alta'
        ]);
    }
}
