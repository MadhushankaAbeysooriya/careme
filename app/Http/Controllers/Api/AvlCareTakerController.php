<?php

namespace App\Http\Controllers\Api;

use App\Models\AvlCareTaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

}
