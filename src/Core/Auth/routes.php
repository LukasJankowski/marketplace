<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Auth\AuthController;
use Marketplace\Core\Role\RoleService;

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
    'prefix' => 'auth'
], function () {

    Route::get('/check', [AuthController::class, 'check'])->name('check');

    Route::get('/refresh', [AuthController::class, 'refresh'])->name('refresh');

    Route::get('/verify/{id}', [AuthController::class, 'verify'])->name('verify');

    Route::post('/reset/{type}', [AuthController::class, 'reset'])
        ->name('reset')
        ->where('type', RoleService::getRouteRegexFromSlugs());

    Route::post('/password/{type}/{id}', [AuthController::class, 'password'])
        ->name('password')
        ->where('type', RoleService::getRouteRegexFromSlugs());

    Route::group(['middleware' => ['throttle:auth']], function () {

        Route::post('/login/{type}', [AuthController::class, 'login'])
            ->name('login')
            ->where('type', RoleService::getRouteRegexFromSlugs());

        Route::post('/register/{type}', [AuthController::class, 'register'])
            ->name('register')
            ->where('type', RoleService::getRouteRegexFromSlugs());

    });
});
