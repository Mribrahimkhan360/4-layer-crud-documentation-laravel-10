<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->route('brand');

        return [
            'name' => ['required', 'string', 'max:100', "unique:brands,name,{$brandId}"],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Brand name is required.',
            'name.max'      => 'Brand name cannot exceed 100 characters.',
            'name.unique'   => 'This brand name already exists.',
        ];
    }
}
