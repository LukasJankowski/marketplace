<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Auth\Access\AuthorizationException as IlluminateAuthorizationException;
use Illuminate\Http\JsonResponse;
use Marketplace\Foundation\Resources\ErrorResource;

class AuthorizationException extends IlluminateAuthorizationException
{
    /**
     * AuthorizationException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'marketplace.core.authorization.unauthorized',
        $code = 401,
        \Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
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
            'errors' => [],
        ])
            ->response()
            ->setStatusCode($this->code);
    }
}
