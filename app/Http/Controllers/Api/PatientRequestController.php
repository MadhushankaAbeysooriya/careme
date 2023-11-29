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
            'user_id' => 'required',
            'shift_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date' => 'The from date field must be a date.',
            'to.required' => 'The to date field is required.',
            'to.date' => 'The to date field must be a date.',
            'user_id.required' => 'User is required.',
            'shift_id.required' => 'Shift is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        PatientRequest::create([
            'from' => $request->from,
            'to' => $request->to,
            'user_id' => $request->user_id,
            'shift_id' => $request->shift_id,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function storeMany(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id', // Validate that each user_id exists in the 'users' table
            'shift_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date' => 'The from date field must be a date.',
            'to.required' => 'The to date field is required.',
            'to.date' => 'The to date field must be a date.',
            'user_ids.required' => 'User IDs are required.',
            'user_ids.array' => 'User IDs must be an array.',
            'user_ids.*.required' => 'Each user ID is required.',
            'user_ids.*.exists' => 'The selected user ID is invalid or does not exist in the users table.',
            'shift_id.required' => 'Shift is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $from = $request->from;
        $to = $request->to;
        $userIds = $request->user_ids;
        $shiftId = $request->shift_id;

        $successCount = 0;
        $errorMessages = [];

        foreach ($userIds as $userId) {
            try {
                PatientRequest::create([
                    'from' => $from,
                    'to' => $to,
                    'user_id' => $userId,
                    'shift_id' => $shiftId,
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
}
