<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenancy()->tenant;

        // Se não houver tenant (acesso ao domínio central), permite
        if (!$tenant) {
            return $next($request);
        }

        // Se o tenant está suspenso ou arquivado, bloqueia acesso
        if (!$tenant->canAccess()) {
            if ($tenant->isSuspended()) {
                return redirect()->route('suspended');
            }
            if ($tenant->isArchived()) {
                return redirect()->route('archived');
            }
        }

        // Se está em período de graça (read-only), bloqueia operações de escrita
        if ($tenant->isReadOnly() && $this->isWriteRequest($request)) {
            return back()->with('error', 'Sua conta está em modo somente leitura. Para continuar usando o sistema, ative sua assinatura.');
        }

        // Se está em trial mas expirado, redireciona para tela de pagamento
        if ($tenant->subscriptionExpired() && !$tenant->hasActiveSubscription()) {
            // Permite acesso às rotas essenciais mesmo expirado
            if ($this->isAllowedRoute($request)) {
                return $next($request);
            }
            return redirect()->route('subscription.required');
        }

        return $next($request);
    }

    /**
     * Verifica se é uma requisição de escrita (POST, PUT, PATCH, DELETE)
     */
    protected function isWriteRequest(Request $request): bool
    {
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
    }

    /**
     * Verifica se é uma rota permitida mesmo com assinatura expirada
     */
    protected function isAllowedRoute(Request $request): bool
    {
        $allowedRoutes = [
            'dashboard',
            'profile.*',
            'subscription.*',
            'logout',
        ];

        return $request->routeIs($allowedRoutes);
    }
}
