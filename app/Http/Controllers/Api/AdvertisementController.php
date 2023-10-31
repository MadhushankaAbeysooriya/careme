<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Retrieve all image paths from the 'advertisements' table
            $imagePaths = Advertisement::pluck('filepath')->toArray();

            $fullPaths = array_map(function($path) {
                return asset($path);
            }, $imagePaths);

            return response()->json(['image_paths' => $fullPaths]);
        }else{
             // If the token is not validated, send a message
             return response()->json(['message' => 'Not validated'], 401);
        }
    }
}
