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
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
            'care_taker_id' => 'required',
            'hospital_id' => 'required',
            'patient_id' => 'required',
            'hrs' => 'required',
            'payment_method_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date_format' => 'The from date field must be in the format YYYY-MM-DD HH:MM:SS.',
            'to.required' => 'The to date field is required.',
            'to.date_format' => 'The to date field must be in the format YYYY-MM-DD HH:MM:SS.',
            'care_taker_id.required' => 'User is required.',
            'hospital_id.required' => 'Hospital is required.',
            'patient_id.required' => 'Hospital is required.',
            'hrs.required' => 'The hrs feild is required.',
            'payment_method_id.required' => 'The payment method feild is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        //dd($request);

        PatientRequest::create([
            'from' => $request->from,
            'to' => $request->to,
            'care_taker_id' => $request->care_taker_id,
            'hospital_id' => $request->hospital_id,
            'patient_id' => $request->patient_id,
            'hrs' =>  $request->hrs,
            'total_price' => $request->total_price,
            'svc_charge' => config('app.svc_charge'),
            'payment_method_id' => $request->payment_method_id,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function storeMany(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
            'care_taker_id' => 'required|array', // Validate that each user_id exists in the 'users' table
            'hospital_id' => 'required',
            'patient_id' => 'required',
            'total_price' => 'required',
            'hrs' => 'required',
            'payment_method_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date_format' => 'The from date field must be in the format YYYY-MM-DD HH:MM:SS.',
            'to.required' => 'The to date field is required.',
            'to.date_format' => 'The to date field must be in the format YYYY-MM-DD HH:MM:SS.',
            'care_taker_id.required' => 'Each user ID is required.',
            'care_taker_id.array' => 'user ID is an array.',
            'hospital_id.required' => 'Hospital is required.',
            'patient_id.required' => 'Hospital is required.',
            'hrs.required' => 'The hrs feild is required.',
            'total_price.required' => 'Total Price is required.',
            'payment_method_id.required' => 'The payment method feild is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $from = $request->input('from');
        $to = $request->input('to');

        //$userIds = $request->input('care_taker_id');

        if ($request->care_taker_id) {
            $careTakerIds = array_map('trim', explode(',', $request->care_taker_id[0]));
        }

        $hospitalId = $request->input('hospital_id');
        $patientId = $request->input('patient_id');
        $hrs = $request->input('hrs');
        $totalPrice = $request->input('total_price');
        $paymentMethod = $request->input('payment_method_id');

        $successCount = 0;
        $errorMessages = [];

        foreach ($careTakerIds as $careTakerId) {
            try {
                //dd($careTakerId);
                PatientRequest::create([
                    'from' => $from,
                    'to' => $to,
                    'care_taker_id' => $careTakerId,
                    'hospital_id' => $hospitalId,
                    'patient_id' => $patientId,
                    'hrs' =>  $hrs,
                    'total_price' => $totalPrice,
                    'svc_charge' => config('app.svc_charge'),
                    'payment_method_id' => $paymentMethod,
                ]);
                $successCount++;
            } catch (Exception $e) {
                $errorMessages[] = "Failed to create PatientRequest for user ID $careTakerId: " . $e->getMessage();
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
                    ->where('care_taker_id',$request->user_id)
                    ->latest('created_at')
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
                    'total_price' => $result->total_price - $result->svc_charge,
                    'payment_method' => $result->paymentmethod->name,
                    //'svc_charge' => $result->svc_charge,
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
                                ->latest('created_at')
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
                    'svc_charge' => $result->svc_charge,
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
                        ->whereIn('status', [0,1,2])
                        ->latest('created_at')
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
                    'total_price' => $result->total_price - $result->svc_charge,
                    'svc_charge' => $result->svc_charge,
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

            $filepathDirectory = public_path('/upload/payment/'.$request->job_id.'/');

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
                    'filepath' => '/upload/payment/'.$request->job_id.'/'.$filefilepath,
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
                        ->whereIn('status', [3,5])
                        ->latest('created_at')
                        ->get();
            //dd($results);

            // Map and transform the results to include only specific fields
           // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->caretaker->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'job_id' => $result->id,
                    'care_taker_id' => $result->care_taker_id,
                    'care_taker_first_name' => $result->caretaker->fname,
                    'care_taker_last_name' => $result->caretaker->lname,
                    'starting_date' => $result->from,
                    'ending_date' => $result->to,
                    'status' => $result->status,
                    'total_price' => $result->total_price - $result->svc_charge,
                    //'svc_charge' => $result->svc_charge,
                    'care_taker_phone' => $result->caretaker->phone,
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
            $results = PatientRequest::where('care_taker_id', $request->care_taker_id)
                        ->whereIn('status', [3,4,5])
                        ->latest('created_at')
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
                    'total_price' => $result->total_price - $result->svc_charge,
                    //'svc_charge' => $result->svc_charge,
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
                        ->whereIn('status', [3,4,5,6])
                        ->latest('created_at')
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
                    'total_price' => $result->total_price - $result->svc_charge,
                    //'svc_charge' => $result->svc_charge,
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
            $results = PatientRequest::where('care_taker_id', $request->care_taker_id)
                        ->where('status', 6)
                        ->latest('created_at')
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
                    'total_price' => $result->total_price  - $result->svc_charge,
                    //'svc_charge' => $result->svc_charge,
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
