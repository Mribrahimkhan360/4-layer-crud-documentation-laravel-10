<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:100', 'unique:brands,name'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Brand name is required.',
            'name.max'      => 'Brand name cannot exceed 100 characters.',
            'name.unique'   => 'This brand name already exists.',
        ];
    }
}
