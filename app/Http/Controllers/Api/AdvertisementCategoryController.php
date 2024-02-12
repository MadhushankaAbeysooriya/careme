<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AdvertisementCategory;

class AdvertisementCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {

            $advertisementCategories = AdvertisementCategory::select('id','name')
                                       ->whereNotIn('id',[1,2,3])
                                        ->get();

            return response()->json(['advertisementCategories' => $advertisementCategories, 'status' => 1, 'message' => 'Success'],200);
        }else{
             // If the token is not validated, send a message
             return response()->json(['message' => 'Not validated','status' => 0], 200);
        }
    }
}
