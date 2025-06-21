<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Bebidas', 'description' => 'Refrescos, jugos, agua y bebidas alcohólicas'],
            ['name' => 'Lácteos', 'description' => 'Leche, quesos, yogurt y derivados lácteos'],
            ['name' => 'Panadería', 'description' => 'Pan, pasteles, galletas y productos de panadería'],
            ['name' => 'Carnes', 'description' => 'Carnes rojas, pollo, pescado y embutidos'],
            ['name' => 'Frutas y Verduras', 'description' => 'Productos frescos, frutas y vegetales'],
            ['name' => 'Abarrotes', 'description' => 'Productos secos, enlatados y conservas'],
            ['name' => 'Limpieza', 'description' => 'Productos de limpieza y cuidado del hogar'],
            ['name' => 'Higiene Personal', 'description' => 'Productos de cuidado e higiene personal'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
