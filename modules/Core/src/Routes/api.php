<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Api\LocationController;
use Modules\Core\Http\Controllers\Api\AutocompleteController;
use Modules\Core\Http\Controllers\Api\AutocompleteSingleController;

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

Route::prefix('api')->name('api')->group(function () {
    Route::get('/countries/{country}/states', [LocationController::class, 'states']);

    Route::prefix('autocomplete')->name('autocomplete.')->group(function () {
        Route::get('/search', [AutocompleteController::class, 'search']);
        Route::get('/list', [AutocompleteController::class, 'list']);
        Route::get('/autocomplete', [AutocompleteSingleController::class, 'index'])->name('autocomplete');
    });

});