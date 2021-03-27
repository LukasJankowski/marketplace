<?php

namespace Marketplace\Foundation\Generators;

class TestMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:test';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new test';

    /**
     * @inheritdoc
     */
    protected $type = 'Test';
}
