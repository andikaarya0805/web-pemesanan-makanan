<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Quinoa Buddha Bowl', 'description' => 'Quinoa, alpukat, edamame, wortel, dan tahini dressing', 'calories' => 420, 'category' => 'lunch', 'dietary_type' => 'vegetarian'],
            ['name' => 'Grilled Salmon', 'description' => 'Salmon panggang dengan sayuran kukus dan nasi merah', 'calories' => 380, 'category' => 'dinner', 'dietary_type' => 'regular'],
            ['name' => 'Veggie Wrap', 'description' => 'Tortilla gandum dengan hummus, sayuran segar, dan feta', 'calories' => 350, 'category' => 'lunch', 'dietary_type' => 'vegetarian'],
            ['name' => 'Green Smoothie Bowl', 'description' => 'Smoothie bayam, pisang, mangga dengan granola topping', 'calories' => 280, 'category' => 'breakfast', 'dietary_type' => 'vegan'],
            ['name' => 'Chicken Teriyaki', 'description' => 'Ayam teriyaki dengan nasi dan sayuran', 'calories' => 450, 'category' => 'dinner', 'dietary_type' => 'regular'],
            ['name' => 'Avocado Toast', 'description' => 'Roti gandum dengan alpukat dan telur', 'calories' => 320, 'category' => 'breakfast', 'dietary_type' => 'vegetarian'],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
