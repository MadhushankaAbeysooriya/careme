<?php

namespace App\Http\Controllers\Api;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                //$shifts = Shift::all();
                $shifts = Shift::select('id', 'name')->get();

                return response()->json(['shifts' => $shifts, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
