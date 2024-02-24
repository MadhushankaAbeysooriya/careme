<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BillProof;
use Illuminate\Support\Facades\Auth;

class BillProofController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $billProofs = BillProof::select('id', 'name')->get();

                return response()->json(['billProofs' => $billProofs, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
