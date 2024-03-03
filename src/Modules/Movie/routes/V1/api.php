<?php

use Illuminate\Support\Facades\Route;
use Modules\Movie\App\Http\Controllers\V1\Front\Panel\MovieController;
use OpenApi\Annotations as OA;

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



Route::prefix('panel/movies')->name('front.panel.movies.')->middleware('auth:api')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('index');
    Route::post('/', [MovieController::class, 'store'])->name('store');
    Route::post('/{movie}', [MovieController::class, 'update'])->name('update');
});
