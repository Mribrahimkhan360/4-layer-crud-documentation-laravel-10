<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderDetail;
use App\Repositories\Contracts\OrderDetailRepositoryInterface;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    protected $model;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->model = $orderDetail;
    }

    /**
     * Insert multiple products under a single order at once.
     *
     * @param  int   $orderId
     * @param  array $products  [ ['product_name' => ..., 'product_quantity' => ...], ... ]
     */
    public function storeMany($orderId, array $products)
    {
        $rows = array_map(function ($product) use ($orderId) {
            return [
                'order_id'         => $orderId,
                'product_name'     => $product['product_name'],
                'product_quantity' => $product['product_quantity'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }, $products);

        return $this->model->insert($rows);
    }

    /**
     * Delete all detail rows for a given order (used before re-syncing on update).
     */
    public function deleteByOrder($orderId)
    {
        return $this->model->where('order_id', $orderId)->delete();
    }
}
