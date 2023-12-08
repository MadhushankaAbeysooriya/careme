<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AvlCareTaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'device_id' => 'required',

        ], [
            'mobile.required' => 'The mobile field is required.',
            'device_id.required' => 'The device id field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $user = User::where('phone', $request->mobile)->first();

        if (! $user) {
            return response()->json(['message' => 'Mobile not found',
                                    'status'=> '0'], 200);
        }

        $token = $user->createToken($request->mobile)->plainTextToken;


        $user->update([
            'login_status' => 1,
            'deviceId' => $request->device_id,
        ]);


        return response()->json([
                        'user_id' => $user->id,
                        'user_type' => $user->user_type,
                        'first_name' => $user->fname,
                        'last_name' => $user->lname,
                        'gender' => $user->gender,
                        'validation' => $user->validated,
                        'api_token' => $token,
                    ]);

    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        $user = User::where('phone', $request->mobile)->first();

        if (! $user) {
            return response()->json(['message' => 'Un Authorized User',
                                    'status'=> '0'], 200);
        }

        return response()->json(['message' => 'Authorized User',
        'status'=> '1'], 200);

    }

    public function checkValidated(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found',
                                    'status'=> '0'], 200);
        }

        $avlCareTaker = AvlCareTaker::where('user_id', $request->user_id)
                        ->where('from', '<=', Carbon::now()) // Assuming 'from' is the start date of availability
                        ->where('to', '>=', Carbon::now())   // Assuming 'to' is the end date of availability
                        ->first();

        if ($avlCareTaker) {
            // User is available
            return response()->json(['validation' => $user->validated, 'available' => '1'], 200);
        } else {
            // User is not available
            return response()->json(['validation' => $user->validated, 'available' => '0'], 200);
        }

    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        //dd($user);

        if ($user) {
            // Revoke the current user's access token
            $user->currentAccessToken()->delete();

            // Update the login status to 0 (logged out)
            $user->update([
                'login_status' => 0,
            ]);

            return response()->json(['message' => 'Logout successful', 'status' => '1'], 200);
        } else {
            return response()->json(['message' => 'User not authenticated', 'status' => '0'], 401);
        }
    }
}
