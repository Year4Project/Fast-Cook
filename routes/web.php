<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerController;
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

Route::middleware('auth')->group(function(){




Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/showAdmin', [AdminController::class, 'showAdmin']);
    Route::get('admin/add', [AdminController::class, 'add']);
    Route::post('admin/add', [AdminController::class, 'insert']);
    Route::get('admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/delete/{id}', [AdminController::class, 'delete']);
});

Route::group(['middleware' => 'owner'], function () {
    Route::get('owner/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('owner/listMenu', [OwnerController::class, 'listMenu']);
    Route::get('owner/addFood', [OwnerController::class, 'addFood']);
    Route::post('owner/addFood', [OwnerController::class, 'insertFood']);
    Route::get('owner/edit/{id}', [OwnerController::class, 'edit']);
    Route::post('owner/edit/{id}', [OwnerController::class, 'update']);
    Route::get('owner/delete/{id}', [OwnerController::class, 'destroy']);

    // Generate QR Code
    Route::get('owner/generateQRCode', [OwnerController::class, 'qrCode']);
});

Route::group(['middleware' => 'user'], function () {
    Route::get('user/dashboard', [DashboardController::class, 'dashboard']);
});

});