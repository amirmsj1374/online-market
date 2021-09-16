<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\AuthController;

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

Route::name('auth.')->prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth:api')->name('auth.')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
