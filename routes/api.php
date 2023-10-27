<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminJobController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\UserSubscriptionController;
use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('admin/login', [AdminController::class, 'login']);

//Subsciber Routes
Route::post('sendOtp', [UserSubscriptionController::class, 'sendOtp']);
Route::post('addSubscriber', [UserSubscriptionController::class, 'addSubscriber']);

//Seeker Routes
Route::post('/validateOtp', [SeekerController::class, 'validateOtp']);
Route::post('/registerSeeker', [SeekerController::class, 'registerSeeker']);
Route::post('/addSeekerDetails', [SeekerController::class, 'addSeekerDetails']);

Route::post('/seeker-login',[SeekerController::class,'loginSeeker']);

//Employer Routes
Route::post('/employer-register', [EmployerController::class, 'employe_register']);
Route::post('/verify-register-otp', [EmployerController::class, 'verifyRegisterOtp']);
Route::post('/employer-login',[EmployerController::class,'login']);
Route::post('/send-forgot-email-otp',[EmployerController::class,'sendForgotEmailOtp']);
Route::post('/check-forgot-otp',[EmployerController::class,'checkForgotOtp']);
Route::post('/update-forgot-password',[EmployerController::class,'updateForgotPassword']);




//Admin Routes
Route::post('admin/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
Route::post('admin/passwordChange/{id}', [AdminController::class, 'changePassword'])->middleware('auth:sanctum');
Route::get('admin/getAdmin', [AdminController::class, 'getAdmin'])->middleware('auth:sanctum');


Route::resource('admin-jobs', AdminJobController::class);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}/states', [CountryController::class, 'states']);

