<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Complain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ComplainController extends Controller
{
    public function index()
    {
        try {

            $complains = Complain::select('id','topic','complain')->where('status',1)->get();

            return response()->json(['complains' => $complains],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function getByUser(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'The user id field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {

            // Get the ClassRoom model with the given user_id
            $complains = Complain::select('id','topic','complain')->where('user_id', $request->user_id)->get();

            if (!$complains) {
                return response()->json(['error' => 'No complains available.'], 404);
            }

            return response()->json(['complains' => $complains], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'topic' => 'required|min:3|max:100',
            'complain' => 'required|min:10|max:255',
        ], [
            'user_id.required' => 'The user id field is required.',
            'topic.required' => 'The topic field is required.',
            'topic.min' => 'The topic must be at least :min characters.',
            'topic.max' => 'The topic may not be greater than :max characters.',
            'complain.required' => 'The complain field is required.',
            'complain.min' => 'The complain must be at least :min characters.',
            'complain.max' => 'The complain may not be greater than :max characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {

            Complain::create([
                'user_id' => $request->user_id,
                'topic'  => $request->topic,
                'complain' => $request->complain,
            ]);

            return response()->json([
                'message' => 'Success',
                'status' => 1,
            ], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
