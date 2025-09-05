<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Api\HomeController;
use Modules\Cart\Http\Controllers\Api\Cart\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

Route::prefix('api/cart')->middleware(['web'])->name('api.cart.')->group(function () {
    Route::get('discount/{id}/view',[CartController::class, 'viewDiscountForm'])->name('discount.view');
    Route::put('discount/{id}/add',[CartController::class, 'addDiscount'])->name('discount.add');
    Route::put('discount/remove',[CartController::class, 'removeDiscount'])->name('discount.remove');
    
    Route::get('item/{order_id}/view',[CartController::class, 'viewItems'])->name('item.view');
    Route::post('item/{order_id}/add',[CartController::class, 'addItems'])->name('item.add');

    Route::post('item/quantity',[CartController::class, 'updateItemQuantity'])->name('item.quantity');
    Route::post('item/remove',[CartController::class, 'removeItem'])->name('item.remove');

    // customer
    Route::get('customer/{order_id}/form',[CartController::class, 'viewCustomerForm'])->name('customer.form');
    Route::post('customer/{order_id}/add',[CartController::class, 'addCustomerOrUpdate'])->name('customer.add');

    
    // profile
    Route::get('customer/{customer_id?}/profile',[CartController::class, 'profileUpdateForm'])->name('customer.profile');
    Route::post('customer/{customer_id}/profile',[CartController::class, 'updateCustomer'])->name('customer.profile');

    Route::post('customer/{customer_id}/billing_address',[CartController::class, 'updateAddress'])->name('customer.billing_address');

    Route::get('payment/payment_form',[CartController::class, 'paymentForm'])->name('payment.payment_form');
    Route::post('payment/payment_form',[CartController::class, 'updateCustomer'])->name('payment.payment_form');

    Route::post('order/{order_id?}/update_status',[CartController::class, 'update_status'])->name('order.update_status');

    Route::post('payment/{order_id?}/charge',[CartController::class, 'paymentProcess'])->name('payment.charge');

    
});

