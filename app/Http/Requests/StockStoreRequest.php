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
        $rules = [
            'product_id'    => ['required', 'exists:products,id'],
            'serial_number' => ['required', 'array', 'min:1'],
        ];

        foreach ($this->input('serial_number', []) as $i => $sn) {
            $rules["serial_number.$i"] = ['required', 'string', 'unique:stocks,serial_number'];
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'product_id.required' => 'Product is required.',
            'product_id.exists'   => 'Selected product does not exist.',
            'serial_number.required' => 'At least one serial number is required.',
            'serial_number.min'      => 'At least one serial number is required.',
        ];

        foreach ($this->input('serial_number', []) as $i => $sn) {
            $messages["serial_number.$i.required"] = 'Serial number ' . ($i + 1) . ' is required.';
            $messages["serial_number.$i.unique"]   = 'Serial number ' . ($i + 1) . ' already exists.';
        }

        return $messages;
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->input('serial_number', []) as $i => $sn) {
            $attributes["serial_number.$i"] = 'Serial number #' . ($i + 1);
        }

        return $attributes;
    }
}
