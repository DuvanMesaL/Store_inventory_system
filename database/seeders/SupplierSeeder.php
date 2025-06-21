<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Coca Cola Company',
                'contact_person' => 'Juan Pérez',
                'email' => 'ventas@cocacola.com',
                'phone' => '+1-555-0101',
                'address' => 'Av. Principal 123, Ciudad'
            ],
            [
                'name' => 'Lácteos del Valle',
                'contact_person' => 'María González',
                'email' => 'contacto@lacteosdelval.com',
                'phone' => '+1-555-0102',
                'address' => 'Calle Industria 456, Valle'
            ],
            [
                'name' => 'Panadería Central',
                'contact_person' => 'Carlos Rodríguez',
                'email' => 'pedidos@panaderiacentral.com',
                'phone' => '+1-555-0103',
                'address' => 'Plaza Central 789, Centro'
            ],
            [
                'name' => 'Distribuidora Norte',
                'contact_person' => 'Ana Martínez',
                'email' => 'ventas@distnorte.com',
                'phone' => '+1-555-0104',
                'address' => 'Zona Industrial Norte, Lote 12'
            ],
            [
                'name' => 'Frutas y Más',
                'contact_person' => 'Luis Hernández',
                'email' => 'info@frutasymas.com',
                'phone' => '+1-555-0105',
                'address' => 'Mercado Central, Local 45'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
