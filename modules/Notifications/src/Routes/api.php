<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\Api\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

Route::post(
    '/notifications/trigger/{eventType}',
    [\Modules\Notifications\Http\Controllers\NotificationController::class, 'triggerNotification']
)
    ->middleware('auth:api');
// Api\HomeController will be generated automatically by the module generator 