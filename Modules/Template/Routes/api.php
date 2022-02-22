<?php

use Illuminate\Support\Facades\Route;
use Modules\Template\Http\Controllers\Api\V1\ManagerController;
use Modules\Template\Http\Controllers\Api\V1\MenuController;
use Modules\Template\Http\Controllers\Api\V1\SectionController;

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

    Route::post('/add/section/{element}', [SectionController::class, 'addSection'])->name('add.section');
    Route::post('/add/multiple/sections/{element}', [SectionController::class, 'addMultipleSections']);

    Route::get('/show/menu', [MenuController::class, 'showMenu']);
    Route::post('/add/menu', [MenuController::class, 'addMenu']);
    Route::post('/add/submenu', [MenuController::class, 'addSubmenu']);
    Route::post('/update/menu', [MenuController::class, 'updateMenu']);
    Route::post('/status/menu', [MenuController::class, 'chnageStatus']);
    Route::post('/delete/menu', [MenuController::class, 'deleteMenu']);
    Route::post('/add/header/section/{element}', [MenuController::class, 'addSection']);
});
