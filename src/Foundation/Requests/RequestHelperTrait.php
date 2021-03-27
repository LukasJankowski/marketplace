<?php

namespace Marketplace\Foundation\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Marketplace\Core\Authorization\RoleService;
use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Foundation\Exceptions\AuthorizationException;
use Marketplace\Foundation\Exceptions\ValidationException as MarketplaceValidationException;

trait RequestHelperTrait
{
    /**
     * @var array<string, string>
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
     * @return array<string, string>
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
     * @param array<string> $rules
     *
     * @return array<string, string>
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
        } catch (ValidationException $exception) {
            throw new MarketplaceValidationException(
                $exception->validator,
                $exception->response,
                $exception->errorBag
            );
        }
    }

    /**
     * @inheritDoc
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException();
    }

    /**
     * Get the user type.
     */
    private function getUserRole(): string
    {
        return (string) $this->route('role');
    }

    /**
     * Check if the user is an admin.
     */
    private function isAdmin(): bool
    {
        return $this->user() !== null
            ? RoleService::getRoleOfUser($this->user()) === Role::ADMIN
            : false;
    }
}
