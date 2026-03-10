<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $stockId = $this->route('stock');

        return [
            'product_id'    => ['required', 'integer', 'exists:products,id'],
            'serial_number' => ['required', 'string', 'max:100', "unique:stocks,serial_number,{$stockId}"],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'    => 'Please select a product.',
            'product_id.exists'      => 'Selected product does not exist.',
            'serial_number.required' => 'Serial number is required.',
            'serial_number.max'      => 'Serial number cannot exceed 100 characters.',
            'serial_number.unique'   => 'This serial number already exists in stock.',
        ];
    }
}
