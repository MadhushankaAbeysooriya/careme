<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\ComplainController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\RelationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\AvlCareTakerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\PatientRequestController;
use App\Http\Controllers\Api\CareTakerProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Generate Token and send to mobile app
Route::post('/generate-token', [AuthController::class, 'generateToken']);

// Generate OTP and send to mobile app
Route::post('/generate-otp', [AuthController::class, 'generateOTP']);

// Verify OTP and generate JWT token
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);

Route::post('/login',[LoginController::class,'login']);

Route::middleware('auth:sanctum')->post('/logout',[LoginController::class,'logout']);

Route::middleware('auth:sanctum')->get('/check-validated', [LoginController::class, 'checkValidated']);

Route::post('/check-user', [LoginController::class, 'checkUser']);

Route::post('/token', function (Request $request) {
    $request->validate([
        'device_id' => 'required',
    ]);

    $user = User::where('deviceId', $request->device_id)->where('login_status',1)->first();

    if (!$user) {
        return response()->json(['message' => 'Device not found in login status',
                                'status'=> '0'], 200);
    }

    $token = $user->createToken($user->phone)->plainTextToken;

    return response()->json([
                            'user_id' => $user->id,
                            'user_type' => $user->user_type,
                            'first_name' => $user->fname,
                            'last_name' => $user->lname,
                            'gender' => $user->gender,
                            'validation' => $user->validated,
                            'api_token' => $token,
                            'login_status' => $user->login_status,
                            ]);
});

Route::post('/register',[RegisterController::class,'register']);

Route::middleware('auth:sanctum')->put('/update-user-profile',[RegisterController::class,'update']);

Route::middleware('auth:sanctum')->get('/advertisements', [AdvertisementController::class, 'index']);

Route::middleware('auth:sanctum')->get('/shifts', [ShiftController::class, 'index']);

Route::middleware('auth:sanctum')->get('/hospitals', [HospitalController::class, 'index']);

Route::middleware('auth:sanctum')->get('/hospitals-by-user', [HospitalController::class, 'getHospitalbyUser']);

Route::middleware('auth:sanctum')->post('/store-avlcaretaker', [AvlCareTakerController::class, 'store']);

Route::middleware('auth:sanctum')->post('/store-avlcaretaker-auto', [AvlCareTakerController::class, 'storeAvlAuto']);

Route::middleware('auth:sanctum')->post('/update-avlcaretaker-auto', [AvlCareTakerController::class, 'updateAvlAuto']);

Route::middleware('auth:sanctum')->get('/search-avlcaretaker', [AvlCareTakerController::class, 'search']);

Route::middleware('auth:sanctum')->get('/search-avlcaretaker-auto', [AvlCareTakerController::class, 'searchAvlAuto']);

Route::middleware('auth:sanctum')->post('/store-caretaker-profile', [CareTakerProfileController::class, 'store']);

Route::middleware('auth:sanctum')->post('/store-caretaker-profile-without-hospital', [CareTakerProfileController::class, 'storewithouthospital']);

Route::middleware('auth:sanctum')->post('/store-caretaker-profile-hospital', [CareTakerProfileController::class, 'storehospital']);

Route::middleware('auth:sanctum')->put('/update-caretaker-profile-hospital', [CareTakerProfileController::class, 'updateHospital']);

Route::middleware('auth:sanctum')->get('/get-user-info', [CareTakerProfileController::class, 'getUserInfo']);

Route::middleware('auth:sanctum')->post('/store-complain', [ComplainController::class, 'store']);

Route::middleware('auth:sanctum')->get('/get-all-complains', [ComplainController::class, 'index']);

Route::middleware('auth:sanctum')->get('/get-complains-by-user', [ComplainController::class, 'getByUser']);

Route::middleware('auth:sanctum')->post('/store-one-request', [PatientRequestController::class, 'storeOne']);

Route::middleware('auth:sanctum')->post('/store-many-request', [PatientRequestController::class, 'storeMany']);

Route::middleware('auth:sanctum')->get('/view-patient-request-by-user', [PatientRequestController::class, 'viewPatientRequestbyUser']);

Route::middleware('auth:sanctum')->post('/approve-patient-request', [PatientRequestController::class, 'approvePatientRequest']);

Route::middleware('auth:sanctum')->post('/reject-patient-request', [PatientRequestController::class, 'rejectPatientRequest']);

Route::middleware('auth:sanctum')->get('/get-approved-patient-request', [PatientRequestController::class, 'getApprovedPatientRequest']);

Route::middleware('auth:sanctum')->get('/get-all-patient-request', [PatientRequestController::class, 'getAllPatientRequest']);

Route::middleware('auth:sanctum')->post('/payment-patient-request', [PatientRequestController::class, 'paymentPatientRequest']);

Route::middleware('auth:sanctum')->get('/get-paid-patient-request', [PatientRequestController::class, 'getPaymentPatientRequest']);

Route::middleware('auth:sanctum')->get('/get-care-taker-schedule', [PatientRequestController::class, 'getCareTakerSchedule']);

Route::middleware('auth:sanctum')->post('/make-rating', [PatientRequestController::class, 'makeRating']);

Route::middleware('auth:sanctum')->get('/get-payment-approve-patient-request', [PatientRequestController::class, 'getPaymentApprovePatientRequest']);

Route::middleware('auth:sanctum')->get('/get-deposit-patient-request', [PatientRequestController::class, 'getDepositPatientRequest']);

Route::middleware('auth:sanctum')->get('/get-patient-notification', [NotificationController::class, 'getPatientNotification']);

Route::middleware('auth:sanctum')->get('/get-caretaker-notification', [NotificationController::class, 'getCareTakerNotification']);

Route::middleware('auth:sanctum')->get('/about-us', [AboutUsController::class, 'index']);

Route::middleware('auth:sanctum')->get('/privacy-policy', [RegisterController::class, 'getprivacypolicy']);

Route::middleware('auth:sanctum')->get('/get-payment-method', [PaymentMethodController::class, 'index']);

Route::middleware('auth:sanctum')->get('/get-languages', [LanguageController::class, 'index']);

Route::middleware('auth:sanctum')->get('/get-language-by-user', [LanguageController::class, 'getLanguagebyUser']);

Route::middleware('auth:sanctum')->get('/get-relations', [RelationController::class, 'index']);

Route::middleware('auth:sanctum')->post('/store-user-language', [CareTakerProfileController::class, 'storeLanguage']);

Route::middleware('auth:sanctum')->put('/update-user-language', [CareTakerProfileController::class, 'updateLanguage']);





