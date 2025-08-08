<?php

use Illuminate\Support\Facades\Route;
use Modules\Customers\Http\Controllers\HomeController;
use Modules\Customers\Http\Controllers\CustomersController;

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
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomersController::class, 'index'])->name('index');        
            // Route::post('/users/toggle-status', [LeadsController::class, 'toggleStatus'])->name('users.toggle-status');
            // Route::post('/users/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('users.bulk-delete');
        });
    });
});


// HomeController will be generated automatically by the module generator 