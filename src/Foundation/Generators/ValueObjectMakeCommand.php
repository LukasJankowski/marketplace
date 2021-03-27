<?php

namespace Marketplace\Foundation\Generators;

class ValueObjectMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:vo';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new value object';

    /**
     * @inheritdoc
     */
    protected $type = 'ValueObject';

    /**
     * @inheritdoc
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
