<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = [
            ['name' => 'Sarah Wijaya', 'role' => 'Marketing Manager', 'message' => 'NutriBox benar-benar mengubah pola makan saya. Makanannya lezat dan saya merasa lebih berenergi!', 'avatar' => 'SW'],
            ['name' => 'Budi Santoso', 'role' => 'Ayah dari 2 anak', 'message' => 'Sangat praktis untuk keluarga sibuk seperti kami. Anak-anak juga suka dengan menu yang variatif.', 'avatar' => 'BS'],
            ['name' => 'Maya Putri', 'role' => 'Fitness Enthusiast', 'message' => 'Kualitas makanan sangat baik dan pengiriman selalu tepat waktu. Highly recommended!', 'avatar' => 'MP'],
        ];

        $plans = Plan::where('is_active', true)->orderBy('price_per_week')->get();
        $menuItems = MenuItem::where('is_active', true)->limit(4)->get();

        return view('home', compact('testimonials', 'plans', 'menuItems'));
    }
}
