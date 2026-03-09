<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Rules — single row update (mirrors UserUpdateRequest pattern)
    |--------------------------------------------------------------------------
    */

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required.',
            'product_id.exists'   => 'Selected product does not exist.',
            'quantity.required'   => 'Quantity is required.',
            'quantity.integer'    => 'Quantity must be a number.',
            'quantity.min'        => 'Quantity must be at least 1.',
        ];
    }
}
