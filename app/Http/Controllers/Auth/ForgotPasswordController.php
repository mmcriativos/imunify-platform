<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe formulário de solicitação de redefinição
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia email com link de redefinição
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Verificar se usuário existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Não encontramos um usuário com este e-mail.']);
        }

        // Verificar se usuário está ativo
        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Esta conta está inativa. Entre em contato com o administrador.']);
        }

        // Gerar token
        $token = Str::random(64);

        // Salvar ou atualizar token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );

        // Construir URL de redefinição
        $tenantDomain = tenant()->id . '.' . config('app.main_domain', parse_url(config('app.url'), PHP_URL_HOST));
        $resetUrl = 'https://' . $tenantDomain . '/password/reset/' . $token . '?email=' . urlencode($request->email);

        // Enviar email
        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl, $token));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de redefinição de senha: ' . $e->getMessage());
            return back()->with('warning', 'Não foi possível enviar o e-mail. Entre em contato com o suporte.');
        }

        return back()->with('status', 'Enviamos um link de redefinição de senha para seu e-mail!');
    }
}
