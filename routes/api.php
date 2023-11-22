<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\AvlCareTakerController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CareTakerProfileController;

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
        'device_id' => 'required',
    ]);

    $user = User::where('deviceId', $request->device_id)->first();

    if (! $user) {
        return response()->json(['message' => 'Device not found',
                                'status'=> '0'], 200);
    }

    $token = $user->createToken($request->device_id)->plainTextToken;

    return response()->json(['user_type' => $user->user_type,
                            'first_name' => $user->fname,
                            'last_name' => $user->lname,
                            'gender' => $user->gender,
                            'validation' => $user->validated,
                            'api_token' => $token,
                            ]);
});

Route::post('/register',[RegisterController::class,'register']);

Route::middleware('auth:sanctum')->get('/advertisements', [AdvertisementController::class, 'index']);

Route::middleware('auth:sanctum')->get('/shifts', [ShiftController::class, 'index']);

Route::middleware('auth:sanctum')->get('/hospitals', [HospitalController::class, 'index']);

Route::middleware('auth:sanctum')->post('/store-avlcaretaker', [AvlCareTakerController::class, 'store']);

Route::middleware('auth:sanctum')->post('/store-avlcaretaker-auto', [AvlCareTakerController::class, 'storeAvlAuto']);

Route::middleware('auth:sanctum')->post('/update-avlcaretaker-auto', [AvlCareTakerController::class, 'updateAvlAuto']);

Route::middleware('auth:sanctum')->get('/search-avlcaretaker', [AvlCareTakerController::class, 'search']);

Route::middleware('auth:sanctum')->post('/store-caretaker-profile', [CareTakerProfileController::class, 'store']);





