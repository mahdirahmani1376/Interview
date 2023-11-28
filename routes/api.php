<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;
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
Route::middleware('auth')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register')->name('auth.register');
        Route::post('/login', 'login')->name('auth.login');
        Route::post('/logout', 'logout')->name('auth.logout');
        Route::post('/refresh', 'refresh')->name('auth.refresh');
        Route::post('/me', 'me')->name('auth.me');
    });

    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/','index')->name('products.index');
        Route::post('/','store')->name('products.store');
        Route::get('/{product}','show')->name('products.show');
        Route::put('/{product}','update')->name('products.update');
        Route::delete('/{product}','destroy')->name('products.destroy');
    });

    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('/','index')->name('orders.index');
        Route::get('/{order}','show')->name('orders.show');
        Route::delete('/{order}','destroy')->name('orders.destroy');
    });

    Route::prefix('/order-products')->controller(OrderProductController::class)->group(function () {
        Route::get('/','index')->name('order-products.index');
        Route::post('/','store')->name('order-products.store');
        Route::get('/{orderProduct}','show')->name('order-products.show');
        Route::put('/{orderProduct}','update')->name('order-products.update');
        Route::delete('/{orderProduct}','destroy')->name('order-products.destroy');
    });
});

