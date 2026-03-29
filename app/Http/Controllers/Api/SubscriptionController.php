<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function pause(Request $request)
    {
        $validated = $request->validate([
            'subscription_id' => 'required|integer',
        ]);

        $subscription = Subscription::where('id', $validated['subscription_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $subscription->update(['status' => 'paused']);

        return response()->json(['success' => true, 'message' => 'Langganan berhasil dijeda.']);
    }
}
