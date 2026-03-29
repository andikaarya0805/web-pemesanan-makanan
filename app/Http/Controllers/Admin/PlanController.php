<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plan.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'price_per_week' => 'required|numeric|min:0',
            'meals_per_week' => 'required|integer|min:1',
            'features' => 'required|string', // We'll convert from newline string to array
            'is_active' => 'boolean',
        ]);

        $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        $validated['is_active'] = $request->has('is_active');

        Plan::create($validated);

        return redirect()->route('admin.plan.index')->with('success', 'Paket langganan berhasil dibuat.');
    }

    public function edit(Plan $plan)
    {
        // Convert features array back to string for textarea
        $plan->features_string = implode("\n", $plan->features ?? []);
        return view('admin.plan.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'price_per_week' => 'required|numeric|min:0',
            'meals_per_week' => 'required|integer|min:1',
            'features' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        $validated['is_active'] = $request->has('is_active');

        $plan->update($validated);

        return redirect()->route('admin.plan.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroy(Plan $plan)
    {
        if ($plan->subscriptions()->where('status', 'active')->count() > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus paket yang masih memiliki langganan aktif.');
        }

        $plan->delete();

        return redirect()->route('admin.plan.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
