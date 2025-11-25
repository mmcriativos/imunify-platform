<?php

return [
    // IMPORTANTE: AppServiceProvider DEVE vir DEPOIS do TenancyServiceProvider
    // para que as rotas centrais (web.php) sejam registradas por último
    // e tenham prioridade sobre as rotas tenant quando em domínio central
    App\Providers\TenancyServiceProvider::class,
    App\Providers\AppServiceProvider::class,
];
