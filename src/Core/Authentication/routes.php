<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Authentication\AuthenticationController;
use Marketplace\Core\Authorization\RoleService;

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
Route::group(
    [
        'as' => 'marketplace.core.authentication.',
        'prefix' => 'auth',
    ],
    function () {
        Route::group(['middleware' => ['api_auth']], function () {
            Route::get('/check', [AuthenticationController::class, 'check'])->name('check');

            Route::get('/refresh', [AuthenticationController::class, 'refresh'])->name('refresh');
        });

        Route::get('/verify/{id}', [AuthenticationController::class, 'verify'])->name('verify');

        Route::post('/reset/{role}', [AuthenticationController::class, 'reset'])
            ->name('reset')
            ->where('role', RoleService::getRouteRegexFromSlugs());

        Route::post('/password/{role}/{id}', [AuthenticationController::class, 'password'])
            ->name('password')
            ->where('role', RoleService::getRouteRegexFromSlugs());

        Route::group(
            ['middleware' => ['throttle:auth']],
            function () {
                Route::post('/login/{role}', [AuthenticationController::class, 'login'])
                    ->name('login')
                    ->where('role', RoleService::getRouteRegexFromSlugs());

                Route::post('/register/{role}', [AuthenticationController::class, 'register'])
                    ->name('register')
                    ->where('role', RoleService::getRouteRegexFromSlugs());
            }
        );
    }
);
