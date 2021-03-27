<?php

namespace Marketplace\Core\Authentication\Requests;

use Marketplace\Core\User\Requests\CreateUserRequest;

class RegisterUserRequest extends CreateUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
