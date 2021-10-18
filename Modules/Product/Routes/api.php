<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\V1\InventoryController;
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

    Route::get('/', [ProductController::class, 'index'])->name('all');
    Route::get('/filter', [ProductController::class, 'filterProducts'])->name('filter');
    Route::post('/create', [ProductController::class, 'create'])->name('create');

    Route::post('/show/{product}', [ProductController::class, 'show'])->name('show');
    Route::post('/update/{product}', [ProductController::class, 'update'])->name('update');

    Route::post('/delete/{product}', [ProductController::class, 'destroy'])->name('delete');
    Route::post('/change/status/{product}', [ProductController::class, 'changeStatus'])->name('change.status');

    Route::post('/media/delete/{product}', [ProductController::class, 'deleteMedia'])->name('media.delete');
});

Route::prefix('/v1/inventory')->group(function () {
    Route::get('/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
});
