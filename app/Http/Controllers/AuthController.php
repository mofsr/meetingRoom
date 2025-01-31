<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginAttempt;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return response()->json(['message' => 'User registered successfully!'], 201);
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // Fetch or initialize login attempt count
    $attempts = LoginAttempt::where('user_id', $user->id)->first();
    
    if ($attempts && $attempts->attempts >= 3) {
        // Check if lockout period has passed
        if (now()->diffInHours($attempts->last_attempt) < 24) {
            return response()->json(['error' => 'Too many login attempts. Try again in 24 hours.'], 429);
        } else {
            // Reset login attempts after 24 hours
            $attempts->update(['attempts' => 0]);
        }
    }

    if (Auth::attempt($request->only('email', 'password'))) {
        // Successful login → Reset failed attempts
        if ($attempts) {
            $attempts->delete();
        }
        
        return response()->json([
            'message' => 'Login successful',
            'token' => $user->createToken('authToken')->plainTextToken,
        ]);
    }

    // Failed login attempt
    if (!$attempts) {
        LoginAttempt::create([
            'user_id' => $user->id,
            'attempts' => 1,
            'last_attempt' => now(),
        ]);
    } else {
        $attempts->increment('attempts', 1);
        $attempts->update(['last_attempt' => now()]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
}


     public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

