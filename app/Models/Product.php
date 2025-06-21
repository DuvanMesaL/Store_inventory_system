<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'min_stock_level',
        'barcode',
        'active'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock_level;
    }

    public function getMarginAttribute()
    {
        if ($this->selling_price > 0) {
            return (($this->selling_price - $this->purchase_price) / $this->selling_price) * 100;
        }
        return 0;
    }

    public function updateStock($quantity, $type, $reason = null, $reference = null)
    {
        $previousStock = $this->stock_quantity;

        if ($type === 'in') {
            $this->stock_quantity += $quantity;
        } elseif ($type === 'out') {
            $this->stock_quantity -= $quantity;
        } elseif ($type === 'adjustment') {
            $this->stock_quantity = $quantity;
        }

        $this->save();

        // Registrar el movimiento
        StockMovement::create([
            'product_id' => $this->id,
            'type' => $type,
            'quantity' => $quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $this->stock_quantity,
            'reason' => $reason,
            'reference' => $reference
        ]);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= min_stock_level');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
