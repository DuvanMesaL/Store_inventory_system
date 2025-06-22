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
        $typeText = $this->movement->type_text;

        return (new MailMessage)
                    ->subject("📦 Movimiento de Stock - {$this->movement->product->name}")
                    ->view('emails.stock-movement', [
                        'user' => $notifiable,
                        'movement' => $this->movement
                    ]);
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
