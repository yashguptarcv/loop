<?php

use Illuminate\Support\Facades\Route;
use Google\Service\Dfareporting\OrderContact;
use Modules\Admin\Http\Controllers\Auth\AuthController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\AutoCompleteController;
use Modules\Admin\Http\Controllers\Settings\RoleController;
use Modules\Admin\Http\Controllers\Settings\SettingController;
use Modules\Admin\Http\Controllers\Settings\UserAdminController;
use Modules\Admin\Http\Controllers\Settings\States\StateController;
use Modules\Admin\Http\Controllers\Website\Coupon\CouponController;
use Modules\Admin\Http\Controllers\Settings\Statuses\TagsController;
use Modules\Admin\Http\Controllers\Settings\Statuses\LeadsController;
use Modules\Admin\Http\Controllers\Settings\Statuses\OrderController;
use Modules\Admin\Http\Controllers\Settings\General\GereralController;
use Modules\Admin\Http\Controllers\Settings\Statuses\SourceController;
use Modules\Admin\Http\Controllers\Settings\Countries\CountryController;
use Modules\Admin\Http\Controllers\Settings\Currencies\CurrencyController;

Route::prefix(config('core::prefix.admin'))->middleware('web')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware(['admin.auth', 'admin.permission'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/autocomplete/autocomplete', [AutoCompleteController::class, 'index'])->name('autocomplete.autocomplete');

        // setting
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::resource('roles', RoleController::class);
            Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk-delete');

            Route::resource('users', UserAdminController::class);
            Route::post('/users/toggle-status', [UserAdminController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::post('/users/bulk-delete', [UserAdminController::class, 'bulkDelete'])->name('users.bulk-delete');

            Route::prefix('statuses')->name('statuses.')->group(function () {
                Route::prefix('leads')->name('leads.')->group(function () {
                    Route::resource('/', LeadsController::class);
                    Route::post('/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('bulk-delete');
                });

                Route::prefix('orders')->name('orders.')->group(function () {
                    Route::resource('/', OrderController::class);
                });

                Route::prefix('source')->name('source.')->group(function () {
                    Route::resource('/', SourceController::class);
                });

                Route::prefix('tags')->name('tags.')->group(function () {
                    Route::resource('/', TagsController::class);
                });
            });

            Route::prefix('currencies')->name('currencies.')->group(function () {
                Route::resource('leads', CurrencyController::class);
            });
            Route::prefix('countries')->name('countries.')->group(function () {
                Route::resource('leads', CountryController::class);
            });
            Route::prefix('states')->name('states.')->group(function () {
                Route::resource('leads', StateController::class);
            });
            Route::prefix('general')->name('general.')->group(function () {
                Route::resource('leads', GereralController::class);
            });
        });

        // Coupons
        Route::resource('coupons', CouponController::class);        
        Route::post('/coupons/bulk-delete', [CouponController::class, 'bulkDelete'])->name('coupons.bulk-delete');
    });
});
