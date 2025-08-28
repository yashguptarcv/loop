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

Route::prefix('api/cart')->name('api.cart.')->group(function () {
    Route::get('discount/{id}/view',[CartController::class, 'viewDiscountForm'])->name('discount.view');
    Route::put('discount/{id}/add',[CartController::class, 'addDiscount'])->name('discount.add');
    Route::put('discount/remove',[CartController::class, 'removeDiscount'])->name('discount.remove');
    
    
    Route::get('item/{order_id}/view',[CartController::class, 'viewItems'])->name('item.view');
    Route::post('item/{order_id}/add',[CartController::class, 'addItems'])->name('item.add');

    Route::post('item/quantity',[CartController::class, 'updateItemQuantity'])->name('item.quantity');
    Route::post('item/remove',[CartController::class, 'removeItem'])->name('item.remove');
});

