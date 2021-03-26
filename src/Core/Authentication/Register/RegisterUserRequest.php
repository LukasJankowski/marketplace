<?php

namespace Marketplace\Core\Authentication\Register;

use Marketplace\Core\User\Create\CreateUserRequest;

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
