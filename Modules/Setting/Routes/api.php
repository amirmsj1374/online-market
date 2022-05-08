<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SettingController;
use Modules\Setting\Http\Controllers\TransportController;

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
Route::prefix('/v1/transport')->group(function() {
    // Route::get('/login/postex', [TransportController::class, 'isTokenExpire']);
    Route::get('/get/list/of/states', [TransportController::class, 'getListOfStates']);
    Route::get('/get/list/of/towns/{id}', [TransportController::class, 'getListOfTowns']);
    Route::get('/get/list/of/services', [TransportController::class, 'getListOfServices']);
    Route::get('/get/list/of/carton', [TransportController::class, 'getListOfCarton']);
    Route::get('/get/list/of/insurances', [TransportController::class, 'getListOfInsurances']);
    Route::get('/get/price/info', [TransportController::class, 'getPriceInfo']);
});

Route::prefix('/v1/setting')->group(function() {
    Route::post('/save/Market/info', [SettingController::class, 'saveMarketInfo']);
    Route::get('/get/Market/info', [SettingController::class, 'getMarketInfo']);
});
