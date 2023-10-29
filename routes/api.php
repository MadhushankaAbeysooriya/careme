<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Generate Token and send to mobile app
Route::post('/generate-token', [AuthController::class, 'generateToken']);

// Generate OTP and send to mobile app
Route::post('/generate-otp', [AuthController::class, 'generateOTP']);

// Verify OTP and generate JWT token
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);

Route::post('/token', function (Request $request) {
    $request->validate([
        'device_name' => 'required',
    ]);

    $user = User::where('deviceId', $request->device_name)->first();

    if (! $user) {
        return response()->json(['message' => 'Device not found'], 404);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['user_type' => $user->user_type,
                            'first_name' => $user->fname,
                            'last_name' => $user->lname,
                            'gender' => $user->gender,
                                'api_token' => $token]);
});


