<?php

namespace Marketplace\Foundation;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Marketplace\Foundation\Resolvers\ModuleResolver;

final class MarketplaceServiceProvider extends ServiceProvider
{
    public const CORE_DIR = __DIR__ . '/../Core';

    public const MODULE_DIR = __DIR__ . '/../Modules';

    public const CONFIG_DIR = __DIR__ . '/../Config';

    public const CORE_NAMESPACE = 'Marketplace\Core';

    public const MODULE_NAMESPACE = 'Marketplace\Modules';

    /**
     * @const array<string>
     */
    public const SERVICE_PROVIDERS = [
        MarketplaceEventServiceProvider::class,
        MarketplaceAuthServiceProvider::class,
        MarketplaceRouteServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        /** @var ModuleResolver $resolver */
        $resolver = $this->app->make(ModuleResolver::class);

        foreach ($resolver->resolveData() as $dir) {
            $this->loadMigrationsFrom($dir);
        }

        if ($this->app->runningInConsole()) {
            $this->commands($resolver->resolveCommands());
            $this->commands(Config::get('marketplace.foundation.generators'));
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach (self::SERVICE_PROVIDERS as $provider) {
            $this->app->register($provider);
        }

        $this->mergeConfigFrom(self::CONFIG_DIR . '/marketplace.php', 'marketplace');
    }
}
