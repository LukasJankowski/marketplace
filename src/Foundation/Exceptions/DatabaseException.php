<?php

namespace Marketplace\Foundation\Exceptions;

class DatabaseException extends \RuntimeException
{
    use ExceptionHelperTrait;

    /**
     * DatabaseException constructor.
     *
     * @param string $message
     * @param int $status
     */
    public function __construct(
        $message = 'marketplace.core.database.failed',
        private int $status = 500
    )
    {
        parent::__construct($message, $this->status);
    }
}
