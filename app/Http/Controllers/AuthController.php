<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function generateToken(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        $mobileNumber = $request->input('mobile_number');

        $user = User::where('contact', $mobileNumber)->where('status',1)->first();

        if (!$user) {
            return response()->json(['error' => 'Mobile number not found in the database.'], 404);
        }

        //Generate Token
        $token = JWTAuth::fromUser($user);

        $userRole = $user->roles->pluck('name','name')->toArray();

        // Sort in ascending order while maintaining key-value associations
        natsort($userRole);

        // Assuming $userRole is an associative array like before
        $userRoles = implode('_', array_values($userRole));

        $user->update([
            'token' => $token,
        ]);

        // Send the JWT token and the verification code (OTP) back to the mobile app
        return response()->json([
            'token' => $token,
            'userRole' => $userRoles,
            'device_id' => $user->device_id,
        ], 200);
        ////////////////////////////////////////////////


        // return response()->json(['message' => 'OTP generated successfully.', 'verification_code' => $verificationCode], 200);
    }

    public function generateOTP(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|digits:10',
            'token' => 'required|string',
        ]);

        $mobileNumber = $request->input('mobile_number');
        $token = $request->input('token');

        $user = User::where('contact', $mobileNumber)
                ->where('token',$token)
                ->where('status',1)->first();

        if (!$user) {
            return response()->json(['error' => 'Mobile number not found in the database.'], 404);
        }

        // $verificationCode = Str::random(6);

        $verificationCode = mt_rand(100000, 999999);

        // Store the hashed verification code with an expiration time (e.g., 5 minutes)
        Cache::put('verification_code:' . $token, Hash::make($verificationCode), now()->addMinutes(5));


        // Send the JWT token and the verification code (OTP) back to the mobile app
        return response()->json([
            'message' => "Success",
            'verification_code' => $verificationCode,
        ], 200);
        ////////////////////////////////////////////////


        // return response()->json(['message' => 'OTP generated successfully.', 'verification_code' => $verificationCode], 200);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'verification_code' => 'required|string|size:6',
            'device_id' => 'required',
        ]);

        $token = $request->input('token');
        $verificationCode = $request->input('verification_code');
        $deviceId = $request->input('device_id');


        $hashedVerificationCode = Cache::get('verification_code:' . $token);

        if (!$hashedVerificationCode || !Hash::check($verificationCode, $hashedVerificationCode)) {
            return response()->json(['error' => 'Invalid verification code.'], 401);
        }

        // Verification successful, issue JWT token
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token not found in the database.'], 404);
        }

        $user->update([
            'device_id' => $deviceId,
        ]);

        // Clear the verification code from cache
        Cache::forget('verification_code:' . $token);

        return response()->json(['message' => 'Verified'], 200);
    }
}

