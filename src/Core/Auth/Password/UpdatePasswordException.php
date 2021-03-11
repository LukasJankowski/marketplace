<?php

namespace Marketplace\Core\Auth\Password;

use Illuminate\Http\JsonResponse;
use Marketplace\Foundation\Resources\ErrorResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdatePasswordException extends HttpException
{
    /**
     * UpdatePasswordException constructor.
     *
     * @param int $statusCode
     * @param string|null $exceptionMessage
     * @param \Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(
        private int $statusCode = 403,
        private ?string $exceptionMessage = 'marketplace.core.auth.password.invalid',
        \Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    )
    {
        parent::__construct($this->statusCode, $this->exceptionMessage, $previous, $headers, $code);
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
            ->setStatusCode($this->statusCode);
    }
}
