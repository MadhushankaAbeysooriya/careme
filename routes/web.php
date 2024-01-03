<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DSDivisionController;
use App\Http\Controllers\GNDivisionController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\PatientRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', RoleController::class);

    Route::get('/users/patient',[UserController::class,'indexPatient'])->name('users.patient');
    Route::get('/users/caretaker',[UserController::class,'indexCareTaker'])->name('users.care_taker');
    Route::get('/users/notvalidated/{id}',[UserController::class,'notvalidated'])->name('users.notvalidated');
    Route::get('/users/validated/{id}',[UserController::class,'validated'])->name('users.validated');
    Route::get('/users/inactive/{id}',[UserController::class,'inactive'])->name('users.inactive');
    Route::get('/users/activate/{id}',[UserController::class,'activate'])->name('users.activate');
    Route::get('/users/resetpass/{id}',[UserController::class,'resetpass'])->name('users.resetpass');
    Route::resource('users', UserController::class);

    Route::get('/province/inactive/{id}',[ProvinceController::class,'inactive'])->name('province.inactive');
    Route::get('/province/activate/{id}',[ProvinceController::class,'activate'])->name('province.activate');
    Route::resource('province', ProvinceController::class);

    Route::get('/district/inactive/{id}',[DistrictController::class,'inactive'])->name('district.inactive');
    Route::get('/district/activate/{id}',[DistrictController::class,'activate'])->name('district.activate');
    Route::resource('district', DistrictController::class);

    Route::get('/gndivision/inactive/{id}',[GNDivisionController::class,'inactive'])->name('gndivisions.inactive');
    Route::get('/gndivision/activate/{id}',[GNDivisionController::class,'activate'])->name('gndivisions.activate');
    Route::resource('gndivisions', GNDivisionController::class);

    Route::get('/dsdivision/inactive/{id}',[DSDivisionController::class,'inactive'])->name('dsdivisions.inactive');
    Route::get('/dsdivision/activate/{id}',[DSDivisionController::class,'activate'])->name('dsdivisions.activate');
    Route::resource('dsdivisions', DSDivisionController::class);

    Route::get('/hospital/inactive/{id}',[HospitalController::class,'inactive'])->name('hospitals.inactive');
    Route::get('/hospital/activate/{id}',[HospitalController::class,'activate'])->name('hospitals.activate');
    Route::resource('hospitals', HospitalController::class);

    Route::get('/advertisement/inactive/{id}',[AdvertisementController::class,'inactive'])->name('advertisements.inactive');
    Route::get('/advertisement/activate/{id}',[AdvertisementController::class,'activate'])->name('advertisements.activate');
    Route::get('/advertisement/delete/{id}',[AdvertisementController::class,'delete'])->name('advertisements.delete');
    Route::resource('advertisements', AdvertisementController::class);

    Route::get('/shifts/inactive/{id}',[ShiftController::class,'inactive'])->name('shifts.inactive');
    Route::get('/shifts/activate/{id}',[ShiftController::class,'activate'])->name('shifts.activate');
    Route::resource('shifts', ShiftController::class);

    // Route::prefix('hospital/{hospital}')->group(function (){
    //     Route::resource('userhospitals',UserHospitalController::class);
    // });

    Route::get('/patient-request/pending/approve',[PatientRequestController::class,'index'])->name('patient_requests.pendingapprove');

    Route::get('/patient-request/approve/view/{id}',[PatientRequestController::class,'approveView'])->name('patient_requests.approveView');

    Route::post('/patient-request/approve/{id}',[PatientRequestController::class,'approve'])->name('patient_requests.approve');

    Route::get('/patient-request/pending/deposit',[PatientRequestController::class,'pendingDeposit'])->name('patient_requests.pendingDeposit');

    Route::get('/patient-request/deposit/view/{id}',[PatientRequestController::class,'depositView'])->name('patient_requests.depositView');

    Route::post('/patient-request/deposit/{id}',[PatientRequestController::class,'deposit'])->name('patient_requests.deposit');

    Route::get('/patient-request/pending/service',[PatientRequestController::class,'pendingService'])->name('patient_requests.pending_service');
});

Route::get('/ajax/getDistricts',[AjaxController::class,'getDistricts'])->name('ajax.getDistricts');

Route::get('/ajax/getDSDivisions',[AjaxController::class,'getDSDivisions'])->name('ajax.getDSDivisions');


