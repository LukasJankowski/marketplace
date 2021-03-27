<?php

namespace Marketplace\Foundation\Generators;

class RequestMakeCommand extends BaseGenerator
{
    /**
     * @inheritdoc
     */
    protected $name = 'marketplace:make:request';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new request';

    /**
     * @inheritdoc
     */
    protected $type = 'Request';
}
