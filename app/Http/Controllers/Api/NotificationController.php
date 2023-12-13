<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PatientRequestStatus;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function getPatientNotification(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
        ], [
            'patient_id.required' => 'The patient id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $results = PatientRequestStatus::whereHas('patientrequest', function ($query) use ($request) {
                            $query->where('patient_id', $request->patient_id);
                        })
                        ->latest('created_at') // Assuming 'created_at' is the timestamp field in your PatientRequestStatus table
                        ->take(10)
                        ->get();

           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                
                return [
                    'job_id' => $result->patient_request_id,
                    // 'patient_first_name' => $result->patient->fname,
                    // 'patient_last_name' => $result->patient->lname,
                    // 'patient_gender' => $result->patient->gender,
                    'hospital' => $result->patientrequest->hospital->name,
                    'starting_date' => $result->patientrequest->from,
                    'ending_date' => $result->patientrequest->to,                    
                    'total_price' => $result->patientrequest->total_price,
                    'status' => $result->status,
                ];
            });

            return response()->json(['data' => $transformedResults]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }

    public function getCareTakerNotification(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'care_taker_id' => 'required',
        ], [
            'care_taker_id.required' => 'The patient id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $results = PatientRequestStatus::whereHas('patientrequest', function ($query) use ($request) {
                            $query->where('user_id', $request->care_taker_id);
                        })
                        ->latest('created_at') // Assuming 'created_at' is the timestamp field in your PatientRequestStatus table
                        ->take(10)
                        ->get();

           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                
                return [
                    'job_id' => $result->patient_request_id,
                    // 'patient_first_name' => $result->patient->fname,
                    // 'patient_last_name' => $result->patient->lname,
                    // 'patient_gender' => $result->patient->gender,
                    'hospital' => $result->patientrequest->hospital->name,
                    'starting_date' => $result->patientrequest->from,
                    'ending_date' => $result->patientrequest->to,                    
                    'total_price' => $result->patientrequest->total_price,
                    'status' => $result->status,
                ];
            });

            return response()->json(['data' => $transformedResults]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }
}
