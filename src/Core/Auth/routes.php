<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Auth\AuthController;

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
    'as' => 'marketplace.core.auth.',
    'prefix' => 'v1',
    'middleware' => ['api']
], function () {

    // Customers
    Route::group([
        'as' => 'customer.',
        'prefix' => 'customer',
    ], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

    // Providers
    Route::group([
        'as' => 'provider.',
        'prefix' => 'provider',
    ], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

    // Admins
    Route::group([
        'as' => 'admin.',
        'prefix' => 'admin',
    ], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

});
