<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Throwable;

class AuthenticationException extends IlluminateAuthenticationException
{
    use ExceptionHelperTrait;

    /**
     * @var int
     */
    private int $status;

    /**
     * AuthenticationException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(
        string $message = 'marketplace.core.authentication.unauthenticated',
        $code = 401
    )
    {
        parent::__construct($message);
        $this->status = $code;
    }
}
