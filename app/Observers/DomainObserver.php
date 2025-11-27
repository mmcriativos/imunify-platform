<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Database\Models\Domain;

class DomainObserver
{
    /**
     * Handle the Domain "created" event.
     */
    public function created(Domain $domain): void
    {
        // TODO: Implementar criação automática via cPanel API HTTP
        // Por enquanto desabilitado porque exec() não está disponível
        
        // Apenas logar que o domínio foi criado
        if (app()->environment('production') && str_ends_with($domain->domain, '.imunify.com.br')) {
            Log::info('🌐 Domínio criado (subdomínio deve ser criado manualmente no cPanel)', [
                'domain' => $domain->domain,
                'subdomain' => str_replace('.imunify.com.br', '', $domain->domain)
            ]);
        }
    }

    /**
     * Handle the Domain "deleted" event.
     */
    public function deleted(Domain $domain): void
    {
        // TODO: Implementar remoção automática via cPanel API HTTP
        // Por enquanto desabilitado porque exec() não está disponível
        
        // Apenas logar que o domínio foi deletado
        if (app()->environment('production') && str_ends_with($domain->domain, '.imunify.com.br')) {
            Log::info('🗑️ Domínio deletado (subdomínio deve ser removido manualmente no cPanel)', [
                'domain' => $domain->domain,
                'subdomain' => str_replace('.imunify.com.br', '', $domain->domain)
            ]);
        }
    }
}
