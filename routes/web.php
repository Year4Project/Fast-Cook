<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\Api\FoodOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\CartController;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\ChatController;
use App\Http\Controllers\Owner\FoodController;
use App\Http\Controllers\Owner\GeneratorQRController;
use App\Http\Controllers\Owner\OrderController;
use App\Http\Controllers\Owner\POSController;
use App\Http\Controllers\Owner\ProfileController;
use App\Http\Controllers\Owner\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\InvoiceController;


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

Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);


Route::middleware('auth')->group(function () {

    Route::group(['middleware' => 'admin'], function () {
        // All Admin Route
        Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
        Route::get('admin/admin/showAdmin', [AdminController::class, 'showAdmin']);
        Route::get('admin/admin/add', [AdminController::class, 'add']);
        Route::post('admin/admin/add', [AdminController::class, 'insert']);
        Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
        Route::put('admin/admin/update/{id}', [AdminController::class, 'update'])->name(('admin.update'));
        Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
        Route::get('admin/admin/updateStatus/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');

        // All Restaurant Routes
        Route::get('admin/restaurant/showRestaurant', [RestaurantController::class, 'showRestaurant']);
        Route::get('admin/restaurant/create', [RestaurantController::class, 'create']);
        Route::post('admin/restaurant/store', [RestaurantController::class, 'createUserAndRestaurant']);
        Route::get('/admin/restaurant/edit/{id}', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::post('/admin/user/{userId}/update', [RestaurantController::class, 'updateUserAndRestaurant'])->name('admin.user.update');
        // Route::get('admin/restaurant/updateStatus/{id}', [RestaurantController::class, 'updateStatus'])->name('updateStatus');
        Route::get('admin/restaurant/updateStatus/{id}', [RestaurantController::class, 'updateStatus'])->name('restaurant.updateStatus');
        // Route::delete('/admin/user/{userId}/delete', [RestaurantController::class, 'deleteUserAndRestaurant'])->name('admin.user.delete');
        // Route::delete('/admin/user/{userId}/delete', [RestaurantController::class, 'deleteUserAndRestaurant'])->name('users.delete');
        Route::get('/admin/userAndRestaurant/{userId}', [RestaurantController::class, 'deleteUserAndRestaurant'])->name('user-restaurant.delete');
    });


    // All Route Group Owner Manage Food, Staff, QR Code, Chat, Profile
    Route::group(['middleware' => ['owner',]], function () {

        //Dashboard
        Route::get('owner/dashboard', [DashboardController::class, 'dashboard']);

        // POS System
        Route::get('owner/cart/index', [CartController::class, 'index'])->name('POS-System');
        Route::post('owner/cart/add-item', [CartController::class, 'addItemToCart'])->name('cart.add');
        Route::post('owner/cart/update-qty', [CartController::class, 'updateCartItemQuantity'])->name('cart.update');
        Route::get('owner/cart/delete-item/{id}', [CartController::class, 'deleteItem'])->name('cart.delete');
        Route::get('cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
        Route::get('owner/cart/customerOrder', [CartController::class, 'customerOrder'])->name('POS-CustomerOrder');



        // Create foods
        Route::get('owner/food/showFood/', [FoodController::class, 'showFood'])->name('MenuFood');
        Route::get('owner/food/createFood', [FoodController::class, 'createFood']);
        Route::post('owner/food/store', [FoodController::class, 'storeFood']);
        Route::get('owner/food/edit/{id}', [FoodController::class, 'edit'])->name('edit');
        Route::get('owner/food/updateStatus/{id}', [FoodController::class, 'updateStatus'])->name('update.Status');
        Route::post('owner/food/edit/{id}', [FoodController::class, 'update'])->name('UpdateFood');
        Route::get('owner/food/delete/{id}', [FoodController::class, 'destroy'])->name('DeleteFood');

        // Category
        Route::get('owner/category/typeFood/', [CategoryController::class, 'category'])->name('owner.category.typeFood');
        Route::get('owner/category/createCategory/', [CategoryController::class, 'createCategory'])->name('owner.category.createCategory');
        Route::post('owner/category/storeCategory/', [CategoryController::class, 'storeCategory'])->name('owner.category.storeCategory');
        Route::get('owner/category/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('owner.category.editCategory');
        Route::post('owner/category/editCategory/{id}', [CategoryController::class, 'updateCategory'])->name('owner.category.updateCategory');
        Route::get('owner/category/deleteCategory/{id}', [CategoryController::class, 'destroyCategory'])->name('owner.category.destroyCategory');
        Route::get('owner/category/updateStatus/{id}', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');

        // Order Food
        Route::get('/owner/order/userOrder', [OrderController::class, 'userOrder'])->name('owner.order.userOrder');
        Route::get('/owner/order/details/{orderId}', [OrderController::class, 'orderDetails'])->name('owner.order.details');
        // Route::get('/owner/order/edit/{id}', [OrderController::class, 'edit'])->name('EditOrder');
        Route::post('/owner/order/food', [OrderController::class, 'orderFood'])->name('owner.order.food');
        Route::post('owner/pos/order', [OrderController::class, 'order_submit'])->name('order.checkout');
        Route::get('owner/cart/customerOrder/{orderId}', [OrderController::class, 'customerOrderDetail'])->name('POS-CustomerOrder.detail');
        Route::get('owner/print-recipe/{orderId}', [OrderController::class, 'printRecipe'])->name('pos-printRecipe');
        // Get all orders
        Route::get('/owner/order/allOrder', [OrderController::class, 'allOrder'])->name('owner.order.allOrder');
        // Invoice
        Route::get('/generate-invoice/{orderId}', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');
        Route::get('owner/order/print-recipe/{orderId}', [OrderController::class, 'printRecipeAPI'])->name('api-printRecipe');

        // update order status form API request
        // routes/api.php or routes/web.php
        Route::put('/api/orders/{order}/status', [FoodOrderController::class, 'updateStatus']);
        // Route::get('admin/order/updateStatus/{orderId}/{status}', [FoodOrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');
        Route::post('admin/order/updateOrderStatus/{orderId}/{status}', [FoodOrderController::class, 'updateOrderStatus'])->name('order.updateStatus');

        // Route::put('/api/orders/{orderId}/status', [FoodOrderController::class, 'updateOrderStatus']);





        // Staff
        Route::get('/owner/staff/listStaff', [StaffController::class, 'listStaff']);
        Route::get('/owner/staff/createStaff', [StaffController::class, 'createStaff']);
        Route::post('/owner/staff/store', [StaffController::class, 'storeStaff']);
        Route::get('/owner/staff/edit/{id}', [StaffController::class, 'edit']);
        Route::post('/owner/staff/edit/{id}', [staffController::class, 'updateStaff']);
        Route::get('owner/staff/delete/{id}', [staffController::class, 'destroy']);

        // Generate QR Code
        Route::get('owner/qr/generateQRCode', [GeneratorQRController::class, 'qrCode'])->name('generateQRCode');
        Route::get('owner/qr/create', [GeneratorQRController::class, 'create']);
        Route::post('owner/qr/store', [GeneratorQRController::class, 'store']);

        Route::get('owner/qr/download-qrcode/{scen}', [GeneratorQRController::class, 'downloadQrCode'])->name('owner.qr.download');
        Route::get('owner/qr/delete-qrcode/{scen}', [GeneratorQRController::class, 'deleteQrCode'])->name('owner.qr.delete');

        // Chats
        Route::get('owner/chat/chat', [ChatController::class, 'chat']);


        // Profile Settings
        Route::get('/owner/profile/edit', [ProfileController::class, 'edit'])->name('owner.profile.edit');
        Route::put('/owner/profile/update', [ProfileController::class, 'update'])->name('owner.profile.update');
        Route::get('/owner/profile/profile', [ProfileController::class, 'profile'])->name('owner.profile');
        Route::put('/owner/profile/update-image', 'ProfileController@updateImage')->name('owner.profile.update.image');

        Route::get('/alerts', [AlertController::class, 'index']);
    });

    // Route::group(['middleware' => 'user'], function () {
    //     Route::get('user/dashboard', [DashboardController::class, 'dashboard']);
    // });

});
