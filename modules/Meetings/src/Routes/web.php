<?php

use Illuminate\Support\Facades\Route;
use Modules\Meetings\Http\Controllers\HomeController;
use Modules\Meetings\Http\Controllers\MeetingsController;
use Modules\Meetings\Http\Controllers\GoogleCalendarController;

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

        Route::resource('meetings', MeetingsController::class);

        Route::get('/my_meetings', [MeetingsController::class, 'getCalendarData'])->name('meetings.my-meeting');

        Route::get('/sync', [MeetingsController::class, 'syncWithGoogle'])->name('meetings.sync');
        Route::get('/list', [MeetingsController::class, 'list'])->name('meetings.list');


        // modal routes
        Route::get('/share', [MeetingsController::class, 'share_calendar'])->name('meetings.share-calander');
        Route::get('/new-meeting', [MeetingsController::class, 'new_meeting'])->name('meetings.new-meeting');

        // oauth
        Route::get('/google/oauth', [GoogleCalendarController::class, 'oauth'])->name('meetings.google.oauth');
        Route::get('/google/callback', [GoogleCalendarController::class, 'callback'])->name('meetings.google.callback');
    });
});

Route::get('/meetings-schudler', [MeetingsController::class, 'syncWithGoogle'])->name('public.calendar');
// HomeController will be generated automatically by the module generator 