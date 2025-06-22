<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('🎉 ¡Bienvenido al Sistema de Inventario!')
                    ->view('emails.welcome', [
                        'user' => $notifiable
                    ]);
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'welcome_user',
            'user_id' => $notifiable->id,
            'user_role' => $notifiable->role,
            'registration_date' => $notifiable->created_at->toISOString(),
        ];
    }
}
