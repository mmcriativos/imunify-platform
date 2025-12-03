<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    /**
     * Exibe formulário de redefinição de senha
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Redefine a senha do usuário
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Buscar token no banco
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token de redefinição inválido ou expirado.']);
        }

        // Verificar se token corresponde
        if (!hash_equals($passwordReset->token, hash('sha256', $request->token))) {
            return back()->withErrors(['email' => 'Token de redefinição inválido.']);
        }

        // Verificar se token expirou (60 minutos)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Este link de redefinição expirou. Solicite um novo.']);
        }

        // Buscar usuário
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Usuário não encontrado.']);
        }

        // Atualizar senha
        $user->password = Hash::make($request->password);
        $user->save();

        // Deletar token usado
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Redirecionar para login com mensagem de sucesso
        return redirect()->route('login')->with('status', '✅ Senha redefinida com sucesso! Você já pode fazer login.');
    }
}
