<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Template\Http\Controllers\Api\V1\TemplateController;

Route::get('/', [TemplateController::class, 'index']);
Route::prefix('template')->group(function () {
    Route::get('/get/all/templates', [TemplateController::class, 'getAllTemplates']);
    Route::get('/get/pages', [TemplateController::class, 'getPages']);
    Route::get('/get/elements', [TemplateController::class, 'getElements']);
});
