<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Communication\Http\Controllers\CommunicationController;

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

Route::prefix('/v1/communication')->name('communication.')->group(function () {

    Route::get('/product', [CommunicationController::class, 'product'])->name('product');

});
