<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCredentialsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Lista todos os usuários
     */
    public function index()
    {
        // Apenas admin pode acessar
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        $users = User::orderBy('created_at', 'desc')->get();
        $tenant = tenant();
        $plan = $tenant->plan;
        
        // Calcular limite de usuários
        $maxUsers = $plan->max_users ?? 1;
        $currentUsers = User::active()->count();
        $canAddMore = $currentUsers < $maxUsers;

        return view('users.index', compact('users', 'maxUsers', 'currentUsers', 'canAddMore'));
    }

    /**
     * Mostra formulário de criação
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $tenant = tenant();
        $plan = $tenant->plan;
        $maxUsers = $plan->max_users ?? 1;
        $currentUsers = User::active()->count();

        if ($currentUsers >= $maxUsers) {
            return redirect()->route('users.index')
                ->with('error', "Limite de usuários atingido. Seu plano permite até {$maxUsers} usuário(s). Faça upgrade para adicionar mais.");
        }

        return view('users.create');
    }

    /**
     * Armazena novo usuário
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Verificar limite
        $tenant = tenant();
        $plan = $tenant->plan;
        $maxUsers = $plan->max_users ?? 1;
        $currentUsers = User::active()->count();

        if ($currentUsers >= $maxUsers) {
            return back()->with('error', "Limite de usuários atingido ({$maxUsers}).");
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,manager,operator,viewer'],
            'password' => ['required', Password::min(8)],
        ]);

        // Guardar a senha em texto plano temporariamente para enviar por email
        $plainPassword = $validated['password'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($plainPassword),
            'is_active' => true,
        ]);

        // Enviar email com credenciais
        try {
            $tenantDomain = tenant()->id . '.' . config('app.main_domain', parse_url(config('app.url'), PHP_URL_HOST));
            Mail::to($user->email)->send(new UserCredentialsMail($user, $plainPassword, $tenantDomain));
        } catch (\Exception $e) {
            \Log::error('Falha ao enviar email de credenciais: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('warning', 'Usuário criado, mas houve um erro ao enviar o email. Credenciais: ' . $user->email . ' / ' . $plainPassword);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso! Um email com as credenciais foi enviado para ' . $user->email);
    }

    /**
     * Mostra formulário de edição
     */
    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Não pode editar o próprio usuário aqui (tem rota de profile)
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Use a página de perfil para editar seus próprios dados.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Atualiza usuário
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Não pode editar o próprio role/status
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode editar seu próprio perfil administrativo.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:admin,manager,operator,viewer'],
            'is_active' => ['required', 'boolean'],
            'password' => ['nullable', Password::min(8)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role = $validated['role'];
        $user->is_active = $validated['is_active'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove usuário
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Não pode deletar a si mesmo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode deletar sua própria conta.');
        }

        // Verifica se é o único admin
        $adminCount = User::where('role', 'admin')->where('is_active', true)->count();
        if ($user->role === 'admin' && $adminCount <= 1) {
            return back()->with('error', 'Não é possível deletar o último administrador.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

    /**
     * Ativa/desativa usuário
     */
    public function toggleStatus(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode desativar sua própria conta.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'ativado' : 'desativado';
        return back()->with('success', "Usuário {$status} com sucesso!");
    }
}
