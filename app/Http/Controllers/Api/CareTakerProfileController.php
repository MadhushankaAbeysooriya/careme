<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareTakerProfileController extends Controller
{
    public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'id_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'id_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'bank' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'user_id' => 'required|exists:users,id',
        'hospital_id' => 'required|array',
    ], [
        'personal_photo.required' => 'The personal photo field is required.',
        'personal_photo.image' => 'The personal photo must be an image.',
        'personal_photo.mimes' => 'The personal photo must be a file of type: jpeg, png, jpg, gif.',
        'personal_photo.max' => 'The personal photo may not be greater than 2048 kilobytes.',
        'id_front.required' => 'The ID front field is required.',
        'id_front.image' => 'The ID front must be an image.',
        // Add similar messages for other fields
        'user_id.required' => 'User is required.',
        'user_id.exists' => 'Invalid user ID.',
        'hospital_id.required' => 'Hospital ID is required.',
        'hospital_id.array' => 'Hospital ID must be an array.',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Handle image uploads and save paths in the database
    $personalPhotoPath = $request->file('personal_photo')->store('personal_photos');
    $idFrontPath = $request->file('id_front')->store('id_fronts');
    $idBackPath = $request->file('id_back')->store('id_backs');
    $bankPath = $request->file('bank')->store('banks');

    // Convert hospital_id array to JSON before storing
    $hospitalIdJson = json_encode($request->hospital_id);

    $avlcaretaker = AvlCareTaker::create([
        'personal_photo' => $personalPhotoPath,
        'id_front' => $idFrontPath,
        'id_back' => $idBackPath,
        'bank' => $bankPath,
        'user_id' => $request->user_id,
        'hospital_id' => $hospitalIdJson,
        // Add other fields as needed
    ]);

    return response()->json([
        'message' => 'Success'
    ], 200);
}

}
