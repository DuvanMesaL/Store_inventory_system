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
        return (new MailMessage)
                    ->subject('⚠️ Alerta de Stock Bajo - Sistema de Inventario')
                    ->view('emails.low-stock-alert', [
                        'user' => $notifiable,
                        'products' => $this->products
                    ]);
    }

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
