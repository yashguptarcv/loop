<?php

use Illuminate\Http\Request;
use Modules\Leads\Models\TagsModel;
use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\Api\HomeController;

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

Route::get('/tags/search', function(Request $request) {
    return TagsModel::query()
        ->where('name', 'like', "%{$request->q}%")
        ->limit(10)
        ->get();
});

// Api\HomeController will be generated automatically by the module generator 