<?php

namespace Marketplace\Core\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\Auth\UserCredentialsDto;
use Marketplace\Core\Data\Models\Admin;
use Marketplace\Core\Data\Models\Customer;
use Marketplace\Core\Data\Models\Provider;
use Marketplace\Foundation\Requests\FillMessagesTrait;

class LoginRequest extends FormRequest
{
    use FillMessagesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return $this->fillMessages(['required', 'email', 'min:6']);
    }

    /**
     * Create the DTO.
     *
     * @return UserCredentialsDto
     */
    public function getDto(): UserCredentialsDto
    {
        $type = match ($this->route()->getName()) {
            'marketplace.core.auth.customer.login' => Customer::class,
            'marketplace.core.auth.provider.login' => Provider::class,
            'marketplace.core.auth.admin.login' => Admin::class,
        };

        return UserCredentialsDto::make(
            $this->get('email'),
            $this->get('password'),
            $type
        );
    }
}
