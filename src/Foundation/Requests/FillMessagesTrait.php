<?php

namespace Marketplace\Foundation\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Marketplace\Foundation\Exceptions\ValidationException as MarketplaceValidationException;

trait FillMessagesTrait
{
    /**
     * @var string[]
     */
    private array $messages = [
        'required' => 'marketplace.core.validation.required',
        'email' => 'marketplace.core.validation.email',
        'min' => 'marketplace.core.validation.min',
    ];

    /**
     * Generate a message array for requests.
     *
     * @param array $rules
     *
     * @return array
     */
    private function fillMessages(array $rules = []): array
    {
        $messageList = [];
        foreach ($rules as $rule) {
            $rule = explode(':', $rule);
            $message = $this->messages[$rule[0]];
            $messageList[$rule[0]] = isset($rule[1])
                ? $message . ':' . $rule[1]
                : $message;;
        }

        return $messageList;
    }

    /**
     * Overwrite the error message.
     *
     * @param Validator $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        try {
            parent::failedValidation($validator);
        } catch (ValidationException $e) {
            throw new MarketplaceValidationException($e->validator, $e->response, $e->errorBag);
        }
    }
}
