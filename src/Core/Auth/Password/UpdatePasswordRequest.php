<?php

namespace Marketplace\Core\Auth\Password;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\Data\User\Dtos\CredentialsDto;
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
     * @return array
     */
    public function rules(): array
    {
        return [
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
        return $this->fillMessages(['required', 'min:6']);
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
