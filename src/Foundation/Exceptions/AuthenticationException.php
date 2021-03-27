<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Throwable;

class AuthenticationException extends IlluminateAuthenticationException
{
    use ExceptionHelperTrait;

    private int $status;

    /**
     * AuthenticationException constructor.
     */
    public function __construct(
        string $message = 'marketplace.core.authentication.unauthenticated',
        int $code = 401
    )
    {
        parent::__construct($message);
        $this->status = $code;
    }
}
