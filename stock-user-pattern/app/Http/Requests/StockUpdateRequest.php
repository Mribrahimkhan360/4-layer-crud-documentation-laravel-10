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
        $stockId = $this->route('stock'); // route parameter

        return [
            'product_id'    => ['required', 'exists:products,id'],
            'serial_number' => ['required', 'string', "unique:stocks,serial_number,{$stockId}"],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'    => 'Product is required.',
            'product_id.exists'      => 'Selected product does not exist.',
            'serial_number.required' => 'Serial number is required.',
            'serial_number.unique'   => 'This serial number already exists.',
        ];
    }
}
