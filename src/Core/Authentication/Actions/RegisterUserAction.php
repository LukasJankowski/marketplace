<?php

namespace Marketplace\Core\Authentication\Actions;

use Marketplace\Core\Authentication\Events\UserRegistered;
use Marketplace\Core\User\Actions\CreateUserAction;
use Marketplace\Core\User\Dtos\PersonDto;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\Resources\UserResource;
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
     * @param PersonDto $details
     *
     * @return UserResource
     *
     * @throws ValidationException
     */
    public function run(PersonDto $details): UserResource
    {
        $response = $this->action->run($details);

        UserRegistered::dispatch($response->resource);

        return $response;
    }
}
