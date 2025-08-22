<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\AuthController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\AutoCompleteController;
use Modules\Admin\Http\Controllers\Settings\RoleController;
use Modules\Admin\Http\Controllers\Settings\SettingController;
use Modules\Admin\Http\Controllers\Settings\Logs\LogsController;
use Modules\Admin\Http\Controllers\Settings\UserAdminController;
use Modules\Admin\Http\Controllers\Settings\States\StateController;
use Modules\Admin\Http\Controllers\Settings\Statuses\TagsController;
use Modules\Admin\Http\Controllers\Settings\Statuses\LeadsController;
use Modules\Admin\Http\Controllers\Settings\Company\CompanyController;
use Modules\Admin\Http\Controllers\Settings\General\GereralController;
use Modules\Admin\Http\Controllers\Settings\Statuses\SourceController;
use Modules\Admin\Http\Controllers\Settings\Statuses\StatusController;
use Modules\Admin\Http\Controllers\Settings\Countries\CountryController;
use Modules\Admin\Http\Controllers\Settings\Currencies\CurrencyController;
use Modules\Admin\Http\Controllers\Settings\Statuses\OrdersStatusController;

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
                Route::resource('leads', LeadsController::class);
                Route::post('/leads/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('leads.bulk-delete');

                Route::resource('source', SourceController::class);

                Route::resource('tags', TagsController::class);

            });

            Route::resource('logs', LogsController::class);

            Route::resource('orders', OrdersStatusController::class);

            Route::resource('currencies', CurrencyController::class);
            Route::post('/currencies/bulk-delete', [CurrencyController::class, 'bulkDelete'])->name('currencies.bulk-delete');

            Route::resource('countries', CountryController::class);
            Route::post('/countries/bulk-delete', [CountryController::class, 'bulkDelete'])->name('countries.bulk-delete');

            Route::resource('states', StateController::class);
            Route::post('/states/bulk-delete', [StateController::class, 'bulkDelete'])->name('states.bulk-delete');
            
            Route::resource('general', GereralController::class);

        });
    });
});
