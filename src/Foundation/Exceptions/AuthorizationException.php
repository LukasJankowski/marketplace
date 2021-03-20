<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Auth\Access\AuthorizationException as IlluminateAuthorizationException;
use Throwable;

class AuthorizationException extends IlluminateAuthorizationException
{
    use ExceptionHelperTrait;

    /**
     * @var int
     */
    private int $status;

    /**
     * AuthorizationException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'marketplace.core.authorization.unauthorized',
        $code = 401,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->status = $code;
    }
}
