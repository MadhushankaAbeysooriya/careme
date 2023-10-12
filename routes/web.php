<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DSDivisionController;
use App\Http\Controllers\LoginDetailController;
use App\Http\Controllers\SearchDetailController;
use App\Http\Controllers\UserHospitalController;

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

    Route::get('/users/inactive/{id}',[UserController::class,'inactive'])->name('users.inactive');
    // Route::get('/users/suspendusers/',[UserController::class,'suspendusers'])->name('users.suspendusers');
    Route::get('/users/activate/{id}',[UserController::class,'activate'])->name('users.activate');
    Route::get('/users/resetpass/{id}',[UserController::class,'resetpass'])->name('users.resetpass');
    Route::resource('users', UserController::class);    

    Route::get('/province/inactive/{id}',[ProvinceController::class,'inactive'])->name('province.inactive');
    Route::get('/province/activate/{id}',[ProvinceController::class,'activate'])->name('province.activate');
    Route::resource('province', ProvinceController::class);    

    Route::get('/district/inactive/{id}',[DistrictController::class,'inactive'])->name('district.inactive');
    Route::get('/district/activate/{id}',[DistrictController::class,'activate'])->name('district.activate');
    Route::resource('district', DistrictController::class);

    Route::get('/dsdivision/inactive/{id}',[DSDivisionController::class,'inactive'])->name('dsdivision.inactive');
    Route::get('/dsdivision/activate/{id}',[DSDivisionController::class,'activate'])->name('dsdivision.activate');
    Route::resource('dsdivision', DSDivisionController::class);

    Route::get('/hospital/inactive/{id}',[HospitalController::class,'inactive'])->name('hospitals.inactive');
    Route::get('/hospital/activate/{id}',[HospitalController::class,'activate'])->name('hospitals.activate');
    Route::resource('hospitals', HospitalController::class);

    Route::post('/searchdetails',[HomeController::class,'searchdetail'])->name('searchdetail');

    Route::get('/logindetails',[LoginDetailController::class,'index'])->name('logindetails.index');

    Route::get('/searchdetails',[SearchDetailController::class,'index'])->name('searchdetails.index');
    
    Route::prefix('hospital/{hospital}')->group(function (){
        Route::resource('userhospitals',UserHospitalController::class);
    });
});

Route::get('/ajax/getDistricts',[AjaxController::class,'getDistricts'])->name('ajax.getDistricts');

Route::get('/ajax/getDSDivisions',[AjaxController::class,'getDSDivisions'])->name('ajax.getDSDivisions');


