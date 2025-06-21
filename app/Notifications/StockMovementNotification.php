<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\StockMovement;

class StockMovementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $movement;

    public function __construct(StockMovement $movement)
    {
        $this->movement = $movement;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $product = $this->movement->product;
        $typeText = $this->movement->type_text;
        $icon = $this->getTypeIcon($this->movement->type);

        return (new MailMessage)
                    ->subject("{$icon} Movimiento de Stock - {$product->name}")
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line("Se ha registrado un **{$typeText}** en el inventario:")
                    ->line('---')
                    ->line("🏷️ **Producto:** {$product->name}")
                    ->line("📦 **Categoría:** {$product->category->name}")
                    ->line("🔢 **Cantidad:** {$this->movement->quantity} unidades")
                    ->line("📊 **Stock anterior:** {$this->movement->previous_stock}")
                    ->line("📈 **Stock actual:** {$this->movement->new_stock}")
                    ->when($this->movement->reason, function($mail) {
                        return $mail->line("📝 **Motivo:** {$this->movement->reason}");
                    })
                    ->when($this->movement->reference, function($mail) {
                        return $mail->line("🔗 **Referencia:** {$this->movement->reference}");
                    })
                    ->line('---')
                    ->line("⏰ **Fecha:** " . $this->movement->created_at->format('d/m/Y H:i:s'))
                    ->action('📊 Ver Detalles del Producto', route('products.show', $product))
                    ->when($this->movement->new_stock <= $product->min_stock_level, function($mail) use ($product) {
                        return $mail->line('⚠️ **Atención:** Este producto ahora tiene stock bajo. Considera reabastecerlo pronto.');
                    })
                    ->salutation('Saludos,<br>**Sistema de Inventario**');
    }

    private function getTypeIcon($type)
    {
        return match($type) {
            'in' => '📥',
            'out' => '📤',
            'adjustment' => '⚙️',
            default => '📦'
        };
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'stock_movement',
            'movement_id' => $this->movement->id,
            'product_id' => $this->movement->product_id,
            'movement_type' => $this->movement->type,
            'quantity' => $this->movement->quantity,
            'new_stock' => $this->movement->new_stock,
            'timestamp' => $this->movement->created_at->toISOString(),
        ];
    }
}
