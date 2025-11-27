<?php

namespace App\Providers;

use App\Models\Agendamento;
use App\Models\AtendimentoVacina;
use App\Observers\AgendamentoObserver;
use App\Observers\AtendimentoVacinaObserver;
use App\Observers\DomainObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Database\Models\Domain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar observers
        Agendamento::observe(AgendamentoObserver::class);
        AtendimentoVacina::observe(AtendimentoVacinaObserver::class);
        Domain::observe(DomainObserver::class);

        // Registrar rotas centrais após todas as outras rotas serem carregadas
        // Isso garante que a rota central "/" sobrescreva a rota tenant "/"
        $this->app->booted(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
