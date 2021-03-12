<?php

namespace Marketplace\Core\Auth\Login;

use Exception;
use Illuminate\Support\MessageBag;
use Marketplace\Foundation\Exceptions\ExceptionHelperTrait;

class LoginException extends Exception
{
    use ExceptionHelperTrait;

    /**
     * @var MessageBag
     */
    private MessageBag $errors;

    /**
     * @var int
     */
    private int $status = 403;

    /**
     * LoginException constructor.
     *
     * @param string $message
     * @param array $errors
     */
    public function __construct($message = 'marketplace.core.auth.login.failed', $errors = [])
    {
        parent::__construct($message);

        $this->errors = new MessageBag($errors);
    }

    /**
     * Get the errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors->messages();
    }
}
