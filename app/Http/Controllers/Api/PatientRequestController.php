<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PatientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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

        $results = PatientRequest::
        //select('id', 'user_id', 'from', 'to', 'status', 'shift_id', 'hospital_id', 'patient_id', 'rate', 'total_price')
                    where('status',0)
                    ->where('user_id',$request->user_id)
                    ->get();

        $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->patient->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'patient_first_name' => $result->patient->fname,
                    'patient_last_name' => $result->patient->lname,
                    'patient_gender' => $result->patient->gender,
                    'patient_age' => $age,
                    'hospital' => $result->hospital->name,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'total_price' => $result->total_price,
                    // 'personaPhoto' => optional($result->patient->patientprofile)->personal_photo
                    //                     ? asset($result->patient->patientprofile->personal_photo)
                    //                     : null,
                    // 'description' => optional($result->patient->patientprofile)->description,
                ];
            });

        return response()->json(['data' => $transformedResults]);

    }

    public function approvePatientRequest(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'patient_request_id' => 'required',
        ], [
            'patient_request_id.required' => 'The patient request id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $patientRequest = PatientRequest::findOrFail($request->patient_request_id);

            if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 1,
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 1,
                    'date' => Carbon::now(),
                ]);
            }

            return response()->json([
                'message' => 'Success',
                'status' => 1,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }

    public function rejectPatientRequest(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'patient_request_id' => 'required',
        ], [
            'patient_request_id.required' => 'The patient request id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $patientRequest = PatientRequest::findOrFail($request->patient_request_id);

            if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 2,
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 2,
                    'date' => Carbon::now(),
                ]);
            }

            return response()->json([
                'message' => 'Success',
                'status' => 1,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }

    public function getApprovedPatientRequest(Request $request)
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
            $results = PatientRequest::where('patient_id', $request->patient_id)
                                ->where('status',1)
                                ->get();
            //dd($results);

            // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->caretaker->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'care_taker_id' => $result->user_id,
                    'care_taker_first_name' => $result->caretaker->fname,
                    'care_taker_last_name' => $result->caretaker->lname,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    //'care_taker_age' => $age,
                    //'care_taker_gender' => $result->caretaker->gender,
                    // 'personaPhoto' => optional($result->caretaker->caretakerprofile)->personal_photo
                    //                     ? asset($result->caretaker->caretakerprofile->personal_photo)
                    //                     : null,
                    // 'description' => optional($result->caretaker->caretakerprofile)->description,
                    'status' => $result->status,
                    'total_price' => $result->total_price,
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

    public function getAllPatientRequest(Request $request)
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
            $results = PatientRequest::where('patient_id', $request->patient_id)
                                ->get();
            //dd($results);

            // Map and transform the results to include only specific fields
           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->caretaker->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'care_taker_id' => $result->user_id,
                    'care_taker_first_name' => $result->caretaker->fname,
                    'care_taker_last_name' => $result->caretaker->lname,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'total_price' => $result->total_price,
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

    public function paymentPatientRequest(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'filepath' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'job_id.required' => 'The job id is required.',
            'filepath.required' => 'The file field is required.',
            'filepath.mimes' => 'The file must be an image (jpeg, png, jpg, gif) or a PDF.',
            'filepath.max' => 'The file may not be greater than 2048 kilobytes.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $patientRequest = PatientRequest::findOrFail($request->job_id);

            $filepathDirectory = public_path('/upload/filepath/'.$request->job_id.'/');

            if (!File::isDirectory($filepathDirectory)) {
                File::makeDirectory($filepathDirectory, 0777, true, true);
            }

            $extfilepath = $request->file('filepath')->extension();
            $filefilepath = $request->job_id.'.'.$extfilepath;

            $request->file('filepath')->move($filepathDirectory, $filefilepath);

            if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 3, //paymet done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 3,
                    'date' => Carbon::now(),
                ]);

                $patientRequest->patientrequestpayment()->create([
                    'filepath' => '/upload/filepath/'.$request->job_id.'/'.$filefilepath,
                ]);
            }

            return response()->json([
                'message' => 'Success',
                'status' => 1,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }

    public function getPaymentPatientRequest(Request $request)
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
            $results = PatientRequest::where('patient_id', $request->patient_id)
                        ->whereIn('status', [3,4])
                        ->get();
            //dd($results);

            // Map and transform the results to include only specific fields
           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->caretaker->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'care_taker_id' => $result->user_id,
                    'care_taker_first_name' => $result->caretaker->fname,
                    'care_taker_last_name' => $result->caretaker->lname,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'total_price' => $result->total_price,
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

    public function makeRating(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
        ], [
            'job_id.required' => 'The job id is required.',
            'rating.required' => 'The rating is required.',
            'rating.numeric' => 'The rating must be a numeric value.',
            'rating.min' => 'The rating must be at least 0.',
            'rating.max' => 'The rating must not exceed 5.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $patientRequest = PatientRequest::findOrFail($request->job_id);

            if($patientRequest)
            {
                $patientRequest->update([
                    'status' => 4, //paymet done
                ]);

                $patientRequest->patientrequeststatus()->create([
                    'status' => 4,
                    'date' => Carbon::now(),
                ]);

                $patientRequest->caretaker->ratings()->create([
                    'rating' => $request->rating,
                ]);
            }

            return response()->json([
                'message' => 'Success',
                'status' => 1,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e . 'Error updating patient request status.',
                'status' => 0,
            ], 500);
        }

    }

    public function getCareTakerSchedule(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'care_taker_id' => 'required',
        ], [
            'care_taker_id.required' => 'The care taker id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $results = PatientRequest::where('user_id', $request->care_taker_id)
                        ->whereIn('status', [3,4])
                        ->get();

           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->caretaker->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'patient_first_name' => $result->patient->fname,
                    'patient_last_name' => $result->patient->lname,
                    'patient_gender' => $result->patient->gender,
                    'patient_age' => $age,
                    'hospital' => $result->hospital->name,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'total_price' => $result->total_price,
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

    public function getPaymentApprovePatientRequest(Request $request)
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
            $results = PatientRequest::where('patient_id', $request->patient_id)
                        ->where('status', 5)
                        ->get();

           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                
                return [
                    'job_id' => $result->id,
                    'care_taker_id' => $result->user_id,
                    'care_taker_first_name' => $result->caretaker->fname,
                    'care_taker_last_name' => $result->caretaker->lname,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'hospital' => $result->hospital->name,
                    'status' => $result->status,
                    'paid_date' => optional($result->patientrequeststatus->where('status', 3)->first())->date,
                    'approved_date' => optional($result->patientrequeststatus->where('status', 5)->first())->date,
                    'total_price' => $result->total_price,
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

    public function getDepositPatientRequest(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'care_taker_id' => 'required',
        ], [
            'care_taker_id.required' => 'The care taker id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $results = PatientRequest::where('user_id', $request->care_taker_id)
                        ->where('status', 6)
                        ->get();

           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                
                return [
                    'job_id' => $result->id,
                    'patient_first_name' => $result->patient->fname,
                    'patient_last_name' => $result->patient->lname,
                    'patient_gender' => $result->patient->gender,
                    'hospital' => $result->hospital->name,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'paid_date' => optional($result->patientrequeststatus->where('status', 3)->first())->date,
                    'approved_date' => optional($result->patientrequeststatus->where('status', 5)->first())->date,
                    'deposited_date' => optional($result->patientrequeststatus->where('status', 6)->first())->date,
                    'total_price' => $result->total_price,
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
