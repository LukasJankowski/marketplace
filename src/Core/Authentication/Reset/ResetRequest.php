<?php

namespace Marketplace\Core\Authentication\Reset;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class ResetRequest extends FormRequest
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
            $this->get('email'),
            '__unused',
            $this->getUserRole()
        );
    }
}
