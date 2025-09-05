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

Route::prefix('checkout')->middleware('web')->name('checkout.')->group(function () {
    Route::middleware(['user.auth', 'user.permission'])->group(function () {
        Route::get('confirm', [CheckoutController::class, 'confirm'])->name('confirm');
        // nomination
        Route::get('/nomination', [CheckoutController::class, 'application'])->name('nomination');
        Route::post('/nomination', [CheckoutController::class, 'createApplication'])->name('nomination');
        Route::put('/nomination', [CheckoutController::class, 'updateApplication'])->name('nomination');
        
    });
});
