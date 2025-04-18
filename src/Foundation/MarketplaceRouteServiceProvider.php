<?php

namespace Marketplace\Foundation;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Marketplace\Foundation\Middlewares\TokenMiddleware;
use Marketplace\Foundation\Resolvers\ModuleResolver;

class MarketplaceRouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->addMiddlewares();

        /** @var ModuleResolver $resolver */
        $resolver = $this->app->make(ModuleResolver::class);

        $this->configureRateLimiting();

        $this->routes(
            function () use ($resolver): void {
                foreach ($resolver->resolveRoutes() as $file) {
                    Route::prefix('v1')
                        ->middleware('api')
                        ->group($file);
                }
            }
        );
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            'auth',
            function (Request $request) {
                return Limit::perMinute(
                    Config::get('marketplace.core.authentication.throttling', 5)
                )
                    ->by(optional($request->user())->getAuthIdentifier() ?: $request->ip());
            }
        );
    }

    /**
     * Setup middlewares.
     */
    private function addMiddlewares(): void
    {
        $this->aliasMiddleware('api_auth', TokenMiddleware::class);
    }
}
