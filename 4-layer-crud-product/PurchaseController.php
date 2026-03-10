<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseStoreRequest;
use App\Services\PurchaseService;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;

        // Only customer role can purchase
        $this->middleware(['auth', 'role:customer']);
    }

    public function index()
    {
        $products  = $this->purchaseService->getAllProducts();
        $purchases = $this->purchaseService->getMyPurchases();
        return view('purchase.index', compact('products', 'purchases'));
    }

    public function store(PurchaseStoreRequest $request)
    {
        $product = $this->purchaseService->findProductById($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        $this->purchaseService->purchaseProduct($request->validated());
        return redirect()->route('purchase.index')->with('success', 'Purchase successful!');
    }
}
