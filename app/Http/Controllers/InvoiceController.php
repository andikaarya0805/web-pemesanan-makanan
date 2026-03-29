<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Subscription $subscription)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check access
        if ($user->id !== $subscription->user_id && !$user->isAdmin()) {
            return abort(403);
        }

        return view('invoice.show', compact('subscription'));
    }
}
