<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderDetailRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;
    protected $orderDetailRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface       $orderRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository       = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->productRepository     = $productRepository;
    }

    /**
     * Get all orders (admin use).
     */
//    public function getAllOrders()
//    {
//        return $this->orderRepository->all();
//    }

    /**
     * Get orders only for the currently authenticated user.
     */
    public function getMyOrders()
    {
        return $this->orderRepository->allByUser(Auth::id());
    }

    /**
     * Find a single order by ID.
     */
    public function findOrderById($id)
    {
        return $this->orderRepository->find($id);
    }



    /**
     * ★ NEW — Get all products for the select dropdown in create/edit form.
     */
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    /**
     * Get all available order statuses.
     */
    public function getOrderStatuses(): array
    {
        return [
            Order::STATUS_PENDING,
            Order::STATUS_CONFIRMED,
            Order::STATUS_CANCELLED,
        ];
    }

    /**
     * Create a new order with its product details.
     *
     * $data = [
     *   'order_status' => 'pending',
     *   'products'     => [
     *       ['product_name' => 'Widget', 'product_quantity' => 2],
     *       ['product_name' => 'Gadget', 'product_quantity' => 5],
     *   ]
     * ]
     */
    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1. Create the parent order row
            $order = $this->orderRepository->store([
                'user_id'      => Auth::id(),
                'order_status' => $data['order_status'] ?? Order::STATUS_PENDING,
            ]);

            // 2. Bulk-insert all product rows linked to this order
            $this->orderDetailRepository->storeMany($order->id, $data['products']);

            return $order;
        });
    }

    /**
     * Update an existing order's status and re-sync its products.
     */
    public function updateOrder($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            // 1. Update the parent order status
            $order = $this->orderRepository->update($id, [
                'order_status' => $data['order_status'],
            ]);

            // 2. Replace all product detail rows (delete + re-insert)
            $this->orderDetailRepository->deleteByOrder($order->id);
            $this->orderDetailRepository->storeMany($order->id, $data['products']);

            return $order;
        });
    }

    /**
     * Delete an order and all its details (cascade handled by DB or manually).
     */
    public function deleteOrder($id)
    {
        return DB::transaction(function () use ($id) {
            $this->orderDetailRepository->deleteByOrder($id);
            return $this->orderRepository->delete($id);
        });
    }
}
