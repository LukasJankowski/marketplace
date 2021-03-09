<?php

namespace Marketplace\Core\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Marketplace\Core\Data\User\Dtos\UserDto;
use Marketplace\Foundation\Requests\RequestHelperTrait;
use Marketplace\Core\Data\User\ValueObjects\Salutation;

class RegisterRequest extends FormRequest
{
    use RequestHelperTrait;

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
            'salutation' => [
                'required',
                Rule::in(Salutation::SALUTATIONS)
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
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
        return $this->fillMessages([
            'required',
            'in:' . implode(',', Salutation::SALUTATIONS),
            'string',
            'email',
            'min:6'
        ]);
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
            $this->getUserType(),
            $this->get('salutation'),
            $this->get('first_name'),
            $this->get('last_name'),
            $this->get('phone')
        );
    }
}
