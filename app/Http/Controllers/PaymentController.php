<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Subscription $subscription)
    {
        if ($subscription->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Subscription is already processed.');
        }

        return view('payment.show', compact('subscription'));
    }

    public function process(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cod,qris,bank_transfer',
        ]);

        $subscription->update([
            'payment_method' => $validated['payment_method'],
            'status' => 'active', // In simulation, we activate immediately
        ]);

        return redirect()->route('payment.success', $subscription->id);
    }

    public function success(Subscription $subscription)
    {
        return view('payment.success', compact('subscription'));
    }
}
