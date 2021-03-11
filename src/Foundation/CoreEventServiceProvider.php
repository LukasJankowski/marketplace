<?php

namespace Marketplace\Foundation;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Marketplace\Core\Auth\AuthEventSubscriber;

class CoreEventServiceProvider extends ServiceProvider
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

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
