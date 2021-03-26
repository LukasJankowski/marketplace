<?php

namespace Marketplace\Foundation;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Marketplace\Foundation\Resolvers\ModuleResolver;

class MarketplaceEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<mixed>
     */
    protected $listen = [
        //
    ];

    /**
     * The event subscriber mappings for the application.
     *
     * @var array<string>
     */
    protected $subscribe = [
        //
    ];

    /**
     * Register dynamic event subscribers.
     *
     * @return void
     */
    public function register(): void
    {
        $this->booting(function () {
            /** @var ModuleResolver $resolver */
            $resolver = $this->app->make(ModuleResolver::class);
            /** @var Dispatcher $dispatcher */
            $dispatcher = $this->app->make(Dispatcher::class);

            foreach ($resolver->resolveSubscribers() as $subscriber) {
                $dispatcher->subscribe($subscriber);
            }
        });

    }
}
