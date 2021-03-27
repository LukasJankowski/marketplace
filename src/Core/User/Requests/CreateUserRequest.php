<?php

namespace Marketplace\Core\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class CreateUserRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'salutation' => [
                Salutation::isSalutationRequired() ? 'required' : 'nullable',
                Rule::in(Salutation::SALUTATIONS),
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'password' => 'required|min:' . Password::getMinPasswordLength(),
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return $this->fillMessages(
            [
                'required',
                'in:' . implode(',', Salutation::SALUTATIONS),
                'string',
                'email',
                'min:' . Password::getMinPasswordLength(),
            ]
        );
    }

    /**
     * Create the DTO.
     *
     * @return UserDto
     */
    public function getDto(): UserDto
    {
        return UserDto::make(
            $this->get('email'),
            $this->get('password'),
            $this->getUserRole(),
            $this->get('salutation'),
            $this->get('first_name'),
            $this->get('last_name'),
            $this->get('phone')
        );
    }
}
