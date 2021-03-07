<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Marketplace\Foundation\Resources\ErrorResource;

class ValidationException extends IlluminateValidationException
{
    /**
     * ValidationException constructor.
     *
     * @param $validator
     * @param null $response
     * @param string $errorBag
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct($validator, $response, $errorBag);

        $this->message = 'marketplace.core.validation.invalid';
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
            ->setStatusCode($this->status);
    }
}
