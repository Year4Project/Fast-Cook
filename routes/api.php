<?php

use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\Api\RestaurantControllerApi;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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

Route::middleware('jwt.auth')->get('user', function(Request $request) {
    return auth()->user();
});




Route::middleware(['apikey', 'auth:api','jwt.auth'])->group(function () {
    /**Route for View Profile */
    Route::get('/profile', [UserController::class, "profile"]);
    Route::put('/profile/update', [UserController::class, "updateProfile"]);

    /**Route for list Foods */
    Route::get('/get-food', [RestaurantControllerApi::class, 'getAllFood']);
    Route::get('/listFood/{id}', [RestaurantControllerApi::class, 'getListFood']);

    Route::get('/restaurant', [RestaurantControllerApi::class, 'getRestaurant']);

    /**Route for orders foods */
    Route::post('/order', [FoodOrderController::class, 'orderFood']);

    /**Route for refresh-token */
    Route::get('/refresh-token', [UserController::class, 'refreshToken']);

    /**Route for logout API */
    Route::post('/logout', [UserController::class, 'logout']);
});

/**Route for login and register API */
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
