<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario personal
        $user1 = User::create([
            'name' => 'Fabian Mendoza',
            'email' => 'fabian14_25@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user1->assignRole('Admin');

        // Usuario de prueba
        $user2 = User::create([
            'name' => 'Tester User',
            'email' => 'test@unadECBTI.com',
            'password' => bcrypt('Un4d2025*'),
        ]);
        $user2->assignRole('Admin');
    }
}
