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
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('¡Te damos la más cordial **bienvenida** a nuestro Sistema de Inventario! 🚀')
                    ->line('Tu cuenta ha sido creada exitosamente y ya puedes comenzar a gestionar el inventario de tu tienda de manera eficiente.')
                    ->line('---')
                    ->line('🌟 **Características principales que puedes usar:**')
                    ->line('📦 • **Gestión completa de productos** - Agregar, editar y organizar tu inventario')
                    ->line('📊 • **Control de stock en tiempo real** - Monitoreo automático de existencias')
                    ->line('⚠️ • **Alertas automáticas de stock bajo** - Nunca te quedes sin productos')
                    ->line('📈 • **Reportes y estadísticas detalladas** - Análisis completo de tu inventario')
                    ->line('🏷️ • **Organización por categorías** - Mantén todo ordenado y fácil de encontrar')
                    ->line('🚚 • **Gestión de proveedores** - Control completo de tus socios comerciales')
                    ->line('---')
                    ->line('🎯 **Tu rol actual:** ' . ucfirst($notifiable->role))
                    ->action('🚀 Acceder al Sistema', route('dashboard'))
                    ->line('💡 **Consejo:** Comienza creando algunas categorías y luego agrega tus primeros productos.')
                    ->line('📞 Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos. ¡Estamos aquí para apoyarte!')
                    ->salutation('¡Gracias por confiar en nosotros!<br>**Equipo del Sistema de Inventario** 💼')
                    ->with([
                        'actionColor' => '#10b981',
                        'displayableActionUrl' => route('dashboard'),
                    ]);
    }

    /**
     * Obtener datos adicionales para Brevo
     */
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
