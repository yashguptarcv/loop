<?php

use Illuminate\Support\Facades\Route;
use Modules\Tax\Http\Controllers\TaxController;
use Modules\Discounts\Http\Controllers\DiscountController;

Route::prefix(config('core::prefix.admin'))->middleware('web')->name('admin.')->group(function () {
    Route::middleware(['admin.auth', 'admin.permission'])->group(function () {

        // Discount CRUD
        Route::resource('discount', DiscountController::class);
        Route::post('/discount/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discount.toggle-status');

        // Coupon validation (AJAX)
        Route::post('/discount/validate-coupon', [DiscountController::class, 'validateCoupon'])->name('discount.validate-coupon');
    });

    // Frontend coupon application
    Route::middleware(['web'])->group(function () {
        Route::post('/apply-coupon', [DiscountController::class, 'applyCoupon'])->name('apply-coupon');
    });
});
