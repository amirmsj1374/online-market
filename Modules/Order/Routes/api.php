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
Route::prefix('/v1/order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('all');
    Route::post('/create', [CartController::class, 'create'])->name('create');
});
