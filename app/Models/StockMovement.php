<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'previous_stock',
        'new_stock',
        'reason',
        'reference'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTypeTextAttribute()
    {
        return match($this->type) {
            'in' => 'Entrada',
            'out' => 'Salida',
            'adjustment' => 'Ajuste',
            default => 'Desconocido'
        };
    }
}
