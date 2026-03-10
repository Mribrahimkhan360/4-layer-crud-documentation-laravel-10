<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permissionId = $this->route('permission'); // route parameter

        return [
            'name'       => ['required', 'string', 'max:100', "unique:permissions,name,{$permissionId}"],
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
