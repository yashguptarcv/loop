<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\HomeController;
use Modules\Invoice\Http\Controllers\InvoiceController;

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

Route::prefix(config('core::prefix.admin'))->middleware('web')->name('admin.')->group(function () {
    Route::middleware(['admin.auth', 'admin.permission'])->group(function () {
        Route::resource('invoice', InvoiceController::class);
    });        
}); 


// HomeController will be generated automatically by the module generator 