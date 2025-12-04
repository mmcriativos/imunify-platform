<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserInvitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'role',
        'invited_by',
        'expires_at',
        'accepted_at',
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    /**
     * Relacionamento: Convite pertence ao usuário que convidou
     */
    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Relacionamento: Convite pode gerar um usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Gerar um novo convite
     */
    public static function generate(string $email, string $role, int $invitedBy, int $expiresInHours = 72): self
    {
        return self::create([
            'email' => $email,
            'token' => Str::random(64),
            'role' => $role,
            'invited_by' => $invitedBy,
            'expires_at' => now()->addHours($expiresInHours),
        ]);
    }

    /**
     * Verificar se o convite expirou
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Verificar se o convite já foi usado
     */
    public function isUsed(): bool
    {
        return $this->accepted_at !== null;
    }

    /**
     * Verificar se o convite é válido
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Marcar convite como usado
     */
    public function markAsUsed(int $userId): void
    {
        $this->update([
            'accepted_at' => now(),
            'user_id' => $userId,
        ]);
    }

    /**
     * Obter URL completa do convite
     */
    public function getInvitationUrl(): string
    {
        return route('invitation.accept', ['token' => $this->token]);
    }

    /**
     * Scope: Apenas convites válidos
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                    ->whereNull('accepted_at');
    }

    /**
     * Scope: Apenas convites pendentes
     */
    public function scopePending($query)
    {
        return $query->whereNull('accepted_at');
    }
}
