<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Http\Controllers\HomeController;

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

Route::prefix('api/admin')->name('api.admin.')->group(function () {
    Route::get('/products/search', [HomeController::class, 'searchProducts'])->name('products.search');
    Route::get('/categories/search', [HomeController::class, 'searchCategories'])->name('categories.search');
});

// Api\HomeController will be generated automatically by the module generator 