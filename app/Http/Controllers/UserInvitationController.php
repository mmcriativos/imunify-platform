<?php

namespace App\Http\Controllers;

use App\Models\UserInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInvitationController extends Controller
{
    /**
     * Exibir lista de convites
     */
    public function index()
    {
        // Apenas master pode gerenciar convites
        if (Auth::user()->role !== 'master') {
            abort(403, 'Apenas administradores master podem gerenciar convites.');
        }

        $invitations = UserInvitation::with(['invitedBy', 'user'])
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    /**
     * Criar novo convite
     */
    public function store(Request $request)
    {
        // Apenas master pode criar convites
        if (Auth::user()->role !== 'master') {
            abort(403, 'Apenas administradores master podem criar convites.');
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
        ]);

        $invitation = UserInvitation::generate(
            $validated['email'],
            $validated['role'],
            Auth::id(),
            72 // 3 dias
        );

        return redirect()
            ->route('invitations.index')
            ->with('success', 'Convite criado com sucesso!')
            ->with('invitation_url', $invitation->getInvitationUrl());
    }

    /**
     * Excluir/revogar convite
     */
    public function destroy(UserInvitation $invitation)
    {
        // Apenas master pode revogar convites
        if (Auth::user()->role !== 'master') {
            abort(403, 'Apenas administradores master podem revogar convites.');
        }

        $invitation->delete();

        return redirect()
            ->route('invitations.index')
            ->with('success', 'Convite revogado com sucesso!');
    }

    /**
     * Copiar link do convite
     */
    public function copyLink(UserInvitation $invitation)
    {
        return response()->json([
            'url' => $invitation->getInvitationUrl()
        ]);
    }
}
