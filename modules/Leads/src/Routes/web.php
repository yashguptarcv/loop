<?php

use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\Application\Application;
use Modules\Leads\Http\Controllers\HomeController;
use Modules\Leads\Http\Controllers\Leads\LeadsController;

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
        Route::resource('/leads', LeadsController::class);


        Route::post('/update-status', [LeadsController::class, 'updateStatus'])->name('leads.update-status');
        Route::get('/details/{lead_id}', [LeadsController::class, 'details'])->name('leads.details');
        Route::post('/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('leads.leads.bulk-delete');
        Route::post('/{lead}/update-assignment', [LeadsController::class, 'updateAssignment'])->name('leads.update-assignment');

        // Attachment routes
        // Route::get('/details/{lead_id}', [LeadsController::class, 'details'])->name('leads.details');

        Route::post('/{lead}/notes', [LeadsController::class, 'storeNote'])->name('leads.notes.store');
        Route::post('/{lead}/attachments', [LeadsController::class, 'storeAttachment'])->name('leads.attachments.store');
        Route::get('/{lead}/attachments/{attachment}/download', [LeadsController::class, 'downloadAttachment'])->name('leads.attachments.download');
        Route::delete('/{lead}/attachments/{attachment}', [LeadsController::class, 'destroyAttachment'])->name('leads.attachments.destroy');

        Route::post('/{lead}/activities', [LeadsController::class, 'storeActivity'])->name('leads.activities.store');
        Route::get('/users/search', [LeadsController::class, 'searchAdmins'])->name('leads.users.search');

        Route::resource('application', Application::class);
        Route::get('/application/send_application/{lead}', [Application::class, 'send_application'])->name('application.send_application');
    });
});

// HomeController will be generated automatically by the module generator 