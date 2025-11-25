<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cidades = [
            ['nome' => 'Artur Nogueira', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Engenheiro Coelho', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Conchal', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Cosmópolis', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Mogi Mirim', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Mogi Guaçu', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Limeira', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Americana', 'uf' => 'SP', 'ativo' => true],
            ['nome' => 'Campinas', 'uf' => 'SP', 'ativo' => true],
        ];

        foreach ($cidades as $cidade) {
            \App\Models\Cidade::create($cidade);
        }
    }
}
