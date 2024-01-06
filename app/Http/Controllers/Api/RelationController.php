<?php

namespace App\Http\Controllers\Api;

use App\Models\Relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RelationController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            try {
                $relations = Relation::select('id', 'name')->where('status',1)->get();

                return response()->json(['relations' => $relations, 'status' => 1],200);

            } catch (Exception $e) {

                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }else{
            return response()->json(['message' => 'Not validated', 'status' => 0], 200);
        }
    }
}
