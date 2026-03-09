<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductOrder;
use App\Repositories\Contracts\ProductOrderRepositoryInterface;

class ProductOrderRepository implements ProductOrderRepositoryInterface
{
    protected $model;

    public function __construct(ProductOrder $productOrder)
    {
        $this->model = $productOrder;
    }

    /*
    |--------------------------------------------------------------------------
    | all — fetch all orders with product and brand
    |--------------------------------------------------------------------------
    */

    public function all()
    {
        return $this->model
            ->with(['product.brand'])
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | store — create a single order
    |--------------------------------------------------------------------------
    */

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | find — find order by id or fail
    |--------------------------------------------------------------------------
    */

    public function find($id)
    {
        return $this->model
            ->with(['product.brand'])
            ->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | update — update order by id
    |--------------------------------------------------------------------------
    */

    public function update($id, array $data)
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }

    /*
    |--------------------------------------------------------------------------
    | delete — delete order by id
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $order = $this->find($id);
        return $order->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | bulkStore — insert multiple product+quantity rows at once
    |--------------------------------------------------------------------------
    */

    public function bulkStore(array $rows)
    {
        return $this->model->insert($rows);
    }
}
