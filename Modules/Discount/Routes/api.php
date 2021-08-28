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
    // Route::get('/index', [DiscountController::class, 'index'])->name('all');
    Route::get('/required', [DiscountController::class, 'Required'])->name('required');
    Route::get('/search'  , [DiscountController::class, 'Search'])->name('search');

    // Route::post('/create', [DiscountController::class, 'create'])->name('create');
    // Route::post('/edit', [DiscountController::class, 'edit'])->name('edit');
    // Route::post('/delete/{category}', [DiscountController::class, 'destroy'])->name('delete');
});