<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductOrderRepositoryInterface;

class ProductOrderService
{
    protected $productOrderRepository;

    public function __construct(ProductOrderRepositoryInterface $productOrderRepository)
    {
        $this->productOrderRepository = $productOrderRepository;
    }

    /*
    |--------------------------------------------------------------------------
    | getAllOrders — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function getAllOrders()
    {
        return $this->productOrderRepository->all();
    }

    /*
    |--------------------------------------------------------------------------
    | getAllProducts — for create/edit form dropdown
    |--------------------------------------------------------------------------
    */

    public function getAllProducts()
    {
        return Product::with('brand')
            ->orderBy('name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | findOrderById — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function findOrderById($id)
    {
        return $this->productOrderRepository->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | createBulkOrders — business logic: zip product_id[] + quantity[] → bulkStore
    |--------------------------------------------------------------------------
    */

    public function createBulkOrders(array $data)
    {
        $productIds = $data['product_id'];
        $quantities = $data['quantity'];

        $rows = [];

        foreach ($productIds as $i => $productId) {
            $rows[] = [
                'product_id' => (int) $productId,
                'quantity'   => (int) $quantities[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $this->productOrderRepository->bulkStore($rows);
    }

    /*
    |--------------------------------------------------------------------------
    | updateOrder — business logic: update single order via Repository
    |--------------------------------------------------------------------------
    */

    public function updateOrder($id, array $data)
    {
        return $this->productOrderRepository->update($id, [
            'product_id' => (int) $data['product_id'],
            'quantity'   => (int) $data['quantity'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | deleteOrder — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function deleteOrder($id)
    {
        return $this->productOrderRepository->delete($id);
    }
}
