<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['string', 'max:255', 'required'],
            'middle_name' => ['string', 'max:255', 'nullable'],
            'last_name' => ['string', 'max:255', 'required'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'mobile_number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user)],
            'pin' => ['required', 'digits:4']
        ];

        if ($this->isMethod('post')) $rules['password'] = ['required', 'confirmed', 'min:8'];
        if ($this->isMethod('put')) $rules['password'] = ['nullable', 'confirmed', 'min:8'];

        return $rules;
    }
}
