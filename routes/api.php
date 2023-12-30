<?php

use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\Api\RestaurantControllerApi;
use App\Http\Controllers\Api\UserController;
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
Route::post('/register', [UserController::class, 'register']);
/**Route for register API */
Route::post('/login', [UserController::class, 'login']);


Route::middleware(['apikey', 'auth:api'])->group(function () {

    /**Route for View Profile */
    Route::post('/profile', [UserController::class, "profile"]);

    /**Route for list Foods */
    Route::get('getFood', [FoodOrderController::class, 'getAllFood']);
    Route::get('listFood/{id}', [RestaurantControllerApi::class, 'getListFood']);
    

    /**Route for orders foods */
    Route::resource('restaurants.orders', FoodOrderController::class);
    /**Route for refresh-token */
    Route::get('/refresh-token', [UserController::class, 'refreshToken']);
    /**Route for logout API */
    Route::post('/logout', [UserController::class, 'logout']);
});
