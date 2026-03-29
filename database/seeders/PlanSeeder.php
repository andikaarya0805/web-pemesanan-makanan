<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'basic',
            'description' => 'Paket Basic - Menu vegetarian dengan kalori terkontrol',
            'price_per_week' => 150000,
            'meals_per_week' => 5,
            'features' => ['5 makanan per minggu', 'Menu vegetarian', 'Kalori terkontrol (1200-1500)', 'Pengiriman 2x seminggu', 'Konsultasi gizi dasar'],
        ]);

        Plan::create([
            'name' => 'premium',
            'description' => 'Paket Premium - Menu variatif dengan konsultasi personal',
            'price_per_week' => 250000,
            'meals_per_week' => 10,
            'features' => ['10 makanan per minggu', 'Menu variatif (vegan, keto, dll)', 'Kalori disesuaikan kebutuhan', 'Pengiriman setiap hari', 'Konsultasi gizi personal', 'Tracking progress'],
        ]);

        Plan::create([
            'name' => 'family',
            'description' => 'Paket Family - Menu untuk keluarga dengan 4 porsi',
            'price_per_week' => 400000,
            'meals_per_week' => 20,
            'features' => ['20 makanan per minggu', 'Menu untuk 4 orang', 'Pilihan menu anak-anak', 'Pengiriman setiap hari', 'Konsultasi gizi keluarga', 'Meal planning assistance'],
        ]);
    }
}
