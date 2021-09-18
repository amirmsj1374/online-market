<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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

Route::prefix('/v1/user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('all');
    Route::post('/create', [UserController::class, 'create'])->name('create');
    Route::post('/show/{user}', [UserController::class, 'show'])->name('show');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::post('/delete/{user}', [UserController::class, 'destroy'])->name('delete');
});
