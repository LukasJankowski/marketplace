<?php

namespace Marketplace\Foundation;

use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
    /**
     * @const string
     */
    public const CORE_DIR = __DIR__ . '/../Core';

    /**
     * @const string[]
     */
    public const CORE_MODULES = [
        'Info',
        'Auth',
    ];

    /**
     * @const string[]
     */
    public const CORE_DATA = [
        'User',
        'Account',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        foreach (self::CORE_DATA as $data) {
            $this->loadMigrationsFrom(self::CORE_DIR . '/' . $data . '/migrations');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(CoreEventServiceProvider::class);
        $this->app->register(CoreAuthServiceProvider::class);
        $this->app->register(CoreRouteServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../Config/marketplace.php', 'marketplace');
    }
}
