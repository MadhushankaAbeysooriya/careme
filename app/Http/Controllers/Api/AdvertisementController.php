<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

            return response()->json(['image_paths' => $fullPaths, 'status' => 1, 'message' => 'Success'],200);
        }else{
             // If the token is not validated, send a message
             return response()->json(['message' => 'Not validated','status' => 0], 200);
        }
    }

    public function advertisementbyCategory(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'advertisement_category_id' => 'required',
            ], [
                'advertisement_category_id.required' => 'The advertisement category is required.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
            }

            // Split the string into an array of individual category IDs
            $categoryIds = explode(',', $request->advertisement_category_id[0]);

            // Retrieve advertisements for the specified category IDs
            $advertisements = Advertisement::select('filepath','url')
                            ->whereIn('advertisement_category_id', $categoryIds)->get();

            // Use the map method to modify each advertisement's filepath
            $advertisements->map(function ($advertisement) {
                $advertisement->filepath = asset($advertisement->filepath);
                return $advertisement;
            });

            return response()->json(['advertisements' => $advertisements, 'status' => 1, 'message' => 'Success'],200);
        }else{
             // If the token is not validated, send a message
             return response()->json(['message' => 'Not validated','status' => 0], 200);
        }
    }
}
