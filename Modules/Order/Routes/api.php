<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\Order\Cart\Cart;
use Modules\Order\Facades\ResponderFacade;
use Modules\Order\Http\Controllers\Api\V1\OrderController;
use Modules\Order\Http\Controllers\Api\V1\CartController;
use Modules\Product\Entities\Product;

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

Route::prefix('/v1/cart')->name('order.')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/delete', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/flush', [CartController::class, 'flush'])->name('cart.flush');
});

Route::prefix('/v1/order')->name('order.')->group(function () {
    Route::post('/create', [OrderController::class, 'create'])->name('cart.create');
});
