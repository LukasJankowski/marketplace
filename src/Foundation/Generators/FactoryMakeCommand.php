<?php

namespace Marketplace\Foundation\Generators;

class FactoryMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:factory';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new factory';

    /**
     * @inheritdoc
     */
    protected $type = 'Factory';

    /**
     * @inheritdoc
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace;
    }
}
