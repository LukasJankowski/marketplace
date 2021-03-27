<?php

namespace Marketplace\Foundation\Generators;

class ResourceMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:resource';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new resource';

    /**
     * @inheritdoc
     */
    protected $type = 'Resource';
}
