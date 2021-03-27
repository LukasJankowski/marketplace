<?php

namespace Marketplace\Core\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Marketplace\Core\Authentication\Actions\CheckLoginAction;
use Marketplace\Core\Authentication\Actions\LoginUserAction;
use Marketplace\Core\Authentication\Actions\RefreshTokenAction;
use Marketplace\Core\Authentication\Actions\RegisterUserAction;
use Marketplace\Core\Authentication\Actions\ResetPasswordAction;
use Marketplace\Core\Authentication\Actions\UpdatePasswordAction;
use Marketplace\Core\Authentication\Actions\VerifyUserAction;
use Marketplace\Core\Authentication\Requests\CheckLoginRequest;
use Marketplace\Core\Authentication\Requests\LoginRequest;
use Marketplace\Core\Authentication\Requests\RefreshTokenRequest;
use Marketplace\Core\Authentication\Requests\RegisterUserRequest;
use Marketplace\Core\Authentication\Requests\ResetRequest;
use Marketplace\Core\Authentication\Requests\UpdatePasswordRequest;
use Marketplace\Core\Authentication\Requests\VerifyUserRequest;
use Marketplace\Core\Authentication\Resources\LoginResource;
use Marketplace\Core\Authentication\Resources\ResetResource;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Foundation\Exceptions\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * Log the user in.
     *
     * @throws Exceptions\LoginException
     */
    public function login(LoginRequest $request, LoginUserAction $action): LoginResource
    {
        return $action->run($request->asDto());
    }

    /**
     * Check the auth status.
     */
    public function check(CheckLoginRequest $request, CheckLoginAction $action): LoginResource
    {
        return $action->run($request->user());
    }

    /**
     * Refresh the users token.
     */
    public function refresh(RefreshTokenRequest $request, RefreshTokenAction $action): LoginResource
    {
        return $action->run($request->user());
    }

    /**
     * Register a new user.
     *
     * @throws ValidationException
     */
    public function register(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        return $action->run($request->asDto())
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Verify a user by email.
     *
     * @return UserResource
     */
    public function verify(VerifyUserRequest $request, VerifyUserAction $action): UserResource
    {
        return $action->run($request->route('id'));
    }

    /**
     * Reset a users password.
     *
     * @throws ValidationException
     */
    public function reset(ResetRequest $request, ResetPasswordAction $action): ResetResource
    {
        return $action->run($request->asDto());
    }

    /**
     * Update a users password.
     *
     * @return UserResource
     */
    public function password(UpdatePasswordRequest $request, UpdatePasswordAction $action): UserResource
    {
        return $action->run($request->asDto(), $request->route('id'));
    }
}
