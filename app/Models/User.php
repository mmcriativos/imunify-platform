<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'phone',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Verifica se o usuário é administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário é gerente ou superior
     */
    public function isManager(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    /**
     * Verifica se o usuário pode gerenciar outros usuários
     */
    public function canManageUsers(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário tem permissão para uma ação
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = [
            'admin' => ['*'], // Acesso total
            'manager' => [
                'view_dashboard', 
                'manage_patients', 
                'manage_appointments', 
                'manage_inventory', 
                'view_reports'
            ],
            'operator' => [
                'view_dashboard', 
                'manage_patients', 
                'manage_appointments'
            ],
            'viewer' => [
                'view_dashboard', 
                'view_patients', 
                'view_appointments'
            ],
        ];

        $userPermissions = $permissions[$this->role] ?? [];

        // Admin tem acesso a tudo
        if (in_array('*', $userPermissions)) {
            return true;
        }

        // Permissão manage_users apenas para admin
        if ($permission === 'manage_users') {
            return $this->isAdmin();
        }

        return in_array($permission, $userPermissions);
    }

    /**
     * Scope para usuários ativos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para usuários por role
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
