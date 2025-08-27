<?php

use Illuminate\Support\Facades\Route;
use Modules\Filemanager\Http\Controllers\HomeController;

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
        Route::delete('filemanager/{id}/delete', [HomeController::class, 'deleteFile'])->name('filemanager.delete');   
    });        
}); 

// HomeController will be generated automatically by the module generator 