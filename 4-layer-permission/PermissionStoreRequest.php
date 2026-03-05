<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:100', 'unique:permissions,name'],
            'guard_name' => ['nullable', 'string', 'in:web,api'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Permission name is required.',
            'name.max'      => 'Permission name cannot exceed 100 characters.',
            'name.unique'   => 'This permission already exists.',
            'guard_name.in' => 'Guard name must be web or api.',
        ];
    }
}
