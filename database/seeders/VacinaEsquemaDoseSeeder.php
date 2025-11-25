<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacina;
use App\Models\VacinaEsquemaDose;

class VacinaEsquemaDoseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 📋 Calendário Nacional de Vacinação - Ministério da Saúde
        // Fonte: https://www.gov.br/saude/pt-br/assuntos/saude-de-a-a-z/c/calendario-nacional-de-vacinacao
        
        $this->seedBCG();
        $this->seedHepatiteB();
        $this->seedPentavalente();
        $this->seedPneumococica10();
        $this->seedPneumococica13();
        $this->seedMeningococicaC();
        $this->seedMeningococicaB();
        $this->seedRotavirus();
        $this->seedInfluenza();
        $this->seedFebreAmarela();
        $this->seedTripliceViral();
        $this->seedTetraViral();
        $this->seedHepatiteA();
        $this->seedVaricela();
        $this->seedDTP();
        $this->seedDT();
        $this->seedHPV();
        $this->seedCovid19();
    }

    private function seedBCG()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%BCG%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => 'Dose única',
                'idade_minima_meses' => 0,
                'idade_maxima_meses' => 1,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Aplicar preferencialmente nas primeiras 12 horas de vida',
                'ordem' => 1
            ]
        );
    }

    private function seedHepatiteB()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Hepatite B%')->first();
        if (!$vacina) return;

        // 1ª dose - Ao nascer
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 0,
                'idade_maxima_meses' => 1,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Primeiras 12 horas de vida',
                'ordem' => 1
            ]
        );

        // 2ª dose - 1 mês
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 1,
                'idade_maxima_meses' => 2,
                'intervalo_minimo_dias' => 30,
                'obrigatoria' => true,
                'rede' => 'ambas',
                'observacoes' => null,
                'ordem' => 2
            ]
        );

        // 3ª dose - 6 meses
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => '3ª dose',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => 12,
                'intervalo_minimo_dias' => 150,
                'obrigatoria' => true,
                'rede' => 'ambas',
                'observacoes' => null,
                'ordem' => 3
            ]
        );
    }

    private function seedPentavalente()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Pentavalente%')->first();
        if (!$vacina) return;

        // 1ª dose - 2 meses
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 2,
                'idade_maxima_meses' => 3,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'DTP + Hib + Hepatite B',
                'ordem' => 1
            ]
        );

        // 2ª dose - 4 meses
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 4,
                'idade_maxima_meses' => 5,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => null,
                'ordem' => 2
            ]
        );

        // 3ª dose - 6 meses
        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => '3ª dose',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => 12,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => null,
                'ordem' => 3
            ]
        );
    }

    private function seedPneumococica10()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Pneumocócica 10%')->orWhere('nome', 'LIKE', '%Pneumo 10%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 2,
                'idade_maxima_meses' => 3,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 4,
                'idade_maxima_meses' => 5,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 2
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => 'Reforço',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 3
            ]
        );
    }

    private function seedPneumococica13()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Pneumocócica 13%')->orWhere('nome', 'LIKE', '%Pneumo 13%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 2,
                'idade_maxima_meses' => 3,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 4,
                'idade_maxima_meses' => 5,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 2
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => '3ª dose',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => 12,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 3
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 4],
            [
                'nome_dose' => 'Reforço',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 4
            ]
        );
    }

    private function seedMeningococicaC()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Meningocócica C%')->orWhere('nome', 'LIKE', '%Meningo C%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 3,
                'idade_maxima_meses' => 4,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 5,
                'idade_maxima_meses' => 6,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 2
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => 'Reforço',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 3
            ]
        );
    }

    private function seedMeningococicaB()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Meningocócica B%')->orWhere('nome', 'LIKE', '%Meningo B%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 3,
                'idade_maxima_meses' => 4,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => false,
                'rede' => 'privada',
                'observacoes' => 'Recomendada pela SBP e SBIm',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 5,
                'idade_maxima_meses' => 6,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 2
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 3],
            [
                'nome_dose' => 'Reforço',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 3
            ]
        );
    }

    private function seedRotavirus()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Rotavírus%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 2,
                'idade_maxima_meses' => 3,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Idade máxima: 3 meses e 15 dias',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 4,
                'idade_maxima_meses' => 7,
                'intervalo_minimo_dias' => 60,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Idade máxima: 7 meses e 29 dias',
                'ordem' => 2
            ]
        );
    }

    private function seedInfluenza()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Influenza%')->orWhere('nome', 'LIKE', '%Gripe%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => 'Anual',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => null,
                'intervalo_minimo_dias' => 365,
                'obrigatoria' => true,
                'rede' => 'ambas',
                'observacoes' => 'Aplicação anual, preferencialmente antes do inverno',
                'ordem' => 1
            ]
        );
    }

    private function seedFebreAmarela()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Febre Amarela%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 9,
                'idade_maxima_meses' => 12,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Para áreas de risco ou viajantes',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => 'Reforço',
                'idade_minima_meses' => 48, // 4 anos
                'idade_maxima_meses' => 60, // 5 anos
                'intervalo_minimo_dias' => 1095, // 3 anos
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => null,
                'ordem' => 2
            ]
        );
    }

    private function seedTripliceViral()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Tríplice Viral%')->orWhere('nome', 'LIKE', '%SCR%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Sarampo, Caxumba e Rubéola',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 15,
                'idade_maxima_meses' => 48, // 4 anos
                'intervalo_minimo_dias' => 90,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 2
            ]
        );
    }

    private function seedTetraViral()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Tetra Viral%')->orWhere('nome', 'LIKE', '%SCRV%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => 'Dose única',
                'idade_minima_meses' => 15,
                'idade_maxima_meses' => 48, // 4 anos
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Sarampo, Caxumba, Rubéola e Varicela',
                'ordem' => 1
            ]
        );
    }

    private function seedHepatiteA()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Hepatite A%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 24,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 18,
                'idade_maxima_meses' => 36,
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => false,
                'rede' => 'privada',
                'observacoes' => 'SUS oferece dose única, privada 2 doses',
                'ordem' => 2
            ]
        );
    }

    private function seedVaricela()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%Varicela%')->orWhere('nome', 'LIKE', '%Catapora%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 12,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'ambas',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 15,
                'idade_maxima_meses' => 48,
                'intervalo_minimo_dias' => 90,
                'obrigatoria' => false,
                'rede' => 'privada',
                'ordem' => 2
            ]
        );
    }

    private function seedDTP()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%DTP%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1º reforço',
                'idade_minima_meses' => 15,
                'idade_maxima_meses' => 18,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Após esquema completo de Pentavalente',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2º reforço',
                'idade_minima_meses' => 48, // 4 anos
                'idade_maxima_meses' => 72, // 6 anos
                'intervalo_minimo_dias' => 730, // 2 anos
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 2
            ]
        );
    }

    private function seedDT()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%dT%')->orWhere('nome', 'LIKE', '%Dupla Adulto%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => 'Reforço a cada 10 anos',
                'idade_minima_meses' => 84, // 7 anos
                'idade_maxima_meses' => null,
                'intervalo_minimo_dias' => 3650, // 10 anos
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Para adolescentes e adultos',
                'ordem' => 1
            ]
        );
    }

    private function seedHPV()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%HPV%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 108, // 9 anos
                'idade_maxima_meses' => 168, // 14 anos
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Meninas e meninos de 9 a 14 anos',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 114, // 9 anos e 6 meses
                'idade_maxima_meses' => 180, // 15 anos
                'intervalo_minimo_dias' => 180,
                'obrigatoria' => true,
                'rede' => 'sus',
                'ordem' => 2
            ]
        );
    }

    private function seedCovid19()
    {
        $vacina = Vacina::where('nome', 'LIKE', '%COVID%')->orWhere('nome', 'LIKE', '%Coronavac%')->first();
        if (!$vacina) return;

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 1],
            [
                'nome_dose' => '1ª dose',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => null,
                'intervalo_minimo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'A partir de 6 meses',
                'ordem' => 1
            ]
        );

        VacinaEsquemaDose::updateOrCreate(
            ['vacina_id' => $vacina->id, 'dose_numero' => 2],
            [
                'nome_dose' => '2ª dose',
                'idade_minima_meses' => 6,
                'idade_maxima_meses' => null,
                'intervalo_minimo_dias' => 28,
                'obrigatoria' => true,
                'rede' => 'sus',
                'observacoes' => 'Intervalo varia conforme fabricante',
                'ordem' => 2
            ]
        );
    }
}
