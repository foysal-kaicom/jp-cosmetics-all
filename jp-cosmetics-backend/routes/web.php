<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\CouponController;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/do-login', [LoginController::class, 'doLogin'])->name('doLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [DashboardController::class, 'showDashboard'])->name('user.dashboard')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {


    Route::get('/profile', [DashboardController::class, 'showProfile'])->name('profile.show');



    Route::group(['prefix' => 'roles', 'as' => 'user.roles.','module'=>'Role', 'middleware' => 'auth'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('list');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('toggleStatus');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.', 'module' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::get('/view/{id}', [UserController::class, 'show'])->name('edit');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update'); // Using POST instead of PUT/PATCH
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.', 'module' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'list'])->name('list');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggleStatus');

    });

    Route::group(['prefix' => 'brand', 'as' => 'brand.', 'module' => 'brand'], function () {
        Route::get('/', [BrandController::class, 'list'])->name('list');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [BrandController::class, 'toggleStatus'])->name('toggleStatus');
        Route::delete('{id}/destroy', [BrandController::class, 'destroy'])->name('destroy');

    });

    Route::group(['prefix' => 'product', 'as' => 'product.', 'module' => 'product'], function () {
        Route::get('/', [ProductController::class, 'list'])->name('list');
        Route::get('/{id}/view', [ProductController::class, 'view'])->name('view');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/product-requests', [ProductController::class, 'productRequestindex'])->name('product-requests.index');
        // Route::delete('{id}/destroy', [BrandController::class, 'destroy'])->name('destroy');

    });

    Route::group(['prefix' => 'customer', 'as' => 'customer.', 'module' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'list'])->name('list');
        Route::get('/{id}/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [CustomerController::class, 'destroy'])->name('destroy');

    });

    Route::group(['prefix' => 'order', 'as' => 'order.', 'module' => 'order'], function () {
        Route::get('/', [OrderController::class, 'list'])->name('list');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [OrderController::class, 'update'])->name('update');
        // Route::delete('{id}/destroy', [CustomerController::class, 'destroy'])->name('destroy');

    });

    Route::group(['prefix' => 'wishlist', 'as' => 'wishlist.', 'module' => 'wishlist'], function () {
        Route::get('/', [WishlistController::class, 'list'])->name('list');
    });  
    
    // Business Settings
    Route::group(['prefix' => 'business-settings', 'as' => 'business-settings.', 'module' => 'business-settings'], function () {
        Route::get('/edit', [BusinessSettingController::class, 'edit'])->name('edit');
        Route::post('/update', [BusinessSettingController::class, 'update'])->name('update');
    });

    // Header Sliders
    Route::group(['prefix' => 'header-sliders', 'as' => 'header-sliders.','module' => 'header-sliders'], function () {
        Route::get('/', [SliderController::class, 'headerIndex'])->name('index');
        Route::get('/create', [SliderController::class, 'headerCreate'])->name('create');
        Route::post('/store', [SliderController::class, 'headerStore'])->name('store');
        Route::get('/{headerSlider}/edit', [SliderController::class, 'headerEdit'])->name('edit');
        Route::put('/{headerSlider}/update', [SliderController::class, 'headerUpdate'])->name('update');
        Route::post('{id}/toggle-status', [SliderController::class, 'headerToggleStatus'])->name('headerToggleStatus');
        Route::delete('/{headerSlider}/delete', [SliderController::class, 'headerDestroy'])->name('destroy');
    });

    // Footer Sliders
    Route::group(['prefix' => 'footer-sliders', 'as' => 'footer-sliders.','module' => 'footer-sliders'], function () {
        Route::get('/', [SliderController::class, 'footerIndex'])->name('index');
        Route::get('/create', [SliderController::class, 'footerCreate'])->name('create');
        Route::post('/store', [SliderController::class, 'footerStore'])->name('store');
        Route::get('/{footerSlider}/edit', [SliderController::class, 'footerEdit'])->name('edit');
        Route::put('/{footerSlider}/update', [SliderController::class, 'footerUpdate'])->name('update');
        Route::post('{id}/toggle-status', [SliderController::class, 'footerToggleStatus'])->name('footerToggleStatus');
        Route::delete('/{footerSlider}/delete', [SliderController::class, 'footerDestroy'])->name('destroy');
    });

    Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
        Route::get('/', [CouponController::class, 'list'])->name('list');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/store', [CouponController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CouponController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [CouponController::class, 'toggleStatus'])->name('toggleStatus');
    });
    
});