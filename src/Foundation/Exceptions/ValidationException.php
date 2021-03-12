<?php

namespace Marketplace\Foundation\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends IlluminateValidationException
{
    use ExceptionHelperTrait;

    /**
     * ValidationException constructor.
     *
     * @param Validator $validator
     * @param  Response|null  $response
     * @param  string  $errorBag
     *
     * @return void
     */
    public function __construct(
        Validator $validator,
        $response = null,
        $errorBag = 'default',
        string $message = 'marketplace.core.validation.invalid'
    )
    {
        parent::__construct($validator, $response, $errorBag);

        $this->message = $message;
    }
}
