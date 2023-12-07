<?php

namespace App\Http\Controllers\Api;

use App\Models\Hospital;
use App\Models\UserHospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                //$shifts = Hospital::all();
                $hospitals = Hospital::select('id', 'name')->get();

                return response()->json(['hospitals' => $hospitals, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }

    public function getHospitalbyUser(Request $request)
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

                $hospitals = UserHospital::select('id', 'hospital_id')->where('user_id',$request->user_id)->get();

                return response()->json(['hospitals' => $hospitals, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
