<?php

namespace Marketplace\Foundation\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Marketplace\Foundation\Exceptions\AuthorizationException;
use Marketplace\Foundation\Exceptions\ValidationException as MarketplaceValidationException;

trait RequestHelperTrait
{
    /**
     * @var string[]
     */
    private array $messages = [
        'required' => 'marketplace.core.validation.required',
        'email' => 'marketplace.core.validation.email',
        'min' => 'marketplace.core.validation.min',
        'in' => 'marketplace.core.validation.in',
        'string' => 'marketplace.core.validation.string',
    ];

    /**
     * Auto fill the messages.
     *
     * @return array
     */
    public function autoFill(): array
    {
        return $this->fillMessages(
            array_unique(
                explode(
                    '|',
                    implode('|', $this->rules())
                )
            )
        );
    }

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
                : $message;
        }

        return $messageList;
    }

    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator): void
    {
        try {
            parent::failedValidation($validator);
        } catch (ValidationException $e) {
            throw new MarketplaceValidationException($e->validator, $e->response, $e->errorBag);
        }
    }

    /**
     * @inheritDoc
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException();
    }

    /**
     * Get the user type.
     *
     * @return string
     */
    private function getUserType(): string
    {
        return $this->route('type');
    }
}
