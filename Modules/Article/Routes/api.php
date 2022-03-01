<?php


use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\Api\V1\ArticleController;

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

Route::prefix('/v1/article')->name('article.')->group(function () {
    Route::get('/filter', [ArticleController::class, 'filter'])->name('filter');
    Route::post('/create', [ArticleController::class, 'create'])->name('create');
    Route::post('/show/{article}', [ArticleController::class, 'show'])->name('show');
    Route::post('/update/{article}', [ArticleController::class, 'update'])->name('update');
    Route::post('/delete/{article}', [ArticleController::class, 'destroy'])->name('delete');
});
