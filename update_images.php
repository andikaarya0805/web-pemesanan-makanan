<?php
use App\Models\MenuItem;

$updates = [
    'Quinoa Buddha Bowl' => '/images/menu5.png',
    'Grilled Salmon' => '/images/menu1.png',
    'Veggie Wrap' => '/images/menu2.png',
    'Green Smoothie Bowl' => '/images/menu3.png',
    'Chicken Teriyaki' => '/images/menu4.png',
    'Avocado Toast' => '/images/menu6.png',
];

foreach ($updates as $name => $url) {
    MenuItem::where('name', $name)->update(['image_url' => $url]);
    echo "Updated $name to $url\n";
}
