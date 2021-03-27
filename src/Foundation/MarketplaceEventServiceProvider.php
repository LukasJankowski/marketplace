<?php

namespace Marketplace\Foundation;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Marketplace\Foundation\Resolvers\ModuleResolver;
use Marketplace\Foundation\Subscribers\ListensTo;

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
     */
    public function register(): void
    {
        $this->booting(function () {
            /** @var ModuleResolver $resolver */
            $resolver = $this->app->make(ModuleResolver::class);
            /** @var Dispatcher $dispatcher */
            $dispatcher = $this->app->make(Dispatcher::class);

            foreach ($resolver->resolveSubscribers() as $subscriber) {
                foreach ($this->resolveListeners($subscriber) as [$event, $listener]) {
                    $dispatcher->listen($event, $listener);
                }
            }
        });
    }

    /**
     * Resolve the listeners of the subscribers dynamically.
     *
     * @return array<string, array>
     *
     * @throws \ReflectionException
     */
    private function resolveListeners(string $subscriber): array
    {
        $reflectionClass = new \ReflectionClass($subscriber);
        $listeners = [];

        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = $method->getAttributes(ListensTo::class);

            foreach ($attributes as $attribute) {
                $listeners[] = [
                    // The event that's configured on the attribute
                    $attribute->newInstance()->event,
                    // The listener for this event
                    [$subscriber, $method->getName()],
                ];
            }
        }

        return $listeners;
    }
}
