<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class LowStockAlert extends Notification implements ShouldQueue
{
    use Queueable;

    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $count = count($this->products);

        return (new MailMessage)
                    ->subject('⚠️ Alerta de Stock Bajo - Sistema de Inventario')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line("Tienes **{$count} producto(s)** con stock bajo que requieren atención inmediata.")
                    ->line('---')
                    ->line('**Productos afectados:**')
                    ->lines($this->products->map(function($product) {
                        $status = $product->stock_quantity == 0 ? '🔴 SIN STOCK' : '🟡 STOCK BAJO';
                        return "• **{$product->name}** ({$product->category->name}) - {$status}";
                    })->toArray())
                    ->line('---')
                    ->line('**Detalles del inventario:**')
                    ->lines($this->products->map(function($product) {
                        return "• {$product->name}: **{$product->stock_quantity}** unidades (Mínimo: {$product->min_stock_level})";
                    })->toArray())
                    ->action('🔍 Ver Productos con Stock Bajo', route('products.index', ['low_stock' => 1]))
                    ->line('💡 **Recomendación:** Te sugerimos reabastecer estos productos lo antes posible para evitar interrupciones en las ventas.')
                    ->line('📊 Puedes revisar el dashboard para obtener más información sobre el estado de tu inventario.')
                    ->salutation('Saludos cordiales,<br>**Sistema de Inventario**')
                    ->with([
                        'actionColor' => '#f59e0b',
                        'displayableActionUrl' => route('products.index', ['low_stock' => 1]),
                    ]);
    }

    /**
     * Obtener datos adicionales para Brevo
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'low_stock_alert',
            'user_id' => $notifiable->id,
            'products_count' => count($this->products),
            'products' => $this->products->pluck('name')->toArray(),
            'timestamp' => now()->toISOString(),
        ];
    }
}
