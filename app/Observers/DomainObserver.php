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
        // Verificar se está em produção e se o domínio termina com .imunify.com.br
        if (app()->environment('production') && str_ends_with($domain->domain, '.imunify.com.br')) {
            try {
                Log::info('🌐 Criando subdomínio via cPanel API', ['domain' => $domain->domain]);
                
                // Extrair apenas o subdomínio (ex: multiimune de multiimune.imunify.com.br)
                $subdomain = str_replace('.imunify.com.br', '', $domain->domain);
                
                // Executar comando uapi para criar subdomínio
                $command = sprintf(
                    'uapi --output=json SubDomain add_subdomain domain=%s rootdomain=imunify.com.br dir=public_html 2>&1',
                    escapeshellarg($subdomain)
                );
                
                exec($command, $output, $returnCode);
                
                $outputJson = implode("\n", $output);
                
                if ($returnCode === 0) {
                    Log::info('✅ Subdomínio criado com sucesso via cPanel API', [
                        'domain' => $domain->domain,
                        'output' => $outputJson
                    ]);
                } else {
                    Log::error('❌ Erro ao criar subdomínio via cPanel API', [
                        'domain' => $domain->domain,
                        'return_code' => $returnCode,
                        'output' => $outputJson
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error('❌ Exceção ao criar subdomínio via cPanel API', [
                    'domain' => $domain->domain,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Handle the Domain "deleted" event.
     */
    public function deleted(Domain $domain): void
    {
        // Verificar se está em produção e se o domínio termina com .imunify.com.br
        if (app()->environment('production') && str_ends_with($domain->domain, '.imunify.com.br')) {
            try {
                Log::info('🗑️ Removendo subdomínio via cPanel API', ['domain' => $domain->domain]);
                
                // Executar comando uapi para deletar subdomínio
                $command = sprintf(
                    'uapi --output=json SubDomain delete domain=%s 2>&1',
                    escapeshellarg($domain->domain)
                );
                
                exec($command, $output, $returnCode);
                
                $outputJson = implode("\n", $output);
                
                if ($returnCode === 0) {
                    Log::info('✅ Subdomínio removido com sucesso via cPanel API', [
                        'domain' => $domain->domain,
                        'output' => $outputJson
                    ]);
                } else {
                    Log::warning('⚠️ Erro ao remover subdomínio via cPanel API', [
                        'domain' => $domain->domain,
                        'return_code' => $returnCode,
                        'output' => $outputJson
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error('❌ Exceção ao remover subdomínio via cPanel API', [
                    'domain' => $domain->domain,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
