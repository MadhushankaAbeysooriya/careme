<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\District;
use App\Models\DSDivision;
use Illuminate\Http\Request;
use App\Models\RegimentDepartment;

class AjaxController extends Controller
{
    public function getRoles(Request $request){
        $tags=[];
        if ($search=$request->name){
            $tags=Roles::where('name','LIKE',"%$search%")->get();
        }
        return response()->json($tags);
    }

    public function getRanks(Request $request){
        if($request->ajax()){
            return Rank::select('*')->where('force_id','=',$request->force_id)->get();
        }else{
             return Rank::where('status',1)->get();
        }
    }

    public function getRegementDepartment(Request $request){
        if($request->ajax()){
            return RegimentDepartment::select('*')->where('force_id','=',$request->force_id)->get();
        }else{
             return RegimentDepartment::where('status',1)->get();
        }
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
}
