<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\District;
use App\Models\DSDivision;
use Illuminate\Http\Request;
use App\Models\RegimentDepartment;
use App\Models\AdvertisementCategory;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function getRoles(Request $request){
        $tags=[];
        if ($search=$request->name){
            $tags=Roles::where('name','LIKE',"%$search%")->get();
        }
        return response()->json($tags);
    }

    public function getDistricts(request $request){
        if($request->ajax()){
            return District::select('*')->where('province_id','=',$request->province_id)->get();
        }else{
             return District::where('status','1')->get();
        }
    }

    public function getDSDivisions(request $request){
        if($request->ajax()){
            return DSDivision::select('*')->where('district_id','=',$request->district_id)->get();
        }else{
             return DSDivision::where('status','1')->get();
        }
    }

    public function getAdvertisementTotal(Request $request) {
        if($request->ajax()) {
            // Retrieve the AdvertisementCategory based on the advertisement_category_id
            $advertisementCategory = AdvertisementCategory::findOrFail($request->advertisement_category_id);

            // Get the from and to dates from the request
            $from = Carbon::createFromFormat('Y-m-d', $request->from);
            $to = Carbon::createFromFormat('Y-m-d', $request->to);

            // Calculate the difference in days
            $numberOfDays = $to->diffInDays($from);

            // Calculate the total based on the amount and number of days
            $total = $advertisementCategory->amount * $numberOfDays;

            // Return the total as JSON response
            return response()->json(['total' => $total, 'amount' => $advertisementCategory->amount]);
        }
    }
}
