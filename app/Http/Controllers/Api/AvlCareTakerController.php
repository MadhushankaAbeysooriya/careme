<?php

namespace App\Http\Controllers\Api;

use App\Models\AvlCareTaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class AvlCareTakerController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
            'shift_id' => 'required',
            'user_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date' => 'The from date field must be a date.',
            'to.required' => 'The to date field is required.',
            'to.date' => 'The to date field must be a date.',
            'shift_id.required' => 'Shift is required.',
            'user_id.required' => 'User is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $avlcaretaker = AvlCareTaker::create([
            'from' => $request->from,
            'to' => $request->to,
            'shift_id' => $request->shift_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function search(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'from' => 'required|date',
                'to' => 'required|date',
                'shift_id' => 'required|integer',
            ]);

            // Get the search criteria from the request
            $from = $request->input('from');
            $to = $request->input('to');
            $shiftId = $request->input('shift_id');

            // Perform the search using query scopes directly in the controller
            // $results = AvlCareTaker::where(function ($query) use ($from, $to) {
            //     $query->whereBetween('from', [$from, $to])
            //         ->orWhereBetween('to', [$from, $to]);
            // })
            // ->where('shift_id', $shiftId)
            // ->get();

            $results = AvlCareTaker::where(function ($query) use ($from, $to) {
                $query->where('from', '<=', $from)
                      ->where('to', '>=', $to);
            })
            ->where('shift_id', $shiftId)
            ->get();

            // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->user->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'user_name' => $result->user->name,
                    'user_age' => $age,
                    'user_gender' => $result->user->gender,
                    // Add other fields as needed
                ];
            });

            return response()->json(['data' => $transformedResults]);
        } catch (Exception $e) {
            // Handle unexpected exceptions or errors
            if ($e instanceof QueryException) {
                return response()->json(['error' => 'Database query error.'], 500);
            }

            return response()->json(['error' => 'Unexpected error.'], 500);
        }
    }

}
