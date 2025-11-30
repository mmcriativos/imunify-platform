<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // NÃO carregar web.php automaticamente - será carregado manualmente no AppServiceProvider
        // para controlar a ordem de prioridade com as rotas tenant
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registra middleware de verificação de acesso do tenant
        $middleware->alias([
            'tenant.access' => \App\Http\Middleware\CheckTenantAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
