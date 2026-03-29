<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $activeSubscriptions = $user->subscriptions()
            ->where('status', 'active')
            ->with('plan')
            ->orderByDesc('created_at')
            ->get();

        $orderHistory = $user->subscriptions()
            ->with('plan')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $totalOrders = $user->subscriptions()->count();
        $activeWeeks = $user->subscriptions()->sum('duration_weeks');
        $totalSpent = $user->subscriptions()->whereIn('status', ['active', 'completed'])->sum('total_price');
        $activeCount = $activeSubscriptions->count();

        $availableMenu = \App\Models\MenuItem::where('is_active', true)->orderBy('category')->get();

        return view('dashboard', compact(
            'user', 'activeSubscriptions', 'orderHistory',
            'totalOrders', 'activeWeeks', 'totalSpent', 'activeCount', 'availableMenu'
        ));
    }

    public function showSubscription(Subscription $subscription)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($subscription->user_id !== $user->id) {
            abort(403);
        }

        $subscription->load(['plan', 'selections.menuItem']);
        
        // Group selections by week if applicable, or just list them
        $selections = $subscription->selections()->with('menuItem')->get();

        return view('subscription.show', compact('subscription', 'selections'));
    }
}
