<?php

namespace Marketplace\Foundation\Exceptions;

use RuntimeException;

class DatabaseException extends RuntimeException
{
    use ExceptionHelperTrait;

    /**
     * DatabaseException constructor.
     */
    public function __construct(
        $message = 'marketplace.core.database.failed',
        private int $status = 500
    )
    {
        parent::__construct($message, $this->status);
    }
}
