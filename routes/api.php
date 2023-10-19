<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;

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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    //  Auth
    Route::post('login', [AuthController::class,'login']);
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

});
Route::group(['middleware' => 'api'], function ($router) {
    // Vendors
    Route::get('vendors', [VendorController::class,'list']);
    Route::post('vendor/create',[VendorController::class,'create']);
    Route::get('vendor/edit/{id}',[VendorController::class,'edit']);
    Route::post('vendor/update/{id}',[VendorController::class,'update']);
    Route::delete('vendor/delete/{id}',[VendorController::class,'delete']);

});
