<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'calories' => 'required|integer',
            'category' => 'required|string',
            'dietary_type' => 'required|string',
            'ingredients' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'calories' => 'required|integer',
            'category' => 'required|string',
            'dietary_type' => 'required|string',
            'ingredients' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menu->image_url && str_contains($menu->image_url, '/storage/menu/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
            }
            
            $path = $request->file('image')->store('menu', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menu)
    {
        if ($menu->image_url && str_contains($menu->image_url, '/storage/menu/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $menu->image_url));
        }
        
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted successfully.');
    }
}
