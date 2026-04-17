<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Nasir Amme',
            'email' => 'nasiramme1511@gmail.com',
            'phone' => '+251996656617',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);
    }
}
