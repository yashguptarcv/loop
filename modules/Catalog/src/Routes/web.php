<?php

use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\HomeController;
use Modules\Leads\Http\Controllers\Leads\LeadsController;
use Modules\Catalog\Http\Controllers\Products\ProductController;
use Modules\Catalog\Http\Controllers\Products\ProductsController;
use Modules\Catalog\Http\Controllers\Category\CategoriesController;

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
        Route::prefix('catalog')->name('catalog.')->group(function () {

            Route::resource('categories', CategoriesController::class);   
            Route::post('/categories/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('categories.bulk-delete');
            Route::get('/categories/import_form', [CategoriesController::class, 'import_form'])->name('categories.import_form');
            Route::post('/categories/import', [CategoriesController::class, 'import'])->name('categories.import');
            Route::post('/categories/toggle-status', [CategoriesController::class, 'toggleStatus'])->name('categories.toggle-status');


            // products
            Route::resource('products', ProductController::class);  
            Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
            Route::post('/products/toggle-status', [ProductController::class, 'bulkUpdateStatus'])->name('products.toggle-status');
            Route::post('/products/toggle-featured', [ProductController::class, 'toggleStatus'])->name('products.toggle-featured');

        });
    });
});

// HomeController will be generated automatically by the module generator 