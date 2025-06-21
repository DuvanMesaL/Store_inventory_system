<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@inventario.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+1-555-0001',
            'email_verified_at' => now(),
        ]);

        // Usuario manager
        User::create([
            'name' => 'Manager Principal',
            'email' => 'manager@inventario.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'phone' => '+1-555-0002',
            'email_verified_at' => now(),
        ]);

        // Usuario empleado
        User::create([
            'name' => 'Empleado Demo',
            'email' => 'empleado@inventario.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'phone' => '+1-555-0003',
            'email_verified_at' => now(),
        ]);
    }
}
