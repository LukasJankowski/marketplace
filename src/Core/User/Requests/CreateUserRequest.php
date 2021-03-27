<?php

namespace Marketplace\Core\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\Account\ValueObjects\Name;
use Marketplace\Core\Account\ValueObjects\Phone;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Core\User\Dtos\PersonDto;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\ValueObjects\Email;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\DataTransferObjects\HasDtoFactory;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class CreateUserRequest extends FormRequest implements HasDtoFactory
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
     * @return PersonDto
     */
    public function asDto(): PersonDto
    {
        return new PersonDto(
            user: new UserDto(
                email: Email::make($this->get('email')),
                password: Password::make($this->get('password')),
                role: Role::make($this->getUserRole()),
            ),
            account: new AccountDto(
                salutation: Salutation::make($this->get('salutation')),
                firstName: Name::make($this->get('first_name')),
                lastName: Name::make($this->get('last_name')),
                phone: Phone::make($this->get('phone'))
            )
        );
    }
}
