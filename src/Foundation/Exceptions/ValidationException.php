<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Validation\ValidationException as IlluminateValidationException;

class ValidationException extends IlluminateValidationException
{
    use ExceptionHelperTrait;

    /**
     * ValidationException constructor.
     *
     * @param $validator
     * @param null $response
     * @param string $errorBag
     * @param string $message
     */
    public function __construct(
        $validator,
        $response = null,
        $errorBag = 'default',
        string $message = 'marketplace.core.validation.invalid'
    )
    {
        parent::__construct($validator, $response, $errorBag);

        $this->message = $message;
    }
}
