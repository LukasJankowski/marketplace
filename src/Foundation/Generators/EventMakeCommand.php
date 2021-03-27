<?php

namespace Marketplace\Foundation\Generators;

class EventMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:event';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new event';

    /**
     * @inheritdoc
     */
    protected $type = 'Event';

    /**
     * @inheritdoc
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
