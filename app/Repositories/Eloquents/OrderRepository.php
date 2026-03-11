<?php

namespace App\Repositories\Eloquents;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $order,Product $product)
    {
        $this->model = $order;
    }

    /**
     * Get all orders with user and order details.
     */
    public function all()
    {
        return $this->model->with(['user', 'orderDetails'])->orderBy('name')->latest()->get();
        //return $this->model->orderBy('name')->get();
    }

    /**
     * Get all orders belonging to a specific user.
     */
    public function allByUser($userId)
    {
        return $this->model->with('orderDetails')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Create a new order.
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find an order by ID (with its details).
     */
    public function find($id)
    {
        return $this->model->with(['user', 'orderDetails'])->findOrFail($id);
    }

    /**
     * Update an existing order.
     */
    public function update($id, array $data)
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }

    /**
     * Delete an order by ID.
     */
    public function delete($id)
    {
        $order = $this->find($id);
        return $order->delete();
    }
}
