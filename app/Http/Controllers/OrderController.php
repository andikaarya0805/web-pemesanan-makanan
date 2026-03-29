<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $selectedPlan = $request->query('plan', 'premium');
        $plan = Plan::where('name', $selectedPlan)->firstOrFail();
        $user = Auth::user();

        return view('order', compact('plan', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date|after:today',
            'duration' => 'required|integer|in:1,4,12,24',
            'delivery_address' => 'required|string',
            'dietary_preferences' => 'nullable|string',
            'allergies' => 'nullable|string',
            'goals' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:qris,bank_transfer,cod',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $totalPrice = $plan->price_per_week * $validated['duration'];
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'start_date' => $validated['start_date'],
            'duration_weeks' => $validated['duration'],
            'total_price' => $totalPrice,
            'payment_method' => $validated['payment_method'],
            'delivery_address' => $validated['delivery_address'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update user preferences
        $user->update([
            'dietary_preferences' => $validated['dietary_preferences'] ?? $user->dietary_preferences,
            'allergies' => $validated['allergies'] ?? $user->allergies,
            'goals' => $validated['goals'] ?? $user->goals,
            'address' => $validated['delivery_address'],
        ]);

        return redirect()->route('payment.show', $subscription->id)->with('success', 'Pesanan berhasil dibuat! Silakan pilih metode pembayaran.');
    }
}
