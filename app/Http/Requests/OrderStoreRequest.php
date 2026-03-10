<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // only logged-in users can place orders
    }

    public function rules(): array
    {
        return [
            'order_status'                    => ['sometimes', 'string', 'in:' . implode(',', [
                                                    Order::STATUS_PENDING,
                                                    Order::STATUS_CONFIRMED,
                                                    Order::STATUS_CANCELLED,
                                                ])],

            // products array must have at least one item
            'products'                        => ['required', 'array', 'min:1'],
            'products.*.product_name'         => ['required', 'string', 'max:255'],
            'products.*.product_quantity'     => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required'                    => 'At least one product is required.',
            'products.min'                         => 'At least one product must be added.',
            'products.*.product_name.required'     => 'Product name is required.',
            'products.*.product_name.max'          => 'Product name cannot exceed 255 characters.',
            'products.*.product_quantity.required' => 'Product quantity is required.',
            'products.*.product_quantity.integer'  => 'Product quantity must be a whole number.',
            'products.*.product_quantity.min'      => 'Product quantity must be at least 1.',
            'order_status.in'                      => 'Invalid order status selected.',
        ];
    }
}
