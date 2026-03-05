<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id'    => ['required', 'exists:brands,id'],
            'name'        => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists'   => 'Selected brand does not exist.',
            'name.required'     => 'Product name is required.',
            'price.required'    => 'Price is required.',
            'price.numeric'     => 'Price must be a valid number.',
            'stock.required'    => 'Stock quantity is required.',
            'stock.integer'     => 'Stock must be a whole number.',
        ];
    }
}
