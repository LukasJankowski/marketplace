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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(self::CORE_DIR . '/Data/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(CoreEventServiceProvider::class);
        $this->app->register(CoreRouteServiceProvider::class);

        $this->mergeConfigFrom(self::CORE_DIR . '/Config/marketplace.php', 'marketplace');
    }
}
