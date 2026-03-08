<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'          => ['required', 'integer', 'exists:products,id'],
            'serial_numbers'      => ['required', 'array', 'min:1'],
            'serial_numbers.*'    => ['required', 'string', 'max:100', 'distinct', 'unique:stocks,serial_number'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'       => 'Please select a product.',
            'product_id.exists'         => 'Selected product does not exist.',
            'serial_numbers.required'   => 'At least one serial number is required.',
            'serial_numbers.min'        => 'At least one serial number is required.',
            'serial_numbers.*.required' => 'Serial number cannot be empty.',
            'serial_numbers.*.max'      => 'Serial number cannot exceed 100 characters.',
            'serial_numbers.*.distinct' => 'Duplicate serial numbers found in your input.',
            'serial_numbers.*.unique'   => 'One or more serial numbers already exist in stock.',
        ];
    }
}
