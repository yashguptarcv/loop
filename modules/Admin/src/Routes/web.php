<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\AuthController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\Settings\RoleController;
use Modules\Admin\Http\Controllers\Settings\SettingController;
use Modules\Admin\Http\Controllers\Settings\Statuses\LeadsController;
use Modules\Admin\Http\Controllers\Settings\UserAdminController;


Route::prefix(config('core::prefix.admin'))->middleware('web')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware(['admin.auth', 'admin.permission'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::resource('roles', RoleController::class);
            Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk-delete');

            Route::resource('users', UserAdminController::class);
            Route::post('/users/toggle-status', [UserAdminController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::post('/users/bulk-delete', [UserAdminController::class, 'bulkDelete'])->name('users.bulk-delete');
            
            Route::prefix('statuses')->name('statuses.')->group(function () {
                Route::resource('leads', LeadsController::class);
            });
        });
    });
});



