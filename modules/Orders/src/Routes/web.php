<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\HomeController;
use Modules\Orders\Http\Controllers\OrderController;
use Modules\Orders\Http\Controllers\Transaction;

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
        Route::post('orders/bulk-delete', [OrderController::class, 'index'])->name('orders.bulk-delete');
        Route::post('orders/toggle-status', [OrderController::class, 'index'])->name('orders.toggle-status');

        Route::resource('transactions', Transaction::class);
        Route::post('transactions/bulk-delete', [Transaction::class, 'index'])->name('transactions.bulk-delete');
        Route::post('transactions/toggle-status', [Transaction::class, 'index'])->name('transactions.toggle-status');
        Route::post('transactions/mark-complete', [Transaction::class, 'index'])->name('transactions.mark-complete');
    });
});
// HomeController will be generated automatically by the module generator 