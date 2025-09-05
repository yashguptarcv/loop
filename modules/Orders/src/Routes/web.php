<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\Transaction;
use Modules\Orders\Http\Controllers\HomeController;
use Modules\Orders\Http\Controllers\OrderController;
use Modules\Orders\Http\Controllers\Orders\Productlists;
use Modules\Orders\Http\Controllers\Statuses\OrdersStatusController;

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
        
        Route::resource('orders', OrderController::class);
        Route::post('orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('orders.bulk-delete');
        Route::post('orders/toggle-status', [OrderController::class, 'updateStatus'])->name('orders.toggle-status');

        // order edit
        Route::resource('transactions', Transaction::class);
        Route::post('transactions/bulk-delete', [Transaction::class, 'bulkDelete'])->name('transactions.bulk-delete');
        Route::post('transactions/mark-complete', [Transaction::class, 'updateStatus'])->name('transactions.mark-complete');


        Route::resource('orders-statuses', OrdersStatusController::class);
    });
});
// HomeController will be generated automatically by the module generator 