<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\V1\ProductController;

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

Route::prefix('/v1/product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.all');
    Route::post('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::post('/delete/{product}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::post('/change/status/{product}', [ProductController::class, 'chnageStatus'])->name('product.chnage.status');
});
