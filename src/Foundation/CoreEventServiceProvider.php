<?php

namespace Marketplace\Foundation;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
