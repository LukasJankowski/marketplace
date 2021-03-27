<?php

namespace Marketplace\Core\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\Authorization\RoleService;
use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class ListUserRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null
            ? RoleService::getRoleOfUser($this->user()) === Role::ADMIN
            : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        // Lists filter?
        return [];
    }
}
