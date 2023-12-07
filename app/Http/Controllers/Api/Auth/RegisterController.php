<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'fname' => ['required','max:255'],
            'lname' => ['required','max:255'],
            'phone' => ['required','unique:users','max:10'],
            'gender' => ['required'],
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'fname.required' => 'The first name field is required.',
            'lname.required' => 'The last name field is required.',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone field must not be more than 10 characters.',
            'phone.unique' => 'The phone number is already taken.',
            'gender.required' => 'The gender field is required.',
        ]);
    }

    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|unique:users|max:10',
            'gender' => 'required',
            'device_id' => 'required',
            'user_type' => 'required',
            'dob' => 'required'
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone field must not be more than 10 characters.',
            'phone.unique' => 'The phone number is already taken.',
            'gender.required' => 'The gender field is required.',
            'device_id.required' => 'The device id field is required.',
            'user_type.required' => 'The user type field is required.',
            'dob.required' => 'The Date of Birth is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        // If validation passes, create the user
        $user = User::create([
            'name' => $request->first_name." ". $request->last_name,
            'email' => $request->email,
            //'password' => Hash::make($request->password),
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'deviceId' => $request->device_id,
            'user_type' => $request->user_type,
            'login_status' => 1,
            'dob' => $request->dob,
            // Add other user fields as needed
        ]);

        // Generate a Sanctum token for the newly registered user
        $token = $user->createToken($request->device_id)->plainTextToken;

        // Return a response with the token and user details
        return response()->json([
            'user_id' => $user->id,
            'api_token' => $token,
            'first_name' => $user->fname,
            'last_name' => $user->lname,
            'user_type' => $user->user_type, // Replace 'user_type' with the actual field name for user type
            'gender' => $user->gender,
            'dob' => $user->dob,
            'status' => 1,
            'message' => "Success",
        ],200);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required',
            'dob' => 'required'
        ], [
            'user_id.required' => 'The user id is required.',
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'gender.required' => 'The gender field is required.',
            'dob.required' => 'The Date of Birth is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found', 'status' => 0], 200);
        }

        // If validation passes, create the user
        $user->update([
            'name' => $request->first_name." ". $request->last_name,
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);

        // Return a response with the token and user details
        return response()->json([
            'message' => 'User updated successfully',
            'status' => 1,
        ],200);
    }

    public function getprivacypolicy()
    {
        if (Auth::check()) {
            // Retrieve all image paths from the 'advertisements' table
            $filepath = PrivacyPolicy::pluck('filepath')->toArray();

            $fullPaths = array_map(function($path) {
                return asset($path);
            }, $filepath);

            return response()->json(['filepath' => $fullPaths, 'status' => 1, 'message' => 'Success'],200);
        }else{
             // If the token is not validated, send a message
             return response()->json(['message' => 'Not validated','status' => 0], 200);
        }
    }
}
