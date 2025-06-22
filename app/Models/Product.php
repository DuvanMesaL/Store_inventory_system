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

        switch ($type) {
            case 'in':
                $this->stock_quantity += $quantity;
                break;
            case 'out':
                if ($quantity > $this->stock_quantity) {
                    throw new \Exception('No hay suficiente stock disponible');
                }
                $this->stock_quantity -= $quantity;
                break;
            case 'adjustment':
                $this->stock_quantity = $quantity;
                $quantity = abs($quantity - $previousStock); // Calcular la diferencia para el registro
                break;
            default:
                throw new \Exception('Tipo de movimiento no válido');
        }

        $this->save();

        // Registrar el movimiento
        $this->stockMovements()->create([
            'type' => $type,
            'quantity' => $quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $this->stock_quantity,
            'reason' => $reason,
            'reference' => $reference
        ]);

        return $this;
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
