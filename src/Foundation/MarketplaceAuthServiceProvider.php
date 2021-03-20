<?php

namespace Marketplace\Foundation;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Marketplace\Foundation\Guards\TokenGuard;

class MarketplaceAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend(
            'core',
            function (Application $app, $name, array $config): Guard {
                return new TokenGuard(
                    Auth::createUserProvider($config['provider']),
                    $app->make(Request::class)
                );
            }
        );
    }
}
