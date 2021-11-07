<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Api\V1\OrderController;
use Modules\Order\Http\Controllers\Api\V1\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// middleware('auth:api')->

Route::prefix('/v1/cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::post('/update', [CartController::class, 'updateCart'])->name('update');
    Route::post('/delete', [CartController::class, 'delete'])->name('delete');
    Route::post('/flush', [CartController::class, 'flush'])->name('flush');
});

Route::prefix('/v1/order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/show/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/create', [OrderController::class, 'create'])->name('create');
});
