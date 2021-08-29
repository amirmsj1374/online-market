<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\Api\V1\DiscountController;

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

Route::prefix('/v1/discount')->name('discount')->group(function () {
    Route::get('/index', [DiscountController::class, 'index'])->name('index');
    Route::prefix('/required')->name('required')->group(function () {
        Route::get('/category', [DiscountController::class, 'categories'])->name('categories');
        Route::get('/product', [DiscountController::class, 'products'])->name('products');
        Route::get('/basket', [DiscountController::class, 'users'])->name('users');
    });

    Route::post('/create', [DiscountController::class, 'create'])->name('create');
    Route::post('/show/{discount}', [DiscountController::class, 'show'])->name('show');
    Route::post('/update/{discount}', [DiscountController::class, 'update'])->name('update');

    Route::post('/delete/{discount}', [DiscountController::class, 'destroy'])->name('delete');
});
