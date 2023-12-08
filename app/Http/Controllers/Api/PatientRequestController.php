<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\PatientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PatientRequestController extends Controller
{
    public function storeOne(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
            'care_taker_id' => 'required',
            'shift_id' => 'required',
            'hospital_id' => 'required',
            'patient_id' => 'required'
        ], [
            'from.required' => 'The from date field is required.',
            'from.date' => 'The from date field must be a date.',
            'to.required' => 'The to date field is required.',
            'to.date' => 'The to date field must be a date.',
            'care_taker_id.required' => 'User is required.',
            'shift_id.required' => 'Shift is required.',
            'hospital_id.required' => 'Hospital is required.',
            'patient_id.required' => 'Hospital is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        //dd($request);

        PatientRequest::create([
            'from' => $request->from,
            'to' => $request->to,
            'user_id' => $request->care_taker_id,
            'shift_id' => $request->shift_id,
            'hospital_id' => $request->hospital_id,
            'patient_id' => $request->patient_id,
            'rate' =>  $request->rate,
            'total_price' => $request->total_price,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function storeMany(Request $request)
    {

        //dd($request);
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
            'care_taker_id' => 'required|array', // Validate that each user_id exists in the 'users' table
            'shift_id' => 'required',
            'hospital_id' => 'required',
            'patient_id' => 'required',
            'rate' => 'required',
            'total_price' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date' => 'The from date field must be a date.',
            'to.required' => 'The to date field is required.',
            'to.date' => 'The to date field must be a date.',
            'care_taker_id.required' => 'Each user ID is required.',
            'care_taker_id.array' => 'user ID is an array.',
            //'care_taker_id.exists' => 'The selected user ID is invalid or does not exist in the users table.',
            'shift_id.required' => 'Shift is required.',
            'hospital_id.required' => 'Hospital is required.',
            'patient_id.required' => 'Hospital is required.',
            'rate.required' => 'Rate is required.',
            'total_price.required' => 'Total Price is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $from = $request->input('from');
        $to = $request->input('to');

        //$userIds = $request->input('care_taker_id');

        if ($request->care_taker_id) {
            $userIds = array_map('trim', explode(',', $request->care_taker_id[0]));
        }

        $shiftId = $request->input('shift_id');
        $hospitalId = $request->input('hospital_id');
        $patientId = $request->input('patient_id');
        $rate = $request->input('rate');
        $totalPrice = $request->input('total_price');

        $successCount = 0;
        $errorMessages = [];

        foreach ($userIds as $userId) {
            try {
                //dd($userId);
                PatientRequest::create([
                    'from' => $from,
                    'to' => $to,
                    'user_id' => $userId,
                    'shift_id' => $shiftId,
                    'hospital_id' => $hospitalId,
                    'patient_id' => $patientId,
                    'rate' =>  $rate,
                    'total_price' => $totalPrice,
                ]);
                $successCount++;
            } catch (Exception $e) {
                $errorMessages[] = "Failed to create PatientRequest for user ID $userId: " . $e->getMessage();
            }
        }

        if ($successCount > 0) {
            return response()->json([
                'message' => 'Successfully created PatientRequests',
                'success_count' => $successCount,
                'status' => 1,
                'errors' => $errorMessages,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed to create PatientRequests',
                'status' => 0,
                'errors' => $errorMessages,
            ], 200);
        }
    }

    public function viewPatientRequestbyUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'user ID is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $results = PatientRequest::select('id', 'user_id', 'from', 'to', 'status', 'shift_id', 'hospital_id', 'patient_id', 'rate', 'total_price')
        ->where('user_id',$request->user_id)->get();

        return response()->json(['data' => $results]);

    }


}
