<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $bebidas = Category::where('name', 'Bebidas')->first();
        $lacteos = Category::where('name', 'Lácteos')->first();
        $panaderia = Category::where('name', 'Panadería')->first();

        $cocaCola = Supplier::where('name', 'Coca Cola Company')->first();
        $lacteosValle = Supplier::where('name', 'Lácteos del Valle')->first();
        $panaderiaC = Supplier::where('name', 'Panadería Central')->first();

        $products = [
            [
                'name' => 'Coca Cola 600ml',
                'sku' => 'CC-600ML',
                'description' => 'Refresco de cola 600ml',
                'category_id' => $bebidas->id,
                'supplier_id' => $cocaCola->id,
                'purchase_price' => 1.20,
                'selling_price' => 2.50,
                'stock_quantity' => 48,
                'min_stock_level' => 20,
                'barcode' => '7501055363057'
            ],
            [
                'name' => 'Leche Entera 1L',
                'sku' => 'LE-1L',
                'description' => 'Leche entera pasteurizada 1 litro',
                'category_id' => $lacteos->id,
                'supplier_id' => $lacteosValle->id,
                'purchase_price' => 2.80,
                'selling_price' => 4.20,
                'stock_quantity' => 5,
                'min_stock_level' => 15,
                'barcode' => '7501234567890'
            ],
            [
                'name' => 'Pan Integral 500g',
                'sku' => 'PI-500G',
                'description' => 'Pan integral de 500g',
                'category_id' => $panaderia->id,
                'supplier_id' => $panaderiaC->id,
                'purchase_price' => 2.10,
                'selling_price' => 3.80,
                'stock_quantity' => 15,
                'min_stock_level' => 10,
            ],
            [
                'name' => 'Agua Mineral 500ml',
                'sku' => 'AM-500ML',
                'description' => 'Agua mineral natural 500ml',
                'category_id' => $bebidas->id,
                'supplier_id' => $cocaCola->id,
                'purchase_price' => 0.80,
                'selling_price' => 1.50,
                'stock_quantity' => 72,
                'min_stock_level' => 30,
                'barcode' => '7501055123456'
            ],
            [
                'name' => 'Yogurt Natural 200g',
                'sku' => 'YN-200G',
                'description' => 'Yogurt natural sin azúcar 200g',
                'category_id' => $lacteos->id,
                'supplier_id' => $lacteosValle->id,
                'purchase_price' => 1.50,
                'selling_price' => 2.80,
                'stock_quantity' => 25,
                'min_stock_level' => 20,
            ],
            [
                'name' => 'Galletas María 200g',
                'sku' => 'GM-200G',
                'description' => 'Galletas María tradicionales 200g',
                'category_id' => $panaderia->id,
                'supplier_id' => $panaderiaC->id,
                'purchase_price' => 1.20,
                'selling_price' => 2.20,
                'stock_quantity' => 8,
                'min_stock_level' => 15,
                'barcode' => '7501234987654'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
