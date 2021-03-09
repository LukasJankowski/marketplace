<?php

namespace Marketplace\Core\Auth\Login;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Marketplace\Foundation\Resources\ErrorResource;

class LoginException extends Exception
{
    /**
     * @var MessageBag
     */
    private MessageBag $errors;

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

    /**
     * Render response of the exception
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return ErrorResource::make([
            'message' => $this->getMessage(),
            'errors' => $this->errors(),
        ])
            ->response()
            ->setStatusCode(403);
    }
}
