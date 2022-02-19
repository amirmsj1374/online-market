<?php

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

    Route::post('/add', [ManagerController::class, 'addNewTemplate']);
    Route::post('/add/page/to/{template}', [ManagerController::class, 'addPage']);
    Route::post('/delete/page/{page}', [ManagerController::class, 'deletePage']);
    Route::post('/add/element/{template}', [ManagerController::class, 'addElements']);

    Route::get('/get/all/templates', [ManagerController::class, 'getAllTemplates']);
    Route::post('/select/{template}', [ManagerController::class, 'selectTemplate']);
    Route::get('/get/pages', [ManagerController::class, 'getPages']);
    Route::get('/get/elements/{template}', [ManagerController::class, 'getAllElements']);
    Route::get('/get/section/of/{page}', [ManagerController::class, 'getSectionOfPage']);

    Route::get('/get/all/inputs/{element}', [ManagerController::class, 'getIputs']);

    Route::get('/get/contents/of/{section}', [ManagerController::class, 'getContentsOfSection']);

    Route::post('/add/section/{element}', [ManagerController::class, 'addSection'])->name('add.section');

    Route::post('/add/multiple/sections/{element}', [ManagerController::class, 'addMultipleSections']);
});
