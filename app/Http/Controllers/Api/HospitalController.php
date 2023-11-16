<?php

namespace App\Http\Controllers\Api;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
