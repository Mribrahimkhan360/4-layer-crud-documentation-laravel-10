<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductOrderStoreRequest;
use App\Http\Requests\ProductOrderUpdateRequest;
use App\Services\ProductOrderService;

class ProductOrderController extends Controller
{
    protected $productOrderService;

    public function __construct(ProductOrderService $productOrderService)
    {
        $this->productOrderService = $productOrderService;
    }

    /*
    |--------------------------------------------------------------------------
    | index — list all product orders
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = $this->productOrderService->getAllOrders();
        return view('product-orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | create — show create form with product dropdown
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = $this->productOrderService->getAllProducts();
        return view('product-orders.create', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | store — validate via FormRequest, delegate to Service
    |--------------------------------------------------------------------------
    */

    public function store(ProductOrderStoreRequest $request)
    {
        $this->productOrderService->createBulkOrders($request->validated());

        $count = count($request->validated('product_id'));

        return redirect()
            ->route('product-orders.index')
            ->with('success', $count . ' order(s) created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | edit — show edit form for single order
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $order    = $this->productOrderService->findOrderById($id);
        $products = $this->productOrderService->getAllProducts();
        return view('product-orders.edit', compact('order', 'products'));
    }

    /*
    |--------------------------------------------------------------------------
    | update — validate via FormRequest, delegate to Service
    |--------------------------------------------------------------------------
    */

    public function update(ProductOrderUpdateRequest $request, $id)
    {
        $this->productOrderService->updateOrder($id, $request->validated());

        return redirect()
            ->route('product-orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | destroy — delete order
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $this->productOrderService->deleteOrder($id);

        return redirect()
            ->back()
            ->with('success', 'Order deleted successfully.');
    }
}
