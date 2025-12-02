<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class HandleDatabaseErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (QueryException $e) {
            // Erros relacionados a banco de dados inexistente ou problemas de conexão
            if ($this->isDatabaseNotFoundError($e)) {
                Log::error('Erro de banco de dados não encontrado', [
                    'error' => $e->getMessage(),
                    'tenant' => tenancy()->tenant?->id ?? 'N/A',
                    'domain' => request()->getHost(),
                    'url' => request()->fullUrl(),
                ]);

                // Se está no contexto de tenant, mostrar página de erro específica
                if (tenancy()->initialized) {
                    return $this->handleTenantDatabaseError($request);
                }

                // Se está no domínio central, mostrar erro genérico
                return $this->handleCentralDatabaseError($request);
            }

            // Outros erros de query - logar mas deixar o handler padrão tratar
            Log::error('Erro de query SQL', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql() ?? 'N/A',
                'tenant' => tenancy()->tenant?->id ?? 'N/A',
            ]);

            // Re-throw para o handler global processar
            throw $e;
        }
    }

    /**
     * Verifica se é erro de banco de dados não encontrado
     */
    protected function isDatabaseNotFoundError(QueryException $e): bool
    {
        $message = $e->getMessage();
        
        // MySQL: Unknown database
        if (str_contains($message, 'Unknown database')) {
            return true;
        }
        
        // PostgreSQL: database does not exist
        if (str_contains($message, 'database') && str_contains($message, 'does not exist')) {
            return true;
        }
        
        // Erro de conexão recusada
        if (str_contains($message, 'Connection refused')) {
            return true;
        }

        return false;
    }

    /**
     * Trata erro de banco no contexto do tenant
     */
    protected function handleTenantDatabaseError(Request $request): Response
    {
        // Se for requisição AJAX, retornar JSON
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Erro de configuração do sistema. Por favor, entre em contato com o suporte.',
                'message' => 'Database configuration error',
            ], 503);
        }

        // Para login com credenciais erradas, retornar ao form com mensagem
        if ($request->is('login') && $request->isMethod('POST')) {
            return back()->withErrors([
                'email' => 'Não foi possível autenticar. Verifique suas credenciais e tente novamente.',
            ])->withInput($request->only('email'));
        }

        // Redirecionar para página de erro do tenant
        return response()->view('errors.tenant-unavailable', [
            'tenant' => tenancy()->tenant,
        ], 503);
    }

    /**
     * Trata erro de banco no domínio central
     */
    protected function handleCentralDatabaseError(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Serviço temporariamente indisponível.',
            ], 503);
        }

        return response()->view('errors.503', [], 503);
    }
}
