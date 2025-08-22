<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Modules\EmailNotification\Jobs\TestJob;
use Modules\EmailNotification\Mail\NotificationEmail;
use Modules\EmailNotification\Http\Controllers\HomeController;
use Modules\EmailNotification\Http\Controllers\EmailTemplateController;

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
        
        Route::resource('email-templates', EmailTemplateController::class);
    });
});