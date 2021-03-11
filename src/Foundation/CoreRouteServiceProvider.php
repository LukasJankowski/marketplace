<?php

namespace Marketplace\Foundation;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class CoreRouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            foreach (CoreServiceProvider::CORE_MODULES as $module) {
                Route::prefix('v1')
                    ->middleware('api')
                    ->group(CoreServiceProvider::CORE_DIR . '/' . $module . '/routes.php');
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(
                Config::get('marketplace.core.auth.throttling', 5)
            )
                ->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
