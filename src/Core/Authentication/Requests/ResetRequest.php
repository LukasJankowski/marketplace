<?php

namespace Marketplace\Core\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Foundation\DataTransferObjects\HasDtoFactory;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class ResetRequest extends FormRequest implements HasDtoFactory
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->autoFill();
    }

    /**
     * Create the DTO.
     */
    public function asDto(): UserDto
    {
        return new UserDto(
            email: $this->get('email'),
            role: $this->getUserRole()
        );
    }
}
