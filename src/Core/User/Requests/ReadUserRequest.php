<?php

namespace Marketplace\Core\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class ReadUserRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = $this->user();
        if ($user === null) {
            return false;
        }

        $isOwner = intval($this->route($user->getAuthIdentifierName())) === $user->getAuthIdentifier();

        return $isOwner || $this->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [];
    }
}
