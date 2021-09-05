<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\V1\CategoryController;

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

Route::prefix('/v1/category')->name('category.')->group(function () {
    Route::get('/index', [CategoryController::class, 'index'])->name('all');
    Route::post('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/delete/{category}', [CategoryController::class, 'destroy'])->name('delete');
});
