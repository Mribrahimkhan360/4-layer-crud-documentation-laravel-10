<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'name'     => ['required', 'string', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists'   => 'Selected brand does not exist.',
            'name.required'     => 'Product name is required.',
            'name.max'          => 'Product name cannot exceed 150 characters.',
        ];
    }
}
