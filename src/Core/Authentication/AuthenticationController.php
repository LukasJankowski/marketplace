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
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @param LoginUserAction $action
     *
     * @return LoginResource
     *
     * @throws Exceptions\LoginException
     */
    public function login(LoginRequest $request, LoginUserAction $action): LoginResource
    {
        return $action->run($request->asDto());
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
        return $action->run($request->asDto())
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
        return $action->run($request->asDto());
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
        return $action->run($request->asDto(), $request->route('id'));
    }
}
