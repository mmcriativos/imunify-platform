<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DatabasePoolLowNotification extends Notification
{
    use Queueable;

    protected int $availableCount;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $availableCount)
    {
        $this->availableCount = $availableCount;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Pool de Databases Ficando Baixo - Imunify Platform')
            ->greeting('Atenção!')
            ->line("O pool de databases está ficando baixo!")
            ->line("Databases disponíveis: **{$this->availableCount}**")
            ->line('Você deve criar mais databases no cPanel e adicioná-los ao pool para evitar que novos cadastros sejam bloqueados.')
            ->action('Acessar cPanel', 'https://imunify.com.br:2083')
            ->line('**Como adicionar databases ao pool:**')
            ->line('1. Acesse o cPanel e crie um novo database MySQL')
            ->line('2. Use o padrão de nome: imunifycom_tenant_nomedotenante')
            ->line('3. Conceda permissões ao usuário: imunifycom_user')
            ->line('4. Execute via SSH: `php artisan pool:add-database imunifycom_tenant_nomedotenante`')
            ->line('Obrigado!');
    }
}
