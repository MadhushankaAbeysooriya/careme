<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CareTakerProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CareTakerProfileController extends Controller
{
    // public function store(Request $request)
    // {
    //     // Validate the request data
    //     $validator = Validator::make($request->all(), [
    //         'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'id_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'id_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'bank' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'user_id' => 'required|exists:users,id',
    //         'hospital_id' => 'required|array',
    //         'description' => 'required'
    //     ], [
    //         'personal_photo.required' => 'The personal photo field is required.',
    //         'personal_photo.image' => 'The personal photo must be an image.',
    //         'personal_photo.mimes' => 'The personal photo must be a file of type: jpeg, png, jpg, gif.',
    //         'personal_photo.max' => 'The personal photo may not be greater than 2048 kilobytes.',
    //         'id_front.required' => 'The ID front field is required.',
    //         'id_front.image' => 'The ID front must be an image.',
    //         // Add similar messages for other fields
    //         'user_id.required' => 'User is required.',
    //         'user_id.exists' => 'Invalid user ID.',
    //         'hospital_id.required' => 'Hospital ID is required.',
    //         'hospital_id.array' => 'Hospital ID must be an array.',
    //         'description.required' => 'Description is required.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
    //     }

    //     // Handle image uploads and save paths in the database
    //     $personalPhotoPath = $request->file('personal_photo')->store('personal_photos');
    //     $idFrontPath = $request->file('id_front')->store('id_fronts');
    //     $idBackPath = $request->file('id_back')->store('id_backs');
    //     $bankPath = $request->file('bank')->store('banks');

    //     $user = User::findorfail($request->user_id);

    //     if($request->hospital_id){
    //         $hospitalIds = array_map('trim', explode(',', $request->hospital_id[0]));
    //         $user->hospitals()->sync($hospitalIds);
    //     }

    //     $caretakerprofile = CareTakerProfile::create([
    //         'personal_photo' => $personalPhotoPath,
    //         'id_front' => $idFrontPath,
    //         'id_back' => $idBackPath,
    //         'bank' => $bankPath,
    //         'user_id' => $request->user_id,
    //         // 'hospital_id' => $hospitalIdJson,
    //         // Add other fields as needed
    //     ]);

    //     return response()->json([
    //         'message' => 'Success',
    //         'status' => 1,
    //     ], 200);
    // }



public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'id_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'id_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'bank' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'user_id' => 'required|unique:care_taker_profiles,user_id',
        'hospital_id' => 'required|array',
        // 'description' => 'required'
        'agreementstatus' => 'required',
    ], [
        'personal_photo.required' => 'The personal photo field is required.',
        'personal_photo.image' => 'The personal photo must be an image.',
        'personal_photo.mimes' => 'The personal photo must be a file of type: jpeg, png, jpg, gif.',
        'personal_photo.max' => 'The personal photo may not be greater than 2048 kilobytes.',
        'id_front.required' => 'The ID front field is required.',
        'id_front.image' => 'The ID front must be an image.',
        // Add similar messages for other fields
        'user_id.required' => 'User is required.',
        'user_id.unique' => 'Only one profile can have',
        'hospital_id.required' => 'Hospital ID is required.',
        'hospital_id.array' => 'Hospital ID must be an array.',
        // 'description.required' => 'Description is required.',
        'agreementstatus.required' => 'Agreement Status is required.',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
    }

    // Handle image uploads and save paths in the database
    $user = User::findOrFail($request->user_id);

    // Create directories if they don't exist
    $personalPhotosDirectory = public_path('/upload/personalphotos/'.$request->user_id.'/');
    $idsDirectory = public_path('/upload/ids/'.$request->user_id.'/');
    $banksDirectory = public_path('/upload/banks/'.$request->user_id.'/');


    if (!File::isDirectory($personalPhotosDirectory)) {
        File::makeDirectory($personalPhotosDirectory, 0777, true, true);
    }

    if (!File::isDirectory($idsDirectory)) {
        File::makeDirectory($idsDirectory, 0777, true, true);
    }

    if (!File::isDirectory($banksDirectory)) {
        File::makeDirectory($banksDirectory, 0777, true, true);
    }

    // Generate a unique filename for the uploaded filepath
    $extPersonalPhotos = $request->file('personal_photo')->extension();
    $filePersonalPhotos = $request->user_id.'.'.$extPersonalPhotos;

    // Move the uploaded file to the destination
    $request->file('personal_photo')->move($personalPhotosDirectory, $filePersonalPhotos);



    // Generate a unique filename for the uploaded filepath
    $extIdFront = $request->file('id_front')->extension();
    $fileIdFront = $request->user_id.'_front.'.$extIdFront;

    // Move the uploaded file to the destination
    $request->file('id_front')->move($idsDirectory, $fileIdFront);


    // Generate a unique filename for the uploaded filepath
    $extIdBack = $request->file('id_back')->extension();
    $fileIdBack = $request->user_id.'_back.'.$extIdBack;

    // Move the uploaded file to the destination
    $request->file('id_back')->move($idsDirectory, $fileIdBack);


    // Generate a unique filename for the uploaded filepath
    $extBank = $request->file('bank')->extension();
    $fileBank = $request->user_id.'.'.$extBank;

    // Move the uploaded file to the destination
    $request->file('bank')->move($banksDirectory, $fileBank);


    // Sync hospitals
    if ($request->hospital_id) {
        $hospitalIds = array_map('trim', explode(',', $request->hospital_id[0]));
        $user->hospitals()->sync($hospitalIds);
    }

    // Create CareTakerProfile record
    $caretakerprofile = CareTakerProfile::create([
        'personal_photo' => '/upload/personalphotos/'.$request->user_id.'/'.$filePersonalPhotos,
        'id_front' => '/upload/ids/'.$request->user_id.'/'.$fileIdFront,
        'id_back' => '/upload/ids/'.$request->user_id.'/'.$fileIdBack,
        'bank' => '/upload/banks/'.$request->user_id.'/'.$fileBank,
        'user_id' => $request->user_id,
        'description' =>$request->description,
        'agreementstatus' => $request->agreementstatus,
    ]);

    return response()->json([
        'message' => 'Success',
        'status' => 1,
    ], 200);
}

    public function getUserInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'The user id field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $user = User::where('id', $request->input('user_id'))->first();

            // Check if the user exists
            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            // Check if the user has a CareTakerProfile
            if ($user->caretakerprofile) {
                $data = [
                    'id' => $user->id,
                    'lname' => $user->lname,
                    'fname' => $user->fname,
                    'validated' => $user->validated,
                    'gender' => $user->gender,
                    'dob' => $user->dob,
                    'phone' => $user->phone,
                    'personalphoto' => $user->caretakerprofile->personal_photo,
                    // 'agreementstatus' => $user->caretakerprofile->agreementstatus,
                ];
            } else {
                $data = [
                    'id' => $user->id,
                    'lname' => $user->lname,
                    'fname' => $user->fname,
                    'validated' => $user->validated,
                    'gender' => $user->gender,
                    'dob' => $user->dob,
                    'phone' => $user->phone,
                ];
            }

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function storewithouthospital(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|unique:care_taker_profiles,user_id',
            'description' => 'required',
            'agreementstatus' => 'required',
        ], [
            'personal_photo.required' => 'The personal photo field is required.',
            'personal_photo.image' => 'The personal photo must be an image.',
            'personal_photo.mimes' => 'The personal photo must be a file of type: jpeg, png, jpg, gif.',
            'personal_photo.max' => 'The personal photo may not be greater than 2048 kilobytes.',
            'id_front.required' => 'The ID front field is required.',
            'id_front.image' => 'The ID front must be an image.',
            // Add similar messages for other fields
            'user_id.required' => 'User is required.',
            'user_id.unique' => 'Only one profile can have',
            'description.required' => 'Description is required.',
            'agreementstatus.required' => 'Agreement Status is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        // Handle image uploads and save paths in the database
        $user = User::findOrFail($request->user_id);

        // Create directories if they don't exist
        $personalPhotosDirectory = public_path('/upload/personalphotos/'.$request->user_id.'/');
        $idsDirectory = public_path('/upload/ids/'.$request->user_id.'/');
        $banksDirectory = public_path('/upload/banks/'.$request->user_id.'/');


        if (!File::isDirectory($personalPhotosDirectory)) {
            File::makeDirectory($personalPhotosDirectory, 0777, true, true);
        }

        if (!File::isDirectory($idsDirectory)) {
            File::makeDirectory($idsDirectory, 0777, true, true);
        }

        if (!File::isDirectory($banksDirectory)) {
            File::makeDirectory($banksDirectory, 0777, true, true);
        }

        // Generate a unique filename for the uploaded filepath
        $extPersonalPhotos = $request->file('personal_photo')->extension();
        $filePersonalPhotos = $request->user_id.'.'.$extPersonalPhotos;

        // Move the uploaded file to the destination
        $request->file('personal_photo')->move($personalPhotosDirectory, $filePersonalPhotos);



        // Generate a unique filename for the uploaded filepath
        $extIdFront = $request->file('id_front')->extension();
        $fileIdFront = $request->user_id.'_front.'.$extIdFront;

        // Move the uploaded file to the destination
        $request->file('id_front')->move($idsDirectory, $fileIdFront);


        // Generate a unique filename for the uploaded filepath
        $extIdBack = $request->file('id_back')->extension();
        $fileIdBack = $request->user_id.'_back.'.$extIdBack;

        // Move the uploaded file to the destination
        $request->file('id_back')->move($idsDirectory, $fileIdBack);


        // Generate a unique filename for the uploaded filepath
        $extBank = $request->file('bank')->extension();
        $fileBank = $request->user_id.'.'.$extBank;

        // Move the uploaded file to the destination
        $request->file('bank')->move($banksDirectory, $fileBank);



        // Create CareTakerProfile record
        CareTakerProfile::create([
            'personal_photo' => '/upload/personalphotos/'.$request->user_id.'/'.$filePersonalPhotos,
            'id_front' => '/upload/ids/'.$request->user_id.'/'.$fileIdFront,
            'id_back' => '/upload/ids/'.$request->user_id.'/'.$fileIdBack,
            'bank' => '/upload/banks/'.$request->user_id.'/'.$fileBank,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'agreementstatus' => $request->agreementstatus,
        ]);

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function storehospital(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'hospital_id' => 'required|array',
            'hospital_id.*' => 'exists:hospitals,id', // Validate each hospital ID exists in the 'hospitals' table
        ], [
            'user_id.required' => 'User is required.',
            'user_id.unique' => 'Only one profile can have',
            'hospital_id.required' => 'Hospital IDs are required.',
            'hospital_id.array' => 'Hospital IDs must be an array.',
            'hospital_id.*.exists' => 'Invalid hospital ID provided.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        // Handle image uploads and save paths in the database
        $user = User::findOrFail($request->user_id);

        // Sync hospitals
        // if ($request->hospital_id) {
        //     $hospitalIds = $request->hospital_id;
        //     $user->hospitals()->sync($hospitalIds);
        // }

        // Sync hospitals
        // if ($request->hospital_id) {
        //     $hospitalIds = array_map('trim', explode(',', $request->hospital_id[0]));
        //     $user->hospitals()->sync($hospitalIds);
        // }

        if ($request->hospital_id) {
            $hospitalIds = array_map('trim', explode(',', $request->hospital_id[0]));
            $user->hospitals()->sync($hospitalIds);
        } else {
            // If no hospital IDs are provided, you may choose to detach all hospitals
            $user->hospitals()->detach();
        }

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

    public function updateHospital(Request $request,)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'hospital_id' => 'required|array',
            'hospital_id.*' => 'exists:hospitals,id',
        ], [
            'user_id.required' => 'User is required.',
            'hospital_id.required' => 'Hospital IDs are required.',
            'hospital_id.array' => 'Hospital IDs must be an array.',
            'hospital_id.*.exists' => 'Invalid hospital ID provided.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        // Handle image uploads and save paths in the database
        $user = User::findOrFail($request->user_id);

        // Sync hospitals
        if ($request->hospital_id) {
            $hospitalIds = array_map('trim', explode(',', $request->hospital_id[0]));
            $user->hospitals()->sync($hospitalIds);
        } else {
            // If no hospital IDs are provided, you may choose to detach all hospitals
            $user->hospitals()->detach();
        }

        return response()->json([
            'message' => 'Success',
            'status' => 1,
        ], 200);
    }

}
