<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\HomeController;

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

Route::prefix('cart')->middleware('web')->name('cart.')->group(function () {    

});

// HomeController will be generated automatically by the module generator 