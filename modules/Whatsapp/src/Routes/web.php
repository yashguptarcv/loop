<?php

use Illuminate\Support\Facades\Route;
use Modules\Whatsapp\Http\Controllers\HomeController;
use Modules\Whatsapp\Http\Controllers\WhatsAppController;
use Modules\Whatsapp\Http\Controllers\WhatsAppTemplateController;

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
        Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
            Route::get('/', [WhatsAppTemplateController::class, 'index'])->name('index');
            Route::resource('templates', WhatsAppTemplateController::class);
            
            Route::get('/whatsapp/templates/sync', [WhatsAppTemplateController::class, 'sync'])->name('templates.sync');
            
            Route::get('/compose', [WhatsAppController::class, 'compose'])->name('compose');
            Route::post('/send-text', [WhatsAppController::class, 'sendTextMessage'])->name('send.text');
            Route::post('/send-template', [WhatsAppController::class, 'sendTemplateMessage'])->name('send.template');
            Route::post('/send-image', [WhatsAppController::class, 'sendImageMessage'])->name('send.image');
            Route::get('/old', [WhatsAppController::class, 'index'])->name('old.index');

            // Message details
            Route::get('/message/{id}', [WhatsAppController::class, 'getMessageDetails'])->name('message.details');

            // Template management routes
            Route::post('/templates/assign-event', [WhatsAppTemplateController::class, 'storeEventMapping'])->name('templates.assign-event');
        });
    });
});

// HomeController will be generated automatically by the module generator
