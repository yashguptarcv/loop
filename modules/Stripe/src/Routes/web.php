<?php

use Illuminate\Support\Facades\Route;
use Modules\Stripe\Http\Controllers\HomeController;
use Modules\Stripe\Processors\StripeProcessor;

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

Route::prefix('stripe')->middleware('web')->name('stripe.')->group(function () {    
    Route::post('/payment-intent', [StripeProcessor::class, 'createPaymentIntent']);
    Route::post('/refund', [StripeProcessor::class, 'refund']);
    Route::post('/webhook', [StripeProcessor::class, 'handleWebhook']); // must be public
});

// HomeController will be generated automatically by the module generator 