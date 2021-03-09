<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Auth\AuthController;
use Marketplace\Foundation\Services\TypeService;

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
    'prefix' => 'v1/auth',
    'middleware' => ['api']
], function () {

    Route::get('/check', [AuthController::class, 'check'])->name('check');

    Route::post('/login/{type}', [AuthController::class, 'login'])
        ->name('login')
        ->where('type', TypeService::getRouteRegexFromKeys());

    Route::post('/register/{type}', [AuthController::class, 'register'])
        ->name('register')
        ->where('type', TypeService::getRouteRegexFromKeys());
});
