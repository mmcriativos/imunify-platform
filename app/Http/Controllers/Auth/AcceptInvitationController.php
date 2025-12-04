<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AcceptInvitationController extends Controller
{
    /**
     * Mostrar formulário de aceite de convite
     */
    public function show(string $token)
    {
        $invitation = UserInvitation::where('token', $token)->firstOrFail();

        // Verificar se convite é válido
        if ($invitation->isExpired()) {
            return view('auth.invitation-expired');
        }

        if ($invitation->isUsed()) {
            return view('auth.invitation-already-used');
        }

        return view('auth.accept-invitation', compact('invitation'));
    }

    /**
     * Processar aceite de convite
     */
    public function accept(Request $request, string $token)
    {
        $invitation = UserInvitation::where('token', $token)->firstOrFail();

        // Verificar se convite é válido
        if (!$invitation->isValid()) {
            return redirect()
                ->route('invitation.accept', $token)
                ->with('error', 'Este convite não é mais válido.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => Hash::make($validated['password']),
            'role' => $invitation->role,
            'is_active' => true,
        ]);

        // Marcar convite como usado
        $invitation->markAsUsed($user->id);

        // Fazer login automático
        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Bem-vindo! Sua conta foi criada com sucesso.');
    }
}
