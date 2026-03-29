<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@nutribox.id',
            'password' => Hash::make('admin123'),
            'phone' => '085156942737',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dika Pengguna',
            'email' => 'dika@nutribox.id',
            'password' => Hash::make('user123'),
            'phone' => '081234567890',
            'role' => 'user',
            'dietary_preferences' => 'vegetarian',
            'goals' => 'weight-loss',
        ]);
    }
}
