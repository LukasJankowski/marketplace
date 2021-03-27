<?php

namespace Marketplace\Foundation\Generators;

class ActionMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:action';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new action';

    /**
     * @inheritdoc
     */
    protected $type = 'Action';
}
