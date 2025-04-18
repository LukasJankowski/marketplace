<?php

namespace Marketplace\Core\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class VerifyUserRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
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
        return [];
    }
}
