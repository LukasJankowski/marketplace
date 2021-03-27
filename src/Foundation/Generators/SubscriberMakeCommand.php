<?php

namespace Marketplace\Foundation\Generators;

class SubscriberMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:subscriber';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new subscriber';

    /**
     * @inheritdoc
     */
    protected $type = 'Subscriber';
}
