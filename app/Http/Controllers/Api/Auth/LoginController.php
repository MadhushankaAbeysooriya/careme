<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AvlCareTaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        $user = User::where('phone', $request->mobile)->first();

        if (! $user) {
            return response()->json(['message' => 'Mobile not found',
                                    'status'=> '0'], 200);
        }

        $token = $user->createToken($request->mobile)->plainTextToken;


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
}
