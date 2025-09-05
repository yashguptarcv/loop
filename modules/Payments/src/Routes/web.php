<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\HomeController;

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
        
        Route::resource('payments', HomeController::class);

        Route::get('payments/config/{code}', [HomeController::class, 'loadConfigForm'])->name('payments.config');
    });
});