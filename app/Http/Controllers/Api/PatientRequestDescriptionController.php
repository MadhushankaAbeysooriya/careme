<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientRequestDescription;

class PatientRequestDescriptionController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $patientRequestDescriptions = PatientRequestDescription::select('id', 'name')->where('status',1)->get();

                return response()->json(['descriptions' => $patientRequestDescriptions, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
