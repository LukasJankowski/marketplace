<?php

namespace Marketplace\Foundation;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Marketplace\Foundation\Resolvers\ModuleResolver;

class MarketplaceRouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        /** @var ModuleResolver $resolver */
        $resolver = $this->app->make(ModuleResolver::class);

        $this->configureRateLimiting();

        $this->routes(function () use ($resolver): void {
            foreach ($resolver->resolveRoutes() as $file) {
                Route::prefix('v1')
                    ->middleware('api')
                    ->group($file);
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(
                Config::get('marketplace.core.auth.throttling', 5)
            )
                ->by(optional($request->user())->getAuthIdentifier() ?: $request->ip());
        });
    }
}
