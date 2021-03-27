<?php

namespace Marketplace\Core\Authentication\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;
use Marketplace\Foundation\Exceptions\ExceptionHelperTrait;

class LoginException extends Exception
{
    use ExceptionHelperTrait;

    private MessageBag $errors;

    private int $status = 403;

    /**
     * LoginException constructor.
     *
     * @param array<string, mixed> $errors
     */
    public function __construct($message = 'marketplace.core.authentication.login.failed', $errors = [])
    {
        parent::__construct($message);

        $this->errors = new MessageBag($errors);
    }

    /**
     * Get the errors.
     *
     * @return array<string, mixed>
     */
    public function errors(): array
    {
        return $this->errors->messages();
    }
}
