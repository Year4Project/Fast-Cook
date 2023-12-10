<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FoodOrderController;
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


    /**Route for login API */
    Route::post('/register',[UserController::class,'register']);
    /**Route for register API */
    Route::post('/login',[UserController::class,'login']);


Route::middleware(['apikey','jwt.auth'])->group(function () {

   
    Route::post('/profile', [UserController::class, "profile"]);
    Route::get('listFood/{id}',[RestaurantControllerApi::class,'getListFood']);

    Route::post('/orders', [OrderController::class, 'foodOrder']);

    // Route::post('orderConfirm/{id}',[RestaurantControllerApi::class,'orderConfirm']);

    /**Route for logout API */
    Route::post('/logout',[UserController::class,'logout']);
});

    
//     Route::get('showOrder/{id}',[RestaurantControllerApi::class,'showOrder']);

    // Route::post('foodOrder',[OrderController::class,'foodOrder']);