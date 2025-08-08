<?php

use Illuminate\Support\Facades\Route;
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
        Route::prefix('leads')->name('leads.')->group(function () {
            Route::resource('/', LeadsController::class);        
            Route::post('/update-status', [LeadsController::class, 'updateStatus'])->name('update-status');
            Route::get('/details/{lead_id}', [LeadsController::class, 'details'])->name('details');
            Route::post('/leads/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('leads.bulk-delete');
            
            // Attachment routes
            // Route::get('/details/{lead_id}', [LeadsController::class, 'details'])->name('details');
            
            Route::post('/leads/{lead}/notes', [LeadsController::class, 'storeNote'])->name('leads.notes.store');
            Route::post('/leads/{lead}/attachments', [LeadsController::class, 'storeAttachment'])->name('leads.attachments.store');
            Route::get('/leads/{lead}/attachments/{attachment}/download', [LeadsController::class, 'downloadAttachment'])->name('leads.attachments.download');
            Route::delete('/leads/{lead}/attachments/{attachment}', [LeadsController::class, 'destroyAttachment'])->name('leads.attachments.destroy');
        });
    });
});

// HomeController will be generated automatically by the module generator 