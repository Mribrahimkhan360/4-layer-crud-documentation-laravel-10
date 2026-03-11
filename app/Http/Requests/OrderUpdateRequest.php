<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'order_status'                    => ['required', 'string', 'in:' . implode(',', [
                                                    Order::STATUS_PENDING,
                                                    Order::STATUS_CONFIRMED,
                                                    Order::STATUS_CANCELLED,
                                                ])],

            // products array must have at least one item on update too
            'products'                        => ['required', 'array', 'min:1'],
            'products.*.product_name'         => ['required', 'string', 'max:255'],
            'products.*.product_quantity'     => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_status.required'                => 'Order status is required.',
            'order_status.in'                      => 'Invalid order status selected.',
            'products.required'                    => 'At least one product is required.',
            'products.min'                         => 'At least one product must remain in the order.',
            'products.*.product_name.required'     => 'Product name is required.',
            'products.*.product_name.max'          => 'Product name cannot exceed 255 characters.',
            'products.*.product_quantity.required' => 'Product quantity is required.',
            'products.*.product_quantity.integer'  => 'Product quantity must be a whole number.',
            'products.*.product_quantity.min'      => 'Product quantity must be at least 1.',
        ];
    }
}
