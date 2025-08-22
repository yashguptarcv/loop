<?php

use Illuminate\Support\Facades\Route;
use Modules\Checkout\Http\Controllers\HomeController;
use Modules\Checkout\Http\Controllers\CheckoutController;

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

// routes/web.php
// Route::middleware(['auth'])->group(function () {
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
        Route::post('/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
        Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    });
// });

// HomeController will be generated automatically by the module generator 