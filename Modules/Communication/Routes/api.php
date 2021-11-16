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
    Route::get('/comment', [CommunicationController::class, 'comment'])->name('comment');
    Route::post('/store/{product}', [CommunicationController::class, 'store'])->name('store');
    Route::post('/delete/comment/{communication}', [CommunicationController::class, 'delete'])->name('delete');
    Route::post('/change/status/comment/{communication}', [CommunicationController::class, 'changeCommentMode'])->name('change.status');

});
