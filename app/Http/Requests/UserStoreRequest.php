<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['sometimes', 'string', 'exists:roles,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required.',
            'name.max'          => 'Name cannot exceed 100 characters.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Enter a valid email address.',
            'email.unique'      => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
            'role.exists'       => 'Selected role does not exist.',
        ];
    }
}
