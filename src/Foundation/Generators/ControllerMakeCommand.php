<?php

namespace Marketplace\Foundation\Generators;

class ControllerMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:controller';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new controller';

    /**
     * @inheritdoc
     */
    protected $type = 'Controller';

    /**
     * @inheritdoc
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace;
    }
}
