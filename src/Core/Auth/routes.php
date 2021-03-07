<?php

use Illuminate\Support\Facades\Route;

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
    'name' => 'marketplace.core.auth.',
    'prefix' => 'v1',
    'middleware' => ['api']
], function () {

    // Customers
    Route::group([
        'name' => 'customer.',
        'prefix' => 'customer',
    ], function () {
//        Route::post('/login', InfoController::class)->name('login');
    });

    // Providers
    Route::group([
        'name' => 'provider.',
        'prefix' => 'provider',
    ], function () {
//        Route::post('/login', InfoController::class)->name('login');
    });

    // Admins
    Route::group([
        'name' => 'admin.',
        'prefix' => 'admin',
    ], function () {
//        Route::post('/login', InfoController::class)->name('login');
    });

});
