<?php

use Illuminate\Support\Facades\Route;
use Modules\Widgets\Http\Controllers\HomeController;

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
        Route::resource('widgets', HomeController::class);

        Route::post('widgets/sort', [HomeController::class, 'sort'])->name('widgets.sort');
        Route::post('widgets/position', [HomeController::class, 'updatePosition'])->name('widgets.position');
        Route::put('widgets/{widget}/assign', [HomeController::class, 'assign'])->name('widgets.assign');
        Route::get('widgets/{widget}/render', [HomeController::class, 'render'])->name('widgets.render');
    });
});
