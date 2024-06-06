<?php

use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\Api\RestaurantControllerApi;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OrderNotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return auth()->user();
});

Route::middleware(['apikey', 'auth:api', 'jwt.auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/update', [UserController::class, 'updateProfile']);
    Route::get('/get-food', [RestaurantControllerApi::class, 'getAllFood']);
    Route::get('/listFood/{id}', [RestaurantControllerApi::class, 'getListFood']);
    Route::get('/restaurant', [RestaurantControllerApi::class, 'getRestaurant']);
    Route::get('/order-history', [FoodOrderController::class, 'getHistoryOrder']);
    Route::post('/order', [FoodOrderController::class, 'orderFood']);
    Route::post('/notify-customer/{orderId}/order-accepted', [OrderNotificationController::class, 'notifyCustomerOrderAccepted']);
    Route::put('/order/updateStatus/{orderId}/{status}', [FoodOrderController::class, 'updateOrderStatus']);
    Route::get('/refresh-token', [UserController::class, 'refreshToken']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/temporary-account', [UserController::class, 'temporaryAccount']);
Route::post('/login', [UserController::class, 'login']);
