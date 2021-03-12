<?php

namespace Marketplace\Foundation;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Marketplace\Core\Auth\AuthEventSubscriber;

class MarketplaceEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * The event subscriber mappings for the application.
     *
     * @var string[]
     */
    protected $subscribe = [
        AuthEventSubscriber::class,
    ];
}
