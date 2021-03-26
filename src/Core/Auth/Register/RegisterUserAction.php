<?php

namespace Marketplace\Core\Auth\Register;

use Marketplace\Core\User\Create\CreateUserAction;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\UserResource;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Exceptions\ValidationException;

class RegisterUserAction extends BaseAction
{
    /**
     * RegisterUserAction constructor.
     *
     * @param CreateUserAction $action
     */
    public function __construct(private CreateUserAction $action)
    {
    }

    /**
     * Register the user.
     *
     * @param UserDto $details
     *
     * @return UserResource
     *
     * @throws ValidationException
     */
    public function run(UserDto $details): UserResource
    {
        $response = $this->action->run($details);

        UserRegistered::dispatch($response->resource);

        return $response;
    }
}
