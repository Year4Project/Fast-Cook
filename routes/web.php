<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\ChatController;
use App\Http\Controllers\Owner\FoodController;
use App\Http\Controllers\Owner\GeneratorQRController;
use App\Http\Controllers\Owner\OrderController;
use App\Http\Controllers\Owner\ProfileController;
use App\Http\Controllers\Owner\StaffController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class, 'login']);
Route::post('login',[AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);

// Route::get('/registration',[AuthController::class, 'registration']);
// Route::post('/registration',[AuthController::class,'registrationPost'])->name('registration.post');


Route::middleware('auth')->group(function(){

Route::group(['middleware' => 'admin'], function () {
    // All Admin Route
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/showAdmin', [AdminController::class, 'showAdmin']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
    Route::get('admin/admin/updateStatus/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');

    // All Restaurant Routes
    Route::get('admin/restaurant/showRestaurant', [RestaurantController::class, 'showRestaurant']);

    Route::get('admin/restaurant/create', [RestaurantController::class, 'create']);
    Route::post('admin/restaurant/store', [RestaurantController::class, 'createRestaurant']);
    Route::get('admin/restaurant/edit/{id}', [RestaurantController::class, 'edit']);
    Route::post('admin/restaurant/edit/{id}', [RestaurantController::class, 'updateRestaurant']);
    Route::get('admin/restaurant/delete/{id}', [RestaurantController::class, 'delete']);
});

Route::group(['middleware' => 'owner'], function () {
    Route::get('owner/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('owner/food/showFood', [FoodController::class, 'showFood'])->name('MenuFood');
    Route::get('owner/food/createFood', [FoodController::class, 'createFood']);
    Route::post('owner/food/store', [FoodController::class, 'storeFood']);
    Route::get('owner/food/edit/{id}', [FoodController::class, 'edit'])->name('edit');

    Route::get('owner/food/updateStatus/{id}', [FoodController::class, 'updateStatus'])->name('updateStatus');

    Route::post('owner/food/edit/{id}', [FoodController::class, 'update'])->name('UpdateFood');
    Route::get('owner/food/delete/{id}', [FoodController::class, 'destroy'])->name('DeleteFood');

    // Order Food
    Route::get('/owner/order/userorder', [OrderController::class, 'userOrder'])->name('userOrder');
    Route::get('/owner/order/listFoodUser/{id}', [OrderController::class, 'listFoodUser'])->name('foodUserOrder');
    Route::get('/owner/order/edit/{id}', [OrderController::class, 'edit'])->name('EditOrder');

    // Staff
    Route::get('/owner/staff/listStaff', [StaffController::class, 'listStaff']);
    Route::get('/owner/staff/createStaff', [StaffController::class, 'createStaff']);
    Route::post('/owner/staff/store', [StaffController::class, 'storeStaff']);
    Route::get('/owner/staff/edit/{id}', [StaffController::class, 'edit']);
    Route::post('/owner/staff/edit/{id}', [staffController::class, 'updateStaff']);
    Route::get('owner/staff/delete/{id}', [staffController::class, 'destroy']);

    // Generate QR Code
    Route::get('owner/qr/generateQRCode', [GeneratorQRController::class, 'qrCode'])->name('Generate QR Code');
    Route::get('owner/qr/create', [GeneratorQRController::class, 'create'])->name('Generate QR Code');
    Route::get('owner/qr/createQRCode', [GeneratorQRController::class, 'qrCode'])->name('Generate QR Code');
    Route::post('owner/qr/store', [GeneratorQRController::class, 'store'])->name('Generate QR Code');
    Route::get('owner/qr/download', [GeneratorQRController::class, 'download'])->name('qrcode.download');

    // Chats
    Route::get('owner/chat/chat', [ChatController::class, 'chat']);


    // Profile Settings
    Route::get('owner/profile/profile', [ProfileController::class, 'profile']);
});

// Route::group(['middleware' => 'user'], function () {
//     Route::get('user/dashboard', [DashboardController::class, 'dashboard']);
// });

});
