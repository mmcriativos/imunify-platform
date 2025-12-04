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
        
        $debugInfo = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'email' => $credentials['email'],
            'password_length' => strlen($credentials['password']),
            'domain' => request()->getHost(),
            'tenant_id' => $tenantId,
            'database' => $database,
            'guard' => config('auth.defaults.guard'),
            'provider' => config('auth.defaults.provider'),
        ];
        
        Log::info('=== TENTATIVA DE LOGIN ===', $debugInfo);
        
        // Buscar ALL users para debug
        $allUsers = \App\Models\User::all(['id', 'name', 'email', 'role', 'is_active']);
        Log::info('Usuários no banco', [
            'total' => $allUsers->count(),
            'usuarios' => $allUsers->toArray(),
        ]);

        // Verificar se usuário existe
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if ($user) {
            $userDebug = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'is_active' => $user->is_active,
                'email_verified' => $user->email_verified_at ? 'sim' : 'não',
                'password_hash_start' => substr($user->password, 0, 20),
            ];
            Log::info('Usuário encontrado', $userDebug);
            
            // Testar senha manualmente
            $senhaCorreta = Hash::check($credentials['password'], $user->password);
            Log::info('Teste de senha', [
                'resultado' => $senhaCorreta ? 'CORRETA' : 'INCORRETA',
                'password_enviado' => $credentials['password'],
                'hash_no_banco' => $user->password,
            ]);
            
            if (!$senhaCorreta) {
                Log::error('❌ Senha incorreta - verifique se o hash está correto');
            }
            
            // Verificar se user está ativo
            if (!$user->is_active) {
                Log::error('❌ Usuário inativo');
            }
            
        } else {
            Log::error('❌ Usuário não encontrado', [
                'email_buscado' => $credentials['email'],
                'database' => $database,
                'tenant_initialized' => tenancy()->initialized ? 'sim' : 'não',
            ]);
        }

        // Tentar autenticar
        Log::info('Chamando Auth::attempt...');
        
        $attemptResult = Auth::attempt($credentials, $request->boolean('remember'));
        
        Log::info('Auth::attempt resultado', [
            'sucesso' => $attemptResult ? 'SIM' : 'NÃO',
            'auth_check' => Auth::check() ? 'sim' : 'não',
            'auth_user' => Auth::user() ? Auth::user()->email : 'null',
        ]);
        
        if ($attemptResult) {
            $request->session()->regenerate();
            
            // Registrar último acesso
            $user = Auth::user();
            $user->last_login_at = now();
            $user->last_login_ip = $request->ip();
            $user->save();
            
            Log::info('✅ LOGIN BEM-SUCEDIDO', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip' => $request->ip(),
            ]);
            
            return redirect()->intended('/dashboard');
        }

        Log::error('❌ Auth::attempt FALHOU - login negado');

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
