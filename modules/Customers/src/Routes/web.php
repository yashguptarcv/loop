<?php

use Illuminate\Support\Facades\Route;
use Modules\Customers\Http\Controllers\HomeController;
use Modules\Customers\Http\Controllers\CustomersController;
use Modules\Customers\Http\Controllers\Auth\AuthCustomerController;
use Modules\Customers\Http\Controllers\Dashboard\HomeController as DashboardHomeController;
use Modules\Customers\Http\Controllers\OverviewController;

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
        Route::resource('customers', CustomersController::class);
        Route::post('/customers/bulk-delete', [CustomersController::class, 'bulkDelete'])->name('customers.bulk-delete');

        
        Route::get('/customers/{customer}/orders', [OverviewController::class, 'orders'])->name('customers.orders');
        Route::get('/customers/{customer}/transactions', [OverviewController::class, 'transactions'])->name('customers.transactions');
        Route::get('/customers/{customer}/lead', [OverviewController::class, 'lead'])->name('customers.lead');        
        Route::get('/customers/{customer}/application', [OverviewController::class, 'application'])->name('customers.application');
        Route::delete('/customers/{customer}/application/{application}', [OverviewController::class, 'applicationDetailsDelete'])->name('customers.application.delete');

    });
});

Route::prefix('customer')->middleware('web')->name('customer.')->group(function () {
    Route::get('/login', [AuthCustomerController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthCustomerController::class, 'login'])->name('login');
    Route::post('/logout', [AuthCustomerController::class, 'logout'])->name('logout');   
    
    
     Route::middleware(['user.auth', 'user.permission'])->group(function () {
        Route::get('/edit/{id}', [DashboardHomeController::class, 'edit'])->name('edit');
        Route::get('/profile',  [DashboardHomeController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardHomeController::class, 'updateProfile'])->name('profile.update');    
        Route::get('/dashboard', [DashboardHomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [DashboardHomeController::class, 'transactions'])->name('transactions');
        Route::get('/transactions/{transaction}', [DashboardHomeController::class, 'showTransaction'])->name('transactions.show');

        Route::get('/applications', [DashboardHomeController::class, 'applicationCustomer'])->name('applications');
        Route::get('/application/{application_id}/detail', [DashboardHomeController::class, 'detail'])->name('application.detail');
        
    });

    
});