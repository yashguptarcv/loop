<?php

use Illuminate\Support\Facades\Route;
use Modules\DataExport\Http\Controllers\HomeController;
use Modules\DataExport\Http\Controllers\ExportController;

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
        Route::prefix('data-export')->name('dataexport.')->group(function () {
            Route::get('/', [ExportController::class, 'index'])->name('index');
            Route::get('/columns/{table}', [ExportController::class, 'getColumns'])->name('columns');
            Route::get('/preview/{table}', [ExportController::class, 'preview'])->name('preview');
            Route::post('/export', [ExportController::class, 'export'])->name('export');
        });
    });
});


// HomeController will be generated automatically by the module generator 