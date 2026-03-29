<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\MenuItem;
use App\Models\MealSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'menu_item_ids' => 'required|array|min:1',
            'menu_item_ids.*' => 'exists:menu_items,id',
        ]);

        $subscription = Subscription::findOrFail($validated['subscription_id']);
        
        $user = Auth::user();

        // Check ownership
        if ($subscription->user_id !== $user->id) {
            return abort(403);
        }

        // Logic to store selection
        // Clear existing selections for this subscription (simulated for current week)
        $subscription->selections()->delete();

        foreach ($validated['menu_item_ids'] as $itemId) {
            MealSelection::create([
                'subscription_id' => $subscription->id,
                'menu_item_id' => $itemId,
                'week_number' => 1, // Defaulting to week 1 for now
                'status' => 'pending'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Menu mingguan berhasil dipilih! Tim kami akan segera menyiapkan pesanan Anda.'
        ]);
    }
}
