<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Template\Http\Controllers\Api\V1\ManagerController;

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

Route::prefix('/v1/template')->group(function () {
    Route::get('/get/all/templates', [ManagerController::class, 'getAllTemplates']);
    Route::post('/select/{template}', [ManagerController::class, 'selectTemplate']);
    Route::get('/get/pages', [ManagerController::class, 'getPages']);
    Route::get('/get/elements/of/page/{page}', [ManagerController::class, 'getElements']);
});
