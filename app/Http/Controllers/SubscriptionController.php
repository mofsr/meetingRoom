<?php

namespace App\Http\Controllers;


use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function upgrade(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|in:Basic Plan,Advance Plan,Premium Plan',
        ]);

        $plans = [
            'Basic Plan' => 5,
            'Advance Plan' => 7,
            'Premium Plan' => 10,
        ];

        $user = Auth::user();
        $user->subscription()->updateOrCreate(
            ['user_id' => $user->id],
            ['plan_name' => $request->plan_name, 'max_bookings_per_day' => $plans[$request->plan_name]]
        );

        return response()->json(['message' => 'Subscription upgraded successfully']);
    }
}
