<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\OwnerController;
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

Route::get('/registration',[AuthController::class, 'registration']);
Route::post('/registration',[AuthController::class,'registrationPost'])->name('registration.post');


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

    // All Restaurant Routes
    Route::get('admin/restaurant/showRestaurant', [RestaurantController::class, 'showRestaurant']);
    Route::get('admin/restaurant/create', [RestaurantController::class, 'create']);
    Route::post('admin/restaurant/store', [RestaurantController::class, 'store']);
    Route::get('admin/restaurant/edit/{id}', [RestaurantController::class, 'edit']);

    Route::get('admin/restaurant/delete/{id}', [RestaurantController::class, 'delete']);
});

Route::group(['middleware' => 'owner'], function () {
    Route::get('owner/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('owner/food/index', [OwnerController::class, 'index'])->name('MenuFood');
    Route::get('owner/food/create', [OwnerController::class, 'create'])->name('CreateFood');
    Route::post('owner/food/create', [OwnerController::class, 'store'])->name('StoreFood');
    Route::get('owner/food/edit/{id}', [OwnerController::class, 'edit'])->name('edit');
    Route::post('owner/food/edit/{id}', [OwnerController::class, 'update'])->name('UpdateFood');
    Route::get('owner/food/delete/{id}', [OwnerController::class, 'delete'])->name('DeleteFood');
    

    // Generate QR Code
    // Route::get('owner/generateQRCode', [OwnerController::class, 'qrCode']);
});

Route::group(['middleware' => 'user'], function () {
    Route::get('user/dashboard', [DashboardController::class, 'dashboard']);
});

});