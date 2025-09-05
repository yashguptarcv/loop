<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\AuthController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\AutoCompleteController;
use Modules\Admin\Http\Controllers\Settings\RoleController;
use Modules\Admin\Http\Controllers\Settings\SettingController;
use Modules\Admin\Http\Controllers\Settings\UserAdminController;
use Modules\Admin\Http\Controllers\Settings\States\StateController;
use Modules\Admin\Http\Controllers\Settings\General\GereralController;
use Modules\Admin\Http\Controllers\Settings\Countries\CountryController;
use Modules\Admin\Http\Controllers\Settings\Currencies\CurrencyController;

Route::prefix(config('core::prefix.admin'))->middleware('web')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware(['admin.auth', 'admin.permission'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        // setting
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');

            Route::resource('roles', RoleController::class);
            Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk-delete');

            Route::resource('users', UserAdminController::class);
            Route::post('/users/toggle-status', [UserAdminController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::post('/users/bulk-delete', [UserAdminController::class, 'bulkDelete'])->name('users.bulk-delete');

            Route::resource('currencies', CurrencyController::class);
            Route::post('/currencies/bulk-delete', [CurrencyController::class, 'bulkDelete'])->name('currencies.bulk-delete');

            Route::resource('countries', CountryController::class);
            Route::post('/countries/bulk-delete', [CountryController::class, 'bulkDelete'])->name('countries.bulk-delete');

            Route::resource('states', StateController::class);
            Route::post('/states/bulk-delete', [StateController::class, 'bulkDelete'])->name('states.bulk-delete');

            Route::resource('general', GereralController::class);
            Route::get('send/test-mail', [GereralController::class, 'send_test_mail'])->name('send.test-mail');
        });
    });
});
