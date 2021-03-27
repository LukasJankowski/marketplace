<?php

namespace Marketplace\Foundation\Subscribers;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ListensTo
{
    /**
     * ListensTo constructor.
     */
    public function __construct(public string $event)
    {
    }
}
