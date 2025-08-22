<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\Api\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

Route::prefix('api/shop')->name('api.shop.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Api\HomeController will be generated automatically by the module generator 