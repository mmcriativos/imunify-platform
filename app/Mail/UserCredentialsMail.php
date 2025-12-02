<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public string $password,
        public string $tenantDomain
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔐 Suas credenciais de acesso - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user-credentials',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'password' => $this->password,
                'loginUrl' => 'https://' . $this->tenantDomain,
                'roleName' => $this->getRoleName(),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Get role display name
     */
    private function getRoleName(): string
    {
        return match ($this->user->role) {
            'admin' => 'Administrador',
            'manager' => 'Gerente',
            'operator' => 'Operador',
            'viewer' => 'Visualizador',
            default => 'Usuário',
        };
    }
}
