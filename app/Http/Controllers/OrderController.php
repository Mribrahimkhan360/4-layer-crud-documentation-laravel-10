<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Show all orders of the logged-in user.
     */
    public function index()
    {
        $orders = $this->orderService->getMyOrders();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the create-order form.
     */
    public function create()
    {
        $statuses = $this->orderService->getOrderStatuses();
        $products = $this->orderService->getAllProducts(); // ← NEW
        return view('orders.create', compact('statuses','products'));
    }

    /**
     * Store a new order with its products.
     */
    public function store(OrderStoreRequest $request)
    {
        $this->orderService->createOrder($request->validated());
        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    /**
     * Show a single order's details.
     */
    public function show($id)
    {
        $order = $this->orderService->findOrderById($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the edit-order form.
     */
    public function edit($id)
    {
        $order    = $this->orderService->findOrderById($id);
        $statuses = $this->orderService->getOrderStatuses();
        $products = $this->orderService->getAllProducts(); // ← NEW
        return view('orders.edit', compact('order', 'statuses','products'));
    }

    /**
     * Update an existing order and its products.
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        $this->orderService->updateOrder($id, $request->validated());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Delete an order (and all its details).
     */

    public function destroy($id)
    {
        $this->orderService->deleteOrder($id);
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
