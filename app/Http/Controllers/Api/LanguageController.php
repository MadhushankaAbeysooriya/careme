<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use App\Models\UserHospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $languages = Language::select('id', 'name')->where('status',1)->get();

                return response()->json(['languages' => $languages, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }

    public function getLanguagebyUser(Request $request)
    {
        if(Auth::check())
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ], [
                'user_id.required' => 'User is required.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
            }

            try {

                $languages = UserHospital::select('id', 'language_id')->where('user_id',$request->user_id)->get();

                return response()->json(['languages' => $languages, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
