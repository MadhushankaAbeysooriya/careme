<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $about_us = AboutUs::get();

                return response()->json(['about_us' => $about_us, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
