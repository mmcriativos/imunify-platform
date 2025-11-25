<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Mostra o formulário de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Debug: Verificar se tenancy está inicializada
        $tenantId = tenancy()->initialized ? tenant('id') : 'NÃO INICIALIZADA';
        $database = tenancy()->initialized ? DB::connection()->getDatabaseName() : 'NÃO CONECTADO';
        
        Log::info('Tentativa de login', [
            'email' => $credentials['email'],
            'domain' => request()->getHost(),
            'tenant_id' => $tenantId,
            'database' => $database,
        ]);

        // Verificar se usuário existe
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user) {
            Log::info('Usuário encontrado', [
                'user_id' => $user->id,
                'email_verified' => $user->email_verified_at ? 'sim' : 'não',
            ]);
            
            // Testar senha manualmente
            if (Hash::check($credentials['password'], $user->password)) {
                Log::info('Senha correta - verificando Auth::attempt');
            } else {
                Log::error('Senha incorreta');
            }
        } else {
            Log::error('Usuário não encontrado', [
                'database' => $database,
                'tenant_initialized' => tenancy()->initialized ? 'sim' : 'não',
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            Log::info('Login bem-sucedido');
            return redirect()->intended('/dashboard');
        }

        Log::error('Auth::attempt falhou');

        throw ValidationException::withMessages([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Processa o logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    /**
     * Auto-login após registro de tenant
     */
    public function autoLogin(Request $request)
    {
        $token = $request->get('token');
        
        if (!$token) {
            Log::warning('Tentativa de auto-login sem token');
            return redirect()->route('login')->with('error', 'Token inválido.');
        }

        // Buscar dados do cache (usar store direto para evitar CacheManager do Tenancy)
        $loginData = app('cache')->store()->pull('login_token_' . $token);
        
        if (!$loginData) {
            Log::warning('Token de auto-login não encontrado ou expirado', ['token' => $token]);
            return redirect()->route('login')->with('error', 'Token expirado ou inválido.');
        }

        // Verificar se estamos no tenant correto
        if (!tenancy()->initialized || tenant('id') !== $loginData['tenant_id']) {
            Log::error('Tenant não corresponde ao token', [
                'token_tenant' => $loginData['tenant_id'],
                'current_tenant' => tenancy()->initialized ? tenant('id') : 'não inicializado'
            ]);
            return redirect()->route('login')->with('error', 'Erro de autenticação.');
        }

        // Buscar usuário no contexto do tenant
        $user = \App\Models\User::where('email', $loginData['user_email'])->first();
        
        if (!$user) {
            Log::error('Usuário não encontrado no tenant', [
                'email' => $loginData['user_email'],
                'tenant_id' => $loginData['tenant_id']
            ]);
            return redirect()->route('login')->with('error', 'Usuário não encontrado.');
        }

        // Fazer login
        Auth::login($user);
        $request->session()->regenerate();

        Log::info('Auto-login bem-sucedido', [
            'user_id' => $user->id,
            'tenant_id' => tenant('id')
        ]);

        return redirect()->route('dashboard')->with('success', 'Bem-vindo ao Imunify! Sua clínica foi criada com sucesso. Trial de 7 dias ativado.');
    }
}
