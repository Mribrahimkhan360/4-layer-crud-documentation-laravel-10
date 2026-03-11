<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->productService->getAllBrands();
        return view('products.create', compact('brands'));
    }

    public function store(ProductStoreRequest $request)
    {
        $this->productService->createProduct($request->validated());
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = $this->productService->findProductById($id);
        $brands  = $this->productService->getAllBrands();
        return view('products.edit', compact('product', 'brands'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $this->productService->updateProduct($id, $request->validated());
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
