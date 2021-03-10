<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Http\JsonResponse;
use Marketplace\Foundation\Resources\ErrorResource;

class BusinessException extends \Exception
{
    /**
     * BusinessException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, $code = 0, \Throwable $previous = null)
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
            ->setStatusCode(422);
    }
}
