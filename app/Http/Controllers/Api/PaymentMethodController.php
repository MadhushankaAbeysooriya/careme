<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $paymentMethods = PaymentMethod::select('id', 'name')->where('status',1)->get();

                return response()->json(['paymentMethods' => $paymentMethods, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
