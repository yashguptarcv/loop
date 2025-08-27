<?php

use Illuminate\Support\Facades\Route;
use Modules\Customers\Http\Controllers\HomeController;
use Modules\Customers\Http\Controllers\CustomersController;
use Modules\Customers\Http\Controllers\Auth\AuthCustomerController;

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
        Route::resource('customers', CustomersController::class);
            Route::post('/customers/bulk-delete', [CustomersController::class, 'bulkDelete'])->name('customers.bulk-delete');
    });
});

Route::prefix('customer')->middleware('web')->name('customer.')->group(function () {
    Route::get('/login', [AuthCustomerController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthCustomerController::class, 'login'])->name('login');
    Route::post('/logout', [AuthCustomerController::class, 'logout'])->name('logout');    
});





// HomeController will be generated automatically by the module generator 

// HomeController will be generated automatically by the module generator 