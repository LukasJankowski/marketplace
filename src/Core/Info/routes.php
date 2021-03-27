<?php

use Illuminate\Support\Facades\Route;
use Marketplace\Core\Info\InfoController;

Route::group(
    [
        'as' => 'marketplace.core.info.',
    ],
    function () {
        Route::get('/info', [InfoController::class, 'dump'])->name('dump');
    }
);
