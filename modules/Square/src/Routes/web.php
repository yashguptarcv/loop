<?php

use Illuminate\Support\Facades\Route;
use Modules\Square\Http\Controllers\HomeController;
use Modules\Square\Processors\SquareProcessor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('square')->middleware('web')->name('square.')->group(function () {    
    Route::post('/charge', [SquareProcessor::class, 'charge'])->name('charge');
});
// HomeController will be generated automatically by the module generator 