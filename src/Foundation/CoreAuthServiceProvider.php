<?php

namespace Marketplace\Foundation;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Marketplace\Foundation\Guards\TokenGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class CoreAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('core', function (Application $app, $name, array $config): Guard {
            return new TokenGuard(
                Auth::createUserProvider($config['provider']),
                $app->make(Request::class)
            );
        });
    }
}
