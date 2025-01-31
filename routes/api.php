<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Models\LoginAttempt;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bookings', [BookingController::class, 'myBookings']);
    Route::post('/bookmeeting', [BookingController::class, 'bookMeeting']);
    Route::get('/available-rooms', [BookingController::class, 'getAvailableRooms']);
});


Route::post('/reset-login-attempts/{user_id}', function ($user_id) {
    LoginAttempt::where('user_id', $user_id)->delete();
    return response()->json(['message' => 'Login attempts reset successfully']);
})->middleware('auth:sanctum');


