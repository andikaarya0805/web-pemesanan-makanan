<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'revenue' => Subscription::whereIn('status', ['active', 'completed'])->sum('total_price'),
            'pending_messages' => ContactMessage::where('status', 'new')->count(),
        ];

        $recentSubscriptions = Subscription::with(['user', 'plan'])
            ->whereHas('user', fn($q) => $q->where('role', 'user'))
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recentMessages = ContactMessage::orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSubscriptions', 'recentMessages'));
    }
}
