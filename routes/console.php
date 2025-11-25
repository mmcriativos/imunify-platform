<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ===================================
// LEMBRETES AUTOMÁTICOS DE VACINAÇÃO
// ===================================

// Envia lembretes de 7 dias - Executa às 9h todos os dias
Schedule::command('lembretes:auto --tipo=7dias')
    ->dailyAt('09:00')
    ->timezone('America/Sao_Paulo')
    ->description('Enviar lembretes 7 dias antes da vacinação');

// Envia lembretes de 1 dia - Executa às 18h todos os dias
Schedule::command('lembretes:auto --tipo=1dia')
    ->dailyAt('18:00')
    ->timezone('America/Sao_Paulo')
    ->description('Enviar lembretes 1 dia antes da vacinação');

// Envia lembretes do dia - Executa às 8h todos os dias
Schedule::command('lembretes:auto --tipo=hoje')
    ->dailyAt('08:00')
    ->timezone('America/Sao_Paulo')
    ->description('Enviar lembretes de vacinação do dia');

// Envia lembretes de atrasados - Executa às 10h toda segunda-feira
Schedule::command('lembretes:auto --tipo=atrasados')
    ->weeklyOn(1, '10:00')
    ->timezone('America/Sao_Paulo')
    ->description('Enviar lembretes de agendamentos atrasados');
