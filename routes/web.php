<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('app');  // This is the entry point for your Vue.js app (index.html or App.vue)
});

Route::get('/login', function () {
    return view('app');  // Render the Vue app for login page
});

Route::get('/bookmeeting', function () {
    return view('bookmeeting'); // This will load the Blade view for the meeting room booking page
});

Route::get('/mybooking', function () {
    return view('mybooking'); // This will load the Blade view for the meeting room booking page
});
Route::get('/register', function () {
    return view('app');  // Render the Vue app for registration page
});
Route::get('/logout', function () {
    return view('app');  // Render the Vue app for registration page
});

// The routes for login and register POST requests
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


