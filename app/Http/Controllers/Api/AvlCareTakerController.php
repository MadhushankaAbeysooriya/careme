<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\AvlCareTaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class AvlCareTakerController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        // $validator = Validator::make($request->all(), [
        //     'from' => 'required|date',
        //     'to' => 'required|date',
        //     'shift_id' => 'required',
        //     'user_id' => 'required',
        // ], [
        //     'from.required' => 'The from date field is required.',
        //     'from.date' => 'The from date field must be a date.',
        //     'to.required' => 'The to date field is required.',
        //     'to.date' => 'The to date field must be a date.',
        //     'shift_id.required' => 'Shift is required.',
        //     'user_id.required' => 'User is required.',
        // ]);

        $validator = Validator::make($request->all(), [
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
            // 'shift_id' => 'required',
            'user_id' => 'required',
        ], [
            'from.required' => 'The from date field is required.',
            'from.date_format' => 'The from date field must be in the format YYYY-MM-DD HH:MM:SS.',
            'to.required' => 'The to date field is required.',
            'to.date_format' => 'The to date field must be in the format YYYY-MM-DD HH:MM:SS.',
            // 'shift_id.required' => 'Shift is required.',
            'user_id.required' => 'User is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $avlcaretaker = AvlCareTaker::create([
            'from' => $request->from,
            'to' => $request->to,
            // 'shift_id' => $request->shift_id,
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
            // $request->validate([
            //     'from' => 'required|date',
            //     'to' => 'required|date',
            //     'shift_id' => 'required|integer',
            // ]);

            $validator = Validator::make($request->all(), [
                'from' => 'required|date_format:Y-m-d H:i:s',
                'to' => 'required|date_format:Y-m-d H:i:s',
                // 'shift_id' => 'required',
            ], [
                'from.required' => 'The from date field is required.',
                'from.date_format' => 'The from date field must be in the format YYYY-MM-DD HH:MM:SS.',
                'to.required' => 'The to date field is required.',
                'to.date_format' => 'The to date field must be in the format YYYY-MM-DD HH:MM:SS.',

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
            }

            // Get the search criteria from the request
            $from = $request->input('from');
            $to = $request->input('to');

            $results = AvlCareTaker::where(function ($query) use ($from, $to) {
                $query->where('from', '<=', $from)
                      ->where('to', '>=', $to);
            })
            ->get();

            // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->user->dob);
                $age = $dob->diffInYears(Carbon::now());
                return [
                    'user_name' => $result->user->name,
                    'user_age' => $age,
                    'user_gender' => $result->user->gender,
                    'personaPhoto' => optional($result->user->caretakerprofile)->personal_photo
                                        ? asset($result->user->caretakerprofile->personal_photo)
                                        : null,
                    'description' => optional($result->user->caretakerprofile)->description,
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

    public function storeAvlAuto(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'User is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $fromDate = Carbon::now(); // Set the from date to the current date
        $toDate = $fromDate->copy()->addDays(3); // Calculate the to date as 4 days from the from date

        AvlCareTaker::create([
            'from' => $fromDate,
            'to' => $toDate,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function updateAvlAuto(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'User is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        $toDate = Carbon::now(); // Calculate the to date as 4 days from the from date

        // Find the final record for the given user_id
        $avlcaretaker = AvlCareTaker::where('user_id', $request->user_id)
                        ->where('to','>', $toDate)
                        ->orderBy('created_at', 'desc') // Assuming created_at is the timestamp field indicating when the record was created
                        ->first();

        if ($avlcaretaker) {
            // Update the existing record
            $avlcaretaker->update([
                'to' => $toDate,
            ]);
        }else{

            return response()->json([
                'message' => 'you are already unavailable',
                'status' => 1,
            ], 200);

        }

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function searchAvlAuto(Request $request)
    {
        try {
            // Validate the request data
            // $request->validate([
            //     'from' => 'required|date',
            //     'to' => 'required|date',
            //     'hospital_id' => 'required',
            // ]);

            $validator = Validator::make($request->all(), [
                'from' => 'required|date_format:Y-m-d H:i:s',
                'to' => 'required|date_format:Y-m-d H:i:s',
                'hospital_id' => 'required',
            ], [
                'from.required' => 'The from date field is required.',
                'from.date_format' => 'The from date field must be in the format YYYY-MM-DD HH:MM:SS.',
                'to.required' => 'The to date field is required.',
                'to.date_format' => 'The to date field must be in the format YYYY-MM-DD HH:MM:SS.',
                'hospital_id.required' => "The Hospital id feild is required.",
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
            }

            // Get the search criteria from the request
            $from = $request->input('from');
            $to = $request->input('to');
            $hospitalId = $request->input('hospital_id');



            $results = AvlCareTaker::where(function ($query) use ($from, $to) {
                            $query->where('from', '<=', $from)
                                ->where('to', '>=', $to);
                        })
                        ->whereHas('user.hospitals', function ($query) use ($hospitalId) {
                            $query->where('hospital_id', $hospitalId);
                        })
                        ->with('user.ratings') // Load the user ratings relationship
                        ->get();



            // Map and transform the results to include only specific fields
            $transformedResults = $results->map(function ($result) {
                $dob = Carbon::parse($result->user->dob);
                $age = $dob->diffInYears(Carbon::now());

                // Calculate the average rating
                $ratings = $result->user->ratings;
                $totalRatings = $ratings->count();
                $averageRating = $totalRatings > 0 ? $ratings->sum('rating') / $totalRatings : 0;


                return [
                    'user_name' => $result->user->name,
                    'user_age' => $age,
                    'user_gender' => $result->user->gender,
                    'personaPhoto' => optional($result->user->caretakerprofile)->personal_photo
                                        ? asset($result->user->caretakerprofile->personal_photo)
                                        : null,
                    'description' => optional($result->user->caretakerprofile)->description,
                    'user_id' => $result->user->id,
                    'rating' => $averageRating,
                    'rate' => 2000,
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
