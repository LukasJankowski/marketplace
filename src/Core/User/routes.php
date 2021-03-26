<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\User\UserController;

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
        'as' => 'marketplace.core.user.',
        'prefix' => 'users',
        'middleware' => ['api_auth'],
    ],
    function () {
        Route::get('/', [UserController::class, 'list'])->name('list');
        Route::post('/', [UserController::class, 'create'])->name('create');
        Route::get('/{id}', [UserController::class, 'read'])->name('read');
        Route::match(['put', 'patch'], '/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
    }
);
