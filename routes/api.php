<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\RestaurantControllerApi;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api'])->group(function () {
    // Your API routes here

});
Route::group(['middleware'=>'api'],function($routes){

    Route::post('/register',[UserController::class,'register']);
    Route::post('/login',[UserController::class,'login']);
    // Route::post('/profile',[UserController::class,'profile']);
    // Route::post('/refresh',[UserController::class,'refresh']);
    // Route::post('/logout',[UserController::class,'logout']);

});

Route::group(["middleware" => ["auth:api"]], function(){

    Route::get("profile", [UserController::class, "profile"]);
    Route::get("refresh", [UserController::class, "refreshToken"]);
    Route::get("logout", [UserController::class, "logout"]);
});

//     Route::post('/auth/register', [UserController::class, 'createUser']);
//     Route::post('/auth/login', [UserController::class, 'loginUser']);


//  Route::get('listFood/{id}',[RestaurantControllerApi::class,'getListFood']);
//     Route::post('orderConfirm/{id}',[RestaurantControllerApi::class,'orderConfirm']);
//     Route::get('showOrder/{id}',[RestaurantControllerApi::class,'showOrder']);

    // Route::post('foodOrder',[OrderController::class,'foodOrder']);
