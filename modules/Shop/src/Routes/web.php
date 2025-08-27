<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\HomeController;
use Modules\Shop\Http\Controllers\Admin\PageController;

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
        Route::resource('pages', PageController::class);
        Route::post('pages/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
        Route::post('pages/bulk-delete', [PageController::class, 'bulkDelete'])->name('pages.bulk-delete');
    });
});

Route::middleware('web')->group(function () {
    Route::get('/{slug?}', [HomeController::class, 'index'])->name('page.show');
});
