<?php

namespace Marketplace\Foundation\Subscribers;

use Illuminate\Events\Dispatcher;

trait SubscriberHelperTrait
{
    /**
     * Subscribe to the events.
     *
     * @param Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        foreach (self::SUBSCRIBER as $event => $subscribers) {
            foreach ($subscribers as $subscriber) {
                $dispatcher->listen($event, $subscriber);
            }
        }
    }
}
