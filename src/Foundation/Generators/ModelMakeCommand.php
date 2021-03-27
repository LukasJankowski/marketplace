<?php

namespace Marketplace\Foundation\Generators;

class ModelMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:model';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new model';

    /**
     * @inheritdoc
     */
    protected $type = 'Model';

    /**
     * @inheritdoc
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace;
    }
}
