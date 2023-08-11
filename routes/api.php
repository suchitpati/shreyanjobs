<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminJobController;
use App\Http\Controllers\CountryController;
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
Route::post('admin/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
Route::post('admin/passwordChange/{id}', [AdminController::class, 'changePassword'])->middleware('auth:sanctum');
Route::get('admin/getAdmin', [AdminController::class, 'getAdmin'])->middleware('auth:sanctum');


Route::resource('admin-jobs', AdminJobController::class)->except(['create', 'edit'])->middleware([]);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}/states', [CountryController::class, 'states']);
