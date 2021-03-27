<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Auth\Access\AuthorizationException as IlluminateAuthorizationException;
use Throwable;

class AuthorizationException extends IlluminateAuthorizationException
{
    use ExceptionHelperTrait;

    private int $status;

    /**
     * AuthorizationException constructor.
     */
    public function __construct(
        string $message = 'marketplace.core.authorization.unauthorized',
        int $code = 403,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->status = $code;
    }
}
