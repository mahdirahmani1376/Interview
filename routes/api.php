<?php

use App\Http\Controllers\AuthController;
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
        Route::put('/{products}','update')->name('products.update');
        Route::get('/{products}','destroy')->name('products.destroy');
    });
});

