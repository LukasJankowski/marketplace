<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Http\Controllers\InfoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'name' => 'marketplace.core.',
    'prefix' => 'v1',
    'middleware' => ['api']
], function () {
    Route::get('/info', InfoController::class)->name('info');
});
