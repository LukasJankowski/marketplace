<?php

namespace Marketplace\Core\Auth\Password;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class UpdatePasswordRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->hasValidSignature();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
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
        return $this->autoFill();
    }

    /**
     * Create the DTO.
     *
     * @return CredentialsDto
     */
    public function getDto(): CredentialsDto
    {
        return CredentialsDto::make(
            '__unused',
            $this->get('password'),
            $this->getUserType()
        );
    }
}
