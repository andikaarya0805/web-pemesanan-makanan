<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)->orderBy('price_per_week')->get();
        $menuItems = MenuItem::where('is_active', true)->limit(6)->get();

        return view('menu', compact('plans', 'menuItems'));
    }
}
