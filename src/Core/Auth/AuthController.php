<?php

namespace Marketplace\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Marketplace\Core\Auth\Check\CheckLoginAction;
use Marketplace\Core\Auth\Check\CheckLoginRequest;
use Marketplace\Core\Auth\Login\LoginRequest;
use Marketplace\Core\Auth\Login\LoginResource;
use Marketplace\Core\Auth\Login\LoginUserAction;
use Marketplace\Core\Auth\Password\UpdatePasswordAction;
use Marketplace\Core\Auth\Password\UpdatePasswordRequest;
use Marketplace\Core\Auth\Refresh\RefreshTokenAction;
use Marketplace\Core\Auth\Refresh\RefreshTokenRequest;
use Marketplace\Core\Auth\Register\RegisterUserAction;
use Marketplace\Core\Auth\Register\RegisterUserRequest;
use Marketplace\Core\Auth\Reset\ResetPasswordAction;
use Marketplace\Core\Auth\Reset\ResetRequest;
use Marketplace\Core\Auth\Reset\ResetResource;
use Marketplace\Core\Auth\Verify\VerifyUserAction;
use Marketplace\Core\Auth\Verify\VerifyUserRequest;
use Marketplace\Core\User\UserResource;
use Marketplace\Foundation\Exceptions\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @param LoginUserAction $action
     *
     * @return LoginResource
     *
     * @throws Login\LoginException
     */
    public function login(LoginRequest $request, LoginUserAction $action): LoginResource
    {
        return $action->run($request->getDto());
    }

    /**
     * Check the auth status.
     *
     * @param CheckLoginRequest $request
     * @param CheckLoginAction $action
     *
     * @return LoginResource
     */
    public function check(CheckLoginRequest $request, CheckLoginAction $action): LoginResource
    {
        return $action->run($request->user());
    }

    /**
     * Refresh the users token.
     *
     * @param RefreshTokenRequest $request
     * @param RefreshTokenAction $action
     *
     * @return LoginResource
     */
    public function refresh(RefreshTokenRequest $request, RefreshTokenAction $action): LoginResource
    {
        return $action->run($request->user());
    }

    /**
     * Register a new user.
     *
     * @param RegisterUserRequest $request
     * @param RegisterUserAction $action
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function register(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        return $action->run($request->getDto())
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Verify a user by email.
     *
     * @param VerifyUserRequest $request
     * @param VerifyUserAction $action
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
     * @param ResetRequest $request
     * @param ResetPasswordAction $action
     *
     * @return ResetResource
     *
     * @throws ValidationException
     */
    public function reset(ResetRequest $request, ResetPasswordAction $action): ResetResource
    {
        return $action->run($request->getDto());
    }

    /**
     * Update a users password.
     *
     * @param UpdatePasswordRequest $request
     * @param UpdatePasswordAction $action
     *
     * @return UserResource
     */
    public function password(UpdatePasswordRequest $request, UpdatePasswordAction $action): UserResource
    {
        return $action->run($request->getDto(), $request->route('id'));
    }
}
