<?php

namespace Marketplace\Foundation;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Marketplace\Foundation\Resolvers\ModuleResolver;

final class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * @const string
     */
    public const CORE_DIR = __DIR__ . '/../Core';

    /**
     * @const string
     */
    public const CONFIG_DIR = __DIR__ . '/../Config';

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
     * @return void
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        foreach (self::SERVICE_PROVIDERS as $provider) {
            $this->app->register($provider);
        }

        $this->mergeConfigFrom(self::CONFIG_DIR . '/marketplace.php', 'marketplace');
    }
}
