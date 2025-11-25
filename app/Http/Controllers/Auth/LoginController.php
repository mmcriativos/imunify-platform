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
}
