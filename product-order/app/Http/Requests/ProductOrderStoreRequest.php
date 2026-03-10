<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Rules — dynamic loop per product_id[] + quantity[] row
    |--------------------------------------------------------------------------
    */

    public function rules(): array
    {
        $rules = [
            'product_id' => ['required', 'array', 'min:1'],
            'quantity'   => ['required', 'array', 'min:1'],
        ];

        foreach ($this->input('product_id', []) as $i => $val) {
            $rules["product_id.$i"] = ['required', 'exists:products,id'];
            $rules["quantity.$i"]   = ['required', 'integer', 'min:1'];
        }

        return $rules;
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    public function messages(): array
    {
        $messages = [
            'product_id.required' => 'At least one product is required.',
            'quantity.required'   => 'At least one quantity is required.',
        ];

        foreach ($this->input('product_id', []) as $i => $val) {
            $row = $i + 1;
            $messages["product_id.$i.required"] = "Row {$row}: Product is required.";
            $messages["product_id.$i.exists"]   = "Row {$row}: Selected product does not exist.";
            $messages["quantity.$i.required"]   = "Row {$row}: Quantity is required.";
            $messages["quantity.$i.integer"]    = "Row {$row}: Quantity must be a number.";
            $messages["quantity.$i.min"]        = "Row {$row}: Quantity must be at least 1.";
        }

        return $messages;
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->input('product_id', []) as $i => $val) {
            $attributes["product_id.$i"] = 'Product #' . ($i + 1);
            $attributes["quantity.$i"]   = 'Quantity #' . ($i + 1);
        }

        return $attributes;
    }
}
